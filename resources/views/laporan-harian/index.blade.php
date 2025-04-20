@extends('layouts.app')

@section('title', 'Daftar Laporan Harian')

@section('content')
    <div class="container">
        <h2 class="mb-4">Daftar Laporan Harian Limbah</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('laporan-harian.create') }}" class="btn btn-primary">+ Tambah Laporan</a>
        </div>

        @if ($laporan->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Limbah</th>
                        <th>Jumlah (kg)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $row)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $row->jenis_limbah }}</td>
                            <td>{{ $row->jumlah }}</td>
                            <td>{{ $row->status }}</td>
                            <td>
                                <a href="{{ route('laporan-harian.show', $row->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('laporan-harian.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('laporan-harian.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $laporan->links() }} {{-- Pagination --}}
        @else
            <p>Belum ada laporan yang dimasukkan.</p>
        @endif
    </div>
@endsection
