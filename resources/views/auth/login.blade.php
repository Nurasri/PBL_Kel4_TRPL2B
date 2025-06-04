<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - Naima Sustainability</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="fixed w-full z-50 bg-gradient-to-r from-[#1B4332] to-[#2D6A4F] text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="/" class="flex items-center space-x-2">
                    <img src="/images/logo6.png" alt="NAIMA Sustainability" class="h-10">
                    <div class="hidden md:block">
                        <p class="text-sm font-light">Solusi Pengelolaan</p>
                        <p class="text-lg font-semibold -mt-1">Limbah Berkelanjutan</p>
                    </div>
                </a>
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="/" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Beranda</a>
                    <a href="/about" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Tentang Kami</a>
                    <a href="/services" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Layanan</a>
                    <a href="/articles" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Artikel</a>
                    <a href="/login" class="ml-2 bg-[#52B788] hover:bg-[#74C69D] px-6 py-2 rounded-lg transition-all duration-300 font-medium">Masuk/Daftar</a>
                </nav>
                <!-- Mobile menu button -->
                <button class="md:hidden text-white hover:text-gray-300">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile menu (hidden by default) -->
        <div class="md:hidden hidden bg-[#2D6A4F] pb-4">
            <nav class="container mx-auto px-4 flex flex-col space-y-2">
                <a href="/" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Beranda</a>
                <a href="/about" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Tentang Kami</a>
                <a href="/services" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Layanan</a>
                <a href="/articles" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Artikel</a>
                <a href="/login" class="bg-[#52B788] hover:bg-[#74C69D] px-6 py-2 rounded-lg transition-all duration-300 text-center font-medium">Masuk/Daftar</a>
            </nav>
        </div>
    </header>

    <!-- Login Section -->
    <section class="min-h-screen pt-24 pb-16 px-4">
        <div class="container mx-auto">
            <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-[#1B4332]">Selamat Datang Kembali</h2>
                        <p class="text-gray-600 mt-2">Silakan masuk ke akun Anda</p>
                    </div>

                    <!-- Login Form -->
                    <form action="/login" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" id="email" name="email" required
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#52B788] focus:border-transparent"
                                    placeholder="nama@email.com">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" id="password" name="password" required
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#52B788] focus:border-transparent"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" id="remember" name="remember"
                                    class="h-4 w-4 text-[#52B788] focus:ring-[#52B788] border-gray-300 rounded">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    Ingat saya
                                </label>
                            </div>
                            <a href="#" class="text-sm text-[#2D6A4F] hover:text-[#52B788]">
                                Lupa password?
                            </a>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#2D6A4F] text-white py-2 px-4 rounded-lg hover:bg-[#40916C] transition-colors duration-300">
                            Masuk
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="my-6 flex items-center">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="px-4 text-sm text-gray-500">atau</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <!-- Social Login -->
                    <div class="space-y-4">
                        <button class="w-full flex items-center justify-center gap-3 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300">
                            <img src="https://www.google.com/favicon.ico" alt="Google" class="w-5 h-5">
                            <span class="text-gray-700">Masuk dengan Google</span>
                        </button>
                    </div>

                    <!-- Register Link -->
                    <p class="mt-8 text-center text-sm text-gray-600">
                        Belum punya akun?
                        <a href="/register" class="text-[#2D6A4F] hover:text-[#52B788] font-medium">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#063C2E] text-white py-12">
        <div class="container mx-auto px-4 grid grid-cols-3 gap-8">
            <div>
                <img src="/images/logo2.png" alt="NAIMA Sustainability" class="h-8 mb-4">
                <p class="text-sm">Kami hadir untuk yang telah atau akan menerapkan pengelolaan perusahaan saat memulai, ingin memperbaiki, hingga ingin mencapai level yang lebih tinggi dalam aspek keberlanjutan.</p>
                <div class="flex gap-4 mt-4">
                    <a href="#" class="text-white hover:text-gray-300"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white hover:text-gray-300"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div>
                <h3 class="font-bold mb-4">Alamat Kantor</h3>
                <p class="text-sm">Mustang No.14a, Dadok Tunggul Hitam, <b>Kec. Koto Tangah, Kota Padang, Sumatera Barat 25586</b></p>
                <p class="text-sm mt-4">Email:<br>naima.sustainability@gmail.com</p>
                <p class="text-sm mt-4">Telepon:<br>+62 823 4567 890</p>
            </div>
            <div>
                <h3 class="font-bold mb-4">Subscribe to Naima</h3>
                <p class="text-sm mb-4">Dapatkan info ter-update dari Naima</p>
                <div class="flex gap-2">
                    <input type="email" placeholder="Email" class="flex-1 p-2 rounded bg-white/10 border border-white/20">
                    <button class="bg-[#00A67C] px-4 py-2 rounded hover:bg-[#008F6B] transition-all">Submit</button>
                </div>
            </div>
        </div>
        <div class="container mx-auto px-4 mt-8 pt-8 border-t border-white/20 text-center text-sm">
            <p>© {{ date('Y') }} Naima. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Mobile menu JavaScript -->
    <script>
        const mobileMenuButton = document.querySelector('.md\\:hidden.text-white');
        const mobileMenu = document.querySelector('.md\\:hidden.hidden');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html> 