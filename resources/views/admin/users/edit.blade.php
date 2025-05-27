<x-app>
    <x-slot:title>
        Edit User
    </x-slot:title>
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Edit User</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <label class="block text-sm" for="name">
                    <span class="text-gray-700 dark:text-gray-400">Nama</span>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        required />
                </label>

                <label class="block mt-4 text-sm" for="email">
                    <span class="text-gray-700 dark:text-gray-400">Email</span>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        required />
                </label>

                <label class="block mt-4 text-sm" for="role">
                    <span class="text-gray-700 dark:text-gray-400">Role</span>
                    <select name="role" id="role"
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="perusahaan" {{ old('role', $user->role) == 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                    </select>
                </label>

                <label class="block mt-4 text-sm" for="status">
                    <span class="text-gray-700 dark:text-gray-400">Status</span>
                    <select name="status" id="status"
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        required>
                        <option value="">-- Pilih Status --</option>
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </label>

                <label class="block mt-4 text-sm" for="notes">
                    <span class="text-gray-700 dark:text-gray-400">Catatan</span>
                    <textarea name="notes" id="notes" rows="3"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">{{ old('notes', $user->notes) }}</textarea>
                </label>

                <button type="submit" class="px-4 py-2 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-950 bg-sky-50">Batal</a>
            </div>
        </form>
    </div>
</x-app> 