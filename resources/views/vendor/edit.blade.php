<x-app>
    <x-slot:title>
        Edit Vendor
    </x-slot:title>
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Edit Vendor
        </h2>

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vendor.update', $vendor->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <label class="block text-sm" for="nama_perusahaan">
                    <span class="text-gray-700 dark:text-gray-400">Nama Perusahaan</span>
                    <input type="text" name="nama_perusahaan" id="nama_perusahaan"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        value="{{ old('nama_perusahaan', $vendor->nama_perusahaan) }}" required />
                </label>

                <label class="block mt-4 text-sm" for="nama_pic">
                    <span class="text-gray-700 dark:text-gray-400">Nama PIC</span>
                    <input type="text" name="nama_pic" id="nama_pic"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        value="{{ old('nama_pic', $vendor->nama_pic) }}" required />
                </label>

                <label class="block mt-4 text-sm" for="email">
                    <span class="text-gray-700 dark:text-gray-400">Email</span>
                    <input type="email" name="email" id="email"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        value="{{ old('email', $vendor->email) }}" required />
                </label>

                <label class="block mt-4 text-sm" for="telepon">
                    <span class="text-gray-700 dark:text-gray-400">Telepon</span>
                    <input type="text" name="telepon" id="telepon"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        value="{{ old('telepon', $vendor->telepon) }}" required />
                </label>

                <label class="block mt-4 text-sm" for="alamat">
                    <span class="text-gray-700 dark:text-gray-400">Alamat</span>
                    <textarea name="alamat" id="alamat"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        rows="3" required>{{ old('alamat', $vendor->alamat) }}</textarea>
                </label>

                <label class="block mt-4 text-sm" for="jenis_layanan">
                    <span class="text-gray-700 dark:text-gray-400">Jenis Layanan</span>
                    <select name="jenis_layanan" id="jenis_layanan"
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        required>
                        <option value="">-- Pilih Jenis Layanan --</option>
                        <option value="Pengangkutan" {{ old('jenis_layanan', $vendor->jenis_layanan) == 'Pengangkutan' ? 'selected' : '' }}>Pengangkutan</option>
                        <option value="Pengolahan" {{ old('jenis_layanan', $vendor->jenis_layanan) == 'Pengolahan' ? 'selected' : '' }}>Pengolahan</option>
                        <option value="Daur Ulang" {{ old('jenis_layanan', $vendor->jenis_layanan) == 'Daur Ulang' ? 'selected' : '' }}>Daur Ulang</option>
                        <option value="Pembuangan" {{ old('jenis_layanan', $vendor->jenis_layanan) == 'Pembuangan' ? 'selected' : '' }}>Pembuangan</option>
                    </select>
                </label>

                <label class="block mt-4 text-sm" for="deskripsi">
                    <span class="text-gray-700 dark:text-gray-400">Deskripsi (Opsional)</span>
                    <textarea name="deskripsi" id="deskripsi"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        rows="3">{{ old('deskripsi', $vendor->deskripsi) }}</textarea>
                </label>

                <label class="block mt-4 text-sm" for="status">
                    <span class="text-gray-700 dark:text-gray-400">Status</span>
                    <select name="status" id="status"
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        required>
                        <option value="aktif" {{ old('status', $vendor->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status', $vendor->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </label>

                <div class="flex mt-6">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Update
                    </button>
                    <a href="{{ route('vendor.index') }}"
                        class="px-4 py-2 ml-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg active:bg-gray-50 hover:bg-gray-100 focus:outline-none focus:shadow-outline-gray">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app> 