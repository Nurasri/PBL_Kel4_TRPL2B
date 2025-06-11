<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of vendors (untuk semua user)
     */
    public function index(Request $request): View
    {
        $query = Vendor::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by jenis layanan
        if ($request->filled('jenis_layanan')) {
            $query->byJenisLayanan($request->jenis_layanan);
        }

        // Filter by status - hanya tampilkan yang aktif untuk perusahaan
        if (auth()->user()->isPerusahaan()) {
            $query->active();
        } elseif ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vendors = $query->latest()->paginate(10)->withQueryString();

        return view('vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new vendor (admin only)
     */
    public function create(): View
    {
        return view('vendor.create');
    }

    /**
     * Store a newly created vendor (admin only)
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            Vendor::validationRules(),
            Vendor::validationMessages()
        );

        Vendor::create($request->all());

        return redirect()->route('vendor.index')
            ->with('success', 'Vendor berhasil ditambahkan.');
    }

    /**
     * Display the specified vendor
     */
    public function show(Vendor $vendor): View
    {
        return view('vendor.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified vendor (admin only)
     */
    public function edit(Vendor $vendor): View
    {
        return view('vendor.edit', compact('vendor'));
    }

    /**
     * Update the specified vendor (admin only)
     */
    public function update(Request $request, Vendor $vendor): RedirectResponse
    {
        $request->validate(
            Vendor::validationRules($vendor->id),
            Vendor::validationMessages()
        );

        $vendor->update($request->all());

        return redirect()->route('vendor.index')
            ->with('success', 'Vendor berhasil diperbarui.');
    }

    /**
     * Remove the specified vendor (admin only)
     */
    public function destroy(Vendor $vendor): RedirectResponse
    {
        try {
            $vendor->delete();
            return redirect()->route('vendor.index')
                ->with('success', 'Vendor berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('vendor.index')
                ->with('error', 'Gagal menghapus vendor. Vendor mungkin masih digunakan.');
        }
    }

    /**
     * Toggle vendor status (admin only)
     */
    public function toggleStatus(Vendor $vendor): RedirectResponse
    {
        $newStatus = $vendor->status === 'aktif' ? 'tidak_aktif' : 'aktif';
        $vendor->update(['status' => $newStatus]);

        $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
            ->with('success', "Vendor berhasil {$statusText}.");
    }

    /**
     * Get vendors by jenis layanan (for AJAX)
     */
    public function getByJenisLayanan(Request $request)
    {
        $jenisLayanan = $request->get('jenis_layanan');
        
        $vendors = Vendor::active()
            ->when($jenisLayanan, function ($query) use ($jenisLayanan) {
                return $query->byJenisLayanan($jenisLayanan);
            })
            ->select('id', 'nama_perusahaan', 'nama_pic', 'telepon')
            ->get();

        return response()->json($vendors);
    }
}
