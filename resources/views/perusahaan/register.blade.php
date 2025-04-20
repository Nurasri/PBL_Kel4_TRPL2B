@extends('layouts.guest')

@section('content')
<div class="container mt-5">
    <h2>Daftar Perusahaan</h2>
    <form action="{{ route('perusahaan.register.submit') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_perusahaan">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nama_admin">Nama Admin</label>
            <input type="text" name="nama_admin" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email">Email Admin</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
@endsection
