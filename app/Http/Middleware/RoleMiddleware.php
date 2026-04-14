<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  // Accept multiple roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Check if user has one of the required roles
        foreach ($roles as $role) {
            // Ensure $user->role and $user->role->name exist before trying to access them
            if ($user->role && isset($user->role->name) && strtolower($user->role->name) === strtolower($role)) {
                return $next($request);
            }
        }

        // If user doesn't have any of the required roles, abort with 403
        abort(403, 'Unauthorized action.');
    }
}
