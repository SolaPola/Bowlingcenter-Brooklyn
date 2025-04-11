<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Person;
use App\Models\Contact;

class AccountController extends Controller
{
    public function index()
    {
        // Empty for now, will be filled in later
        return view('account.index');
    }
}
