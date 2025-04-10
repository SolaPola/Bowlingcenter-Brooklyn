<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
// use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;

class UserController extends Controller
{
    public function index(Request $request)
    {

        //makes variables for pagination

        $perPage = 25;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $total = DB::table('user')->count();

        // try catch looks if the SP exists
        try{
            //reads the users from the database
            $users = DB::table('user')
                ->select('id', 'username','name', 'email', 'role', 'first_name', 'infix', 'last_name', 'birth_date')
                ->orderBy('id', 'asc')
                ->offset($offset)
                ->limit($perPage)
                ->get()
                ->toArray();

        } catch (\Exception $e) {
            //logs the error in the log
            Log::error('error reading users: ' . $e->getMessage());
            //makes an empty array if the SP doesn't exist
            $users = [];
        }
        
        //paginate

        $users = new LengthAwarePaginator($users, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        //redirect the user to the index page with all the users
        return view('user.index', ['users' => $users]);
        }

    public function create()
    {
        //redirect the user to the create page
        return view('auth.register');
    }

    //creates rows in the database
    public function store(Request $request)
    {
        //validate the input
        $request->validate([
            'FirstName' => ['required', 'string', 'max:50', 'min:2'],
            'Infix' => ['nullable', 'string', 'max:10'],
            'LastName' => ['required', 'string', 'max:50', 'min:2'],
            'BirthDate' => ['required', 'date', 'before:2006-01-01', 'after:1920-01-01'],
            'Email' => ['required', 'email', 'unique:users,email'],
            'Username' => ['required', 'string', 'min:2', 'max:50', 'unique:users,name'],
            'Password' => ['required', 'min:8', 'max:255', Rules\Password::defaults()],
            'PasswordRepeat' => ['required', 'same:Password'],
            'Role' => ['required', 'string', 'in:Gebruiker,Administrator']
        ]);

        //if infix is empty, set it to an empty string
        if ($request->Infix == null) {
            $Infix = '';
        }else{
            $Infix = $request->Infix;
        }
        $password = Hash::make($request->Password);

        //try catch to create the user
        try {
            DB::beginTransaction();
            //creates the user in the database
            $user = User::create([
                'name' => $request->Username,
                'email' => $request->Email,
                'password' => $password,
                'role' => $request->Role,
                'first_name' => $request->FirstName,
                'infix' => $Infix,
                'last_name' => $request->LastName,
                'birth_date' => $request->BirthDate,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            //logs the error in the log
            Log::error('error creating user: ' . $e->getMessage());

            //redirects the user to the create page with an error message
            return redirect()->route('users.create')->with('error', 'Er is iets fout gegaan, probeer het later opnieuw.');
        }
        //sends the user back to the overview if the user is created
        return redirect()->route('users.index')->with('success', 'Gebruiker is aangemaakt.');
    }

    public function edit($id)
    {
        //reads the user from the database
        $user = DB::table('users')->where('id', $id)->first();
        //redirects the user to the edit page with the user data
        return view('users.edit', ['user' => $user]);
    }

    //updates the user in the database
    public function update(Request $request, $id)
    {
        //validate the input
        $request->validate([
            'FirstName' => ['required', 'string', 'max:50', 'min:2'],
            'Infix' => ['nullable', 'string', 'max:10'],
            'LastName' => ['required', 'string', 'max:50', 'min:2'],
            'BirthDate' => ['required', 'date', 'before:2006-01-01', 'after:1920-01-01'],
            'Email' => ['required', 'email', Rule::unique('users')->ignore($id),],
            'Username' => ['required', 'string', 'min:2', 'max:50', Rule::unique('users')->ignore($id),],
            'Role' => ['required', 'string', 'in:Gebruiker,Administrator']
        ]);

        //if infix is empty, set it to an empty string
        if ($request->Infix == null) {
            $Infix = '';
        }else{
            $Infix = $request->Infix;
        }

        //try catch to update the user
        try {
            DB::beginTransaction();
            //updates the user in the database
            DB::table('users')->where('id', $id)->update([
                'name' => $request->Username,
                'email' => $request->Email,
                'role' => $request->Role,
                'first_name' => $request->FirstName,
                'infix' => $Infix,
                'last_name' => $request->LastName,
                'birth_date' => $request->BirthDate,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            //logs the error in the log
            Log::error('error updating user: ' . $e->getMessage());

            //redirects the user to the edit page with an error message
            return redirect()->route('users.edit')->with('error', 'Er is iets fout gegaan, probeer het later opnieuw.');
        }
        //sends the user back to the overview if the user is updated
        return redirect()->route('users.index')->with('success', 'Gebruiker is aangepast.');
    }
    //deletes the user from the database
    public function destroy($id)
    {
        //try catch to delete the user
        try {
            DB::beginTransaction();
            //deletes the user from the database
            DB::table('users')->where('id', $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            //logs the error in the log
            Log::error('error deleting user: ' . $e->getMessage());

            //redirects the user to the index page with an error message
            return redirect()->route('users.index')->with('error', 'Er is iets fout gegaan, probeer het later opnieuw.');
        }
        //sends the user back to the overview if the user is deleted
        return redirect()->route('users.index')->with('success', 'Gebruiker is verwijderd.');
    }
    public function show($id)
    {
        //reads the user from the database
        $user = DB::table('users')->where('id', $id)->first();
        //redirects the user to the show page with the user data
        return view('users.show', ['user' => $user]);
    }
    

}