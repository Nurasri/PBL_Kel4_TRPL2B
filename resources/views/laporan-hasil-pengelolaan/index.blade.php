<x-app>
    <x-slot:title>
        Laporan Hasil Pengelolaan Limbah
    </x-slot:title>
    
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Laporan Hasil Pengelolaan Limbah
            </h2>
            <div class="flex space-x-2">
                @if(!auth()->user()->isAdmin())
                    <x-button href="{{ route('laporan-hasil-pengelolaan.create') }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Laporan Hasil
                    </x-button>
                @endif
                <x-button variant="secondary" href="{{ route('laporan-hasil-pengelolaan.export', request()->query()) }}">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </x-button>
            </div>
        </div>

        @if (session('success'))
            <x-alert type="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        @if (session('error'))
            <x-alert type="error" dismissible>{{ session('error') }}</x-alert>
        @endif

        @if (session('info'))
            <x-alert type="info" dismissible>{{ session('info') }}</x-alert>
        @endif

        <!-- Filter Section -->
        <x-card class="mb-6">
            <form method="GET" action="{{ route('laporan-hasil-pengelolaan.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                
                <div class="flex-1 min-w-48">
                    <x-label>Pencarian</x-label>
                    <x-input name="search" value="{{ request('search') }}" placeholder="Cari nomor sertifikat, catatan..." />
                </div>
                
                <div>
                    <x-label>Status Hasil</x-label>
                    <x-select name="status_hasil" :options="$statusHasilOptions" value="{{ request('status_hasil') }}" placeholder="Semua Status" />
                </div>

                @if(auth()->user()->isAdmin())
                    <div>
                        <x-label>Perusahaan</x-label>
                        <x-select name="perusahaan_id" :options="$perusahaanOptions" value="{{ request('perusahaan_id') }}" placeholder="Semua Perusahaan" />
                    </div>
                @endif
                
                <div>
                    <x-label>Tanggal Dari</x-label>
                    <x-input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" />
                </div>
                
                <div>
                    <x-label>Tanggal Sampai</x-label>
                    <x-input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" />
                </div>
                
                <div class="flex items-end space-x-2">
                    <x-button type="submit" variant="secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter
                    </x-button>
                    
                    @if(request()->hasAny(['search', 'status_hasil', 'perusahaan_id', 'tanggal_dari', 'tanggal_sampai']))
                        <x-button href="{{ route('laporan-hasil-pengelolaan.index') }}" variant="secondary">
                            Reset
                        </x-button>
                    @endif
                </div>
            </form>
        </x-card>

        <!-- Table -->
        <x-card>
            @if($laporanHasil->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Tanggal Selesai</th>
                                <th class="px-4 py-3">Jenis Limbah</th>
                                @if(auth()->user()->isAdmin())
                                    <th class="px-4 py-3">Perusahaan</th>
                                @endif
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Efisiensi</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Biaya</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach($laporanHasil as $item)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $item->tanggal_selesai->format('d/m/Y') }}</div>
                                        @if($item->nomor_sertifikat)
                                            <div class="text-xs text-gray-500">{{ $item->nomor_sertifikat }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $item->pengelolaanLimbah->jenisLimbah->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->pengelolaanLimbah->jenisLimbah->kode_limbah }}</div>
                                    </td>
                                    @if(auth()->user()->isAdmin())
                                        <td class="px-4 py-3">
                                            <div class="text-sm">{{ $item->perusahaan->nama_perusahaan }}</div>
                                        </td>
                                    @endif
                                    <td class="px-4 py-3">
                                        <div class="text-sm">
                                            <div>Berhasil: {{ number_format($item->jumlah_berhasil_dikelola, 2) }} {{ $item->satuan }}</div>
                                            @if($item->jumlah_residu > 0)
                                                <div class="text-xs text-gray-500">Residu: {{ number_format($item->jumlah_residu, 2) }} {{ $item->satuan }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-{{ $item->efisiensi_pengelolaan >= 80 ? 'green' : ($item->efisiensi_pengelolaan >= 60 ? 'yellow' : 'red') }}-600 h-2 rounded-full" 
                                                     style="width: {{ min($item->efisiensi_pengelolaan, 100) }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium">{{ number_format($item->efisiensi_pengelolaan, 1) }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-{{ $item->status_hasil_badge_class }}-700 bg-{{ $item->status_hasil_badge_class }}-100 rounded-full">
                                            {{ $item->status_hasil_name }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($item->biaya_aktual)
                                            <div class="text-sm font-medium">Rp {{ number_format($item->biaya_aktual, 0, ',', '.') }}</div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-2 text-sm">
                                            <a href="{{ route('laporan-hasil-pengelolaan.show', $item) }}"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                                title="Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            @if(!auth()->user()->isAdmin() && $item->canEdit())
                                                <a href="{{ route('laporan-hasil-pengelolaan.edit', $item) }}"
                                                    class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('laporan-hasil-pengelolaan.destroy', $item) }}" method="POST" class="inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan hasil ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                        title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $laporanHasil->links() }}
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">
                        @if(request()->hasAny(['search', 'status_hasil', 'perusahaan_id', 'tanggal_dari', 'tanggal_sampai']))
                            Tidak ada laporan hasil yang sesuai dengan filter.
                        @else
                            Belum ada laporan hasil pengelolaan.
                        @endif
                    </p>
                    @if(!auth()->user()->isAdmin())
                        <x-button href="{{ route('laporan-hasil-pengelolaan.create') }}" class="mt-4">
                            Buat Laporan Hasil Pertama
                        </x-button>
                    @endif
                </div>
            @endif
        </x-card>
    </div>
</x-app>