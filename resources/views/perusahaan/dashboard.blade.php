<x-app>
    <x-slot:title>
        Dashboard Perusahaan
    </x-slot:title>
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard Perusahaan
        </h2>

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

        <!-- Welcome Card -->
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="flex items-center">
                @if($perusahaan->logo)
                    <img src="{{ Storage::url($perusahaan->logo) }}" alt="Logo"
                        class="w-16 h-16 rounded-full object-cover mr-4">
                @else
                    <div class="w-16 h-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-4">
                        <span class="text-gray-500 dark:text-gray-400 text-xs">Logo</span>
                    </div>
                @endif
                <div>
                    <h1 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
                        Selamat datang, {{ $perusahaan->nama_perusahaan }}!
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $perusahaan->jenis_usaha }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Total Laporan -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div
                    class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Laporan
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $total_laporan }}
                    </p>
                </div>
            </div>

            <!-- Laporan Pending -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Laporan Pending
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $laporan_pending }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-700 dark:text-gray-300">
                Aksi Cepat
            </h4>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('laporan-harian.create') }}"
                    class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 dark:bg-green-900 dark:hover:bg-green-800 transition-colors">
                    <svg class="w-8 h-8 mr-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-green-800 dark:text-green-200">Buat Laporan</p>
                        <p class="text-sm text-green-600 dark:text-green-400">Laporan harian limbah</p>
                    </div>
                </a>

                <a href="{{ route('penyimpanan.index') }}"
                    class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 dark:bg-blue-900 dark:hover:bg-blue-800 transition-colors">
                    <svg class="w-8 h-8 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-blue-800 dark:text-blue-200">Penyimpanan</p>
                        <p class="text-sm text-blue-600 dark:text-blue-400">Kelola penyimpanan limbah</p>
                    </div>
                </a>

                <a href="{{ route('perusahaan.show', $perusahaan) }}"
                    class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 dark:bg-purple-900 dark:hover:bg-purple-800 transition-colors">
                    <svg class="w-8 h-8 mr-3 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <div>
                        <p class="font-medium text-purple-800 dark:text-purple-200">Profil Perusahaan</p>
                        <p class="text-sm text-purple-600 dark:text-purple-400">Lihat & edit profil</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-700 dark:text-gray-300">
                Aktivitas Terbaru
            </h4>
            <div class="text-gray-600 dark:text-gray-400">
                <p>Belum ada aktivitas terbaru.</p>
            </div>
        </div>
    </div>
</x-app>