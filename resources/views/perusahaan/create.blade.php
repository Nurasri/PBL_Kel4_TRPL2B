<x-app>
    <x-slot:title>
        Buat Profil Perusahaan
    </x-slot:title>
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Buat Profil Perusahaan
            </h2>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.perusahaan.index') }}" 
                   class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
                    Kembali
                </a>
            @endif
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form method="POST" action="{{ route('perusahaan.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Nama Perusahaan -->
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nama Perusahaan</span>
                    <input type="text" 
                           name="nama_perusahaan" 
                           value="{{ old('nama_perusahaan') }}"
                           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                           required />
                    @error('nama_perusahaan')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </label>

                <!-- Alamat -->
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Alamat</span>
                    <textarea name="alamat" 
                              rows="3" 
                              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                              required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </label>

                <!-- Nomor Telepon -->
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nomor Telepon</span>
                    <input type="text" 
                           name="no_telp" 
                           value="{{ old('no_telp') }}"
                           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                           required />
                    @error('no_telp')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </label>

                <!-- Jenis Usaha -->
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Jenis Usaha</span>
                    <input type="text" 
                           name="jenis_usaha" 
                           value="{{ old('jenis_usaha') }}"
                           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                           required />
                    @error('jenis_usaha')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </label>

                <!-- Nomor Registrasi -->
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nomor Registrasi</span>
                    <input type="text" 
                           name="no_registrasi" 
                           value="{{ old('no_registrasi') }}"
                           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                           required />
                    @error('no_registrasi')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </label>

                <!-- Deskripsi -->
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Deskripsi</span>
                    <textarea name="deskripsi" 
                              rows="4" 
                              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </label>

                <!-- Logo -->
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Logo Perusahaan</span>
                    <input type="file" 
                           name="logo" 
                           class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                           accept="image/*" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG atau JPEG (Maks. 2MB)</p>
                    @error('logo')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </label>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app> 