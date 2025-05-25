<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisLimbah;

class JenisLimbahController extends Controller
{
    public function index()
    {
        $jenisLimbahs = JenisLimbah::latest()->paginate(10);
        return view('jenis-limbah.index', compact('jenisLimbahs'));
    }

    public function create()
    {
        return view('jenis-limbah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:jenis_limbahs,nama',
            'deskripsi' => 'nullable|string',
        ]);

        JenisLimbah::create($request->all());

        return redirect()->route('admin.jenis-limbah.index')
                         ->with('success', 'Jenis limbah berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jenisLimbah = JenisLimbah::findOrFail($id);
        return view('jenis-limbah.show', compact('jenisLimbah'));
    }

    public function edit($id)
    {
        $jenisLimbah = JenisLimbah::findOrFail($id);
        return view('jenis-limbah.edit', compact('jenisLimbah'));
    }

    public function update(Request $request, $id)
    {
        $jenisLimbah = JenisLimbah::findOrFail($id);

        $request->validate([
            'nama' => 'required|unique:jenis_limbahs,nama,' . $jenisLimbah->id,
            'deskripsi' => 'nullable|string',
        ]);

        $jenisLimbah->update($request->all());

        return redirect()->route('admin.jenis-limbah.index')
                         ->with('success', 'Jenis limbah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisLimbah = JenisLimbah::findOrFail($id);
        $jenisLimbah->delete();

        return redirect()->route('admin.jenis-limbah.index')
                         ->with('success', 'Jenis limbah berhasil dihapus.');
    }
}

