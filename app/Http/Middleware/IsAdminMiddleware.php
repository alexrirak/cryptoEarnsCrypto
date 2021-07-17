<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check the user is logged in
        if (!Auth::check()){
            return redirect()->route('login');
        }

        // Check that the admin flag is true for this user
        if (Auth::user()->isAdmin == true){
            return $next($request);
        }

        // If not an admin redirect back to where they came from
        return redirect()->back();
    }
}
