<x-app>
    <x-slot:title>
        Detail Perusahaan
    </x-slot:title>
    <div class="container max-w-2xl mx-auto py-8">
        <h2 class="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">Profil Perusahaan</h2>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
                role="alert">
                {{ session('info') }}
            </div>
        @endif

        <x-card>
            <div class="space-y-6">
                <div>
                    <x-label>Nama Perusahaan</x-label>
                    <div class="text-gray-900 dark:text-gray-100 font-semibold">{{ $perusahaan->nama_perusahaan }}</div>
                </div>
                <div>
                    <x-label>Nomor Registrasi</x-label>
                    <div class="text-gray-700 dark:text-gray-200">{{ $perusahaan->no_registrasi }}</div>
                </div>
                <div>
                    <x-label>Jenis Usaha</x-label>
                    <div class="text-gray-700 dark:text-gray-200">{{ $perusahaan->jenis_usaha }}</div>
                </div>
                <div>
                    <x-label>Alamat</x-label>
                    <div class="text-gray-700 dark:text-gray-200">{{ $perusahaan->alamat }}</div>
                </div>
                <div>
                    <x-label>Telepon</x-label>
                    <div class="text-gray-700 dark:text-gray-200">{{ $perusahaan->telepon }}</div>
                </div>
                <div>
                    <x-label>Email</x-label>
                    <div class="text-gray-700 dark:text-gray-200">{{ $perusahaan->email }}</div>
                </div>
                <div>
                    <x-label>Deskripsi</x-label>
                    <div class="text-gray-700 dark:text-gray-200">{{ $perusahaan->deskripsi ?: '-' }}</div>
                </div>
                <div>
                    <x-label>Logo</x-label>
                    <div class="mt-2">
                        @if($perusahaan->logo)
                            <img src="{{ Storage::url($perusahaan->logo) }}" alt="Logo {{ $perusahaan->nama_perusahaan }}"
                                class="w-32 h-32 object-cover rounded-lg">
                        @else
                            <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-500">No Logo</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div>
                    <x-label>Terdaftar Pada</x-label>
                    <div class="text-gray-700 dark:text-gray-200">{{ $perusahaan->created_at->format('d F Y H:i') }}
                    </div>
                </div>
                <div>
                    <x-label>Terakhir Diperbarui</x-label>
                    <div class="text-gray-700 dark:text-gray-200">{{ $perusahaan->updated_at->format('d F Y H:i') }}
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end mt-8 space-x-2">
                @if(auth()->user()->id === $perusahaan->user_id || auth()->user()->isAdmin())
                    <a href="{{ route('perusahaan.edit', $perusahaan) }}"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-semibold">Edit
                        Profil</a>
                @endif
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('perusahaan.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition font-semibold">Kembali</a>
                @endif
            </div>
        </x-card>
    </div>
</x-app>