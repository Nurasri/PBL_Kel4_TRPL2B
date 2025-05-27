<?php

namespace App\Http\Controllers;

use App\Models\JenisLimbah;
use Illuminate\Http\Request;

class JenisLimbahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisLimbah = JenisLimbah::paginate(10);
        return view('jenis-limbah.index', compact('jenisLimbah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis-limbah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        JenisLimbah::create($request->all());

        return redirect()->route('admin.jenis-limbah.index')
            ->with('success', 'Jenis limbah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisLimbah $jenisLimbah)
    {
        return view('jenis-limbah.show', compact('jenisLimbah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisLimbah $jenisLimbah)
    {
        return view('jenis-limbah.edit', compact('jenisLimbah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisLimbah $jenisLimbah)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $jenisLimbah->update($request->all());

        return redirect()->route('admin.jenis-limbah.index')
            ->with('success', 'Jenis limbah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisLimbah $jenisLimbah)
    {
        $jenisLimbah->delete();

        return redirect()->route('admin.jenis-limbah.index')
            ->with('success', 'Jenis limbah berhasil dihapus.');
    }
}

