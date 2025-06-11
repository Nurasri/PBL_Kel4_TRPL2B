<?php

namespace App\Http\Controllers;

use App\Models\LaporanHarian;
use App\Models\JenisLimbah;
use App\Models\Penyimpanan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanHarianController extends Controller
{
    /**
     * Display a listing of laporan harian
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        
        // Pastikan user memiliki perusahaan
        if (!$user->hasValidPerusahaan()) {
            return redirect()->route('perusahaan.create')
                ->with('info', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        $query = LaporanHarian::with(['jenisLimbah', 'penyimpanan'])
            ->byPerusahaan($user->perusahaan->id);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('jenisLimbah', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode_limbah', 'like', "%{$search}%");
            })->orWhereHas('penyimpanan', function($q) use ($search) {
                $q->where('nama_penyimpanan', 'like', "%{$search}%");
            })->orWhere('keterangan', 'like', "%{$search}%");
        }

        // Filter by jenis limbah
        if ($request->filled('jenis_limbah_id')) {
            $query->byJenisLimbah($request->jenis_limbah_id);
        }

        // Filter by penyimpanan
        if ($request->filled('penyimpanan_id')) {
            $query->byPenyimpanan($request->penyimpanan_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        $laporan = $query->latest('tanggal')->paginate(15)->withQueryString();

        // Data untuk filter
        $jenisLimbahOptions = JenisLimbah::where('status', 'active')
            ->orderBy('nama')
            ->pluck('nama', 'id');

        $penyimpananOptions = Penyimpanan::where('perusahaan_id', $user->perusahaan->id)
            ->where('status', 'aktif')
            ->orderBy('nama_penyimpanan')
            ->pluck('nama_penyimpanan', 'id');

        $statusOptions = LaporanHarian::getStatusOptions();

        return view('laporan-harian.index', compact(
            'laporan',
            'jenisLimbahOptions',
            'penyimpananOptions', 
            'statusOptions'
        ));
    }

    /**
     * Show the form for creating a new laporan
     */
    public function create(): View
    {
        $user = Auth::user();
        
        if (!$user->hasValidPerusahaan()) {
            return redirect()->route('perusahaan.create')
                ->with('error', 'Silakan lengkapi profil perusahaan terlebih dahulu.');
        }

        // Ambil jenis limbah aktif
        $jenisLimbahs = JenisLimbah::where('status', 'active')
            ->orderBy('nama')
            ->get();

        // Ambil penyimpanan milik perusahaan yang aktif
        $penyimpanans = Penyimpanan::where('perusahaan_id', $user->perusahaan->id)
            ->where('status', 'aktif')
            ->orderBy('nama_penyimpanan')
            ->get();

        return view('laporan-harian.create', compact('jenisLimbahs', 'penyimpanans'));
    }

    /**
     * Store a newly created laporan
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            LaporanHarian::validationRules(),
            LaporanHarian::validationMessages()
        );

        try {
            DB::beginTransaction();

            // Validasi penyimpanan milik perusahaan
            $penyimpanan = Penyimpanan::where('id', $request->penyimpanan_id)
                ->where('perusahaan_id', auth()->user()->perusahaan->id)
                ->first();

            if (!$penyimpanan) {
                return back()->withErrors(['penyimpanan_id' => 'Penyimpanan tidak valid.'])->withInput();
            }

            // Validasi kapasitas jika langsung submit
            if ($request->status === 'submitted') {
                if (!$penyimpanan->canAccommodate($request->jumlah)) {
                    return back()->withErrors([
                        'jumlah' => 'Kapasitas penyimpanan tidak mencukupi. Sisa kapasitas: ' . 
                               number_format($penyimpanan->sisa_kapasitas, 2) . ' ' . $penyimpanan->satuan
                    ])->withInput();
                }
            }

            // Ambil satuan dari jenis limbah
            $jenisLimbah = JenisLimbah::find($request->jenis_limbah_id);
        
            $laporan = new LaporanHarian([
                'perusahaan_id' => auth()->user()->perusahaan->id,
                'jenis_limbah_id' => $request->jenis_limbah_id,
                'penyimpanan_id' => $request->penyimpanan_id,
                'tanggal' => $request->tanggal,
                'jumlah' => $request->jumlah,
                'satuan' => $jenisLimbah->satuan_default,
                'status' => $request->get('status', 'draft'),
                'keterangan' => $request->keterangan
            ]);
            
            $laporan->save();

            // Update kapasitas jika submitted
            if ($request->status === 'submitted') {
                $penyimpanan->addLimbah($request->jumlah);
            }

            DB::commit();

            $message = $laporan->isDraft() ? 
                'Laporan berhasil disimpan sebagai draft.' : 
                'Laporan berhasil disubmit dan kapasitas penyimpanan telah diperbarui.';

            return redirect()->route('laporan-harian.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menyimpan laporan: ' . $e->getMessage()])->withInput();
        }
    }
    /**
     * Display the specified laporan
     */
    public function show(LaporanHarian $laporanHarian): View
    {
        $user = Auth::user();
        
        // Pastikan user hanya bisa melihat laporan milik perusahaannya
        if ($laporanHarian->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        $laporanHarian->load(['jenisLimbah', 'penyimpanan', 'perusahaan']);
        
        return view('laporan-harian.show', compact('laporanHarian'));
    }

    /**
     * Show the form for editing the specified laporan
     */
    public function edit(LaporanHarian $laporanHarian): View
    {
        $user = Auth::user();
        
        // Pastikan user hanya bisa edit laporan milik perusahaannya
        if ($laporanHarian->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        // Pastikan laporan bisa diedit
        if (!$laporanHarian->canEdit()) {
            return redirect()->route('laporan-harian.show', $laporanHarian)
                ->with('error', 'Laporan yang sudah disubmit tidak dapat diedit.');
        }

        $jenisLimbahs = JenisLimbah::where('status', 'active')
            ->orderBy('nama')
            ->get();

        $penyimpanans = Penyimpanan::where('perusahaan_id', $user->perusahaan->id)
            ->where('status', 'aktif')
            ->orderBy('nama_penyimpanan')
            ->get();

        return view('laporan-harian.edit', compact('laporanHarian', 'jenisLimbahs', 'penyimpanans'));
    }

    /**
     * Update the specified laporan
     */
    public function update(Request $request, LaporanHarian $laporanHarian): RedirectResponse
    {
        $user = Auth::user();
        
        // Pastikan user hanya bisa update laporan milik perusahaannya
        if ($laporanHarian->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        // Pastikan laporan bisa diedit
        if (!$laporanHarian->canEdit()) {
            return redirect()->route('laporan-harian.show', $laporanHarian)
                ->with('error', 'Laporan yang sudah disubmit tidak dapat diedit.');
        }

        $request->validate(
            LaporanHarian::validationRules($laporanHarian->id),
            LaporanHarian::validationMessages()
        );

        try {
            DB::beginTransaction();

            // Validasi penyimpanan milik perusahaan
            $penyimpanan = Penyimpanan::where('id', $request->penyimpanan_id)
                ->where('perusahaan_id', $user->perusahaan->id)
                ->first();

            if (!$penyimpanan) {
                return back()->withErrors(['penyimpanan_id' => 'Penyimpanan tidak valid.'])->withInput();
            }

            // Validasi kapasitas jika akan disubmit
            if ($request->status === 'submitted') {
                if (!$penyimpanan->canAccommodate($request->jumlah)) {
                    return back()->withErrors([
                        'jumlah' => 'Kapasitas penyimpanan tidak mencukupi. Sisa kapasitas: ' . 
                                   number_format($penyimpanan->sisa_kapasitas, 2) . ' ' . $penyimpanan->satuan
                    ])->withInput();
                }
            }

            $laporanHarian->update($request->all());

            DB::commit();

            $message = $laporanHarian->isDraft() ? 
                'Laporan berhasil diperbarui.' : 
                'Laporan berhasil disubmit dan kapasitas penyimpanan telah diperbarui.';

            return redirect()->route('laporan-harian.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal memperbarui laporan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified laporan
     */
    public function destroy(LaporanHarian $laporanHarian): RedirectResponse
    {
        $user = Auth::user();
        
        // Pastikan user hanya bisa hapus laporan milik perusahaannya
        if ($laporanHarian->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        // Pastikan laporan bisa dihapus
        if (!$laporanHarian->canDelete()) {
            return redirect()->route('laporan-harian.index')
                ->with('error', 'Laporan yang sudah disubmit tidak dapat dihapus.');
        }

        try {
            $laporanHarian->delete();
            return redirect()->route('laporan-harian.index')
                ->with('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('laporan-harian.index')
                ->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }

    /**
     * Submit laporan (change status from draft to submitted)
     */
    public function submit(LaporanHarian $laporanHarian): RedirectResponse
    {
        $user = Auth::user();
        
        // Pastikan user hanya bisa submit laporan milik perusahaannya
        if ($laporanHarian->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        if (!$laporanHarian->canSubmit()) {
            return redirect()->route('laporan-harian.show', $laporanHarian)
                ->with('error', 'Laporan tidak dapat disubmit.');
        }

        try {
            DB::beginTransaction();

            // Validasi kapasitas penyimpanan
            if (!$laporanHarian->penyimpanan->canAccommodate($laporanHarian->jumlah)) {
                return back()->with('error', 
                    'Kapasitas penyimpanan tidak mencukupi. Sisa kapasitas: ' . 
                    number_format($laporanHarian->penyimpanan->sisa_kapasitas, 2) . ' ' . 
                    $laporanHarian->penyimpanan->satuan
                );
            }

            $laporanHarian->submit();

            DB::commit();

            return redirect()->route('laporan-harian.index')
                ->with('success', 'Laporan berhasil disubmit dan kapasitas penyimpanan telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal submit laporan: ' . $e->getMessage());
        }
    }

        /**
     * Get penyimpanan by jenis limbah (AJAX)
     */
    public function getPenyimpananByJenisLimbah(Request $request)
    {
        try {
            $jenisLimbahId = $request->get('jenis_limbah_id');
            $perusahaanId = auth()->user()->perusahaan->id;

            $penyimpanans = Penyimpanan::where('perusahaan_id', $perusahaanId)
                ->where('jenis_limbah_id', $jenisLimbahId)
                ->where('status', 'aktif')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nama_penyimpanan' => $item->nama_penyimpanan,
                        'lokasi' => $item->lokasi,
                        'sisa_kapasitas' => $item->sisa_kapasitas,
                        'satuan' => $item->satuan,
                        'persentase_kapasitas' => $item->persentase_kapasitas,
                        'status_kapasitas_text' => $item->status_kapasitas_text,
                        'status_kapasitas_color' => $item->status_kapasitas_color,
                    ];
                });

            return response()->json($penyimpanans);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get jenis limbah info (AJAX)
     */
    public function getJenisLimbahInfo(Request $request)
    {
        $jenisLimbahId = $request->jenis_limbah_id;
        
        $jenisLimbah = JenisLimbah::find($jenisLimbahId);
        
        if (!$jenisLimbah) {
            return response()->json(['error' => 'Jenis limbah tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $jenisLimbah->id,
            'nama' => $jenisLimbah->nama,
            'kode_limbah' => $jenisLimbah->kode_limbah,
            'kategori' => $jenisLimbah->kategori,
            'kategori_name' => $jenisLimbah->kategori_name,
            'satuan_default' => $jenisLimbah->satuan_default,
            'satuan_name' => $jenisLimbah->satuan_name,
            'tingkat_bahaya' => $jenisLimbah->tingkat_bahaya,
            'tingkat_bahaya_name' => $jenisLimbah->tingkat_bahaya_name,
            'deskripsi' => $jenisLimbah->deskripsi
        ]);
    }

    /**
     * Get laporan statistics for dashboard
     */
    public function getStatistics(Request $request)
    {
        $user = Auth::user();
        $perusahaanId = $user->perusahaan->id;
        
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        $statistics = [
            'total_laporan' => LaporanHarian::byPerusahaan($perusahaanId)
                ->byDateRange($startDate, $endDate)
                ->count(),
            
            'laporan_draft' => LaporanHarian::byPerusahaan($perusahaanId)
                ->byStatus('draft')
                ->byDateRange($startDate, $endDate)
                ->count(),
            
            'laporan_submitted' => LaporanHarian::byPerusahaan($perusahaanId)
                ->byStatus('submitted')
                ->byDateRange($startDate, $endDate)
                ->count(),
            
            'total_limbah' => LaporanHarian::byPerusahaan($perusahaanId)
                ->byStatus('submitted')
                ->byDateRange($startDate, $endDate)
                ->sum('jumlah'),
            
            'jenis_limbah_terbanyak' => LaporanHarian::byPerusahaan($perusahaanId)
                ->byStatus('submitted')
                ->byDateRange($startDate, $endDate)
                ->with('jenisLimbah')
                ->get()
                ->groupBy('jenis_limbah_id')
                ->map(function($group) {
                    return [
                        'jenis_limbah' => $group->first()->jenisLimbah->nama,
                        'total' => $group->sum('jumlah'),
                        'satuan' => $group->first()->satuan
                    ];
                })
                ->sortByDesc('total')
                ->take(5)
                ->values()
        ];

        return response()->json($statistics);
    }

    /**
     * Export laporan to Excel/CSV
     */
    public function export(Request $request)
    {
        $user = Auth::user();
        $query = LaporanHarian::with(['jenisLimbah', 'penyimpanan'])
            ->byPerusahaan($user->perusahaan->id);

        // Apply same filters as index
        if ($request->filled('jenis_limbah_id')) {
            $query->byJenisLimbah($request->jenis_limbah_id);
        }

        if ($request->filled('penyimpanan_id')) {
            $query->byPenyimpanan($request->penyimpanan_id);
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        $laporan = $query->latest('tanggal')->get();

        // Simple CSV export
        $filename = 'laporan-harian-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($laporan) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'Tanggal',
                'Jenis Limbah',
                'Kode Limbah',
                'Penyimpanan',
                'Lokasi',
                'Jumlah',
                'Satuan',
                'Status',
                'Keterangan',
                'Tanggal Laporan'
            ]);

            // Data CSV
            foreach ($laporan as $item) {
                fputcsv($file, [
                    $item->tanggal->format('d/m/Y'),
                    $item->jenisLimbah->nama,
                    $item->jenisLimbah->kode_limbah,
                    $item->penyimpanan->nama_penyimpanan,
                    $item->penyimpanan->lokasi,
                    $item->jumlah,
                    $item->satuan,
                    $item->status_name,
                    $item->keterangan,
                    $item->tanggal_laporan->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk actions for multiple laporan
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,submit',
            'laporan_ids' => 'required|array',
            'laporan_ids.*' => 'exists:laporan_harians,id'
        ]);

        $user = Auth::user();
        $laporanIds = $request->laporan_ids;
        
        // Pastikan semua laporan milik perusahaan user
        $laporan = LaporanHarian::whereIn('id', $laporanIds)
            ->where('perusahaan_id', $user->perusahaan->id)
            ->get();

        if ($laporan->count() !== count($laporanIds)) {
            return back()->with('error', 'Beberapa laporan tidak valid atau bukan milik perusahaan Anda.');
        }

        try {
            DB::beginTransaction();

            $successCount = 0;
            $errorCount = 0;

            foreach ($laporan as $item) {
                try {
                    if ($request->action === 'delete') {
                        if ($item->canDelete()) {
                            $item->delete();
                            $successCount++;
                        } else {
                            $errorCount++;
                        }
                    } elseif ($request->action === 'submit') {
                        if ($item->canSubmit()) {
                            $item->submit();
                            $successCount++;
                        } else {
                            $errorCount++;
                        }
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                    \Log::error('Bulk action error: ' . $e->getMessage());
                }
            }

            DB::commit();

            $actionName = $request->action === 'delete' ? 'dihapus' : 'disubmit';
            $message = "{$successCount} laporan berhasil {$actionName}.";
            
            if ($errorCount > 0) {
                $message .= " {$errorCount} laporan gagal diproses.";
            }

            return redirect()->route('laporan-harian.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal melakukan aksi bulk: ' . $e->getMessage());
        }
    }
}
