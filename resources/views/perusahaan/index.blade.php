<x-app>
    <x-slot:title>
        Daftar Perusahaan
    </x-slot:title>
    <div class="container">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Daftar Perusahaan</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="px-6 my-6">
            <button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <a href="{{ route('perusahaan.create') }}">Tambah Perusahaan</a>
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                @if ($perusahaans->count())
                    <table class="w-full whitespace-no-wrap">
                        <thead class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3">Logo</th>
                                <th class="px-4 py-3">Nama Perusahaan</th>
                                <th class="px-4 py-3">Pemilik</th>
                                <th class="px-4 py-3">Jenis Usaha</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($perusahaans as $perusahaan)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        @if ($perusahaan->logo)
                                            <img src="{{ Storage::url($perusahaan->logo) }}" alt="Logo {{ $perusahaan->nama_perusahaan }}" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                <span class="text-gray-500 dark:text-gray-400 text-xs">No Logo</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $perusahaan->nama_perusahaan }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $perusahaan->no_registrasi }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm">{{ $perusahaan->user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $perusahaan->user->email }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $perusahaan->jenis_usaha }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-4 text-sm">
                                            <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Detail">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                <a href="{{ route('perusahaan.show', $perusahaan) }}">Detail</a>
                                            </button>
                                            @if(auth()->user()->id === $perusahaan->user_id)
                                                <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                    <a href="{{ route('perusahaan.edit', $perusahaan) }}">Edit</a>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Belum ada data perusahaan yang terdaftar.</p>
                @endif
            </div>
            {{ $perusahaans->links() }}
        </div>
    </div>
</x-app>