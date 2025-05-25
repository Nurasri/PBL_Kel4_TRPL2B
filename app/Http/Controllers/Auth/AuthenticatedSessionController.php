<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // Check if user is active
        if (!$user->isActive()) {
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();
            
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.');
        }

        // Update last login info
        $user->updateLastLogin();

        Session::regenerate();

        try {
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            
            if ($user->isPerusahaan()) {
                // Check if company profile exists
                if (!$user->perusahaan) {
                    return redirect()->route('perusahaan.create')
                        ->with('warning', 'Silakan lengkapi profil perusahaan Anda.');
                }
                return redirect()->route('perusahaan.dashboard');
            }

            // If somehow the user has an invalid role, log them out
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();
            
            return redirect()->route('login')
                ->with('error', 'Akun Anda tidak memiliki akses yang valid.');
        } catch (\Exception $e) {
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();
            
            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat mengalihkan halaman. Silakan coba lagi.');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect('/');
    }
}
