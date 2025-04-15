<?php

namespace App\Http\Middleware\checkEmployee;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();

        if($user->role == 'employee' || $user->role == 'administrator'){
            return $next($request);
        }else{
            return redirect('/');
        }

    }
}