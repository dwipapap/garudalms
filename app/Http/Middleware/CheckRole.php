<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($request->user()->role !== $role) {
            return response()->json([
                'message' => 'Hei anteck anteck asing, ini bukan rolemu'
            ], 403);
        }

        return $next($request);
    }
}