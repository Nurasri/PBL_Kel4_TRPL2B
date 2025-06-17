<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\LaporanHarian;
use App\Models\PengelolaanLimbah;
use App\Models\LaporanHasilPengelolaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function index(): View
    {
        $perusahaan = Perusahaan::with('user')->latest()->paginate(10);
        return view('perusahaan.index', compact('perusahaan'));
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

    public function create(): View
    {
        return view('perusahaan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'jenis_usaha' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'no_registrasi' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $perusahaan = Perusahaan::create([
            'user_id' => Auth::id(),
            'nama_perusahaan' => $request->nama_perusahaan,
            'jenis_usaha' => $request->jenis_usaha,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'no_registrasi' => $request->no_registrasi,
            'deskripsi' => $request->deskripsi,
            'logo' => $logoPath,
        ]);

        return redirect()->route('perusahaan.dashboard')
            ->with('success', 'Profil perusahaan berhasil dibuat.');
    }

    public function edit(Perusahaan $perusahaan): View
    {
        $user = Auth::user();

        // Pastikan user hanya bisa edit perusahaan miliknya sendiri
        if ($perusahaan->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request, Perusahaan $perusahaan): RedirectResponse
    {
        $user = Auth::user();

        // Pastikan user hanya bisa update perusahaan miliknya sendiri
        if ($perusahaan->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'jenis_usaha' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'no_registrasi' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $updateData = $request->only([
            'nama_perusahaan',
            'jenis_usaha',
            'alamat',
            'telepon',
            'email',
            'no_registrasi',
            'deskripsi'
        ]);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($perusahaan->logo) {
                Storage::disk('public')->delete($perusahaan->logo);
            }

            $updateData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $perusahaan->update($updateData);

        return redirect()->route('perusahaan.show', $perusahaan)
            ->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    public function adminIndex(): View
    {
        $perusahaan = Perusahaan::with('user')->latest()->paginate(10);
        return view('perusahaan.index', compact('perusahaan'));
    }

    public function adminShow(Perusahaan $perusahaan): View
    {
        return view('perusahaan.show', compact('perusahaan'));
    }
}
