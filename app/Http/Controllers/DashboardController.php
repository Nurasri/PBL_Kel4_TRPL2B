<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\LaporanHarianLimbah;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek role
        if ($user->role === 'admin') {
            $totalLaporan = LaporanHarianLimbah::where('perusahaan_id', $user->perusahaan_id)->count();
            $totalUser = User::where('perusahaan_id', $user->perusahaan_id)->count();

            return view('dashboard.admin', [
                'totalLaporan' => $totalLaporan,
                'totalUser' => $totalUser,
            ]);
        }

        // Role karyawan
        return view('dashboard.karyawan');
    }
}

