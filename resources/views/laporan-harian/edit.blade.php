@extends('layouts.app')

@section('title', 'Edit Laporan')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Laporan Harian Limbah</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('laporan-harian.update', $laporan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $laporan->tanggal) }}" required>
            </div>

            <div class="mb-3">
                <label for="jenis_limbah" class="form-label">Jenis Limbah</label>
                <input type="text" name="jenis_limbah" class="form-control" value="{{ old('jenis_limbah', $laporan->jenis_limbah) }}" required>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah (kg)</label>
                <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $laporan->jumlah) }}" required>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi Pengelolaan</label>
                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $laporan->lokasi) }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status Pengelolaan</label>
                <select name="status" class="form-select" required>
                    <option value="disimpan" {{ $laporan->status == 'disimpan' ? 'selected' : '' }}>Disimpan</option>
                    <option value="dibuang" {{ $laporan->status == 'dibuang' ? 'selected' : '' }}>Dibuang</option>
                    <option value="didaur ulang" {{ $laporan->status == 'didaur ulang' ? 'selected' : '' }}>Didaur ulang</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="{{ route('laporan-harian.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
