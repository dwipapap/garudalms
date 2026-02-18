<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($request->user()->role !== $role) {
            // For API requests, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Hei anteck anteck asing, ini bukan rolemu',
                ], 403);
            }

            // For web requests, redirect with flash message
            return redirect('/login')->with('error', 'Hei anteck anteck asing, ini bukan rolemu');
        }

        return $next($request);
    }
}
