@extends('layouts.app')

@section('title', 'Tambah Laporan Harian')

@section('content')
    <div class="container">
        <h2 class="mb-4">Tambah Laporan Harian Limbah</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('laporan-harian.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="jenis_limbah" class="form-label">Jenis Limbah</label>
                <select name="jenis_limbah" class="form-control" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Plastik">Plastik</option>
                    <option value="Kertas">Kertas</option>
                    <option value="Logam">Logam</option>
                    <option value="B3">B3</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah (kg)</label>
                <input type="number" step="0.01" name="jumlah" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi Pengelolaan</label>
                <input type="text" name="lokasi" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status Pengelolaan</label>
                <select name="status" class="form-control" required>
                    <option value="Terkelola">Terkelola</option>
                    <option value="Belum">Belum Terkelola</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('laporan-harian.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
