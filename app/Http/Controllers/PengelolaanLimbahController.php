<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\View\View;
use App\Models\JenisLimbah;
use App\Models\Penyimpanan;
use Illuminate\Http\Request;
use App\Models\LaporanHarian;
use App\Models\PengelolaanLimbah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Helpers\NotificationHelper;

class PengelolaanLimbahController extends Controller
{
    /**
     * Display a listing of pengelolaan limbah
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        if (!$user->hasValidPerusahaan()) {
            return redirect()->route('perusahaan.create')
                ->with('info', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        $query = PengelolaanLimbah::with(['jenisLimbah', 'penyimpanan', 'vendor'])
            ->where('perusahaan_id', $user->perusahaan->id);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_manifest', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%")
                    ->orWhereHas('jenisLimbah', function ($subQ) use ($search) {
                        $subQ->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vendor', function ($subQ) use ($search) {
                        $subQ->where('nama_perusahaan', 'like', "%{$search}%");
                    });
            });
        }

        // Filters
        if ($request->filled('jenis_limbah_id')) {
            $query->where('jenis_limbah_id', $request->jenis_limbah_id);
        }

        // Filter by jenis pengelolaan
        if ($request->filled('jenis_pengelolaan')) {
            $query->where('jenis_pengelolaan', $request->jenis_pengelolaan);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by vendor
        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_mulai', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_mulai', '<=', $request->tanggal_sampai);
        }

        $pengelolaanLimbah = $query->latest('tanggal_mulai')->paginate(15)->withQueryString();

        // Data untuk filter
        $jenisLimbahOptions = JenisLimbah::pluck('nama', 'id');
        $jenisOptions = PengelolaanLimbah::getJenisPengelolaanOptions();
        $statusOptions = PengelolaanLimbah::getStatusOptions();
        $vendorOptions = Vendor::where('status', 'aktif')->pluck('nama_perusahaan', 'id');

        return view('pengelolaan-limbah.index', compact(
            'pengelolaanLimbah',
            'jenisLimbahOptions',
            'jenisOptions',
            'statusOptions',
            'vendorOptions'
        ));
    }
    /**
     * Show the form for creating a new pengelolaan
     */
    public function create(): View
    {
        $user = Auth::user();

        if (!$user->hasValidPerusahaan()) {
            return redirect()->route('perusahaan.create')
                ->with('error', 'Silakan lengkapi profil perusahaan terlebih dahulu.');
        }
        // Ambil jenis limbah yang memiliki stok di penyimpanan
        $jenisLimbahs = JenisLimbah::whereHas('penyimpanans', function ($query) use ($user) {
            $query->where('perusahaan_id', $user->perusahaan->id)
                ->where('status', 'aktif')
                ->where('kapasitas_terpakai', '>', 0);
        })->with(['penyimpanans' => function ($query) use ($user) {
            $query->where('perusahaan_id', $user->perusahaan->id)
                ->where('status', 'aktif')
                ->where('kapasitas_terpakai', '>', 0);
        }])->get();

        // Tambahkan total stok untuk setiap jenis limbah
        $jenisLimbahs->each(function ($jenisLimbah) use ($user) {
            $jenisLimbah->total_stok_tersedia = $jenisLimbah->penyimpanans
                ->where('perusahaan_id', $user->perusahaan->id)
                ->sum('kapasitas_terpakai');
        });
        $vendors = Vendor::where('status', 'aktif')->get();

        return view('pengelolaan-limbah.create', compact('jenisLimbahs', 'vendors'));
    }

    /**
     * Store a newly created pengelolaan
     */
    public function store(Request $request): RedirectResponse
    {
        if (empty($request->vendor_id)) {
            $request->merge(['vendor_id' => null]);
        }
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'jenis_limbah_id' => 'required|exists:jenis_limbahs,id',
            'penyimpanan_id' => 'required|exists:penyimpanans,id',
            'jumlah_dikelola' => 'required|numeric|min:0.01',
            'jenis_pengelolaan' => 'required|in:internal,vendor_eksternal',
            'metode_pengelolaan' => 'required|in:reduce,reuse,recycle,treatment,disposal,incineration,landfill,composting,stabilization',
            'vendor_id' => 'required_if:jenis_pengelolaan,vendor_eksternal|exists:vendors,id',
            'biaya' => 'nullable|numeric|min:0',
            'status' => 'required|in:diproses,dalam_pengangkutan,selesai',
            'catatan' => 'nullable|string|max:1000'
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai pengelolaan wajib diisi.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini.',
            'jenis_limbah_id.required' => 'Jenis limbah wajib dipilih.',
            'penyimpanan_id.required' => 'Penyimpanan wajib dipilih.',
            'jumlah_dikelola.required' => 'Jumlah yang dikelola wajib diisi.',
            'jumlah_dikelola.min' => 'Jumlah minimal 0.01.',
            'jenis_pengelolaan.required' => 'Jenis pengelolaan wajib dipilih.',
            'metode_pengelolaan.required' => 'Metode pengelolaan wajib dipilih.',
            'vendor_id.required_if' => 'Vendor wajib dipilih untuk pengelolaan eksternal.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        try {
            DB::beginTransaction();

            $user = auth()->user();

            // Validasi jenis limbah dan penyimpanan milik perusahaan
            $jenisLimbah = JenisLimbah::findOrFail($request->jenis_limbah_id);
            $penyimpanan = Penyimpanan::where('id', $request->penyimpanan_id)
                ->where('perusahaan_id', $user->perusahaan->id)
                ->where('jenis_limbah_id', $request->jenis_limbah_id)
                ->where('status', 'aktif')
                ->first();

            if (!$penyimpanan) {
                return back()->withErrors(['penyimpanan_id' => 'Penyimpanan tidak valid.'])->withInput();
            }

            // Validasi stok tersedia
            if ($request->jumlah_dikelola > $penyimpanan->kapasitas_terpakai) {
                return back()->withErrors([
                    'jumlah_dikelola' => 'Jumlah melebihi stok tersedia: ' .
                        number_format($penyimpanan->kapasitas_terpakai, 2) . ' ' . $penyimpanan->satuan
                ])->withInput();
            }

            // Generate nomor manifest otomatis
            $nomorManifest = $this->generateNomorManifest();

            $vendorId = $request->jenis_pengelolaan === 'vendor_eksternal' ? $request->vendor_id : null;

            // Buat pengelolaan limbah
            $pengelolaan = new PengelolaanLimbah([
                'perusahaan_id' => $user->perusahaan->id,
                'jenis_limbah_id' => $request->jenis_limbah_id,
                'penyimpanan_id' => $request->penyimpanan_id,
                'vendor_id' => $vendorId,
                'tanggal_mulai' => $request->tanggal_mulai,
                'jumlah_dikelola' => $request->jumlah_dikelola,
                'satuan' => $jenisLimbah->satuan_default,
                'jenis_pengelolaan' => $request->jenis_pengelolaan,
                'metode_pengelolaan' => $request->metode_pengelolaan,
                'status' => $request->status,
                'biaya' => $request->biaya,
                'nomor_manifest' => $nomorManifest,
                'catatan' => $request->catatan,
            ]);

            $pengelolaan->save();

            // Update kapasitas penyimpanan (kurangi karena limbah dikeluarkan untuk dikelola)
            $penyimpanan->kapasitas_terpakai -= $request->jumlah_dikelola;
            $penyimpanan->save();

            NotificationHelper::pengelolaanCreated($pengelolaan);

            DB::commit();

            return redirect()->route('pengelolaan-limbah.index')
                ->with('success', 'Pengelolaan limbah berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->with('error', 'Gagal membuat pengelolaan limbah: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified pengelolaan
     */
    public function show(PengelolaanLimbah $pengelolaanLimbah): View
    {
        $user = Auth::user();

        if ($pengelolaanLimbah->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        $pengelolaanLimbah->load(['jenisLimbah', 'penyimpanan', 'vendor', 'perusahaan']);

        return view('pengelolaan-limbah.show', compact('pengelolaanLimbah'));
    }

    /**
     * Show the form for editing the specified pengelolaan
     */
    public function edit(PengelolaanLimbah $pengelolaanLimbah): View
    {
        $user = Auth::user();

        // Pastikan pengelolaan limbah milik perusahaan yang sedang login
        if ($pengelolaanLimbah->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized action.');
        }

        // Hanya bisa edit jika status masih diproses
        if (!$pengelolaanLimbah->canEdit()) {
            return redirect()->route('pengelolaan-limbah.show', $pengelolaanLimbah)
                ->with('error', 'Pengelolaan limbah ini tidak dapat diedit karena sudah dalam proses atau selesai.');
        }

        // Get penyimpanan yang sesuai dengan jenis limbah
        $penyimpanans = Penyimpanan::where('perusahaan_id', $user->perusahaan->id)
            ->where('jenis_limbah_id', $pengelolaanLimbah->jenis_limbah_id)
            ->where('status', 'aktif')
            ->get();

        // Get vendors
        $vendors = Vendor::where('status', 'aktif')->get();

        return view('pengelolaan-limbah.edit', compact(
            'pengelolaanLimbah',
            'penyimpanans',
            'vendors'
        ));
    }

    /**
     * Update the specified pengelolaan
     */
    public function update(Request $request, PengelolaanLimbah $pengelolaanLimbah): RedirectResponse
    {
        $user = Auth::user();

        // Pastikan pengelolaan limbah milik perusahaan yang sedang login
        if ($pengelolaanLimbah->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!$pengelolaanLimbah->canEdit()) {
            return redirect()->route('pengelolaan-limbah.show', $pengelolaanLimbah)
                ->with('error', 'Pengelolaan limbah ini tidak dapat diedit.');
        }

        $request->validate([
            'tanggal_mulai' => 'required|date',
            'penyimpanan_id' => 'required|exists:penyimpanans,id',
            'jumlah_dikelola' => 'required|numeric|min:0.01',
            'jenis_pengelolaan' => 'required|in:internal,vendor_eksternal',
            'metode_pengelolaan' => 'required|in:reduce,reuse,recycle,treatment,disposal,incineration,landfill,composting,stabilization',
            'vendor_id' => 'required_if:jenis_pengelolaan,vendor_eksternal|exists:vendors,id',
            'biaya' => 'nullable|numeric|min:0',
            'status' => 'required|in:diproses,dalam_pengangkutan,selesai,dibatalkan',
            'catatan' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            // Validasi penyimpanan
            $penyimpanan = Penyimpanan::where('id', $request->penyimpanan_id)
                ->where('perusahaan_id', $user->perusahaan->id)
                ->where('jenis_limbah_id', $pengelolaanLimbah->jenis_limbah_id)
                ->first();

            if (!$penyimpanan) {
                return back()->withErrors(['penyimpanan_id' => 'Penyimpanan tidak valid.'])->withInput();
            }

            // Hitung perubahan stok
            $jumlahLama = $pengelolaanLimbah->jumlah_dikelola;
            $jumlahBaru = $request->jumlah_dikelola;
            $perubahanStok = $jumlahBaru - $jumlahLama;

            // Update stok penyimpanan
            $penyimpanan->kapasitas_terpakai += $perubahanStok;
            $penyimpanan->save();

            // Update pengelolaan limbah
            $pengelolaanLimbah->update([
                'tanggal_mulai' => $request->tanggal_mulai,
                'jumlah_dikelola' => $request->jumlah_dikelola,
                'jenis_pengelolaan' => $request->jenis_pengelolaan,
                'metode_pengelolaan' => $request->metode_pengelolaan,
                'status' => $request->status,
                'biaya' => $request->biaya,
                'vendor_id' => $request->vendor_id,
                'catatan' => $request->catatan,
            ]);

            DB::commit();
            if ($request->status === 'selesai') {
                NotificationHelper::notifyUser(
                    $pengelolaanLimbah->perusahaan->user,
                    'Pengelolaan Limbah Selesai',
                    "Pengelolaan {$pengelolaanLimbah->jenisLimbah->nama} telah selesai. Silakan buat laporan hasil.",
                    'info',
                    route('laporan-hasil-pengelolaan.create')
                );
            }

            return redirect()->route('pengelolaan-limbah.index')
                ->with('success', 'Pengelolaan limbah berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal memperbarui: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Generate nomor manifest otomatis
     */
    private function generateNomorManifest(): string
    {
        $prefix = 'MNF';
        $date = date('Ymd');
        $lastNumber = PengelolaanLimbah::whereDate('created_at', today())->count() + 1;

        return $prefix . $date . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * API method untuk mendapatkan info stok saat edit
     */
    public function getStokInfo(PengelolaanLimbah $pengelolaanLimbah)
    {
        // Pastikan pengelolaan limbah milik perusahaan yang sedang login
        if ($pengelolaanLimbah->perusahaan_id !== auth()->user()->perusahaan->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Get total stok untuk jenis limbah ini
        $totalStok = Penyimpanan::where('perusahaan_id', auth()->user()->perusahaan->id)
            ->where('jenis_limbah_id', $pengelolaanLimbah->jenis_limbah_id)
            ->where('status', 'aktif')
            ->sum('kapasitas_terpakai');

        return response()->json([
            'total_stok' => $totalStok,
            'satuan' => $pengelolaanLimbah->satuan,
            'jenis_limbah' => $pengelolaanLimbah->jenisLimbah->nama
        ]);
    }

    /**
     * API untuk mendapatkan detail jenis limbah
     */
    public function getJenisLimbahDetails(Request $request)
    {
        try {
            $jenisLimbahId = $request->get('jenis_limbah_id');
            $perusahaanId = auth()->user()->perusahaan->id;

            $jenisLimbah = JenisLimbah::with(['penyimpanans' => function ($query) use ($perusahaanId) {
                $query->where('perusahaan_id', $perusahaanId)
                    ->where('status', 'aktif')
                    ->where('kapasitas_terpakai', '>', 0);
            }])->find($jenisLimbahId);

            if (!$jenisLimbah) {
                return response()->json(['error' => 'Jenis limbah tidak ditemukan'], 404);
            }

            $totalStok = $jenisLimbah->penyimpanans->sum('kapasitas_terpakai');

            return response()->json([
                'id' => $jenisLimbah->id,
                'nama' => $jenisLimbah->nama,
                'kode_limbah' => $jenisLimbah->kode_limbah,
                'satuan_default' => $jenisLimbah->satuan_default,
                'total_stok' => $totalStok,
                'penyimpanans' => $jenisLimbah->penyimpanans->map(function ($penyimpanan) {
                    return [
                        'id' => $penyimpanan->id,
                        'nama_penyimpanan' => $penyimpanan->nama_penyimpanan,
                        'lokasi' => $penyimpanan->lokasi,
                        'kapasitas_terpakai' => $penyimpanan->kapasitas_terpakai,
                        'satuan' => $penyimpanan->satuan
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Export data pengelolaan limbah
     */
    public function export(Request $request)
    {
        $user = Auth::user();

        $query = PengelolaanLimbah::with(['jenisLimbah', 'penyimpanan', 'vendor'])
            ->where('perusahaan_id', $user->perusahaan->id);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_manifest', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%")
                    ->orWhereHas('jenisLimbah', function ($subQ) use ($search) {
                        $subQ->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('jenis_limbah_id')) {
            $query->where('jenis_limbah_id', $request->jenis_limbah_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_mulai', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_mulai', '<=', $request->tanggal_sampai);
        }

        $data = $query->latest('tanggal_mulai')->get();

        $filename = 'pengelolaan_limbah_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'Tanggal Mulai Pengelolaan',
                'Jenis Limbah',
                'Kode Limbah',
                'Penyimpanan',
                'Lokasi',
                'Jumlah Dikelola',
                'Satuan',
                'Jenis Pengelolaan',
                'Metode Pengelolaan',
                'Status',
                'Vendor',
                'Biaya',
                'Nomor Manifest',
                'Catatan'
            ]);

            // Data CSV
            foreach ($data as $item) {
                fputcsv($file, [
                    $item->tanggal_mulai->format('d/m/Y'),
                    $item->jenisLimbah->nama,
                    $item->jenisLimbah->kode_limbah,
                    $item->penyimpanan->nama_penyimpanan,
                    $item->penyimpanan->lokasi,
                    number_format($item->jumlah_dikelola, 2),
                    $item->satuan,
                    $item->jenis_pengelolaan_name,
                    $item->metode_pengelolaan_name,
                    $item->status_name,
                    $item->vendor ? $item->vendor->nama_perusahaan : '-',
                    $item->biaya ? 'Rp ' . number_format($item->biaya, 2) : '-',
                    $item->nomor_manifest ?? '-',
                    $item->catatan ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $user = Auth::user();

        if (!$user->hasValidPerusahaan()) {
            return response()->json(['error' => 'Perusahaan tidak valid'], 400);
        }

        $perusahaanId = $user->perusahaan->id;

        // Total pengelolaan
        $totalPengelolaan = PengelolaanLimbah::where('perusahaan_id', $perusahaanId)->count();

        // Pengelolaan bulan ini
        $pengelolaanBulanIni = PengelolaanLimbah::where('perusahaan_id', $perusahaanId)
            ->whereMonth('tanggal_mulai', now()->month)
            ->whereYear('tanggal_mulai', now()->year)
            ->count();

        // Total limbah dikelola (dalam kg/liter)
        $totalLimbahDikelola = PengelolaanLimbah::where('perusahaan_id', $perusahaanId)
            ->where('status', 'selesai')
            ->sum('jumlah_dikelola');

        // Pengelolaan berdasarkan status
        $statusStats = PengelolaanLimbah::where('perusahaan_id', $perusahaanId)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Pengelolaan berdasarkan jenis
        $jenisStats = PengelolaanLimbah::where('perusahaan_id', $perusahaanId)
            ->selectRaw('jenis_pengelolaan, COUNT(*) as total')
            ->groupBy('jenis_pengelolaan')
            ->pluck('total', 'jenis_pengelolaan');

        // Trend pengelolaan 6 bulan terakhir
        $trendData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = PengelolaanLimbah::where('perusahaan_id', $perusahaanId)
                ->whereMonth('tanggal_mulai', $date->month)
                ->whereYear('tanggal_mulai', $date->year)
                ->count();

            $trendData[] = [
                'bulan' => $date->format('M Y'),
                'total' => $count
            ];
        }

        return response()->json([
            'total_pengelolaan' => $totalPengelolaan,
            'pengelolaan_bulan_ini' => $pengelolaanBulanIni,
            'total_limbah_dikelola' => number_format($totalLimbahDikelola, 2),
            'status_stats' => $statusStats,
            'jenis_stats' => $jenisStats,
            'trend_data' => $trendData
        ]);
    }
}
