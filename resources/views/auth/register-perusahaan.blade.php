<x-guest>
    <x-slot:title>
        Register Perusahaan
    </x-slot:title>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img
                        aria-hidden="true"
                        class="object-cover w-full h-full dark:hidden"
                        src="{{ asset('assets/img/create-account-office.jpeg') }}"
                        alt="Office"
                    />
                    <img
                        aria-hidden="true"
                        class="hidden object-cover w-full h-full dark:block"
                        src="{{ asset('assets/img/create-account-office-dark.jpeg') }}"
                        alt="Office"
                    />
                </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                            Daftar Akun Perusahaan
                        </h1>

                        <form method="POST" action="{{ route('register.store') }}">
                            @csrf
                            <input type="hidden" name="role" value="perusahaan">

                            <!-- Name -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Nama</span>
                                <input
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                />
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </label>

                            <!-- Email -->
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Email</span>
                                <input
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                />
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </label>

                            <!-- Password -->
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Password</span>
                                <input
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    type="password"
                                    name="password"
                                    required
                                />
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </label>

                            <!-- Confirm Password -->
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Konfirmasi Password</span>
                                <input
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                />
                                @error('password_confirmation')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </label>

                            <button
                                type="submit"
                                class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                            >
                                Daftar
                            </button>
                        </form>

                        <p class="mt-4 text-center">
                            <a
                                class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
                                href="{{ route('login') }}"
                            >
                                Sudah punya akun? Login
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest> 

