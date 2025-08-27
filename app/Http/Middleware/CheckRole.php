<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle($request, Closure $next, ...$roles)
{
    $u = auth()->user();
    if (!$u) abort(403);

    // 1) spatie/permission
    if (method_exists($u, 'hasRole')) {
        foreach ($roles as $r) if ($u->hasRole($r)) return $next($request);
    }
    // 2) kolom users.role
    if (\Illuminate\Support\Facades\Schema::hasColumn('users','role')) {
        if (in_array($u->role, $roles)) return $next($request);
    }
    abort(403);
}

}
