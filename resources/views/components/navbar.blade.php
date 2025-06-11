    <!-- Header -->
    <header class="fixed w-full z-50 bg-gradient-to-r from-[#1B4332] to-[#2D6A4F] text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <img src="/images/logo7.png" alt="NAIMA Sustainability" class="h-10">
                    <div class="hidden md:block">
                        <p class="text-sm font-light">Solusi Pengelolaan</p>
                        <p class="text-lg font-semibold -mt-1">Limbah Berkelanjutan</p>
                    </div>
                </div>
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="#home"
                        class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Beranda</a>
                    <a href="#about"
                        class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Tentang Kami</a>
                    <a href="#layanan"
                        class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Layanan</a>
                    <a href="/articles"
                        class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Artikel</a>
                    <a href="/login"
                        class="ml-2 bg-[#52B788] hover:bg-[#74C69D] px-6 py-2 rounded-lg transition-all duration-300 font-medium">Masuk/Daftar</a>
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
                <a href="#"
                    class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Beranda</a>
                <a href="#" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Tentang
                    Kami</a>
                <a href="#"
                    class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Layanan</a>
                <a href="#"
                    class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Artikel</a>
                <a href="#"
                    class="bg-[#52B788] hover:bg-[#74C69D] px-6 py-2 rounded-lg transition-all duration-300 text-center font-medium">Masuk/Daftar</a>
            </nav>
        </div>
    </header>


    <!-- Carousel Section with overlay text -->
    <section id="home" class="relative h-[700px]">
        <div class="carousel-container absolute inset-0">
            <div class="carousel-slides h-full relative">
                <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-500">
                    <img src="/images/carousel/1.jpg" alt="Carousel Image 1"
                        class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent flex items-center">
                        <div class="container mx-auto px-4">
                            <div class="max-w-2xl text-white">
                                <h1 class="text-5xl font-bold mb-4 ml-7">Solusi Limbah Berkelanjutan</h1>
                                <p class="text-xl mb-8 ml-7">Bersama menciptakan lingkungan yang lebih bersih untuk masa
                                    depan yang lebih baik</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-500">
                    <img src="/images/carousel/2.jpg" alt="Carousel Image 2"
                        class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent flex items-center">
                        <div class="container mx-auto px-4">
                            <div class="max-w-2xl text-white">
                                <h1 class="text-5xl font-bold mb-4 ml-7">Inovasi Pengolahan Limbah</h1>
                                <p class="text-xl mb-8 ml-7">Teknologi modern untuk pengelolaan limbah yang efisien dan
                                    ramah lingkungan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-500">
                    <img src="/images/carousel/5.jpg" alt="Carousel Image 3"
                        class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent flex items-center">
                        <div class="container mx-auto px-4">
                            <div class="max-w-2xl text-white">
                                <h1 class="text-5xl font-bold mb-4 ml-7">Komitmen Lingkungan</h1>
                                <p class="text-xl mb-8 ml-7">Mendukung pembangunan berkelanjutan melalui pengelolaan
                                    limbah yang bertanggung jawab</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button onclick="moveSlide(-1)"
                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-4xl z-10 hover:text-[#52B788] transition-colors">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button onclick="moveSlide(1)"
                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-4xl z-10 hover:text-[#52B788] transition-colors">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-10">
            <button onclick="goToSlide(0)" class="w-3 h-3 rounded-full bg-white transition-colors"></button>
            <button onclick="goToSlide(1)" class="w-3 h-3 rounded-full bg-gray-400 transition-colors"></button>
            <button onclick="goToSlide(2)" class="w-3 h-3 rounded-full bg-gray-400 transition-colors"></button>
        </div>
    </section>
