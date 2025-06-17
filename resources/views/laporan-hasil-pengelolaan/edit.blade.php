<x-app>
    <x-slot:title>
        Edit Laporan Hasil Pengelolaan
    </x-slot:title>
    
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Edit Laporan Hasil Pengelolaan
            </h2>
            <x-button variant="secondary" href="{{ route('laporan-hasil-pengelolaan.show', $laporanHasilPengelolaan) }}">
                Kembali
            </x-button>
        </div>

        @if ($errors->any())
            <x-alert type="error">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <x-card>
            <form action="{{ route('laporan-hasil-pengelolaan.update', $laporanHasilPengelolaan) }}" method="POST" enctype="multipart/form-data" id="laporan-form">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <!-- Info Pengelolaan (Read-only) -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-3">Informasi Pengelolaan</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Jenis Limbah:</span>
                                    <p class="font-medium">{{ $laporanHasilPengelolaan->pengelolaanLimbah->jenisLimbah->nama }}</p>
                                </div>
                                                                <div>
                                    <span class="text-gray-500">Tanggal Mulai:</span>
                                    <p class="font-medium">{{ $laporanHasilPengelolaan->pengelolaanLimbah->tanggal_mulai->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Jumlah Dikelola:</span>
                                    <p class="font-medium">{{ number_format($laporanHasilPengelolaan->pengelolaanLimbah->jumlah_dikelola, 2) }} {{ $laporanHasilPengelolaan->satuan }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Jenis Pengelolaan:</span>
                                    <p class="font-medium">{{ $laporanHasilPengelolaan->pengelolaanLimbah->jenis_pengelolaan_name }}</p>
                                </div>
                            </div>
                        </div>

                        <x-form-group label="Tanggal Selesai" name="tanggal_selesai" required>
                            <x-input type="date" name="tanggal_selesai" 
                                     value="{{ old('tanggal_selesai', $laporanHasilPengelolaan->tanggal_selesai->format('Y-m-d')) }}" 
                                     max="{{ date('Y-m-d') }}" required />
                        </x-form-group>

                        <x-form-group label="Status Hasil" name="status_hasil" required>
                            <x-select name="status_hasil" required>
                                <option value="">Pilih Status Hasil</option>
                                @foreach(\App\Models\LaporanHasilPengelolaan::getStatusHasilOptions() as $key => $label)
                                    <option value="{{ $key }}" 
                                            {{ old('status_hasil', $laporanHasilPengelolaan->status_hasil) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </x-select>
                        </x-form-group>

                        <div class="grid grid-cols-2 gap-4">
                            <x-form-group label="Jumlah Berhasil Dikelola" name="jumlah_berhasil_dikelola" required>
                                <div class="flex">
                                    <x-input type="number" name="jumlah_berhasil_dikelola" 
                                             value="{{ old('jumlah_berhasil_dikelola', $laporanHasilPengelolaan->jumlah_berhasil_dikelola) }}" 
                                             step="0.01" min="0" placeholder="0.00" required class="rounded-r-none" 
                                             data-max="{{ $laporanHasilPengelolaan->pengelolaanLimbah->jumlah_dikelola }}" />
                                    <x-input type="text" value="{{ $laporanHasilPengelolaan->satuan }}" readonly 
                                             class="w-20 rounded-l-none border-l-0 bg-gray-50 dark:bg-gray-700" />
                                </div>
                            </x-form-group>

                            <x-form-group label="Jumlah Residu" name="jumlah_residu">
                                <x-input type="number" name="jumlah_residu" 
                                         value="{{ old('jumlah_residu', $laporanHasilPengelolaan->jumlah_residu) }}" 
                                         step="0.01" min="0" placeholder="0.00" />
                                <p class="mt-1 text-xs text-gray-500">
                                    Sisa limbah yang tidak berhasil dikelola
                                </p>
                            </x-form-group>
                        </div>

                        <x-form-group label="Metode Disposal Akhir" name="metode_disposal_akhir">
                            <x-select name="metode_disposal_akhir">
                                <option value="">Pilih Metode Disposal</option>
                                @foreach(\App\Models\LaporanHasilPengelolaan::getMetodeDisposalOptions() as $key => $label)
                                    <option value="{{ $key }}" 
                                            {{ old('metode_disposal_akhir', $laporanHasilPengelolaan->metode_disposal_akhir) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </x-select>
                        </x-form-group>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <x-form-group label="Biaya Aktual" name="biaya_aktual">
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                    Rp
                                </span>
                                <x-input type="number" name="biaya_aktual" 
                                         value="{{ old('biaya_aktual', $laporanHasilPengelolaan->biaya_aktual) }}" 
                                         step="0.01" min="0" placeholder="0.00" class="rounded-l-none" />
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                Biaya aktual yang dikeluarkan untuk pengelolaan
                            </p>
                        </x-form-group>

                        <x-form-group label="Nomor Sertifikat" name="nomor_sertifikat">
                            <x-input name="nomor_sertifikat" 
                                     value="{{ old('nomor_sertifikat', $laporanHasilPengelolaan->nomor_sertifikat) }}" 
                                     placeholder="Nomor sertifikat disposal/treatment" />
                        </x-form-group>

                        <!-- Dokumentasi Existing -->
                        @if($laporanHasilPengelolaan->dokumentasi && count($laporanHasilPengelolaan->dokumentasi) > 0)
                            <div>
                                <x-label>Dokumentasi Saat Ini</x-label>
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                    @foreach($laporanHasilPengelolaan->dokumentasi as $index => $filePath)
                                        @php
                                            $fileName = basename($filePath);
                                            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png']);
                                        @endphp
                                        <div class="border border-gray-200 dark:border-gray-700 rounded p-2 relative">
                                            @if($isImage)
                                                <img src="{{ Storage::url($filePath) }}" 
                                                     alt="Dokumentasi {{ $index + 1 }}" 
                                                     class="w-full h-16 object-cover rounded mb-1">
                                            @else
                                                <div class="w-full h-16 bg-gray-100 dark:bg-gray-800 rounded mb-1 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <p class="text-xs text-gray-600 dark:text-gray-400 truncate" title="{{ $fileName }}">
                                                {{ $fileName }}
                                            </p>
                                            <div class="flex items-center justify-between mt-1">
                                                <a href="{{ route('laporan-hasil-pengelolaan.download-dokumentasi', [$laporanHasilPengelolaan, $index]) }}"
                                                   class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                                    Download
                                                </a>
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="hapus_dokumentasi[]" value="{{ $index }}" 
                                                           class="text-red-600 rounded">
                                                    <span class="ml-1 text-xs text-red-600">Hapus</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Centang "Hapus" untuk menghapus file yang tidak diperlukan
                                </p>
                            </div>
                        @endif

                        <x-form-group label="Tambah Dokumentasi Baru" name="dokumentasi">
                            <x-input type="file" name="dokumentasi[]" multiple accept=".pdf,.jpg,.jpeg,.png" />
                            <p class="mt-1 text-xs text-gray-500">
                                Upload foto, dokumen sertifikat, atau bukti lainnya (PDF, JPG, PNG, max 5MB per file)
                            </p>
                        </x-form-group>

                        <x-form-group label="Catatan Hasil" name="catatan_hasil">
                            <x-textarea name="catatan_hasil" rows="6" 
                                        placeholder="Catatan detail tentang hasil pengelolaan...">{{ old('catatan_hasil', $laporanHasilPengelolaan->catatan_hasil) }}</x-textarea>
                        </x-form-group>
                    </div>
                </div>

                <!-- Peringatan Jumlah -->
                <div id="jumlah-warning" class="hidden mt-4 p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h4 class="font-medium text-yellow-800 dark:text-yellow-200">Peringatan</h4>
                            <p id="jumlah-warning-text" class="text-sm text-yellow-700 dark:text-yellow-300 mt-1"></p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <x-button variant="secondary" href="{{ route('laporan-hasil-pengelolaan.show', $laporanHasilPengelolaan) }}">
                        Batal
                    </x-button>
                    <x-button type="submit" id="submit-btn">
                        Update Laporan Hasil
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahBerhasilInput = document.querySelector('input[name="jumlah_berhasil_dikelola"]');
            const jumlahResiduInput = document.querySelector('input[name="jumlah_residu"]');
            const jumlahWarning = document.getElementById('jumlah-warning');
            const submitBtn = document.getElementById('submit-btn');
            
            const maxJumlah = parseFloat(jumlahBerhasilInput.dataset.max);

            // Handle input changes
            jumlahBerhasilInput.addEventListener('input', validateJumlah);
            jumlahResiduInput.addEventListener('input', validateJumlah);

            function validateJumlah() {
                const jumlahBerhasil = parseFloat(jumlahBerhasilInput.value) || 0;
                const jumlahResidu = parseFloat(jumlahResiduInput.value) || 0;
                const totalJumlah = jumlahBerhasil + jumlahResidu;
                
                const warningText = document.getElementById('jumlah-warning-text');
                
                if (jumlahBerhasil > maxJumlah) {
                    warningText.textContent = 
                        `Jumlah berhasil dikelola (${jumlahBerhasil.toFixed(2)}) tidak boleh melebihi jumlah yang dikelola (${maxJumlah.toFixed(2)}).`;
                    jumlahWarning.classList.remove('hidden');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else if (totalJumlah > maxJumlah) {
                    warningText.textContent = 
                        `Total jumlah berhasil dan residu (${totalJumlah.toFixed(2)}) tidak boleh melebihi jumlah yang dikelola (${maxJumlah.toFixed(2)}).`;
                    jumlahWarning.classList.remove('hidden');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    jumlahWarning.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            // Initial validation
            validateJumlah();
        });
    </script>
</x-app>
