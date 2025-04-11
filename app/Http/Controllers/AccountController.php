<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Person;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = DB::select('CALL spGetAccountsInfo()');
        
        // Paginate the results manually
        $page = request()->get('page', 1); // Get the current page from the request
        $perPage = 10; // Number of items per page
        
        $total = count($accounts); // Total number of items
        $accounts = array_slice($accounts, ($page - 1) * $perPage, $perPage); // Get the slice for the current page
        
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $accounts, 
            $total, 
            $perPage, 
            $page, 
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('account.index', ['accounts' => $paginator]);
    }
}
