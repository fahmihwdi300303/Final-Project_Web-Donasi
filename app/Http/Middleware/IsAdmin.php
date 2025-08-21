<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah login dan role_id = 1 (Admin)
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request);
        }

        // Jika bukan admin, redirect ke homepage atau dashboard lain
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
