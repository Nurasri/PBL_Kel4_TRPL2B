<x-app>
    <x-slot:title>
        Detail Perusahaan
    </x-slot:title>
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Detail Perusahaan
            </h2>
            <div class="flex space-x-4">
                @if(auth()->user()->id === $perusahaan->user_id)
                    <a href="{{ route('perusahaan.edit', $perusahaan) }}" 
                       class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Edit Profil
                    </a>
                @endif
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.perusahaan.index') }}" 
                       class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
                        Kembali
                    </a>
                @endif
            </div>
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Dasar -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                        Informasi Dasar
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama Perusahaan</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-200">{{ $perusahaan->nama_perusahaan }}</p>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nomor Registrasi</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-200">{{ $perusahaan->no_registrasi }}</p>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Jenis Usaha</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-200">{{ $perusahaan->jenis_usaha }}</p>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Alamat</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-200">{{ $perusahaan->alamat }}</p>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nomor Telepon</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-200">{{ $perusahaan->no_telp }}</p>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Deskripsi</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-200">{{ $perusahaan->deskripsi ?: '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                        Informasi Tambahan
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Pemilik</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-200">
                                {{ $perusahaan->user->name }}
                                <span class="text-sm text-gray-500">({{ $perusahaan->user->email }})</span>
                            </p>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Logo Perusahaan</span>
                            <div class="mt-2">
                                @if($perusahaan->logo)
                                    <img src="{{ asset('storage/' . $perusahaan->logo) }}" 
                                         alt="Logo {{ $perusahaan->nama_perusahaan }}" 
                                         class="w-32 h-32 object-cover rounded-lg">
                                @else
                                    <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <span class="text-gray-500">No Logo</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Terdaftar Pada</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-200">
                                {{ $perusahaan->created_at->format('d F Y H:i') }}
                            </p>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Terakhir Diperbarui</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-200">
                                {{ $perusahaan->updated_at->format('d F Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app> 