<x-app>
    <x-slot:title>
        Daftar Perusahaan
    </x-slot:title>
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Daftar Perusahaan
        </h2>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
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
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('perusahaan.show', $perusahaan) }}" 
                                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            Detail
                                        </a>
                                        @if(auth()->user()->id === $perusahaan->user_id)
                                            <a href="{{ route('perusahaan.edit', $perusahaan) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                Edit
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                {{ $perusahaans->links() }}
            </div>
        </div>
    </div>
</x-app>