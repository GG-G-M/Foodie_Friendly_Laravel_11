<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        // 1. Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Check if role matches
        if ($user->role !== $role) {
            // 3. First flash unauthorized message
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // 4. Then determine where to redirect
            $redirectRoute = match($user->role) {
                'admin' => 'admin.dashboard',
                'customer' => 'home',
                default => null
            };

            // 5. If we have a redirect route, flash message and redirect
            if ($redirectRoute) {
                return redirect()->route($redirectRoute)
                    ->with('error', 'You are not authorized to access this page.');
            }

            // 6. For other roles (or no role), show 403 page
            abort(403, 'Unauthorized');
        }

        // 7. If role matches, proceed
        return $next($request);
    }
}