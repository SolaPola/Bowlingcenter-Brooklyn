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
}
