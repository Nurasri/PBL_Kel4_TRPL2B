<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Http\Requests\ProfilPerusahaanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of all companies (admin only).
     */
    public function index(): View
    {
        // Only admin can access this view
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $perusahaans = Perusahaan::with('user')->latest()->paginate(10);
        return view('perusahaan.index', compact('perusahaans'));
    }

    /**
     * Show the form for creating a new company profile.
     */
    public function create(): View|RedirectResponse
    {
        // Only company users can create profiles
        if (Auth::user()->isAdmin()) {
            abort(403);
        }

        if (Auth::user()->perusahaan) {
            return redirect()->route('perusahaan.dashboard')
                ->with('error', 'Profil perusahaan sudah ada.');
        }
        return view('perusahaan.create');
    }

    /**
     * Store a newly created company profile.
     */
    public function store(ProfilPerusahaanRequest $request): RedirectResponse
    {
        // Only company users can create profiles
        if (Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logo-perusahaan', 'public');
        }

        $validated['user_id'] = Auth::id();

        Perusahaan::create($validated);

        return redirect()->route('perusahaan.dashboard')
            ->with('success', 'Profil perusahaan berhasil dibuat!');
    }

    /**
     * Display the specified company profile.
     */
    public function show(Perusahaan $perusahaan): View
    {
        // Admin can view any profile, company users can only view their own
        if (!Auth::user()->isAdmin() && Auth::id() !== $perusahaan->user_id) {
            abort(403);
        }

        return view('perusahaan.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the company profile.
     */
    public function edit(Perusahaan $perusahaan): View
    {
        // Only company users can edit their own profile
        if (Auth::user()->isAdmin() || Auth::id() !== $perusahaan->user_id) {
            abort(403);
        }

        return view('perusahaan.edit', compact('perusahaan'));
    }

    /**
     * Update the specified company profile.
     */
    public function update(ProfilPerusahaanRequest $request, Perusahaan $perusahaan): RedirectResponse
    {
        // Only company users can update their own profile
        if (Auth::user()->isAdmin() || Auth::id() !== $perusahaan->user_id) {
            abort(403);
        }

        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($perusahaan->logo) {
                Storage::disk('public')->delete($perusahaan->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logo-perusahaan', 'public');
        }

        $perusahaan->update($validated);

        return redirect()->route('perusahaan.dashboard')
            ->with('success', 'Profil perusahaan berhasil diperbarui!');
    }

    /**
     * Remove the specified company profile.
     */
    public function destroy(Perusahaan $perusahaan): RedirectResponse
    {
        // Only company users can delete their own profile
        if (Auth::user()->isAdmin() || Auth::id() !== $perusahaan->user_id) {
            abort(403);
        }

        // Delete logo if exists
        if ($perusahaan->logo) {
            Storage::disk('public')->delete($perusahaan->logo);
        }

        $perusahaan->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Profil perusahaan berhasil dihapus!');
    }

    /**
     * Display the company dashboard.
     */
    public function dashboard(): View|RedirectResponse
    {
        $perusahaan = Auth::user()->perusahaan;

        if (!$perusahaan) {
            return redirect()->route('perusahaan.create')
                ->with('error', 'Silakan lengkapi profil perusahaan terlebih dahulu.');
        }

        // Data untuk dashboard
        $data = [
            'perusahaan' => $perusahaan,
            'total_laporan' => $perusahaan->laporanHarian()->count(),
            'laporan_pending' => $perusahaan->laporanHarian()->where('status', 'pending')->count(),
        ];

        return view('perusahaan.dashboard', $data);
    }
} 