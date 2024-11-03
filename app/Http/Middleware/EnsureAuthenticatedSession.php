<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EnsureAuthenticatedSession
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Session::regenerate();
            Session::save();
        }
        return $next($request);
    }
}
