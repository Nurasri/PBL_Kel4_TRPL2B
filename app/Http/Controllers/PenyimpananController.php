<?php

namespace App\Http\Controllers;

use App\Models\Penyimpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenyimpananController extends Controller
{
    public function index()
    {
        $penyimpanan = Penyimpanan::where('perusahaan_id', Auth::user()->perusahaan_id)->get();
        return view('penyimpanan.index', compact('penyimpanan'));
    }

    public function create()
    {
        return view('penyimpanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
            'jenis_penyimpanan' => 'required|string|max:255',
            'kapasitas' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        Penyimpanan::create([
            'perusahaan_id' => Auth::user()->perusahaan_id,
            'lokasi' => $request->lokasi,
            'jenis_penyimpanan' => $request->jenis_penyimpanan,
            'kapasitas' => $request->kapasitas,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('penyimpanan.index')->with('success', 'Data penyimpanan berhasil ditambahkan.');
    }

    public function show(Penyimpanan $penyimpanan)
    {
        return view('penyimpanan.show', compact('penyimpanan'));
    }

    public function edit(Penyimpanan $penyimpanan)
    {
        return view('penyimpanan.edit', compact('penyimpanan'));
    }

    public function update(Request $request, Penyimpanan $penyimpanan)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
            'jenis_penyimpanan' => 'required|string|max:255',
            'kapasitas' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $penyimpanan->update($request->all());

        return redirect()->route('penyimpanan.index')->with('success', 'Data penyimpanan berhasil diperbarui.');
    }

    public function destroy(Penyimpanan $penyimpanan)
    {
        $penyimpanan->delete();
        return redirect()->route('penyimpanan.index')->with('success', 'Data penyimpanan berhasil dihapus.');
    }
}

