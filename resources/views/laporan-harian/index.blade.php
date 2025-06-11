<x-app>
    <x-slot:title>
        Laporan Harian Limbah
    </x-slot:title>
    
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Laporan Harian Limbah
            </h2>
            <div class="flex space-x-2">
                <x-button href="{{ route('laporan-harian.export') }}" variant="secondary" size="sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </x-button>
                <x-button href="{{ route('laporan-harian.create') }}">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Laporan
                </x-button>
            </div>
        </div>

        @if (session('success'))
            <x-alert type="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        @if (session('error'))
            <x-alert type="error" dismissible>{{ session('error') }}</x-alert>
        @endif

        <!-- Filter Section -->
        <!-- Filter Section -->
        <x-card class="mb-6">
            <form method="GET" action="{{ route('laporan-harian.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-label>Pencarian</x-label>
                        <x-input name="search" value="{{ request('search') }}" placeholder="Cari jenis limbah, penyimpanan..." />
                    </div>
                    <div>
                        <x-label>Jenis Limbah</x-label>
                        <x-select name="jenis_limbah_id" :options="$jenisLimbahOptions" value="{{ request('jenis_limbah_id') }}" placeholder="Semua Jenis" />
                    </div>
                    <div>
                        <x-label>Penyimpanan</x-label>
                        <x-select name="penyimpanan_id" :options="$penyimpananOptions" value="{{ request('penyimpanan_id') }}" placeholder="Semua Penyimpanan" />
                    </div>
                    <div>
                        <x-label>Status</x-label>
                        <x-select name="status" :options="$statusOptions" value="{{ request('status') }}" placeholder="Semua Status" />
                    </div>
                    <div>
                        <x-label>Tanggal Dari</x-label>
                        <x-input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" />
                    </div>
                    <div>
                        <x-label>Tanggal Sampai</x-label>
                        <x-input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" />
                    </div>
                </div>

                <div class="flex flex-wrap justify-end items-center gap-2">
                    <x-button type="submit" size="sm">Filter</x-button>
                    <x-button type="button" variant="secondary" size="sm" onclick="window.location.href='{{ route('laporan-harian.index') }}'">Reset</x-button>
                </div>
            </form>
        </x-card>


        <!-- Bulk Actions -->
        @if($laporan->count() > 0)
            <x-card class="mb-4 p-4">
                <form id="bulk-form" action="{{ route('laporan-harian.bulk-action') }}" method="POST">
                    @csrf
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                            <label for="select-all" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Pilih Semua</label>
                        </div>
                        
                        <select name="action" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-green-400 focus:ring focus:ring-green-400 focus:ring-opacity-50">
                            <option value="">Pilih Aksi</option>
                            <option value="submit">Submit Terpilih</option>
                            <option value="delete">Hapus Terpilih</option>
                        </select>
                        
                        <x-button type="submit" size="sm" onclick="return confirm('Yakin melakukan aksi ini?')">
                            Jalankan
                        </x-button>
                    </div>
                </form>
            </x-card>
        @endif

        <!-- Data Table -->
        <x-card :padding="false">
            @if ($laporan->count())
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3 w-8"></th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Jenis Limbah</th>
                                <th class="px-4 py-3">Penyimpanan</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($laporan as $item)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <input type="checkbox" name="laporan_ids[]" value="{{ $item->id }}" 
                                               form="bulk-form" class="laporan-checkbox rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $item->tanggal->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->tanggal_laporan->format('H:i') }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $item->jenisLimbah->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->jenisLimbah->kode_limbah }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $item->penyimpanan->nama_penyimpanan }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->penyimpanan->lokasi }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ number_format($item->jumlah, 2) }} {{ $item->satuan }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-{{ $item->status_badge_class }}-700 bg-{{ $item->status_badge_class }}-100 rounded-full">
                                            {{ $item->status_name }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-2 text-sm">
                                            <a href="{{ route('laporan-harian.show', $item) }}"
                                                class="flex items-center px-2 py-1 text-blue-600 rounded hover:bg-blue-50"
                                                title="Detail">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                            
                                            @if($item->canEdit())
                                                <a href="{{ route('laporan-harian.edit', $item) }}"
                                                    class="flex items-center px-2 py-1 text-green-600 rounded hover:bg-green-50"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                            
                                            @if($item->canSubmit())
                                                <form action="{{ route('laporan-harian.submit', $item) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="flex items-center px-2 py-1 text-purple-600 rounded hover:bg-purple-50"
                                                            title="Submit"
                                                            onclick="return confirm('Yakin ingin submit laporan ini?')">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($item->canDelete())
                                                <form action="{{ route('laporan-harian.destroy', $item) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="flex items-center px-2 py-1 text-red-600 rounded hover:bg-red-50"
                                                            title="Hapus"
                                                            onclick="return confirm('Yakin ingin menghapus laporan ini?')">
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
                    {{ $laporan->links() }}
                </div>
            @else
                                <div class="p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada laporan harian.</p>
                    <x-button href="{{ route('laporan-harian.create') }}">
                        Buat Laporan Pertama
                    </x-button>
                </div>
            @endif
        </x-card>
    </div>

    <!-- JavaScript untuk bulk actions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const laporanCheckboxes = document.querySelectorAll('.laporan-checkbox');

            // Select all functionality
            selectAllCheckbox.addEventListener('change', function() {
                laporanCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Update select all when individual checkboxes change
            laporanCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkedCount = document.querySelectorAll('.laporan-checkbox:checked').length;
                    selectAllCheckbox.checked = checkedCount === laporanCheckboxes.length;
                    selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < laporanCheckboxes.length;
                });
            });
        });
    </script>
</x-app>
