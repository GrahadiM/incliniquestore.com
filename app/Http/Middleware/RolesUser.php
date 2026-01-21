<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolesUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $rolesArray = explode('|', $roles); // bisa "admin|super-admin"

        // Menggunakan Spatie roles
        if (! $user->hasAnyRole($rolesArray)) {
            abort(403, 'Unauthorized. Only admin or super-admin can access.');
        }

        return $next($request);
    }
}
