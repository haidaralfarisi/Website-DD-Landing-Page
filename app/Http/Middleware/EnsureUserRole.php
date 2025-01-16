<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Cek role berdasarkan level yang diberikan
        if ($role == 'SUPERADMIN' && $user->level != 'SUPERADMIN') {
            abort(403, 'Forbidden');
        }

        if ($role == 'ADMIN' && $user->level != 'ADMIN') {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
