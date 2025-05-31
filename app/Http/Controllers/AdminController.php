<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perusahaan;
use App\Models\JenisLimbah; // Pastikan model ini ada
use App\Models\Vendor; // Pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $totalUsers = User::count();
        $totalPerusahaan = Perusahaan::count();
        $activeUsers = User::where('status', 'active')->count();
        $pendingUsers = User::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPerusahaan', 
            'activeUsers',
            'pendingUsers'
        ));
    }

    public function users(): View
    {
        $users = User::with('perusahaan')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function toggleUserStatus(User $user): RedirectResponse
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return redirect()->back()->with('success', 'Status user berhasil diubah.');
    }

    public function destroyUser(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    // Gunakan view perusahaan yang sudah ada
    public function perusahaan(): View
    {
        $perusahaans = Perusahaan::with('user')->paginate(10);
        return view('perusahaan.index', compact('perusahaans'));
    }

    // Gunakan view jenis-limbah yang sudah ada
    public function jenisLimbah(): View
    {
        $jenisLimbah = JenisLimbah::paginate(10); // Sesuaikan dengan model Anda
        return view('jenis-limbah.index', compact('jenisLimbah'));
    }

    // Gunakan view vendor yang sudah ada
    public function vendor(): View
    {
        $vendors = Vendor::paginate(10); // Sesuaikan dengan model Anda
        return view('vendor.index', compact('vendors'));
    }
}
