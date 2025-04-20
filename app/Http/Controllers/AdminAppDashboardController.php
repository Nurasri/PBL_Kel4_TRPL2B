<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\User;
use App\Models\LaporanHarianLimbah;

class AdminAppDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
