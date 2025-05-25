<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PerusahaanMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if (!$user->isPerusahaan()) {
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
            
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda tidak memiliki akses yang valid.');
        }

        // Jika user adalah perusahaan tapi belum memiliki profil
        if (!$user->perusahaan) {
            return redirect()->route('perusahaan.create')
                ->with('warning', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        return $next($request);
    }
} 