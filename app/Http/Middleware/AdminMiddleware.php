<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Only allows authenticated users with is_admin = true to pass through.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->expectsJson()) {
            if (!auth()->check() || !auth()->user()->is_admin) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }
        }

        // Not logged in at all → send to admin login
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        // Logged in but not admin → send back to their dashboard with a notice
        if (!auth()->user()->is_admin) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
