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
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $user = Auth::user();

        // 2. Check if user's role matches any of the allowed roles
        if (!in_array($user->role, $roles)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.'
                ], 403);
            }

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak untuk panel tersebut.');
            }

            return redirect()->route('siswa.dashboard')->with('error', 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}
