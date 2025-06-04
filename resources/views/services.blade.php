<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Layanan - Naima Sustainability</title>
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
                    <a href="/services" class="px-4 py-2 bg-[#40916C] rounded-lg transition-all duration-300">Layanan</a>
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
                <a href="/services" class="px-4 py-2 bg-[#40916C] rounded-lg transition-all duration-300">Layanan</a>
                <a href="/articles" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Artikel</a>
                <a href="#" class="bg-[#52B788] hover:bg-[#74C69D] px-6 py-2 rounded-lg transition-all duration-300 text-center font-medium">Masuk/Daftar</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-32 pb-16 bg-gradient-to-b from-[#1B4332] to-[#2D6A4F] text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-6">Layanan Kami</h1>
                <p class="text-xl mb-8">Solusi komprehensif untuk pengelolaan limbah dan keberlanjutan lingkungan</p>
            </div>
        </div>
    </section>

    <!-- Main Services -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                <!-- Waste Management Service -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="/images/services/waste-management.jpg" alt="Waste Management" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-[#1B4332] mb-4">Pengelolaan Limbah</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Pengumpulan dan pemilahan limbah</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Pengolahan limbah B3 dan non-B3</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Daur ulang dan pemanfaatan limbah</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Sustainability Consulting -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="/images/services/sustainability.jpg" alt="Sustainability Consulting" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-[#1B4332] mb-4">Konsultasi Keberlanjutan</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Audit lingkungan</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Perencanaan strategi keberlanjutan</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Implementasi sistem manajemen lingkungan</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Training and Education -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="/images/services/training.jpg" alt="Training and Education" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-[#1B4332] mb-4">Pelatihan dan Edukasi</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Workshop pengelolaan limbah</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Sertifikasi pengelolaan lingkungan</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Program kesadaran lingkungan</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Environmental Impact Assessment -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="/images/services/assessment.jpg" alt="Environmental Assessment" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-[#1B4332] mb-4">Analisis Dampak Lingkungan</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Studi AMDAL</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Pemantauan kualitas lingkungan</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#2D6A4F] mt-1 mr-3"></i>
                                <span>Rekomendasi perbaikan lingkungan</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-[#042A20] text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Butuh Konsultasi?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Tim ahli kami siap membantu Anda menemukan solusi terbaik untuk kebutuhan pengelolaan limbah dan keberlanjutan lingkungan</p>
            <a href="#" class="inline-block bg-[#52B788] hover:bg-[#74C69D] px-8 py-3 rounded-lg transition-all duration-300 font-medium text-lg">Hubungi Kami</a>
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