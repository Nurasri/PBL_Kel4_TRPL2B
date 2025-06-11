<?php

namespace App\Http\Controllers;

use App\Models\PengelolaanLimbah;
use App\Models\LaporanHarian;
use App\Models\Penyimpanan;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $query = PengelolaanLimbah::with(['laporanHarian.jenisLimbah', 'penyimpanan', 'vendor'])
            ->where('perusahaan_id', $user->perusahaan->id);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_manifest', 'like', "%{$search}%")
                  ->orWhere('catatan', 'like', "%{$search}%")
                  ->orWhereHas('laporanHarian.jenisLimbah', function($subQ) use ($search) {
                      $subQ->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('vendor', function($subQ) use ($search) {
                      $subQ->where('nama_perusahaan', 'like', "%{$search}%");
                  });
            });
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
        $jenisOptions = PengelolaanLimbah::getJenisPengelolaanOptions();
        $statusOptions = PengelolaanLimbah::getStatusOptions();
        $vendorOptions = Vendor::where('status', 'aktif')->pluck('nama_perusahaan', 'id');

        return view('pengelolaan-limbah.index', compact(
            'pengelolaanLimbah',
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

        // Ambil laporan harian yang sudah submitted dan belum dikelola sepenuhnya
        $laporanHarians = LaporanHarian::with(['jenisLimbah', 'penyimpanan'])
            ->where('perusahaan_id', $user->perusahaan->id)
            ->where('status', 'submitted')
            ->whereRaw('jumlah > COALESCE((SELECT SUM(jumlah_dikelola) FROM pengelolaan_limbahs WHERE laporan_harian_id = laporan_harians.id), 0)')
            ->get();

        $vendors = Vendor::where('status', 'aktif')->get();

        return view('pengelolaan-limbah.create', compact('laporanHarians', 'vendors'));
    }

    /**
     * Store a newly created pengelolaan
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            PengelolaanLimbah::validationRules(),
            PengelolaanLimbah::validationMessages()
        );

        try {
            DB::beginTransaction();

            // Validasi laporan harian milik perusahaan
            $laporanHarian = LaporanHarian::where('id', $request->laporan_harian_id)
                ->where('perusahaan_id', auth()->user()->perusahaan->id)
                ->first();

            if (!$laporanHarian) {
                return back()->withErrors(['laporan_harian_id' => 'Laporan harian tidak valid.'])->withInput();
            }

            // Cek sisa limbah yang bisa dikelola
            $totalDikelola = PengelolaanLimbah::where('laporan_harian_id', $laporanHarian->id)->sum('jumlah_dikelola');
            $sisaLimbah = $laporanHarian->jumlah - $totalDikelola;

            if ($request->jumlah_dikelola > $sisaLimbah) {
                return back()->withErrors([
                    'jumlah_dikelola' => 'Jumlah yang dikelola melebihi sisa limbah. Sisa: ' . 
                                       number_format($sisaLimbah, 2) . ' ' . $laporanHarian->satuan
                ])->withInput();
            }

            $pengelolaan = new PengelolaanLimbah($request->all());
            $pengelolaan->perusahaan_id = auth()->user()->perusahaan->id;
            $pengelolaan->penyimpanan_id = $laporanHarian->penyimpanan_id;
            $pengelolaan->satuan = $laporanHarian->satuan;
            $pengelolaan->save();

            // Update kapasitas penyimpanan (kurangi karena limbah dikeluarkan)
            $laporanHarian->penyimpanan->reduceLimbah($request->jumlah_dikelola);

            DB::commit();

            return redirect()->route('pengelolaan-limbah.index')
                ->with('success', 'Pengelolaan limbah berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menyimpan pengelolaan: ' . $e->getMessage()])->withInput();
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

        $pengelolaanLimbah->load(['laporanHarian.jenisLimbah', 'penyimpanan', 'vendor', 'perusahaan']);
        
        return view('pengelolaan-limbah.show', compact('pengelolaanLimbah'));
    }

    /**
     * Show the form for editing the specified pengelolaan
     */
    public function edit(PengelolaanLimbah $pengelolaanLimbah): View
    {
        $user = Auth::user();
        
        if ($pengelolaanLimbah->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        if (!$pengelolaanLimbah->canEdit()) {
            return redirect()->route('pengelolaan-limbah.show', $pengelolaanLimbah)
                ->with('error', 'Pengelolaan limbah ini tidak dapat diedit.');
        }

        $vendors = Vendor::where('status', 'aktif')->get();

        return view('pengelolaan-limbah.edit', compact('pengelolaanLimbah', 'vendors'));
    }

    /**
     * Update the specified pengelolaan
     */
    public function update(Request $request, PengelolaanLimbah $pengelolaanLimbah): RedirectResponse
    {
        $user = Auth::user();
        
        if ($pengelolaanLimbah->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        if (!$pengelolaanLimbah->canEdit()) {
            return redirect()->route('pengelolaan-limbah.show', $pengelolaanLimbah)
                ->with('error', 'Pengelolaan limbah ini tidak dapat diedit.');
        }

        $request->validate(
            PengelolaanLimbah::validationRules($pengelolaanLimbah->id),
            PengelolaanLimbah::validationMessages()
        );

        try {
            DB::beginTransaction();

            // Jika jumlah berubah, update kapasitas penyimpanan
            $selisihJumlah = $request->jumlah_dikelola - $pengelolaanLimbah->jumlah_dikelola;
            
            if ($selisihJumlah != 0) {
                if ($selisihJumlah > 0) {
                    // Jumlah bertambah, kurangi kapasitas penyimpanan
                    $pengelolaanLimbah->penyimpanan->reduceLimbah($selisihJumlah);
                } else {
                    // Jumlah berkurang, tambah kapasitas penyimpanan
                    $pengelolaanLimbah->penyimpanan->addLimbah(abs($selisihJumlah));
                }
            }

            $pengelolaanLimbah->update($request->all());

            DB::commit();

            return redirect()->route('pengelolaan-limbah.index')
                ->with('success', 'Pengelolaan limbah berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal memperbarui pengelolaan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified pengelolaan
     */
    public function destroy(PengelolaanLimbah $pengelolaanLimbah): RedirectResponse
    {
        $user = Auth::user();
        
        if ($pengelolaanLimbah->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        if (!$pengelolaanLimbah->canEdit()) {
            return redirect()->route('pengelolaan-limbah.index')
                ->with('error', 'Pengelolaan limbah ini tidak dapat dihapus.');
        }

        try {
            DB::beginTransaction();

            // Kembalikan kapasitas penyimpanan
            $pengelolaanLimbah->penyimpanan->addLimbah($pengelolaanLimbah->jumlah_dikelola);

            $pengelolaanLimbah->delete();

            DB::commit();

            return redirect()->route('pengelolaan-limbah.index')
                ->with('success', 'Pengelolaan limbah berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('pengelolaan-limbah.index')
                ->with('error', 'Gagal menghapus pengelolaan: ' . $e->getMessage());
        }
    }

    /**
     * Update status pengelolaan
     */
    public function updateStatus(Request $request, PengelolaanLimbah $pengelolaanLimbah): RedirectResponse
    {
        $user = Auth::user();
        
        if ($pengelolaanLimbah->perusahaan_id !== $user->perusahaan->id) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'status' => 'required|in:diproses,dalam_pengangkutan,selesai,dibatalkan',
            'tanggal_selesai' => 'nullable|date',
            'catatan_status' => 'nullable|string|max:500'
        ]);

        try {
            $updateData = ['status' => $request->status];
            
            if ($request->status === 'selesai' && $request->tanggal_selesai) {
                $updateData['tanggal_selesai'] = $request->tanggal_selesai;
            }

            if ($request->catatan_status) {
                $updateData['catatan'] = $pengelolaanLimbah->catatan . "\n[" . now()->format('d/m/Y H:i') . "] " . $request->catatan_status;
            }

            $pengelolaanLimbah->update($updateData);

            return redirect()->back()
                ->with('success', 'Status pengelolaan berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    /**
     * Get laporan harian details for AJAX
     */
    public function getLaporanDetails(Request $request)
    {
        try {
            $laporanId = $request->get('laporan_id');
            $perusahaanId = auth()->user()->perusahaan->id;

            $laporan = LaporanHarian::with(['jenisLimbah', 'penyimpanan'])
                ->where('id', $laporanId)
                ->where('perusahaan_id', $perusahaanId)
                ->first();

            if (!$laporan) {
                return response()->json(['error' => 'Laporan tidak ditemukan'], 404);
            }

            // Hitung sisa limbah yang bisa dikelola
            $totalDikelola = PengelolaanLimbah::where('laporan_harian_id', $laporan->id)->sum('jumlah_dikelola');
            $sisaLimbah = $laporan->jumlah - $totalDikelola;

            return response()->json([
                'id' => $laporan->id,
                'tanggal' => $laporan->tanggal->format('d/m/Y'),
                'jenis_limbah' => $laporan->jenisLimbah->nama,
                'kode_limbah' => $laporan->jenisLimbah->kode_limbah,
                'penyimpanan' => $laporan->penyimpanan->nama_penyimpanan,
                'lokasi' => $laporan->penyimpanan->lokasi,
                'jumlah_total' => $laporan->jumlah,
                'jumlah_dikelola' => $totalDikelola,
                'sisa_limbah' => $sisaLimbah,
                'satuan' => $laporan->satuan,
                'max_dikelola' => $sisaLimbah
            ]);
            } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}