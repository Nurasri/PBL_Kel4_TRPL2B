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

        // Admin bisa lihat semua, perusahaan hanya milik sendiri
        if ($user->isAdmin()) {
            $query = LaporanHasilPengelolaan::with(['pengelolaanLimbah.jenisLimbah', 'pengelolaanLimbah.vendor', 'perusahaan']);
        } else {
            if (!$user->hasValidPerusahaan()) {
                return redirect()->route('perusahaan.create')
                    ->with('info', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
            }
            $query = LaporanHasilPengelolaan::with(['pengelolaanLimbah.jenisLimbah', 'pengelolaanLimbah.vendor'])
                ->byPerusahaan($user->perusahaan->id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sertifikat', 'like', "%{$search}%")
                    ->orWhere('catatan_hasil', 'like', "%{$search}%")
                    ->orWhereHas('pengelolaanLimbah.jenisLimbah', function ($subQ) use ($search) {
                        $subQ->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('perusahaan', function ($subQ) use ($search) {
                        $subQ->where('nama_perusahaan', 'like', "%{$search}%");
                    });
            });
        }

        // Filters
        if ($request->filled('status_hasil')) {
            $query->byStatus($request->status_hasil);
        }

        if ($request->filled('perusahaan_id') && $user->isAdmin()) {
            $query->byPerusahaan($request->perusahaan_id);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_selesai', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_selesai', '<=', $request->tanggal_sampai);
        }

        $laporanHasil = $query->latest('tanggal_selesai')->paginate(15)->withQueryString();

        // Data untuk filter
        $statusHasilOptions = LaporanHasilPengelolaan::getStatusHasilOptions();
        
        // Untuk admin, tambahkan filter perusahaan
        $perusahaanOptions = [];
        if ($user->isAdmin()) {
            $perusahaanOptions = \App\Models\Perusahaan::orderBy('nama_perusahaan')->pluck('nama_perusahaan', 'id');
        }

        return view('laporan-hasil-pengelolaan.index', compact(
            'laporanHasil',
            'statusHasilOptions',
            'perusahaanOptions'
        ));
    }

    /**
     * Show the form for creating a new laporan hasil (Perusahaan only)
     */
    public function create(Request $request): View
    {
        $user = Auth::user();

        // Hanya perusahaan yang bisa create
        if ($user->isAdmin()) {
            return redirect()->route('laporan-hasil-pengelolaan.index')
                ->with('info', 'Admin hanya dapat melihat laporan hasil pengelolaan.');
        }

        if (!$user->hasValidPerusahaan()) {
            return redirect()->route('perusahaan.create')
                ->with('error', 'Silakan lengkapi profil perusahaan terlebih dahulu.');
        }

        // Ambil pengelolaan limbah yang sudah selesai tapi belum ada laporan hasil
        $pengelolaanLimbahs = PengelolaanLimbah::with(['jenisLimbah', 'penyimpanan', 'vendor'])
            ->where('perusahaan_id', $user->perusahaan->id)
            ->where('status', 'selesai')
            ->whereDoesntHave('laporanHasil')
            ->get();

        // Jika ada parameter pengelolaan_limbah_id dari URL
        $selectedPengelolaan = null;
        if ($request->filled('pengelolaan_limbah_id')) {
            $selectedPengelolaan = $pengelolaanLimbahs->where('id', $request->pengelolaan_limbah_id)->first();
        }

        return view('laporan-hasil-pengelolaan.create', compact('pengelolaanLimbahs', 'selectedPengelolaan'));
    }

    /**
     * Store a newly created laporan hasil (Perusahaan only)
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // Hanya perusahaan yang bisa create
        if ($user->isAdmin()) {
            return redirect()->route('laporan-hasil-pengelolaan.index')
                ->with('error', 'Admin tidak dapat membuat laporan hasil pengelolaan.');
        }

        $request->validate(
            LaporanHasilPengelolaan::validationRules(),
            LaporanHasilPengelolaan::validationMessages()
        );

        try {
            DB::beginTransaction();

            // Validasi pengelolaan limbah milik perusahaan
            $pengelolaanLimbah = PengelolaanLimbah::where('id', $request->pengelolaan_limbah_id)
                ->where('perusahaan_id', $user->perusahaan->id)
                ->where('status', 'selesai')
                ->first();

            if (!$pengelolaanLimbah) {
                return back()->withErrors(['pengelolaan_limbah_id' => 'Pengelolaan limbah tidak valid atau belum selesai.'])->withInput();
            }

            // Cek apakah sudah ada laporan hasil
            if ($pengelolaanLimbah->hasLaporanHasil()) {
                return back()->withErrors(['pengelolaan_limbah_id' => 'Pengelolaan limbah ini sudah memiliki laporan hasil.'])->withInput();
            }

            // Validasi jumlah berhasil dikelola tidak melebihi jumlah yang dikelola
            if ($request->jumlah_berhasil_dikelola > $pengelolaanLimbah->jumlah_dikelola) {
                return back()->withErrors([
                    'jumlah_berhasil_dikelola' => 'Jumlah berhasil dikelola tidak boleh melebihi jumlah yang dikelola (' . 
                        number_format($pengelolaanLimbah->jumlah_dikelola, 2) . ' ' . $pengelolaanLimbah->satuan . ').'
                ])->withInput();
            }

            // Handle file uploads
            $dokumentasiPaths = [];
            if ($request->hasFile('dokumentasi')) {
                foreach ($request->file('dokumentasi') as $file) {
                    $path = $file->store('laporan-hasil-pengelolaan', 'public');
                    $dokumentasiPaths[] = $path;
                }
            }

            // Hitung efisiensi otomatis
            $efisiensi = ($request->jumlah_berhasil_dikelola / $pengelolaanLimbah->jumlah_dikelola) * 100;

            // Buat laporan hasil (langsung final, tanpa approval)
            $laporanHasil = new LaporanHasilPengelolaan([
                'perusahaan_id' => $user->perusahaan->id,
                'pengelolaan_limbah_id' => $request->pengelolaan_limbah_id,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status_hasil' => $request->status_hasil,
                'jumlah_berhasil_dikelola' => $request->jumlah_berhasil_dikelola,
                'jumlah_residu' => $request->jumlah_residu ?? 0,
                'satuan' => $pengelolaanLimbah->satuan,
                'metode_disposal_akhir' => $request->metode_disposal_akhir,
                'biaya_aktual' => $request->biaya_aktual,
                'efisiensi_pengelolaan' => $efisiensi,
                'dokumentasi' => $dokumentasiPaths,
                'nomor_sertifikat' => $request->nomor_sertifikat,
                'catatan_hasil' => $request->catatan_hasil,
                'status_validasi' => 'approved' // Langsung approved tanpa proses approval
            ]);

            $laporanHasil->save();

            DB::commit();

            return redirect()->route('laporan-hasil-pengelolaan.index')
                ->with('success', 'Laporan hasil pengelolaan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menyimpan laporan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified laporan hasil
     */
    public function show(LaporanHasilPengelolaan $laporanHasilPengelolaan): View
    {
        $user = Auth::user();

        // Admin bisa lihat semua, perusahaan hanya milik sendiri
        if (!$user->isAdmin() && $laporanHasilPengelolaan->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        $laporanHasilPengelolaan->load(['pengelolaanLimbah.jenisLimbah', 'pengelolaanLimbah.penyimpanan', 'pengelolaanLimbah.vendor', 'perusahaan']);

        return view('laporan-hasil-pengelolaan.show', compact('laporanHasilPengelolaan'));
    }

    /**
     * Show the form for editing the specified laporan hasil (Perusahaan only)
     */
    public function edit(LaporanHasilPengelolaan $laporanHasilPengelolaan): View
    {
        $user = Auth::user();

        // Hanya perusahaan yang bisa edit
        if ($user->isAdmin()) {
            return redirect()->route('laporan-hasil-pengelolaan.show', $laporanHasilPengelolaan)
                ->with('info', 'Admin hanya dapat melihat laporan hasil pengelolaan.');
        }

        if ($laporanHasilPengelolaan->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        $laporanHasilPengelolaan->load('pengelolaanLimbah.jenisLimbah');

        return view('laporan-hasil-pengelolaan.edit', compact('laporanHasilPengelolaan'));
    }

    /**
     * Update the specified laporan hasil (Perusahaan only)
     */
    public function update(Request $request, LaporanHasilPengelolaan $laporanHasilPengelolaan): RedirectResponse
    {
        $user = Auth::user();

        // Hanya perusahaan yang bisa update
        if ($user->isAdmin()) {
            return redirect()->route('laporan-hasil-pengelolaan.show', $laporanHasilPengelolaan)
                ->with('error', 'Admin tidak dapat mengedit laporan hasil pengelolaan.');
        }

        if ($laporanHasilPengelolaan->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate(
            array_merge(
                LaporanHasilPengelolaan::validationRules($laporanHasilPengelolaan->id),
                ['pengelolaan_limbah_id' => 'required|exists:pengelolaan_limbahs,id']
            ),
            LaporanHasilPengelolaan::validationMessages()
        );

        try {
            DB::beginTransaction();

            // Validasi jumlah berhasil dikelola
            if ($request->jumlah_berhasil_dikelola > $laporanHasilPengelolaan->pengelolaanLimbah->jumlah_dikelola) {
                return back()->withErrors([
                    'jumlah_berhasil_dikelola' => 'Jumlah berhasil dikelola tidak boleh melebihi jumlah yang dikelola (' . 
                        number_format($laporanHasilPengelolaan->pengelolaanLimbah->jumlah_dikelola, 2) . ' ' . 
                        $laporanHasilPengelolaan->satuan . ').'
                ])->withInput();
            }

            // Handle file uploads
            $dokumentasiPaths = $laporanHasilPengelolaan->dokumentasi ?? [];
            if ($request->hasFile('dokumentasi')) {
                foreach ($request->file('dokumentasi') as $file) {
                    $path = $file->store('laporan-hasil-pengelolaan', 'public');
                    $dokumentasiPaths[] = $path;
                }
            }

            // Hitung ulang efisiensi
            $efisiensi = ($request->jumlah_berhasil_dikelola / $laporanHasilPengelolaan->pengelolaanLimbah->jumlah_dikelola) * 100;

            // Update laporan hasil
            $laporanHasilPengelolaan->update([
                'tanggal_selesai' => $request->tanggal_selesai,
                'status_hasil' => $request->status_hasil,
                'jumlah_berhasil_dikelola' => $request->jumlah_berhasil_dikelola,
                'jumlah_residu' => $request->jumlah_residu ?? 0,
                'metode_disposal_akhir' => $request->metode_disposal_akhir,
                'biaya_aktual' => $request->biaya_aktual,
                'efisiensi_pengelolaan' => $efisiensi,
                'dokumentasi' => $dokumentasiPaths,
                'nomor_sertifikat' => $request->nomor_sertifikat,
                'catatan_hasil' => $request->catatan_hasil,
            ]);

            DB::commit();

            return redirect()->route('laporan-hasil-pengelolaan.show', $laporanHasilPengelolaan)
                ->with('success', 'Laporan hasil pengelolaan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal memperbarui laporan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified laporan hasil
     */
    public function destroy(LaporanHasilPengelolaan $laporanHasilPengelolaan): RedirectResponse
    {
        $user = Auth::user();

        if ($laporanHasilPengelolaan->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        if (!$laporanHasilPengelolaan->canEdit()) {
            return redirect()->route('laporan-hasil-pengelolaan.index')
                ->with('error', 'Laporan hasil ini tidak dapat dihapus.');
        }

        try {
            // Hapus file dokumentasi
            if ($laporanHasilPengelolaan->dokumentasi) {
                foreach ($laporanHasilPengelolaan->dokumentasi as $filePath) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            $laporanHasilPengelolaan->delete();

            return redirect()->route('laporan-hasil-pengelolaan.index')
                ->with('success', 'Laporan hasil pengelolaan berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('laporan-hasil-pengelolaan.index')
                ->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }

    /**
     * Submit laporan untuk validasi
     */
    public function submit(LaporanHasilPengelolaan $laporanHasilPengelolaan): RedirectResponse
    {
        $user = Auth::user();

        if ($laporanHasilPengelolaan->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        if (!$laporanHasilPengelolaan->canSubmit()) {
            return redirect()->back()
                ->with('error', 'Laporan hasil ini tidak dapat disubmit.');
        }

        try {
            $laporanHasilPengelolaan->submit();

            return redirect()->route('laporan-hasil-pengelolaan.show', $laporanHasilPengelolaan)
                ->with('success', 'Laporan hasil berhasil disubmit untuk validasi.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal submit laporan: ' . $e->getMessage());
        }
    }

    /**
     * Approve laporan hasil (Admin only)
     */
    public function approve(Request $request, LaporanHasilPengelolaan $laporanHasilPengelolaan): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$laporanHasilPengelolaan->canApprove()) {
            return redirect()->back()
                ->with('error', 'Laporan hasil ini tidak dapat disetujui.');
        }

        $request->validate([
            'catatan_validasi' => 'nullable|string|max:1000'
        ]);

        try {
            $laporanHasilPengelolaan->approve(auth()->id(), $request->catatan_validasi);

            return redirect()->route('laporan-hasil-pengelolaan.show', $laporanHasilPengelolaan)
                ->with('success', 'Laporan hasil berhasil disetujui.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyetujui laporan: ' . $e->getMessage());
        }
    }

    /**
     * Reject laporan hasil (Admin only)
     */
    public function reject(Request $request, LaporanHasilPengelolaan $laporanHasilPengelolaan): RedirectResponse
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$laporanHasilPengelolaan->canApprove()) {
            return redirect()->back()
                ->with('error', 'Laporan hasil ini tidak dapat ditolak.');
        }

        $request->validate([
            'catatan_validasi' => 'required|string|max:1000'
        ], [
            'catatan_validasi.required' => 'Catatan penolakan wajib diisi.'
        ]);

        try {
            $laporanHasilPengelolaan->reject(auth()->id(), $request->catatan_validasi);

            return redirect()->route('laporan-hasil-pengelolaan.show', $laporanHasilPengelolaan)
                ->with('success', 'Laporan hasil berhasil ditolak.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menolak laporan: ' . $e->getMessage());
        }
    }

    /**
     * Download dokumentasi file
     */
    public function downloadDokumentasi(LaporanHasilPengelolaan $laporanHasilPengelolaan, $index)
    {
        $user = Auth::user();

        // Check authorization
        if ($laporanHasilPengelolaan->perusahaan_id !== $user->perusahaan->id && !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        if (!isset($laporanHasilPengelolaan->dokumentasi[$index])) {
            abort(404, 'File tidak ditemukan.');
        }

        $filePath = $laporanHasilPengelolaan->dokumentasi[$index];
        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan di storage.');
        }

        return Storage::disk('public')->download($filePath);
    }

    /**
     * Export laporan hasil to CSV
     */
    public function export(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasValidPerusahaan()) {
            return redirect()->route('perusahaan.create')
                ->with('error', 'Silakan lengkapi profil perusahaan terlebih dahulu.');
        }

        $query = LaporanHasilPengelolaan::with(['pengelolaanLimbah.jenisLimbah', 'pengelolaanLimbah.vendor'])
            ->byPerusahaan($user->perusahaan->id);

        // Apply same filters as index
        if ($request->filled('status_hasil')) {
            $query->byStatus($request->status_hasil);
        }

        if ($request->filled('status_validasi')) {
            $query->byValidasi($request->status_validasi);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_selesai', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_selesai', '<=', $request->tanggal_sampai);
        }

        $laporanHasil = $query->latest('tanggal_selesai')->get();

        $filename = 'laporan-hasil-pengelolaan-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($laporanHasil) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'Tanggal Selesai',
                'Jenis Limbah',
                'Jumlah Dikelola',
                'Jumlah Berhasil',
                'Jumlah Residu',
                'Efisiensi (%)',
                'Status Hasil',
                'Metode Disposal',
                'Biaya Aktual',
                'Vendor',
                'Status Validasi',
                'Nomor Sertifikat'
            ]);

            // Data
            foreach ($laporanHasil as $item) {
                fputcsv($file, [
                    $item->tanggal_selesai->format('d/m/Y'),
                    $item->pengelolaanLimbah->jenisLimbah->nama,
                    number_format($item->pengelolaanLimbah->jumlah_dikelola, 2) . ' ' . $item->satuan,
                    number_format($item->jumlah_berhasil_dikelola, 2) . ' ' . $item->satuan,
                    number_format($item->jumlah_residu, 2) . ' ' . $item->satuan,
                    number_format($item->efisiensi_pengelolaan, 2) . '%',
                    $item->status_hasil_name,
                    $item->metode_disposal_akhir ?? '-',
                    $item->biaya_aktual ? 'Rp ' . number_format($item->biaya_aktual, 2) : '-',
                    $item->pengelolaanLimbah->vendor->nama_perusahaan ?? '-',
                    $item->status_validasi_name,
                    $item->nomor_sertifikat ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Dashboard/Summary data
     */
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user->hasValidPerusahaan()) {
            return redirect()->route('perusahaan.create')
                ->with('info', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        $perusahaanId = $user->perusahaan->id;

        // Summary statistics
        $totalLaporan = LaporanHasilPengelolaan::byPerusahaan($perusahaanId)->count();
        $laporanBerhasil = LaporanHasilPengelolaan::byPerusahaan($perusahaanId)->byStatus('berhasil')->count();
        $laporanPartial = LaporanHasilPengelolaan::byPerusahaan($perusahaanId)->byStatus('partial')->count();
        $laporanGagal = LaporanHasilPengelolaan::byPerusahaan($perusahaanId)->byStatus('gagal')->count();

        // Efisiensi rata-rata
        $avgEfisiensi = LaporanHasilPengelolaan::byPerusahaan($perusahaanId)
            ->avg('efisiensi_pengelolaan') ?? 0;

        // Total biaya
        $totalBiaya = LaporanHasilPengelolaan::byPerusahaan($perusahaanId)
            ->sum('biaya_aktual') ?? 0;

        // Recent reports
        $recentReports = LaporanHasilPengelolaan::with(['pengelolaanLimbah.jenisLimbah'])
            ->byPerusahaan($perusahaanId)
            ->latest('tanggal_selesai')
            ->take(5)
            ->get();

        return view('laporan-hasil-pengelolaan.dashboard', compact(
            'totalLaporan',
            'laporanBerhasil',
            'laporanPartial',
            'laporanGagal',
            'avgEfisiensi',
            'totalBiaya',
            'recentReports'
        ));
    }

    /**
     * Get pengelolaan limbah yang bisa dibuat laporan hasil (AJAX)
     */
    public function getPengelolaanSelesai(Request $request)
    {
        $user = Auth::user();
        
        $pengelolaanLimbahs = PengelolaanLimbah::with(['jenisLimbah', 'penyimpanan'])
            ->where('perusahaan_id', $user->perusahaan->id)
            ->where('status', 'selesai')
            ->whereDoesntHave('laporanHasil')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'tanggal_mulai' => $item->tanggal_mulai->format('d/m/Y'),
                    'jenis_limbah' => $item->jenisLimbah->nama,
                    'jumlah_dikelola' => $item->jumlah_dikelola,
                    'satuan' => $item->satuan,
                    'penyimpanan' => $item->penyimpanan->nama_penyimpanan,
                    'jenis_pengelolaan' => $item->jenis_pengelolaan_name
                ];
            });

        return response()->json($pengelolaanLimbahs);
    }
}
