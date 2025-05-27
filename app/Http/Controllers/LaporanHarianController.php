<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanHarian;

class LaporanHarianController extends Controller
{
    public function create()
    {
        return view('laporan-harian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_limbah' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'lokasi' => 'required|string',
            'status' => 'required|string',
        ]);

        LaporanHarian::create($request->all());

        return redirect()->route('laporan-harian.index')->with('success', 'Laporan berhasil ditambahkan!');
    }
    public function show($id)
    {
        $laporan = LaporanHarian::findOrFail($id);
        return view('laporan-harian.show', compact('laporan'));
    }
    public function index()
    {
        $laporan = LaporanHarian::latest()->paginate(10); // Bisa disesuaikan jumlah per halaman
        return view('laporan-harian.index', compact('laporan'));
    }
    // Tampilkan form edit
    public function edit($id)
    {
        $laporan = LaporanHarian::findOrFail($id);
        return view('laporan-harian.edit', compact('laporan'));
    }

    // Proses update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_limbah' => 'required|string',
            'jumlah' => 'required|numeric',
            'lokasi' => 'required|string',
            'status' => 'required|string',
        ]);

        $laporan = LaporanHarian::findOrFail($id);
        $laporan->update($request->all());

        return redirect()->route('laporan-harian.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $laporan = LaporanHarian::findOrFail($id);
        $laporan->delete();

        return redirect()->route('laporan-harian.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
