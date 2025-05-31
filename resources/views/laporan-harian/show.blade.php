<x-app>
    <x-slot:title>
        Detail Laporan Harian Limbah
    </x-slot:title>
    <div class="container">
        <h2 class="mb-4">Detail Laporan Harian Limbah</h2>

        <div class="card">
            <div class="card-body">
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y') }}</p>
                <p><strong>Jenis Limbah:</strong> {{ $laporan->jenis_limbah }}</p>
                <p><strong>Jumlah:</strong> {{ $laporan->jumlah }} kg</p>
                <p><strong>Lokasi Pengelolaan:</strong> {{ $laporan->lokasi }}</p>
                <p><strong>Status Pengelolaan:</strong> {{ $laporan->status }}</p>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('laporan-harian.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('laporan-harian.edit', $laporan->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</x-app>
