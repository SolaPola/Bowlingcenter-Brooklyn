<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Person;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        // Get date filters from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date') ?: date('Y-m-d'); // Default to today if not provided
        
        // Format dates for SQL query
        $formattedStartDate = $startDate ? Carbon::parse($startDate)->format('Y-m-d') : null;
        $formattedEndDate = $endDate ? Carbon::parse($endDate)->format('Y-m-d') : null;
        
        // Call stored procedure with date parameters
        $accounts = DB::select('CALL spGetAccountsInfo(?, ?)', [
            $formattedStartDate, 
            $formattedEndDate
        ]);
        
        // Paginate the results manually
        $page = $request->get('page', 1);
        $perPage = 10;
        
        $total = count($accounts);
        $accounts = array_slice($accounts, ($page - 1) * $perPage, $perPage);
        
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $accounts, 
            $total, 
            $perPage, 
            $page, 
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        return view('account.index', [
            'accounts' => $paginator,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function show($id)
    {
        // Get account details using the specific stored procedure
        $accounts = DB::select('CALL spGetAccountById(?)', [$id]);
        
        // Check if account exists
        if (empty($accounts)) {
            return redirect()->route('accounts.index')
                ->with('error', 'Account not found');
        }
        
        $account = $accounts[0]; // Get the first (and only) result
        
        return view('account.show', compact('account'));
    }

    // edit
    public function edit($id)
    {
        $account = Person::findOrFail($id);
        $contacts = Contact::where('personId', $id)->where('isActive', 1)->get();
        return view('account.edit', compact('account', 'contacts'));
    }

    // update
    public function update(Request $request, $id)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'infix' => 'nullable|string|max:255',
            'lastName' => 'required|string|max:255',
            'mobileNumber' => 'required|string|max:255',
            'emailAddress' => 'required|email|max:255',
        ]);

        // Set isAdult value (checkbox handling)
        $isAdult = $request->has('isAdult') ? 1 : 0;
        
        // Call the stored procedure to update account information
        DB::select('CALL spUpdateAccountInfo(?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $request->firstName,
            $request->infix,
            $request->lastName,
            $request->mobileNumber,
            $request->emailAddress,
            $isAdult
        ]);

        return redirect()->route('account.index')
            ->with('success', 'Account updated successfully');
    }
}
