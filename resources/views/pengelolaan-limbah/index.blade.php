<x-app>
    <x-slot:title>
        Pengelolaan Limbah
    </x-slot:title>
    
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Pengelolaan Limbah
            </h2>
            <x-button href="{{ route('pengelolaan-limbah.create') }}">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pengelolaan
            </x-button>
        </div>

        @if (session('success'))
            <x-alert type="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        @if (session('error'))
            <x-alert type="error" dismissible>{{ session('error') }}</x-alert>
        @endif

        <!-- Filter Section -->
        <x-card class="mb-6">
            <form method="GET" action="{{ route('pengelolaan-limbah.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div>
                    <x-label>Pencarian</x-label>
                    <x-input name="search" value="{{ request('search') }}" placeholder="Cari manifest, jenis limbah..." />
                </div>
                
                <div>
                    <x-label>Jenis Pengelolaan</x-label>
                    <x-select name="jenis_pengelolaan" :options="$jenisOptions" value="{{ request('jenis_pengelolaan') }}" placeholder="Semua Jenis" />
                </div>
                
                <div>
                    <x-label>Status</x-label>
                    <x-select name="status" :options="$statusOptions" value="{{ request('status') }}" placeholder="Semua Status" />
                </div>
                
                <div>
                    <x-label>Vendor</x-label>
                    <x-select name="vendor_id" :options="$vendorOptions" value="{{ request('vendor_id') }}" placeholder="Semua Vendor" />
                </div>
                
                <div>
                    <x-label>Tanggal Dari</x-label>
                    <x-input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" />
                </div>
                
                <div>
                    <x-label>Tanggal Sampai</x-label>
                    <x-input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" />
                </div>
                
                <div class="md:col-span-6 flex items-end space-x-2">
                    <x-button type="submit" size="sm">Filter</x-button>
                    <x-button type="button" variant="secondary" size="sm" onclick="window.location.href='{{ route('pengelolaan-limbah.index') }}'">Reset</x-button>
                </div>
            </form>
        </x-card>

        <!-- Data Table -->
        <x-card :padding="false">
            @if ($pengelolaanLimbah->count())
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Jenis Limbah</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Jenis Pengelolaan</th>
                                <th class="px-4 py-3">Vendor</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($pengelolaanLimbah as $item)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $item->tanggal_mulai->format('d/m/Y') }}</div>
                                        @if($item->tanggal_selesai)
                                            <div class="text-xs text-gray-500">Selesai: {{ $item->tanggal_selesai->format('d/m/Y') }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $item->laporanHarian->jenisLimbah->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->laporanHarian->jenisLimbah->kode_limbah }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ number_format($item->jumlah_dikelola, 2) }} {{ $item->satuan }}</div>
                                        @if($item->nomor_manifest)
                                            <div class="text-xs text-gray-500">{{ $item->nomor_manifest }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm">{{ $item->jenis_pengelolaan_name }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($item->vendor)
                                            <div class="text-sm">{{ $item->vendor->nama_perusahaan }}</div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-{{ $item->status_badge_class }}-700 bg-{{ $item->status_badge_class }}-100 rounded-full">
                                            {{ $item->status_name }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-2 text-sm">
                                            <a href="{{ route('pengelolaan-limbah.show', $item) }}"
                                                class="flex items-center px-2 py-1 text-blue-600 rounded hover:bg-blue-50"
                                                title="Detail">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                            
                                            @if($item->canEdit())
                                                <a href="{{ route('pengelolaan-limbah.edit', $item) }}"
                                                    class="flex items-center px-2 py-1 text-green-600 rounded hover:bg-green-50"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                            
                                            @if($item->canEdit())
                                                <form action="{{ route('pengelolaan-limbah.destroy', $item) }}" method="POST" 
                                                      class="inline" onsubmit="return confirm('Yakin ingin menghapus pengelolaan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="flex items-center px-2 py-1 text-red-600 rounded hover:bg-red-50"
                                                            title="Hapus">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
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
                    {{ $pengelolaanLimbah->links() }}
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada data pengelolaan limbah.</p>
                    <x-button class="mt-4" href="{{ route('pengelolaan-limbah.create') }}">
                        Tambah Pengelolaan Pertama
                    </x-button>
                </div>
            @endif
        </x-card>
    </div>
</x-app>