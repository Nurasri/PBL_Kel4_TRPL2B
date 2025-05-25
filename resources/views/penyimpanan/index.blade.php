<x-app>
    <x-slot:title>
        Penyimpanan Limbah
    </x-slot:title>
    <div class="container">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Data Penyimpanan Limbah</h2>
        <div class="px-6 my-6">
            <a href="{{ route('penyimpanan.create') }}"
                class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Tambah Penyimpanan
                <span class="ml-2" aria-hidden="true">+</span>
            </a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                @if ($penyimpanan->count())
                    <table class="w-full whitespace-no-wrap">
                        <thead
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3">Lokasi</th>
                                <th class="px-4 py-3">Jenis Penyimpanan</th>
                                <th class="px-4 py-3">Kapasitas</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($penyimpanan as $item)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm">{{ $item->lokasi }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $item->jenis_penyimpanan }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $item->kapasitas ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-4 text-sm">
                                            <a href="{{ route('penyimpanan.edit', $item->id) }}"
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">
                                                <svg class="w-5 h-5 mr-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('penyimpanan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                                    <svg class="w-5 h-5 mr-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                            <a href="{{ route('penyimpanan.show', $item->id) }}"
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">
                                                <svg class="w-5 h-5 mr-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M15 8a3 3 0 11-6 0 3 3 0 016 0zm-3 5a7 7 0 100-14 7 7 0 000 14zm0 2a9 9 0 110-18 9 9 0 010 18z"></path>
                                                </svg>
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Belum ada data penyimpanan.</p>
                @endif
            </div>
        </div>
    </div>
</x-app>
