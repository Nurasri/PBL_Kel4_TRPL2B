<?php
namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerusahaanRegisterController extends Controller
{
    public function showForm()
    {
        return view('perusahaan.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nama_admin' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Simpan perusahaan
        $perusahaan = Perusahaan::create([
            'nama' => $request->nama_perusahaan,
            'email' => $request->email,
            'status_langganan' => 'menunggu', // default status
        ]);

        // Buat user admin perusahaan
        User::create([
            'nama' => $request->nama_admin,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'perusahaan_id' => $perusahaan->id,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login setelah aktivasi.');
    }
}
