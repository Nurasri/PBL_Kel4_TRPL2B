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
    public function dashboard(): View
    {
        $user = Auth::user();
        $perusahaan = $user->perusahaan;

        if (!$perusahaan) {
            return redirect()->route('perusahaan.create')
                ->with('info', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        // Hitung statistik untuk dashboard
        $total_laporan = 0; // Sesuaikan dengan model laporan Anda
        $laporan_pending = 0; // Sesuaikan dengan model laporan Anda

        return view('perusahaan.dashboard', compact('perusahaan', 'total_laporan', 'laporan_pending'));
    }

    public function index(): View
    {
        $perusahaans = Perusahaan::with('user')->paginate(10);
        return view('perusahaan.index', compact('perusahaans'));
    }

    public function show(Perusahaan $perusahaan): View
    {
        return view('perusahaan.show', compact('perusahaan'));
    }

    public function create(): View
    {
        if (Auth::user()->perusahaan) {
            return redirect()->route('perusahaan.show', Auth::user()->perusahaan)
                ->with('info', 'Anda sudah memiliki profil perusahaan.');
        }

        return view('perusahaan.create');
    }

    public function store(ProfilPerusahaanRequest $request): RedirectResponse
    {
        if (Auth::user()->perusahaan) {
            return redirect()->route('perusahaan.show', Auth::user()->perusahaan)
                ->with('info', 'Anda sudah memiliki profil perusahaan.');
        }

        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $perusahaan = Perusahaan::create($data);

        return redirect()->route('perusahaan.show', $perusahaan)
            ->with('success', 'Profil perusahaan berhasil dibuat!');
    }

    public function edit(Perusahaan $perusahaan): View
    {
        if (Auth::user()->id !== $perusahaan->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit perusahaan ini.');
        }

        return view('perusahaan.edit', compact('perusahaan'));
    }

    public function update(ProfilPerusahaanRequest $request, Perusahaan $perusahaan): RedirectResponse
    {
        if (Auth::user()->id !== $perusahaan->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit perusahaan ini.');
        }

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            if ($perusahaan->logo) {
                Storage::disk('public')->delete($perusahaan->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $perusahaan->update($data);

        return redirect()->route('perusahaan.show', $perusahaan)
            ->with('success', 'Profil perusahaan berhasil diperbarui!');
    }
}
