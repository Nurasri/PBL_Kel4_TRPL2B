<x-app>
    <x-slot:title>
        Edit Jenis Limbah
    </x-slot:title>
<div class="container">
    <h1 class="mb-4">Edit Jenis Limbah</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada kesalahan pada input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.jenis-limbah.update', $jenisLimbah->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Jenis Limbah</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $jenisLimbah->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $jenisLimbah->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('admin.jenis-limbah.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</x-app>
