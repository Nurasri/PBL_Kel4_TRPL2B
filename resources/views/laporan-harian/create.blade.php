<x-app>
    <x-slot:title>
        Tambah Laporan Harian
    </x-slot:title>
    
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Tambah Laporan Harian Limbah
            </h2>
            <x-button variant="secondary" href="{{ route('laporan-harian.index') }}">
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
            <form action="{{ route('laporan-harian.store') }}" method="POST" id="laporan-form">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <x-form-group label="Tanggal Laporan" name="tanggal" required>
                            <x-input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required />
                        </x-form-group>

                        <x-form-group label="Jenis Limbah" name="jenis_limbah_id" required>
                            <x-select name="jenis_limbah_id" id="jenis_limbah_select" required>
                                <option value="">Pilih Jenis Limbah</option>
                                @foreach($jenisLimbahs as $jenis)
                                    <option value="{{ $jenis->id }}" 
                                            data-satuan="{{ $jenis->satuan_default }}"
                                            {{ old('jenis_limbah_id') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama }} ({{ $jenis->kode_limbah }})
                                    </option>
                                @endforeach
                            </x-select>
                        </x-form-group>

                        <x-form-group label="Penyimpanan" name="penyimpanan_id" required>
                            <x-select name="penyimpanan_id" id="penyimpanan_select" required>
                                <option value="">Pilih jenis limbah terlebih dahulu</option>
                            </x-select>
                            
                            <div id="penyimpanan-info" class="hidden mt-2 p-3 bg-blue-50 rounded-lg">
                                <div class="text-sm text-blue-700">
                                    <div class="flex justify-between mb-1">
                                        <span>Sisa Kapasitas:</span>
                                        <span id="sisa-kapasitas" class="font-medium">-</span>
                                    </div>
                                    <div class="w-full bg-blue-200 rounded-full h-2">
                                        <div id="kapasitas-bar" class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs mt-1">
                                        <span id="status-kapasitas">-</span>
                                        <span id="persentase-kapasitas">0%</span>
                                    </div>
                                </div>
                            </div>
                        </x-form-group>

                        <div class="grid grid-cols-2 gap-4">
                            <x-form-group label="Jumlah" name="jumlah" required>
                                <x-input type="number" name="jumlah" step="0.01" min="0.01" 
                                         value="{{ old('jumlah') }}" placeholder="0.00" required />
                            </x-form-group>

                            <x-form-group label="Satuan" name="satuan">
                                <x-input name="satuan" id="satuan_display" readonly placeholder="Pilih jenis limbah" class="bg-gray-50" />
                            </x-form-group>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <x-form-group label="Keterangan" name="keterangan">
                            <x-textarea name="keterangan" rows="6" 
                                        placeholder="Catatan tambahan tentang laporan ini...">{{ old('keterangan') }}</x-textarea>
                        </x-form-group>

                        <!-- Peringatan Kapasitas -->
                        <div id="kapasitas-warning" class="hidden p-4 bg-yellow-50 rounded-lg">
                            <div class="flex">
                                <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h4 class="font-medium text-yellow-800">Peringatan Kapasitas</h4>
                                    <p id="kapasitas-warning-text" class="text-sm text-yellow-700 mt-1"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 space-x-3">
                    <x-button variant="secondary" href="{{ route('laporan-harian.index') }}">
                        Batal
                    </x-button>
                    <x-button type="submit" name="status" value="draft">
                        Simpan Draft
                    </x-button>
                    <x-button type="submit" name="status" value="submitted" id="submit-btn">
                        Submit Laporan
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisLimbahSelect = document.getElementById('jenis_limbah_select');
            const penyimpananSelect = document.getElementById('penyimpanan_select');
            const satuanDisplay = document.getElementById('satuan_display');
            const penyimpananInfo = document.getElementById('penyimpanan-info');
            const jumlahInput = document.querySelector('input[name="jumlah"]');
            const kapasitasWarning = document.getElementById('kapasitas-warning');
            const submitBtn = document.getElementById('submit-btn');

            let currentPenyimpananData = null;

            // Handle jenis limbah change
            jenisLimbahSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                
                if (selectedOption.value) {
                    const satuan = selectedOption.dataset.satuan;
                    satuanDisplay.value = satuan;
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
                penyimpananSelect.innerHTML = '<option value="">Loading...</option>';
                penyimpananSelect.disabled = true;

                fetch(`{{ route('api.penyimpanan-by-jenis-limbah') }}?jenis_limbah_id=${jenisLimbahId}`)
                    .then(response => response.json())
                    .then(data => {
                        currentPenyimpananData = data;
                        
                        penyimpananSelect.disabled = false;
                        penyimpananSelect.innerHTML = '<option value="">Pilih Penyimpanan</option>';
                        
                        if (data.length === 0) {
                            penyimpananSelect.innerHTML = '<option value="">Tidak ada penyimpanan tersedia</option>';
                        } else {
                            data.forEach(penyimpanan => {
                                const option = document.createElement('option');
                                option.value = penyimpanan.id;
                                option.textContent = `${penyimpanan.nama_penyimpanan} - ${penyimpanan.lokasi}`;
                                option.selected = {{ old('penyimpanan_id') ?: 'null' }} == penyimpanan.id;
                                penyimpananSelect.appendChild(option);
                            });
                        }
                        
                        // Trigger change if there's old value
                        if ({{ old('penyimpanan_id') ?: 'null' }}) {
                            penyimpananSelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => {
                        console.error('Error loading penyimpanan:', error);
                        penyimpananSelect.disabled = false;
                        penyimpananSelect.innerHTML = '<option value="">Error loading data</option>';
                    });
            }

            // Update penyimpanan info display
            function updatePenyimpananInfo(penyimpanan) {
                document.getElementById('sisa-kapasitas').textContent = 
                    `${parseFloat(penyimpanan.sisa_kapasitas).toFixed(2)} ${penyimpanan.satuan}`;
                
                document.getElementById('kapasitas-bar').style.width = `${penyimpanan.persentase_kapasitas}%`;
                document.getElementById('kapasitas-bar').className = 
                    `bg-${penyimpanan.status_kapasitas_color}-600 h-2 rounded-full`;
                
                document.getElementById('status-kapasitas').textContent = penyimpanan.status_kapasitas_text;
                document.getElementById('persentase-kapasitas').textContent = `${penyimpanan.persentase_kapasitas}%`;
                
                penyimpananInfo.classList.remove('hidden');
            }

            // Check kapasitas and show warning
            function checkKapasitas() {
                const jumlah = parseFloat(jumlahInput.value) || 0;
                const selectedPenyimpanan = penyimpananSelect.value;
                
                if (jumlah > 0 && selectedPenyimpanan && currentPenyimpananData) {
                    const penyimpanan = currentPenyimpananData.find(p => p.id == selectedPenyimpanan);
                    
                    if (penyimpanan) {
                        const sisaKapasitas = parseFloat(penyimpanan.sisa_kapasitas);
                        const warningText = document.getElementById('kapasitas-warning-text');
                        
                        if (jumlah > sisaKapasitas) {
                            warningText.textContent = 
                                `Jumlah limbah (${jumlah.toFixed(2)} ${penyimpanan.satuan}) melebihi sisa kapasitas penyimpanan (${sisaKapasitas.toFixed(2)} ${penyimpanan.satuan}).`;
                            kapasitasWarning.classList.remove('hidden');
                            submitBtn.disabled = true;
                            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        } else if (jumlah > (sisaKapasitas * 0.8)) {
                            warningText.textContent = 
                                `Peringatan: Jumlah limbah akan mengisi lebih dari 80% sisa kapasitas penyimpanan.`;
                            kapasitasWarning.classList.remove('hidden');
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        } else {
                            kapasitasWarning.classList.add('hidden');
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        }
                    }
                } else {
                    kapasitasWarning.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            // Initialize if old values exist
            @if(old('jenis_limbah_id'))
                jenisLimbahSelect.dispatchEvent(new Event('change'));
            @endif
        });
    </script>
</x-app>
