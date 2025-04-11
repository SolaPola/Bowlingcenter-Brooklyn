<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Person;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountController extends Controller
{
    /**
     * Display a listing of accounts
     * Uses stored procedure to fetch accounts with pagination
     */
    public function index(Request $request)
    {
        try {
            // Get page parameters for pagination
            $perPage = 10;
            $page = $request->input('page', 1);
            
            // Get all accounts using stored procedure
            $allAccounts = DB::select('CALL sp_get_all_accounts()');
            
            // Log the number of accounts retrieved
            Log::info('Retrieved ' . count($allAccounts) . ' accounts from database');
            
            // Create pagination 
            $currentPageItems = array_slice($allAccounts, ($page - 1) * $perPage, $perPage);
            
            $accounts = new LengthAwarePaginator(
                $currentPageItems,
                count($allAccounts),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            
            return view('account.index', compact('accounts'));
        } catch (Exception $e) {
            // Log error and provide feedback
            Log::error('Error fetching accounts: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het ophalen van de accounts.');
        }
    }

    /**
     * Show the form for creating a new account
     */
    public function create()
    {
        try {
            // Get roles for dropdown
            $roles = DB::table('roles')->where('isActive', true)->get();
            
            if ($roles->isEmpty()) {
                Log::warning('No active roles found when creating account');
                return redirect()->route('account.index')
                               ->with('error', 'Er zijn geen actieve rollen gevonden.');
            }
            
            return view('account.create', compact('roles'));
        } catch (Exception $e) {
            Log::error('Error in create account form: ' . $e->getMessage());
            return redirect()->route('account.index')
                           ->with('error', 'Er is een fout opgetreden bij het laden van het formulier.');
        }
    }

    /**
     * Store a newly created account in storage.
     * Uses stored procedure to handle account creation logic
     */
    public function store(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'firstName' => ['required', 'string', 'max:50', 'min:2'],
                'infix' => ['nullable', 'string', 'max:10'],
                'lastName' => ['required', 'string', 'max:50', 'min:2'],
                'birthDate' => ['required', 'date', 'before:today', 'after:1920-01-01'],
                'email' => ['required', 'email', 'unique:users,email'],
                'username' => ['required', 'string', 'min:2', 'max:50', 'unique:users,name'],
                'password' => ['required', 'min:8', 'max:255', 'confirmed'],
                'role' => ['required', 'string', 'exists:roles,name']
            ]);
            
            // Handle optional infix
            $infix = $request->infix ?? '';
            
            // Hash password
            $password = Hash::make($request->password);
            
            // Log account creation attempt
            Log::info('Attempting to create account for: ' . $request->username);
            
            // Call stored procedure to create account
            $result = DB::select('CALL sp_create_account(?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->firstName,
                $infix,
                $request->lastName,
                $request->birthDate,
                $request->email,
                $request->username,
                $password,
                $request->role
            ]);
            
            // Check result and respond accordingly
            if (!empty($result) && isset($result[0]->account_id) && $result[0]->account_id > 0) {
                Log::info('Account created successfully with ID: ' . $result[0]->account_id);
                return redirect()->route('account.index')
                               ->with('success', 'Account is succesvol aangemaakt.');
            } else {
                $errorMessage = !empty($result) && isset($result[0]->message) 
                    ? $result[0]->message 
                    : 'Er is een fout opgetreden bij het aanmaken van het account.';
                
                Log::error('Failed to create account: ' . $errorMessage);
                return redirect()->back()
                               ->withInput()
                               ->with('error', $errorMessage);
            }
        } catch (Exception $e) {
            Log::error('Exception in account store method: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Er is een fout opgetreden bij het opslaan van het account: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified account
     * Uses stored procedure to get account details by ID
     */
    public function show($id)
    {
        try {
            $accountData = DB::select('CALL sp_get_account_by_id(?)', [$id]);
            
            if (!$accountData) {
                Log::warning('Account not found with ID: ' . $id);
                return redirect()->route('account.index')
                               ->with('error', 'Account niet gevonden.');
            }
            
            $account = $accountData[0];
            
            return view('account.show', compact('account'));
        } catch (Exception $e) {
            Log::error('Error showing account details: ' . $e->getMessage());
            return redirect()->route('account.index')
                           ->with('error', 'Er is een fout opgetreden bij het tonen van het account.');
        }
    }

    /**
     * Show the form for editing the specified account
     */
    public function edit($id)
    {
        try {
            $accountData = DB::select('CALL sp_get_account_by_id(?)', [$id]);
            
            if (!$accountData) {
                Log::warning('Account not found for editing with ID: ' . $id);
                return redirect()->route('account.index')
                               ->with('error', 'Account niet gevonden.');
            }
            
            $account = $accountData[0];
            $roles = DB::table('roles')->where('isActive', true)->get();
            
            // Check if there are available roles
            if ($roles->isEmpty()) {
                Log::warning('No active roles available for editing account');
                return redirect()->route('account.index')
                               ->with('error', 'Er zijn geen actieve rollen beschikbaar.');
            }
            
            return view('account.edit', compact('account', 'roles'));
        } catch (Exception $e) {
            Log::error('Error in edit account form: ' . $e->getMessage());
            return redirect()->route('account.index')
                           ->with('error', 'Er is een fout opgetreden bij het laden van het formulier.');
        }
    }

    /**
     * Update the specified account in storage
     * Uses stored procedure to update account details
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Starting account update process for ID: ' . $id);
            
            // Validate the input
            $validated = $request->validate([
                'firstName' => ['required', 'string', 'max:50', 'min:2'],
                'infix' => ['nullable', 'string', 'max:10'],
                'lastName' => ['required', 'string', 'max:50', 'min:2'],
                'birthDate' => ['required', 'date', 'before:today', 'after:1920-01-01'],
                'email' => ['required', 'email', 'unique:users,email,'.$id],
                'username' => ['required', 'string', 'min:2', 'max:50', 'unique:users,name,'.$id],
                'role' => ['required', 'string', 'exists:roles,name'],
                'isActive' => ['sometimes', 'boolean']
            ]);
            
            // First, check if the account exists
            $existingAccount = DB::select('CALL sp_get_account_by_id(?)', [$id]);
            
            if (empty($existingAccount)) {
                Log::warning('Attempted to update non-existent account with ID: ' . $id);
                return redirect()->route('account.index')
                               ->with('error', 'Account niet gevonden.');
            }
            
            // Handle optional infix
            $infix = $request->infix ?? '';
            
            // Set active status
            $isActive = isset($request->isActive) ? 1 : 0;
            
            // Call stored procedure to update account
            $result = DB::select('CALL sp_update_account(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->firstName,
                $infix,
                $request->lastName,
                $request->birthDate,
                $request->email,
                $request->username,
                $request->role,
                $isActive
            ]);
            
            // Check result and respond accordingly
            if (!empty($result) && isset($result[0]->account_id) && $result[0]->account_id > 0) {
                Log::info('Account updated with ID: ' . $id);
                return redirect()->route('account.show', $id)
                               ->with('success', 'Account is succesvol bijgewerkt.');
            } else {
                $errorMessage = !empty($result) && isset($result[0]->message) 
                    ? $result[0]->message 
                    : 'Er is een fout opgetreden bij het bijwerken van het account.';
                
                Log::error('Failed to update account: ' . $errorMessage);
                return redirect()->back()
                               ->withInput()
                               ->with('error', $errorMessage);
            }
        } catch (Exception $e) {
            Log::error('Error updating account: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Er is een fout opgetreden bij het bijwerken van het account: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified account from storage or deactivate it
     * Uses stored procedure to handle account deletion/deactivation
     */
    public function destroy($id)
    {
        try {
            // Call stored procedure to safely handle account deletion
            // This typically soft-deletes by changing isActive status
            $result = DB::select('CALL sp_delete_account(?)', [$id]);
            
            Log::info('Account deactivated with ID: ' . $id);
            return redirect()->route('account.index')
                           ->with('success', 'Het account is succesvol gedeactiveerd.');
        } catch (Exception $e) {
            Log::error('Error deactivating account: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Er is een fout opgetreden bij het deactiveren van het account.');
        }
    }

    /**
     * Change password for account
     */
    public function changePassword($id)
    {
        try {
            $account = DB::select('CALL sp_get_account_by_id(?)', [$id]);
            
            if (!$account) {
                Log::warning('Account not found for password change with ID: ' . $id);
                return redirect()->route('account.index')
                               ->with('error', 'Account niet gevonden.');
            }
            
            return view('account.change-password', ['id' => $id]);
        } catch (Exception $e) {
            Log::error('Error accessing password change form: ' . $e->getMessage());
            return redirect()->route('account.index')
                           ->with('error', 'Er is een fout opgetreden bij het laden van het wachtwoord wijzigen formulier.');
        }
    }

    /**
     * Process password change request
     */
    public function updatePassword(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'password' => ['required', 'min:8', 'max:255', 'confirmed'],
            ]);
            
            // Hash new password
            $password = Hash::make($request->password);
            
            // Call stored procedure to update password
            $result = DB::select('CALL sp_update_account_password(?, ?)', [
                $id,
                $password
            ]);
            
            if (!empty($result) && isset($result[0]->account_id) && $result[0]->account_id > 0) {
                Log::info('Password updated for account with ID: ' . $id);
                return redirect()->route('account.show', $id)
                               ->with('success', 'Wachtwoord is succesvol bijgewerkt.');
            } else {
                Log::error('Failed to update password for account ID: ' . $id);
                return redirect()->back()
                               ->with('error', 'Er is een fout opgetreden bij het bijwerken van het wachtwoord.');
            }
        } catch (Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Er is een fout opgetreden bij het wijzigen van het wachtwoord: ' . $e->getMessage());
        }
    }
}
