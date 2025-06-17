<x-app>
    <x-slot:title>
        Detail Laporan Hasil Pengelolaan
    </x-slot:title>
    
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Detail Laporan Hasil Pengelolaan
            </h2>
            <div class="flex space-x-2">
                @if(!auth()->user()->isAdmin() && $laporanHasilPengelolaan->canEdit())
                    <x-button href="{{ route('laporan-hasil-pengelolaan.edit', $laporanHasilPengelolaan) }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </x-button>
                @endif
                <x-button variant="secondary" href="{{ route('laporan-hasil-pengelolaan.index') }}">
                    Kembali
                </x-button>
            </div>
        </div>

        @if (session('success'))
            <x-alert type="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        @if (session('info'))
            <x-alert type="info" dismissible>{{ session('info') }}</x-alert>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Utama -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Pengelolaan -->
                <x-card>
                    <x-card-header>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Informasi Pengelolaan Limbah
                        </h3>
                    </x-card-header>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-label>Jenis Limbah</x-label>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $laporanHasilPengelolaan->pengelolaanLimbah->jenisLimbah->nama }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $laporanHasilPengelolaan->pengelolaanLimbah->jenisLimbah->kode_limbah }}
                            </p>
                        </div>
                        <div>
                            <x-label>Tanggal Mulai Pengelolaan</x-label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $laporanHasilPengelolaan->pengelolaanLimbah->tanggal_mulai->format('d F Y') }}
                            </p>
                        </div>
                        <div>
                            <x-label>Jumlah Dikelola</x-label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ number_format($laporanHasilPengelolaan->pengelolaanLimbah->jumlah_dikelola, 2) }} {{ $laporanHasilPengelolaan->satuan }}
                            </p>
                        </div>
                        <div>
                            <x-label>Jenis Pengelolaan</x-label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $laporanHasilPengelolaan->pengelolaanLimbah->jenis_pengelolaan_name }}
                            </p>
                        </div>
                        @if($laporanHasilPengelolaan->pengelolaanLimbah->vendor)
                            <div>
                                <x-label>Vendor</x-label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $laporanHasilPengelolaan->pengelolaanLimbah->vendor->nama_perusahaan }}
                                </p>
                            </div>
                        @endif
                        <div>
                            <x-label>Penyimpanan Asal</x-label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $laporanHasilPengelolaan->pengelolaanLimbah->penyimpanan->nama_penyimpanan }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $laporanHasilPengelolaan->pengelolaanLimbah->penyimpanan->lokasi }}
                            </p>
                        </div>
                    </div>
                </x-card>

                <!-- Hasil Pengelolaan -->
                <x-card>
                    <x-card-header>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Hasil Pengelolaan
                        </h3>
                    </x-card-header>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-label>Tanggal Selesai</x-label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $laporanHasilPengelolaan->tanggal_selesai->format('d F Y') }}
                            </p>
                        </div>
                        <div>
                            <x-label>Status Hasil</x-label>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-tight text-{{ $laporanHasilPengelolaan->status_hasil_badge_class }}-700 bg-{{ $laporanHasilPengelolaan->status_hasil_badge_class }}-100 rounded-full">
                                {{ $laporanHasilPengelolaan->status_hasil_name }}
                            </span>
                        </div>
                        <div>
                            <x-label>Jumlah Berhasil Dikelola</x-label>
                            <p class="text-sm font-medium text-green-600 dark:text-green-400">
                                {{ number_format($laporanHasilPengelolaan->jumlah_berhasil_dikelola, 2) }} {{ $laporanHasilPengelolaan->satuan }}
                            </p>
                        </div>
                        @if($laporanHasilPengelolaan->jumlah_residu > 0)
                            <div>
                                <x-label>Jumlah Residu</x-label>
                                <p class="text-sm text-yellow-600 dark:text-yellow-400">
                                    {{ number_format($laporanHasilPengelolaan->jumlah_residu, 2) }} {{ $laporanHasilPengelolaan->satuan }}
                                </p>
                            </div>
                        @endif
                        <div>
                            <x-label>Efisiensi Pengelolaan</x-label>
                            <div class="flex items-center">
                                <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-{{ $laporanHasilPengelolaan->efisiensi_pengelolaan >= 80 ? 'green' : ($laporanHasilPengelolaan->efisiensi_pengelolaan >= 60 ? 'yellow' : 'red') }}-600 h-2 rounded-full" 
                                         style="width: {{ min($laporanHasilPengelolaan->efisiensi_pengelolaan, 100) }}%"></div>
                                </div>
                                <span class="text-sm font-medium">{{ number_format($laporanHasilPengelolaan->efisiensi_pengelolaan, 1) }}%</span>
                            </div>
                        </div>
                        @if($laporanHasilPengelolaan->metode_disposal_akhir)
                            <div>
                                <x-label>Metode Disposal Akhir</x-label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ ucfirst(str_replace('_', ' ', $laporanHasilPengelolaan->metode_disposal_akhir)) }}
                                </p>
                            </div>
                        @endif
                        @if($laporanHasilPengelolaan->biaya_aktual)
                            <div>
                                <x-label>Biaya Aktual</x-label>
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($laporanHasilPengelolaan->biaya_aktual, 0, ',', '.') }}
                                </p>
                            </div>
                        @endif
                        @if($laporanHasilPengelolaan->nomor_sertifikat)
                            <div>
                                <x-label>Nomor Sertifikat</x-label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $laporanHasilPengelolaan->nomor_sertifikat }}
                                </p>
                            </div>
                        @endif
                    </div>

                    @if($laporanHasilPengelolaan->catatan_hasil)
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <x-label>Catatan Hasil</x-label>
                            <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $laporanHasilPengelolaan->catatan_hasil }}</p>
                            </div>
                        </div>
                    @endif
                </x-card>

                <!-- Dokumentasi -->
                @if($laporanHasilPengelolaan->dokumentasi && count($laporanHasilPengelolaan->dokumentasi) > 0)
                    <x-card>
                        <x-card-header>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Dokumentasi
                            </h3>
                        </x-card-header>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($laporanHasilPengelolaan->dokumentasi as $index => $filePath)
                                @php
                                    $fileName = basename($filePath);
                                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                    $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png']);
                                @endphp
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3">
                                    @if($isImage)
                                        <img src="{{ Storage::url($filePath) }}" 
                                             alt="Dokumentasi {{ $index + 1 }}" 
                                             class="w-full h-24 object-cover rounded mb-2 cursor-pointer"
                                             onclick="openImageModal('{{ Storage::url($filePath) }}', '{{ $fileName }}')">
                                    @else
                                        <div class="w-full h-24 bg-gray-100 dark:bg-gray-800 rounded mb-2 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <p class="text-xs text-gray-600 dark:text-gray-400 truncate" title="{{ $fileName }}">
                                        {{ $fileName }}
                                    </p>
                                    <a href="{{ route('laporan-hasil-pengelolaan.download-dokumentasi', [$laporanHasilPengelolaan, $index]) }}"
                                       class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mt-1">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </x-card>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Status Card -->
                <x-card>
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-{{ $laporanHasilPengelolaan->status_hasil_badge_class }}-100 flex items-center justify-center">
                            @if($laporanHasilPengelolaan->status_hasil === 'berhasil')
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @elseif($laporanHasilPengelolaan->status_hasil === 'partial')
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            {{ $laporanHasilPengelolaan->status_hasil_name }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Efisiensi: {{ number_format($laporanHasilPengelolaan->efisiensi_pengelolaan, 1) }}%
                        </p>
                    </div>
                </x-card>

                <!-- Timeline -->
                <x-card>
                    <x-card-header>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Timeline
                        </h3>
                    </x-card-header>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Pengelolaan Dimulai</p>
                                <p class="text-xs text-gray-500">{{ $laporanHasilPengelolaan->pengelolaanLimbah->tanggal_mulai->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-green-600 rounded-full mt-2"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Pengelolaan Selesai</p>
                                <p class="text-xs text-gray-500">{{ $laporanHasilPengelolaan->tanggal_selesai->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-purple-600 rounded-full mt-2"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Laporan Dibuat</p>
                                <p class="text-xs text-gray-500">{{ $laporanHasilPengelolaan->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        @if($laporanHasilPengelolaan->updated_at != $laporanHasilPengelolaan->created_at)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-2 h-2 bg-gray-600 rounded-full mt-2"></div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Terakhir Diupdate</p>
                                    <p class="text-xs text-gray-500">{{ $laporanHasilPengelolaan->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </x-card>

                @if(auth()->user()->isAdmin())
                    <!-- Info Perusahaan -->
                    <x-card>
                        <x-card-header>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Informasi Perusahaan
                            </h3>
                        </x-card-header>
                        <div class="space-y-2">
                            <div>
                                <x-label>Nama Perusahaan</x-label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $laporanHasilPengelolaan->perusahaan->nama_perusahaan }}
                                </p>
                            </div>
                            <div>
                                <x-label>NPWP</x-label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $laporanHasilPengelolaan->perusahaan->npwp ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <x-label>Alamat</x-label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $laporanHasilPengelolaan->perusahaan->alamat }}
                                </p>
                            </div>
                        </div>
                    </x-card>
                @endif
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain">
            <p id="modalImageName" class="text-white text-center mt-2"></p>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc, imageName) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('modalImageName').textContent = imageName;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-app>