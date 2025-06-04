<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Naima Sustainability</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .carousel-container {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .service-card {
            transition: all 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-5px);
        }
    </style>
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
                <a href="#" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Beranda</a>
                <a href="#" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Tentang Kami</a>
                <a href="#" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Layanan</a>
                <a href="#" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Artikel</a>
                <a href="#" class="bg-[#52B788] hover:bg-[#74C69D] px-6 py-2 rounded-lg transition-all duration-300 text-center font-medium">Masuk/Daftar</a>
            </nav>
        </div>
    </header>

    <!-- Carousel Section with overlay text -->
    <section class="relative h-[700px]">
        <div class="carousel-container absolute inset-0">
            <div class="carousel-slides h-full relative">
                <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-500">
                    <img src="/images/carousel/1.jpg" alt="Carousel Image 1" class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent flex items-center">
                        <div class="container mx-auto px-4">
                            <div class="max-w-2xl text-white">
                                <h1 class="text-5xl font-bold mb-4 ml-7">Solusi Limbah Berkelanjutan</h1>
                                <p class="text-xl mb-8 ml-7">Bersama menciptakan lingkungan yang lebih bersih untuk masa depan yang lebih baik</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-500">
                    <img src="/images/carousel/2.jpg" alt="Carousel Image 2" class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent flex items-center">
                        <div class="container mx-auto px-4">
                            <div class="max-w-2xl text-white">
                                <h1 class="text-5xl font-bold mb-4 ml-7">Inovasi Pengolahan Limbah</h1>
                                <p class="text-xl mb-8 ml-7">Teknologi modern untuk pengelolaan limbah yang efisien dan ramah lingkungan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-500">
                    <img src="/images/carousel/5.jpg" alt="Carousel Image 3" class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent flex items-center">
                        <div class="container mx-auto px-4">
                            <div class="max-w-2xl text-white">
                                <h1 class="text-5xl font-bold mb-4 ml-7">Komitmen Lingkungan</h1>
                                <p class="text-xl mb-8 ml-7">Mendukung pembangunan berkelanjutan melalui pengelolaan limbah yang bertanggung jawab</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button onclick="moveSlide(-1)" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-4xl z-10 hover:text-[#52B788] transition-colors">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button onclick="moveSlide(1)" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-4xl z-10 hover:text-[#52B788] transition-colors">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-10">
            <button onclick="goToSlide(0)" class="w-3 h-3 rounded-full bg-white transition-colors"></button>
            <button onclick="goToSlide(1)" class="w-3 h-3 rounded-full bg-gray-400 transition-colors"></button>
            <button onclick="goToSlide(2)" class="w-3 h-3 rounded-full bg-gray-400 transition-colors"></button>
        </div>
    </section>

    <!-- Service Categories -->
    <section class="py-8 container mx-auto px-4">
    <h2 class="text-2xl font-bold text-center mb-12">Layanan Kami</h2>
        <div class="grid grid-cols-3 gap-8 max-w-3xl mx-auto">
            <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow">
                <i class="fas fa-handshake text-4xl mb-4 "></i>
                <p class="text-base font-medium">STRATEGI BISNIS</p>
            </div>
            <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow">
                <i class="fas fa-cogs text-4xl mb-4 "></i>
                <p class="text-base font-medium">MANAJEMEN LIMBAH</p>
            </div>
            <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow">
                <i class="fas fa-recycle text-4xl mb-4 "></i>
                <p class="text-base font-medium">PENGELOLAAN LIMBAH</p>
            </div>
        </div>
    </section>

    <!-- Main Services -->
    <section class="py-16 text-white" style="background-color: #042A20;">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-2xl font-bold mb-4">Kami hadir untuk memberikan Solusi untuk berbagai masalah</h2>
            <p class="text-center mb-12">yang dihadapi organisasi dalam menerapkan aspek keberlanjutan</p>
            
            <div class="grid grid-cols-2 gap-6 max-w-4xl mx-auto">
                <div class="service-card bg-[#0B4D3C] p-6 rounded-lg">
                    <div class="flex items-start gap-4">
                        <img src="/images/transform-icon.png" alt="" class="w-12 h-12">
                        <div>
                            <h3 class="font-bold mb-2">TRANSFORMASI KEBERLANJUTAN</h3>
                            <p class="text-sm">Memberikan solusi untuk organisasi dalam menerapkan strategy dan model operasional organisasi</p>
                        </div>
                    </div>
                </div>
                <div class="service-card bg-[#0B4D3C] p-6 rounded-lg">
                    <div class="flex items-start gap-4">
                        <img src="/images/strategy-icon.png" alt="" class="w-12 h-12">
                        <div>
                            <h3 class="font-bold mb-2">MEREALISASIKAN STRATEGI FUNGSIONAL</h3>
                            <p class="text-sm">Membantu strategi dan proses yang tepat untuk mencapai tujuan dan target keberlanjutan</p>
                        </div>
                    </div>
                </div>
                <div class="service-card bg-[#0B4D3C] p-6 rounded-lg">
                    <div class="flex items-start gap-4">
                        <img src="/images/distribution-icon.png" alt="" class="w-12 h-12">
                        <div>
                            <h3 class="font-bold mb-2">MENGHADAPI DISRUPSI</h3>
                            <p class="text-sm">Memberikan solusi dan proses untuk organisasi dalam menghadapi perubahan secara efektif</p>
                        </div>
                    </div>
                </div>
                <div class="service-card bg-[#0B4D3C] p-6 rounded-lg">
                    <div class="flex items-start gap-4">
                        <img src="/images/citra-icon.png" alt="" class="w-12 h-12">
                        <div>
                            <h3 class="font-bold mb-2">MEMBANGUN CITRA KEBERLANJUTAN</h3>
                            <p class="text-sm">Membantu peningkatan dan sistem keberlanjutan organisasi untuk mencapai citra positif</p>
                        </div>
                    </div>
                </div>
                <div class="service-card bg-[#0B4D3C] p-6 rounded-lg col-span-2">
                    <div class="flex items-start gap-4">
                        <img src="/images/efficiency-icon.png" alt="" class="w-12 h-12">
                        <div>
                            <h3 class="font-bold mb-2">EFISIENSI ORGANISASI</h3>
                            <p class="text-sm">Memberikan praktik baik yang menunjang organisasi untuk lebih efektif dalam mencapai efisiensi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements -->
    <section class="py-16 container mx-auto px-4">
        <h2 class="text-2xl font-bold text-center mb-12">Pencapaian Naima</h2>
        <div class="grid grid-cols-3 gap-8 max-w-4xl mx-auto">
            <div class="text-center">
                <div class="text-4xl font-bold text-[#042A20] mb-2">20+</div>
                <p class="text-sm">Jumlah proyek yang berhasil diselesaikan</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-[#042A20] mb-2">17+</div>
                <p class="text-sm">Sektor industri yang telah dibantu</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-[#042A20] mb-2">6+</div>
                <p class="text-sm">Penghargaan yang pernah diraih</p>
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

    <!-- Add carousel JavaScript before closing body tag -->
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.bottom-8 button');

        // Show initial slide
        showSlide(currentSlide);

        // Auto advance slides every 5 seconds
        setInterval(() => moveSlide(1), 5000);

        function showSlide(n) {
            // Hide all slides
            slides.forEach(slide => slide.style.opacity = '0');
            dots.forEach(dot => dot.classList.replace('bg-white', 'bg-gray-400'));

            // Show current slide
            slides[n].style.opacity = '1';
            dots[n].classList.replace('bg-gray-400', 'bg-white');
        }

        function moveSlide(direction) {
            currentSlide = (currentSlide + direction + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        function goToSlide(n) {
            currentSlide = n;
            showSlide(currentSlide);
        }
    </script>
</body>

</html>
