<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Models\Perusahaan;
use App\Models\Penyimpanan;
use Illuminate\Http\Request;
use App\Models\LaporanHarian;
use App\Models\PengelolaanLimbah;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\LaporanHasilPengelolaan;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfilPerusahaanRequest;

class PerusahaanController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();

        if (!$user->hasValidPerusahaan()) {
            return redirect()->route('perusahaan.create')
                ->with('info', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        $perusahaan = $user->perusahaan;
        $perusahaanId = $perusahaan->id;

        // Basic Statistics
        $total_laporan = LaporanHarian::where('perusahaan_id', $perusahaanId)->count();
        $laporan_pending = LaporanHarian::where('perusahaan_id', $perusahaanId)
            ->where('status', 'draft')->count();

        $total_pengelolaan = PengelolaanLimbah::where('perusahaan_id', $perusahaanId)->count();

        $total_laporan_hasil = LaporanHasilPengelolaan::where('perusahaan_id', $perusahaanId)->count();

        // Laporan Hasil Statistics
        $laporan_berhasil = LaporanHasilPengelolaan::where('perusahaan_id', $perusahaanId)
            ->where('status_hasil', 'berhasil')->count();

        $laporan_partial = LaporanHasilPengelolaan::where('perusahaan_id', $perusahaanId)
            ->where('status_hasil', 'sebagian_berhasil')->count();

        $laporan_gagal = LaporanHasilPengelolaan::where('perusahaan_id', $perusahaanId)
            ->where('status_hasil', 'gagal')->count();

        // Average Efficiency
        $avg_efisiensi = LaporanHasilPengelolaan::where('perusahaan_id', $perusahaanId)
            ->avg('efisiensi_pengelolaan') ?? 0;

        // Total Cost
        $total_biaya = LaporanHasilPengelolaan::where('perusahaan_id', $perusahaanId)
            ->sum('biaya_aktual') ?? 0;

        // Recent Activities
        $recent_laporan_harian = LaporanHarian::with(['jenisLimbah', 'penyimpanan'])
            ->where('perusahaan_id', $perusahaanId)
            ->latest()
            ->take(5)
            ->get();

        $recent_pengelolaan = PengelolaanLimbah::with(['jenisLimbah'])
            ->where('perusahaan_id', $perusahaanId)
            ->latest('tanggal_mulai')
            ->take(5)
            ->get();

        $recent_laporan_hasil = LaporanHasilPengelolaan::with(['pengelolaanLimbah.laporanHarian.jenisLimbah'])
            ->where('perusahaan_id', $perusahaanId)
            ->latest()
            ->take(5)
            ->get();

        // Monthly Trend (6 months)
        $monthly_trend = LaporanHasilPengelolaan::where('perusahaan_id', $perusahaanId)
            ->where('tanggal_selesai', '>=', Carbon::now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(tanggal_selesai, "%Y-%m") as month, COUNT(*) as total_laporan')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Alerts and Notifications
        $alerts = $this->generateAlerts($perusahaanId);

        return view('perusahaan.dashboard', compact(
            'perusahaan',
            'total_laporan',
            'laporan_pending',
            'total_pengelolaan',
            'total_laporan_hasil',
            'laporan_berhasil',
            'laporan_partial',
            'laporan_gagal',
            'avg_efisiensi',
            'total_biaya',
            'recent_laporan_harian',
            'recent_pengelolaan',
            'recent_laporan_hasil',
            'monthly_trend',
            'alerts'
        ));
    }

    private function generateAlerts($perusahaanId): array
    {
        $alerts = [];

        // Check for draft reports
        $draftCount = LaporanHarian::where('perusahaan_id', $perusahaanId)
            ->where('status', 'draft')->count();

        if ($draftCount > 0) {
            $alerts[] = [
                'type' => 'yellow',
                'title' => 'Laporan Draft',
                'message' => "Anda memiliki {$draftCount} laporan harian yang masih dalam status draft.",
                'action' => [
                    'text' => 'Lihat Laporan',
                    'url' => route('laporan-harian.index', ['status' => 'draft'])
                ]
            ];
        }

        // Storage capacity warning
        $fullStorages = Penyimpanan::whereRaw('(kapasitas_terpakai / kapasitas_maksimal) > 0.9')->count();
        if ($fullStorages > 0) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'Kapasitas Penyimpanan',
                'message' => "Ada {$fullStorages} penyimpanan yang hampir penuh (>90%).",
                'action' => [
                    'text' => 'Lihat Penyimpanan',
                    'url' => route('penyimpanan.index')
                ]
            ];
        }

        // Check for pending pengelolaan
        $pendingPengelolaan = PengelolaanLimbah::where('perusahaan_id', $perusahaanId)
            ->where('status', 'diproses')->count();

        if ($pendingPengelolaan > 0) {
            $alerts[] = [
                'type' => 'blue',
                'title' => 'Pengelolaan Dalam Proses',
                'message' => "Ada {$pendingPengelolaan} pengelolaan limbah yang sedang dalam proses.",
                'action' => [
                    'text' => 'Lihat Pengelolaan',
                    'url' => route('pengelolaan-limbah.index', ['status' => 'diproses'])
                ]
            ];
        }

        // Check for low efficiency
        $lowEfficiency = LaporanHasilPengelolaan::where('perusahaan_id', $perusahaanId)
            ->where('efisiensi_pengelolaan', '<', 60)
            ->where('tanggal_selesai', '>=', Carbon::now()->subMonth())
            ->count();

        if ($lowEfficiency > 0) {
            $alerts[] = [
                'type' => 'red',
                'title' => 'Efisiensi Rendah',
                'message' => "Terdapat {$lowEfficiency} laporan hasil dengan efisiensi di bawah 60% bulan ini.",
                'action' => [
                    'text' => 'Lihat Laporan Hasil',
                    'url' => route('laporan-hasil-pengelolaan.index')
                ]
            ];
        }

        // Check for overdue pengelolaan (more than 30 days)
        $overduePengelolaan = PengelolaanLimbah::where('perusahaan_id', $perusahaanId)
            ->where('status', '!=', 'selesai')
            ->where('tanggal_mulai', '<', Carbon::now()->subDays(30))
            ->count();

        if ($overduePengelolaan > 0) {
            $alerts[] = [
                'type' => 'red',
                'title' => 'Pengelolaan Terlambat',
                'message' => "Ada {$overduePengelolaan} pengelolaan limbah yang sudah berjalan lebih dari 30 hari.",
                'action' => [
                    'text' => 'Lihat Pengelolaan',
                    'url' => route('pengelolaan-limbah.index')
                ]
            ];
        }

        return $alerts;
    }

    public function index(Request $request): View
    {
        $query = Perusahaan::with('user');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_perusahaan', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_telp', 'like', "%{$search}%")
                    ->orWhere('no_registrasi', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        // Filter by jenis usaha
        if ($request->filled('jenis_usaha')) {
            $query->where('jenis_usaha', $request->jenis_usaha);
        }

        $perusahaans = $query->latest()->paginate(10)->withQueryString();

        // Data untuk filter
        $jenisUsahaOptions = [
            'manufaktur' => 'Manufaktur',
            'jasa' => 'Jasa',
            'dagang' => 'Dagang',
            'pertanian' => 'Pertanian',
            'pertambangan' => 'Pertambangan',
            'konstruksi' => 'Konstruksi',
            'teknologi' => 'Teknologi',
            'lainnya' => 'Lainnya'
        ];

        return view('perusahaan.index', compact('perusahaans', 'jenisUsahaOptions'));
    }

    public function show(Perusahaan $perusahaan): View
    {
        $user = Auth::user();

        // Pastikan user hanya bisa melihat perusahaan miliknya sendiri atau admin
        if (!$user->isAdmin() && $perusahaan->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('perusahaan.show', compact('perusahaan'));
    }

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
        NotificationHelper::perusahaanUpdated($perusahaan);

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

    public function adminIndex(): View
    {
        $perusahaans = Perusahaan::with('user')->latest()->paginate(10);
        return view('perusahaan.index', compact('perusahaans'));
    }

    public function adminShow(Perusahaan $perusahaan): View
    {
        return view('perusahaan.show', compact('perusahaan'));
    }
}
