<x-app>
    <x-slot:title>
        Tambah Jenis Limbah
    </x-slot:title>
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Tambah Jenis Limbah</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.jenis-limbah.store') }}" method="POST">
            @csrf
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <label class="block text-sm" for="nama">
                    <span class="text-gray-700 dark:text-gray-400">Nama Jenis Limbah</span>
                    <input type="text" name="nama" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required value="{{ old('nama') }}" />
                </label>
                <label class="block text-sm mt-4" for="deskripsi">
                    <span class="text-gray-700 dark:text-gray-400">Deskripsi (opsional)</span>
                    <textarea name="deskripsi" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" rows="3">{{ old('deskripsi') }}</textarea>
                </label>
                <button type="submit" class="px-4 py-2 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Simpan</button>
                <a href="{{ route('admin.jenis-limbah.index') }}" class="px-4 py-2 mt-4 ml-2 text-sm font-medium leading-5 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none focus:shadow-outline-gray">Kembali</a>
            </div>
        </form>
    </div>
</x-app>
