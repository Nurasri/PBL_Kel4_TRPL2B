<x-app>
    <x-slot:title>
        Dashboard Perusahaan
    </x-slot:title>
<div class="container">
    <h1>Dashboard Perusahaan</h1>
    <p>Selamat datang, {{ $perusahaan->nama_perusahaan ?? 'Perusahaan' }}!</p>
    <ul>
        <li>Total Laporan: {{ $total_laporan }}</li>
        <li>Laporan Pending: {{ $laporan_pending }}</li>
    </ul>
</div>
</x-app>
