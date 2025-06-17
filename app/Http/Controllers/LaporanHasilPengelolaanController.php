<?php

namespace App\Http\Controllers;

use App\Models\LaporanHasilPengelolaan;
use App\Models\PengelolaanLimbah;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaporanHasilPengelolaanController extends Controller
{
    /**
     * Display a listing of laporan hasil
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        if (!$user->hasValidPerusahaan()) {
            return redirect()->route('perusahaan.create')
                ->with('info', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        $query = LaporanHasilPengelolaan::with(['pengelolaanLimbah.jenisLimbah', 'pengelolaanLimbah.vendor', 'validator'])
            ->byPerusahaan($user->perusahaan->id);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sertifikat', 'like', "%{$search}%")
                    ->orWhere('catatan_hasil', 'like', "%{$search}%")
                    ->orWhereHas('pengelolaanLimbah.jenisLimbah', function ($subQ) use ($search) {
                        $subQ->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Filters
        if ($request->filled('status_hasil')) {
            $query->byStatus($request->status_hasil);
        }

        if ($request->filled('status_validasi')) {
            $query->byValidasi($request->status_validasi);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_selesai', '>=', $request->tanggal_dari);
        }
        if ($request->
