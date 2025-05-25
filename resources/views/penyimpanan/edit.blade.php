<x-app>
    <x-slot:title>
        Edit Penyimpanan Limbah
    </x-slot:title>
<div class="container">
    <h1 class="mb-4">Edit Data Penyimpanan Limbah</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penyimpanan.update', $penyimpanan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi Penyimpanan</label>
            <input type="text" name="lokasi" class="form-control" required value="{{ old('lokasi', $penyimpanan->lokasi) }}">
        </div>

        <div class="mb-3">
            <label for="jenis_penyimpanan" class="form-label">Jenis Penyimpanan</label>
            <input type="text" name="jenis_penyimpanan" class="form-control" required value="{{ old('jenis_penyimpanan', $penyimpanan->jenis_penyimpanan) }}">
        </div>

        <div class="mb-3">
            <label for="kapasitas" class="form-label">Kapasitas</label>
            <input type="text" name="kapasitas" class="form-control" value="{{ old('kapasitas', $penyimpanan->kapasitas) }}">
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea name="catatan" class="form-control">{{ old('catatan', $penyimpanan->catatan) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('penyimpanan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</x-app>
