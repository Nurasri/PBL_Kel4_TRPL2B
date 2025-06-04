<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Artikel - Naima Sustainability</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-white text-gray-900">
    <!-- Header -->
    <header class="fixed w-full z-50 bg-gradient-to-r from-[#1B4332] to-[#2D6A4F] text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <img src="/images/logo6.png" alt="NAIMA Sustainability" class="h-10">
                    <div class="hidden md:block">
                        <p class="text-sm font-light">Solusi Pengelolaan</p>
                        <p class="text-lg font-semibold -mt-1">Limbah Berkelanjutan</p>
                    </div>
                </div>
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="/" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Beranda</a>
                    <a href="/about" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Tentang Kami</a>
                    <a href="/services" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Layanan</a>
                    <a href="/articles" class="px-4 py-2 bg-[#40916C] rounded-lg transition-all duration-300">Artikel</a>
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
                <a href="/articles" class="px-4 py-2 bg-[#40916C] rounded-lg transition-all duration-300">Artikel</a>
                <a href="#" class="bg-[#52B788] hover:bg-[#74C69D] px-6 py-2 rounded-lg transition-all duration-300 text-center font-medium">Masuk/Daftar</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-32 pb-16 bg-gradient-to-b from-[#1B4332] to-[#2D6A4F] text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-6">Artikel & Berita</h1>
                <p class="text-xl mb-8">Informasi terkini seputar pengelolaan limbah dan keberlanjutan lingkungan</p>
            </div>
        </div>
    </section>

    <!-- Featured Article -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="md:flex">
                        <div class="md:w-1/2">
                            <img src="/images/articles/featured.jpg" alt="Featured Article" class="w-full h-full object-cover">
                        </div>
                        <div class="md:w-1/2 p-8">
                            <span class="text-[#52B788] font-medium">Featured</span>
                            <h2 class="text-3xl font-bold text-[#1B4332] mt-2 mb-4">Inovasi Terbaru dalam Pengelolaan Limbah Industri</h2>
                            <p class="text-gray-600 mb-6">Temukan bagaimana teknologi terbaru dapat membantu industri dalam mengelola limbah secara lebih efektif dan ramah lingkungan.</p>
                            <div class="flex items-center mb-6">
                                <img src="/images/team/author.jpg" alt="Author" class="w-10 h-10 rounded-full mr-4">
                                <div>
                                    <p class="font-medium">John Doe</p>
                                    <p class="text-sm text-gray-500">12 Mei 2024</p>
                                </div>
                            </div>
                            <a href="#" class="inline-block bg-[#52B788] hover:bg-[#74C69D] text-white px-6 py-2 rounded-lg transition-all duration-300">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Grid -->
    <section class="pb-16">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Article Card 1 -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="/images/articles/article1.jpg" alt="Article 1" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <span class="text-[#52B788] text-sm font-medium">Sustainability</span>
                            <h3 class="text-xl font-bold text-[#1B4332] mt-2 mb-3">Pentingnya Daur Ulang dalam Industri Modern</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Pelajari bagaimana praktik daur ulang dapat menguntungkan bisnis Anda sambil melindungi lingkungan.</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="/images/team/author1.jpg" alt="Author" class="w-8 h-8 rounded-full mr-3">
                                    <p class="text-sm">Jane Smith</p>
                                </div>
                                <p class="text-sm text-gray-500">10 Mei 2024</p>
                            </div>
                        </div>
                    </div>

                    <!-- Article Card 2 -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="/images/articles/article2.jpg" alt="Article 2" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <span class="text-[#52B788] text-sm font-medium">Tips & Tricks</span>
                            <h3 class="text-xl font-bold text-[#1B4332] mt-2 mb-3">5 Cara Mengurangi Limbah di Kantor</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Temukan langkah-langkah praktis untuk menciptakan lingkungan kerja yang lebih ramah lingkungan.</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="/images/team/author2.jpg" alt="Author" class="w-8 h-8 rounded-full mr-3">
                                    <p class="text-sm">Mike Johnson</p>
                                </div>
                                <p class="text-sm text-gray-500">8 Mei 2024</p>
                            </div>
                        </div>
                    </div>

                    <!-- Article Card 3 -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="/images/articles/article3.jpg" alt="Article 3" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <span class="text-[#52B788] text-sm font-medium">News</span>
                            <h3 class="text-xl font-bold text-[#1B4332] mt-2 mb-3">Regulasi Baru Pengelolaan Limbah B3</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Update terbaru tentang peraturan pengelolaan limbah B3 yang perlu diketahui oleh pelaku industri.</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="/images/team/author3.jpg" alt="Author" class="w-8 h-8 rounded-full mr-3">
                                    <p class="text-sm">Sarah Wilson</p>
                                </div>
                                <p class="text-sm text-gray-500">5 Mei 2024</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <a href="#" class="px-4 py-2 bg-[#F0F7F4] text-[#1B4332] rounded-lg hover:bg-[#52B788] hover:text-white transition-all">Previous</a>
                        <a href="#" class="px-4 py-2 bg-[#52B788] text-white rounded-lg">1</a>
                        <a href="#" class="px-4 py-2 bg-[#F0F7F4] text-[#1B4332] rounded-lg hover:bg-[#52B788] hover:text-white transition-all">2</a>
                        <a href="#" class="px-4 py-2 bg-[#F0F7F4] text-[#1B4332] rounded-lg hover:bg-[#52B788] hover:text-white transition-all">3</a>
                        <a href="#" class="px-4 py-2 bg-[#F0F7F4] text-[#1B4332] rounded-lg hover:bg-[#52B788] hover:text-white transition-all">Next</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-[#042A20] text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Berlangganan Newsletter</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Dapatkan artikel terbaru dan update seputar pengelolaan limbah dan keberlanjutan lingkungan</p>
            <div class="max-w-md mx-auto flex gap-4">
                <input type="email" placeholder="Masukkan email Anda" class="flex-1 px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400">
                <button class="bg-[#52B788] hover:bg-[#74C69D] px-8 py-3 rounded-lg transition-all duration-300">Subscribe</button>
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

    <!-- WhatsApp Button -->
    <a href="#" class="fixed bottom-8 right-8 bg-[#25D366] text-white p-4 rounded-full shadow-lg hover:bg-[#128C7E] transition-all">
        <i class="fab fa-whatsapp text-2xl"></i>
    </a>

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