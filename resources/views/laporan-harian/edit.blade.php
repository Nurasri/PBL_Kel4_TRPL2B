<x-app>
    <x-slot:title>
        Edit Laporan Harian Limbah
    </x-slot:title>
    
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Edit Laporan Harian Limbah
            </h2>
            <div class="flex space-x-2">
                <x-button variant="secondary" href="{{ route('laporan-harian.show', $laporanHarian) }}">
                    Detail
                </x-button>
                <x-button variant="secondary" href="{{ route('laporan-harian.index') }}">
                    Kembali
                </x-button>
            </div>
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
            <form action="{{ route('laporan-harian.update', $laporanHarian) }}" method="POST" id="laporan-form">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <!-- Tanggal Laporan -->
                        <div class="mb-4">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Laporan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" id="tanggal" 
                                   value="{{ old('tanggal', $laporanHarian->tanggal->format('Y-m-d')) }}" 
                                   max="{{ date('Y-m-d') }}" required
                                   class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-green-400 focus:ring focus:ring-green-400 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:focus:border-green-400 dark:focus:ring-green-400" />
                            @error('tanggal')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Limbah (Read Only) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jenis Limbah
                            </label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $laporanHarian->jenisLimbah->nama }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Kode: {{ $laporanHarian->jenisLimbah->kode_limbah }} | 
                                    Satuan: {{ $laporanHarian->jenisLimbah->satuan_default }}
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Jenis limbah tidak dapat diubah setelah laporan dibuat</p>
                        </div>

                        <!-- Penyimpanan (Read Only) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Penyimpanan
                            </label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $laporanHarian->penyimpanan->nama_penyimpanan }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Lokasi: {{ $laporanHarian->penyimpanan->lokasi }}
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Penyimpanan tidak dapat diubah setelah laporan dibuat</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Jumlah -->
                            <div class="mb-4">
                                <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jumlah <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="jumlah" id="jumlah" step="0.01" min="0.01" 
                                       value="{{ old('jumlah', $laporanHarian->jumlah) }}" 
                                       placeholder="0.00" required
                                       class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-green-400 focus:ring focus:ring-green-400 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:focus:border-green-400 dark:focus:ring-green-400" />
                                @error('jumlah')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Satuan (Read Only) -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Satuan
                                </label>
                                <input type="text" value="{{ $laporanHarian->satuan }}" readonly 
                                       class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" />
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Keterangan
                            </label>
                            <textarea name="keterangan" id="keterangan" rows="6" 
                                      placeholder="Catatan tambahan tentang laporan ini..."
                                      class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-green-400 focus:ring focus:ring-green-400 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:focus:border-green-400 dark:focus:ring-green-400">{{ old('keterangan', $laporanHarian->keterangan) }}</textarea>
                            @error('keterangan')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Info Jenis Limbah -->
                        <div class="p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                            <h4 class="font-medium text-green-800 dark:text-green-200 mb-2">Informasi Jenis Limbah</h4>
                            <div class="text-sm text-green-700 dark:text-green-300 space-y-1">
                                <div><strong>Kode:</strong> {{ $laporanHarian->jenisLimbah->kode_limbah }}</div>
                                <div><strong>Kategori:</strong> {{ $laporanHarian->jenisLimbah->kategori_name }}</div>
                                <div><strong>Satuan:</strong> {{ $laporanHarian->jenisLimbah->satuan_default }}</div>
                            </div>
                        </div>

                        <!-- Info Penyimpanan -->
                        <div class="p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                            <h4 class="font-medium text-blue-800 dark:text-blue-200 mb-2">Informasi Penyimpanan</h4>
                            <div class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                                <div><strong>Nama:</strong> {{ $laporanHarian->penyimpanan->nama_penyimpanan }}</div>
                                <div><strong>Lokasi:</strong> {{ $laporanHarian->penyimpanan->lokasi }}</div>
                                <div><strong>Kapasitas Maksimal:</strong> {{ number_format($laporanHarian->penyimpanan->kapasitas_maksimal, 2) }} {{ $laporanHarian->penyimpanan->satuan }}</div>
                                <div><strong>Sisa Kapasitas:</strong> {{ number_format($laporanHarian->penyimpanan->sisa_kapasitas, 2) }} {{ $laporanHarian->penyimpanan->satuan }}</div>
                            </div>
                        </div>

                        <!-- Info Status -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-2">Status Laporan</h4>
                            <div class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                                <div class="flex justify-between">
                                    <span>Status Saat Ini:</span>
                                    <span class="px-2 py-1 text-xs font-semibold leading-tight text-{{ $laporanHarian->status_badge_class }}-700 bg-{{ $laporanHarian->status_badge_class }}-100 rounded-full">
                                        {{ $laporanHarian->status_name }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Dibuat:</span>
                                    <span>{{ $laporanHarian->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Diupdate:</span>
                                    <span>{{ $laporanHarian->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 space-x-3">
                    <x-button variant="secondary" href="{{ route('laporan-harian.index') }}">
                        Batal
                    </x-button>
                    @if($laporanHarian->canEdit())
                        <x-button type="submit">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </x-button>
                    @endif
                    @if($laporanHarian->canSubmit())
                        <x-button type="submit" name="status" value="submitted">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Submit Laporan
                        </x-button>
                    @endif
                </div>
            </form>
        </x-card>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisLimbahSelect = document.getElementById('jenis_limbah_select');
            const penyimpananSelect = document.getElementById('penyimpanan_select');
            const satuanDisplay = document.getElementById('satuan_display');
            const jenisLimbahInfo = document.getElementById('jenis-limbah-info');
            const limbahDetails = document.getElementById('limbah-details');
            const penyimpananInfo = document.getElementById('penyimpanan-info');
            const jumlahInput = document.querySelector('input[name="jumlah"]');
            const kapasitasWarning = document.getElementById('kapasitas-warning');
            const submitBtn = document.getElementById('submit-btn');

            let currentPenyimpananData = null;
            const currentPenyimpananId = {{ $laporanHarian->penyimpanan_id }};

            // Handle jenis limbah change
            jenisLimbahSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                
                if (selectedOption.value) {
                    const satuan = selectedOption.dataset.satuan;
                    const kategori = selectedOption.dataset.kategori;
                    const kode = selectedOption.dataset.kode;
                    
                    satuanDisplay.value = satuan;
                    
                    // Update jenis limbah info
                    limbahDetails.innerHTML = `
                        <div><strong>Kode:</strong> ${kode}</div>
                        <div><strong>Kategori:</strong> ${kategori}</div>
                        <div><strong>Satuan:</strong> ${satuan}</div>
                    `;
                    
                    // Load penyimpanan options
                    loadPenyimpananOptions(selectedOption.value);
                } else {
                    satuanDisplay.value = '';
                    penyimpananInfo.classList.add('hidden');
                    penyimpananSelect.innerHTML = '<option value="">Pilih jenis limbah terlebih dahulu</option>';
                }
            });

            // Handle penyimpanan change
            penyimpananSelect.addEventListener('change', function() {
                if (this.value && currentPenyimpananData) {
                    const selected = currentPenyimpananData.find(p => p.id == this.value);
                    if (selected) {
                        updatePenyimpananInfo(selected);
                        checkKapasitas();
                    }
                } else {
                    penyimpananInfo.classList.add('hidden');
                    kapasitasWarning.classList.add('hidden');
                }
            });

            // Handle jumlah change
            jumlahInput.addEventListener('input', checkKapasitas);

            // Load penyimpanan options via AJAX
            function loadPenyimpananOptions(jenisLimbahId) {
                fetch(`{{ route('api.penyimpanan-by-jenis-limbah') }}?jenis_limbah_id=${jenisLimbahId}`)
                    .then(response => response.json())
                    .then(data => {
                        currentPenyimpananData = data;
                        
                        penyimpananSelect.innerHTML = '<option value="">Pilih Penyimpanan</option>';
                        
                        if (data.length === 0) {
                            penyimpananSelect.innerHTML = '<option value="">Tidak ada penyimpanan tersedia</option>';
                        } else {
                            data.forEach(penyimpanan => {
                                const option = document.createElement('option');
                                option.value = penyimpanan.id;
                                option.textContent = `${penyimpanan.nama_penyimpanan} - ${penyimpanan.lokasi}`;
                                option.selected = currentPenyimpananId == penyimpanan.id;
                                penyimpananSelect.appendChild(option);
                            });
                        }
                        
                        // Trigger change to show current penyimpanan info
                        if (currentPenyimpananId) {
                            penyimpananSelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => {
                        console.error('Error loading penyimpanan:', error);
                        penyimpananSelect.innerHTML = '<option value="">Error loading data</option>';
                    });
            }

            // Update penyimpanan info display
            function updatePenyimpananInfo(penyimpanan) {
                // Adjust capacity for current laporan if editing
                let adjustedSisaKapasitas = parseFloat(penyimpanan.sisa_kapasitas);
                if (currentPenyimpananId == penyimpanan.id) {
                    // Add back the current laporan amount to get true available capacity
                    adjustedSisaKapasitas += {{ $laporanHarian->jumlah }};
                }
                
                document.getElementById('sisa-kapasitas').textContent = 
                    `${adjustedSisaKapasitas.toFixed(2)} ${penyimpanan.satuan}`;
                
                // Recalculate percentage
                const totalKapasitas = parseFloat(penyimpanan.kapasitas_maksimal || 100);
                const terpakai = totalKapasitas - adjustedSisaKapasitas;
                const persentase = Math.min(100, Math.max(0, (terpakai / totalKapasitas) * 100));
                
                document.getElementById('kapasitas-bar').style.width = `${persentase}%`;
                
                // Update color based on percentage
                let colorClass = 'green';
                let statusText = 'Aman';
                if (persentase >= 90) {
                    colorClass = 'red';
                    statusText = 'Penuh';
                } else if (persentase >= 75) {
                    colorClass = 'yellow';
                    statusText = 'Peringatan';
                }
                
                document.getElementById('kapasitas-bar').className = `bg-${colorClass}-600 h-2 rounded-full`;
                document.getElementById('status-kapasitas').textContent = statusText;
                document.getElementById('persentase-kapasitas').textContent = `${persentase.toFixed(1)}%`;
                
                // Store adjusted capacity for validation
                penyimpanan.adjusted_sisa_kapasitas = adjustedSisaKapasitas;
                
                penyimpananInfo.classList.remove('hidden');
            }

            // Check kapasitas and show warning
            function checkKapasitas() {
                const jumlah = parseFloat(jumlahInput.value) || 0;
                const selectedPenyimpanan = penyimpananSelect.value;
                
                if (jumlah > 0 && selectedPenyimpanan && currentPenyimpananData) {
                    const penyimpanan = currentPenyimpananData.find(p => p.id == selectedPenyimpanan);
                    
                    if (penyimpanan) {
                        const sisaKapasitas = penyimpanan.adjusted_sisa_kapasitas || parseFloat(penyimpanan.sisa_kapasitas);
                        const warningText = document.getElementById('kapasitas-warning-text');
                        
                        if (jumlah > sisaKapasitas) {
                            warningText.textContent = 
                                `Jumlah limbah (${jumlah.toFixed(2)} ${penyimpanan.satuan}) melebihi sisa kapasitas penyimpanan (${sisaKapasitas.toFixed(2)} ${penyimpanan.satuan}).`;
                            kapasitasWarning.classList.remove('hidden');
                            if (submitBtn) {
                                submitBtn.disabled = true;
                                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                        } else if (jumlah > (sisaKapasitas * 0.8)) {
                            warningText.textContent = 
                                `Peringatan: Jumlah limbah akan mengisi lebih dari 80% sisa kapasitas penyimpanan.`;
                            kapasitasWarning.classList.remove('hidden');
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            }
                        } else {
                            kapasitasWarning.classList.add('hidden');
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            }
                        }
                    }
                } else {
                    kapasitasWarning.classList.add('hidden');
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                }
            }

            // Initialize with current values
            jenisLimbahSelect.dispatchEvent(new Event('change'));
        });
    </script>
</x-app>

