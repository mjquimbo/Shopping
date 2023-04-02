<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRole
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return redirect('/admin');
        }
        return $next($request);
    }
}
