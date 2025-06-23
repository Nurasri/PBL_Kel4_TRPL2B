<?php

namespace App\Http\Controllers;

use App\Models\LaporanHasilPengelolaan;
use App\Models\PengelolaanLimbah;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaporanHasilPengelolaanController extends Controller
{
    /**
     * Display a listing of laporan hasil pengelolaan
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        
        // Base query
        $query = LaporanHasilPengelolaan::with([
            'pengelolaanLimbah.jenisLimbah', 
            'pengelolaanLimbah.penyimpanan',
            'pengelolaanLimbah.vendor',
            'perusahaan'
        ]);

        // Filter berdasarkan role
        if ($user->isPerusahaan()) {
            // Perusahaan hanya melihat laporan mereka sendiri
            $query->where('perusahaan_id', $user->perusahaan->id);
        }
        // Admin dapat melihat semua laporan (tidak ada filter tambahan)

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pengelolaanLimbah.jenisLimbah', function ($subQ) use ($search) {
                    $subQ->where('nama', 'like', "%{$search}%")
                         ->orWhere('kode_limbah', 'like', "%{$search}%");
                })
                ->orWhereHas('pengelolaanLimbah.vendor', function ($subQ) use ($search) {
                    $subQ->where('nama_perusahaan', 'like', "%{$search}%");
                })
                ->orWhereHas('perusahaan', function ($subQ) use ($search) {
                    $subQ->where('nama_perusahaan', 'like', "%{$search}%");
                })
                ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        // Filter by perusahaan (hanya untuk admin)
        if ($user->isAdmin() && $request->filled('perusahaan_id')) {
            $query->where('perusahaan_id', $request->perusahaan_id);
        }

        // Filter by jenis limbah
        if ($request->filled('jenis_limbah_id')) {
            $query->whereHas('pengelolaanLimbah', function ($q) use ($request) {
                $q->where('jenis_limbah_id', $request->jenis_limbah_id);
            });
        }

        // Filter by vendor
        if ($request->filled('vendor_id')) {
            $query->whereHas('pengelolaanLimbah', function ($q) use ($request) {
                $q->where('vendor_id', $request->vendor_id);
            });
        }

        // Filter by status hasil
        if ($request->filled('status_hasil')) {
            $query->where('status_hasil', $request->status_hasil);
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_selesai', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_selesai', '<=', $request->tanggal_sampai);
        }

        $laporanHasil = $query->latest('tanggal_selesai')->paginate(15)->withQueryString();

        // Data untuk filter
        $jenisLimbahOptions = \App\Models\JenisLimbah::pluck('nama', 'id');
        $vendorOptions = \App\Models\Vendor::pluck('nama_perusahaan', 'id');
        $statusOptions = LaporanHasilPengelolaan::getStatusHasilOptions();
        
        // Filter options berdasarkan role
        if ($user->isAdmin()) {
            $perusahaanOptions = Perusahaan::pluck('nama_perusahaan', 'id');
        } else {
            $perusahaanOptions = collect(); // Kosong untuk perusahaan
        }

        return view('laporan-hasil-pengelolaan.index', compact(
            'laporanHasil',
            'jenisLimbahOptions',
            'vendorOptions',
            'statusOptions',
            'perusahaanOptions'
        ));
    }

    /**
     * Show the form for creating a new laporan (Perusahaan only)
     */
    public function create(): View
    {
        $user = Auth::user();
        
        // Hanya perusahaan yang bisa create
        if (!$user->isPerusahaan()) {
            abort(403, 'Hanya perusahaan yang dapat membuat laporan hasil pengelolaan.');
        }

        // Get pengelolaan limbah yang sudah selesai tapi belum ada laporannya
        $pengelolaanLimbah = PengelolaanLimbah::with(['jenisLimbah', 'penyimpanan', 'vendor'])
            ->where('perusahaan_id', $user->perusahaan->id)
            ->where('status', 'selesai')
            ->whereDoesntHave('laporanHasilPengelolaan')
            ->get();

        return view('laporan-hasil-pengelolaan.create', compact('pengelolaanLimbah'));
    }

    /**
     * Store a newly created laporan
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Hanya perusahaan yang bisa store
        if (!$user->isPerusahaan()) {
            abort(403, 'Hanya perusahaan yang dapat membuat laporan hasil pengelolaan.');
        }

        $request->validate([
            'pengelolaan_limbah_id' => 'required|exists:pengelolaan_limbahs,id',
            'tanggal_selesai' => 'required|date',
            'jumlah_berhasil_dikelola' => 'required|numeric|min:0',
            'jumlah_residu' => 'nullable|numeric|min:0',
            'status_hasil' => 'required|in:berhasil,sebagian_berhasil,gagal',
            'keterangan' => 'nullable|string',
            'dokumentasi.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        try {
            DB::beginTransaction();

            // Validasi pengelolaan limbah milik perusahaan
            $pengelolaanLimbah = PengelolaanLimbah::where('id', $request->pengelolaan_limbah_id)
                ->where('perusahaan_id', $user->perusahaan->id)
                ->where('status', 'selesai')
                ->first();

            if (!$pengelolaanLimbah) {
                return back()->withInput()
                    ->with('error', 'Pengelolaan limbah tidak valid atau belum selesai.');
            }

            // Check if laporan already exists
            if ($pengelolaanLimbah->laporanHasilPengelolaan) {
                return back()->withInput()
                    ->with('error', 'Laporan hasil pengelolaan untuk pengelolaan ini sudah ada.');
            }

            $data = $request->only([
                'pengelolaan_limbah_id', 'tanggal_selesai', 'jumlah_berhasil_dikelola',
                'jumlah_residu', 'status_hasil', 'keterangan'
            ]);

            $data['perusahaan_id'] = $user->perusahaan->id;
            $data['satuan'] = $pengelolaanLimbah->satuan;

            // Handle file uploads
            if ($request->hasFile('dokumentasi')) {
                $dokumentasi = [];
                foreach ($request->file('dokumentasi') as $file) {
                    $path = $file->store('laporan-hasil-pengelolaan', 'public');
                    $dokumentasi[] = $path;
                }
                $data['dokumentasi'] = json_encode($dokumentasi);
            }

            LaporanHasilPengelolaan::create($data);

            DB::commit();

            return redirect()->route('laporan-hasil-pengelolaan.index')
                ->with('success', 'Laporan hasil pengelolaan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->with('error', 'Gagal menambahkan laporan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified laporan
     */
    public function show(LaporanHasilPengelolaan $laporanHasilPengelolaan): View
    {
        $user = Auth::user();
        
        // Debug: log akses
        \Log::info('User accessing laporan hasil pengelolaan show:', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'laporan_id' => $laporanHasilPengelolaan->id,
            'laporan_perusahaan_id' => $laporanHasilPengelolaan->perusahaan_id
        ]);
        
        // Check access permission
        if ($user->isPerusahaan() && $laporanHasilPengelolaan->perusahaan_id !== $user->perusahaan->id) {
            \Log::warning('Unauthorized access attempt to laporan hasil pengelolaan', [
                'user_id' => $user->id,
                'laporan_id' => $laporanHasilPengelolaan->id
            ]);
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        $laporanHasilPengelolaan->load([
            'pengelolaanLimbah.jenisLimbah',
            'pengelolaanLimbah.penyimpanan',
            'pengelolaanLimbah.vendor',
            'perusahaan'
        ]);
        
        return view('laporan-hasil-pengelolaan.show', compact('laporanHasilPengelolaan'));
    }

    /**
     * Show the form for editing (Perusahaan only)
     */
    public function edit(LaporanHasilPengelolaan $laporanHasilPengelolaan): View
    {
        $user = Auth::user();
        
        // Hanya perusahaan yang bisa edit dan hanya laporan mereka sendiri
        if (!$user->isPerusahaan() || $laporanHasilPengelolaan->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit laporan ini.');
        }

        $laporanHasilPengelolaan->load([
            'pengelolaanLimbah.jenisLimbah',
            'pengelolaanLimbah.penyimpanan',
            'pengelolaanLimbah.vendor'
        ]);

        return view('laporan-hasil-pengelolaan.edit', compact('laporanHasilPengelolaan'));
    }

    /**
     * Update the specified laporan (Perusahaan only)
     */
    public function update(Request $request, LaporanHasilPengelolaan $laporanHasilPengelolaan): RedirectResponse
    {
        $user = Auth::user();
        
        // Hanya perusahaan yang bisa update dan hanya laporan mereka sendiri
        if (!$user->isPerusahaan() || $laporanHasilPengelolaan->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate laporan ini.');
        }

        $request->validate([
            'tanggal_selesai' => 'required|date',
            'jumlah_berhasil_dikelola' => 'required|numeric|min:0',
            'jumlah_residu' => 'nullable|numeric|min:0',
            'status_hasil' => 'required|in:berhasil,sebagian_berhasil,gagal',
            'keterangan' => 'nullable|string',
            'dokumentasi.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        try {
            $data = $request->only([
                'tanggal_selesai', 'jumlah_berhasil_dikelola',
                'jumlah_residu', 'status_hasil', 'keterangan'
            ]);

            // Handle file uploads
            if ($request->hasFile('dokumentasi')) {
                // Delete old files
                if ($laporanHasilPengelolaan->dokumentasi) {
                    $oldFiles = json_decode($laporanHasilPengelolaan->dokumentasi, true);
                    foreach ($oldFiles as $file) {
                        Storage::disk('public')->delete($file);
                    }
                }

                $dokumentasi = [];
                foreach ($request->file('dokumentasi') as $file) {
                    $path = $file->store('laporan-hasil-pengelolaan', 'public');
                    $dokumentasi[] = $path;
                }
                $data['dokumentasi'] = json_encode($dokumentasi);
            }

            $laporanHasilPengelolaan->update($data);

            return redirect()->route('laporan-hasil-pengelolaan.show', $laporanHasilPengelolaan)
                ->with('success', 'Laporan hasil pengelolaan berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui laporan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified laporan (Perusahaan only)
     */
    public function destroy(LaporanHasilPengelolaan $laporanHasilPengelolaan): RedirectResponse
    {
        $user = Auth::user();
        
                // Hanya perusahaan yang bisa delete dan hanya laporan mereka sendiri
        if (!$user->isPerusahaan() || $laporanHasilPengelolaan->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus laporan ini.');
        }

        try {
            // Delete uploaded files
            if ($laporanHasilPengelolaan->dokumentasi) {
                $files = json_decode($laporanHasilPengelolaan->dokumentasi, true);
                foreach ($files as $file) {
                    Storage::disk('public')->delete($file);
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
     * Download dokumentasi file
     */
    public function downloadDokumentasi(LaporanHasilPengelolaan $laporanHasilPengelolaan, $index)
    {
        $user = Auth::user();

        // Check authorization - admin dan perusahaan pemilik bisa download
        if ($user->isPerusahaan() && $laporanHasilPengelolaan->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        if (!$laporanHasilPengelolaan->dokumentasi) {
            abort(404, 'Tidak ada dokumentasi.');
        }

        $files = json_decode($laporanHasilPengelolaan->dokumentasi, true);
        
        if (!isset($files[$index])) {
            abort(404, 'File tidak ditemukan.');
        }

        $filePath = $files[$index];
        
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

        // Base query
        $query = LaporanHasilPengelolaan::with([
            'pengelolaanLimbah.jenisLimbah',
            'pengelolaanLimbah.vendor',
            'perusahaan'
        ]);

        // Filter berdasarkan role
        if ($user->isPerusahaan()) {
            $query->where('perusahaan_id', $user->perusahaan->id);
        }

        // Apply same filters as index
        if ($request->filled('perusahaan_id') && $user->isAdmin()) {
            $query->where('perusahaan_id', $request->perusahaan_id);
        }

        if ($request->filled('status_hasil')) {
            $query->where('status_hasil', $request->status_hasil);
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

        $callback = function() use ($laporanHasil, $user) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            $csvHeaders = [
                'Tanggal Selesai',
                'Jenis Limbah',
                'Jumlah Berhasil Dikelola',
                'Jumlah Residu',
                'Status Hasil',
                'Vendor',
                'Keterangan'
            ];

            // Tambah kolom perusahaan untuk admin
            if ($user->isAdmin()) {
                array_splice($csvHeaders, 1, 0, 'Perusahaan');
            }

            fputcsv($file, $csvHeaders);

            // Data
            foreach ($laporanHasil as $item) {
                $row = [
                    $item->tanggal_selesai->format('d/m/Y'),
                    $item->pengelolaanLimbah->jenisLimbah->nama,
                    number_format($item->jumlah_berhasil_dikelola, 2) . ' ' . $item->satuan,
                    number_format($item->jumlah_residu ?? 0, 2) . ' ' . $item->satuan,
                    ucfirst(str_replace('_', ' ', $item->status_hasil)),
                    $item->pengelolaanLimbah->vendor->nama_perusahaan ?? '-',
                    $item->keterangan ?? '-'
                ];

                // Tambah data perusahaan untuk admin
                if ($user->isAdmin()) {
                    array_splice($row, 1, 0, $item->perusahaan->nama_perusahaan);
                }

                fputcsv($file, $row);
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

        if ($user->isPerusahaan() && !$user->hasValidPerusahaan()) {
            return redirect()->route('perusahaan.create')
                ->with('info', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        // Base query
        $query = LaporanHasilPengelolaan::query();

        // Filter berdasarkan role
        if ($user->isPerusahaan()) {
            $query->where('perusahaan_id', $user->perusahaan->id);
        }

        // Summary statistics
        $totalLaporan = $query->count();
        $laporanBerhasil = (clone $query)->where('status_hasil', 'berhasil')->count();
        $laporanSebagianBerhasil = (clone $query)->where('status_hasil', 'sebagian_berhasil')->count();
        $laporanGagal = (clone $query)->where('status_hasil', 'gagal')->count();

        // Recent reports
        $recentReports = (clone $query)->with([
                'pengelolaanLimbah.jenisLimbah',
                'perusahaan'
            ])
            ->latest('tanggal_selesai')
            ->take(5)
            ->get();

        // Monthly statistics for chart
        $monthlyStats = (clone $query)
            ->selectRaw('MONTH(tanggal_selesai) as month, COUNT(*) as total')
            ->whereYear('tanggal_selesai', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = $monthlyStats[$i] ?? 0;
        }

        return view('laporan-hasil-pengelolaan.dashboard', compact(
            'totalLaporan',
            'laporanBerhasil',
            'laporanSebagianBerhasil',
            'laporanGagal',
            'recentReports',
            'monthlyData'
        ));
    }

    /**
     * Get pengelolaan limbah yang bisa dibuat laporan hasil (AJAX)
     */
    public function getPengelolaanSelesai(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isPerusahaan()) {
            return response()->json([]);
        }
        
        $pengelolaanLimbahs = PengelolaanLimbah::with(['jenisLimbah', 'penyimpanan'])
            ->where('perusahaan_id', $user->perusahaan->id)
            ->where('status', 'selesai')
            ->whereDoesntHave('laporanHasilPengelolaan')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'tanggal_mulai' => $item->tanggal_mulai->format('d/m/Y'),
                    'jenis_limbah' => $item->jenisLimbah->nama,
                    'jumlah_dikelola' => $item->jumlah_dikelola,
                    'satuan' => $item->satuan,
                    'penyimpanan' => $item->penyimpanan->nama_penyimpanan,
                    'jenis_pengelolaan' => $item->jenis_pengelolaan_name ?? 'Pengelolaan Limbah'
                ];
            });

        return response()->json($pengelolaanLimbahs);
    }

    /**
     * Bulk actions for laporan hasil (Perusahaan only)
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->isPerusahaan()) {
            abort(403, 'Hanya perusahaan yang dapat melakukan bulk action.');
        }

        $request->validate([
            'action' => 'required|in:delete',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:laporan_hasil_pengelolaans,id'
        ]);

        try {
            $selectedItems = LaporanHasilPengelolaan::whereIn('id', $request->selected_items)
                ->where('perusahaan_id', $user->perusahaan->id)
                ->get();

            if ($selectedItems->count() !== count($request->selected_items)) {
                return back()->with('error', 'Beberapa laporan tidak ditemukan atau bukan milik Anda.');
            }

            switch ($request->action) {
                case 'delete':
                    foreach ($selectedItems as $item) {
                        // Delete uploaded files
                        if ($item->dokumentasi) {
                            $files = json_decode($item->dokumentasi, true);
                            foreach ($files as $file) {
                                Storage::disk('public')->delete($file);
                            }
                        }
                        $item->delete();
                    }
                    
                    return redirect()->route('laporan-hasil-pengelolaan.index')
                        ->with('success', count($selectedItems) . ' laporan berhasil dihapus.');
                    
                default:
                    return back()->with('error', 'Aksi tidak valid.');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal melakukan bulk action: ' . $e->getMessage());
        }
    }
}
