@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Dashboard Admin Perusahaan</h2>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow p-3">
                <h5>Total Laporan Harian</h5>
                <p class="fs-4">{{ $totalLaporan }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow p-3">
                <h5>Total User Terdaftar</h5>
                <p class="fs-4">{{ $totalUser }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
