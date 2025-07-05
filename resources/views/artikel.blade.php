<x-layout>
    <!-- Header -->
    <header class="fixed w-full z-50 bg-gradient-to-r from-[#1B4332] to-[#2D6A4F] text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                <a href="/">
                    <img src="/images/logo7.png" alt="NAIMA Sustainability" class="h-10">
                    </a>
                    <div class="hidden md:block">
                        <p class="text-sm font-light">Solusi Pengelolaan</p>
                        <p class="text-lg font-semibold -mt-1">Limbah Berkelanjutan</p>
                    </div>
                </div>
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="/"
                        class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Beranda</a>
                    <a href="/tentang-kami"
                        class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Tentang Kami</a>
                    <a href="/layanan"
                        class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Layanan</a>
                    <a href="/artikel"
                        class="px-4 py-2 bg-[#40916C] rounded-lg transition-all duration-300">Artikel</a>
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
                <a href="/"
                    class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Beranda</a>
                <a href="/tentang-kami" class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Tentang
                    Kami</a>
                <a href="/layanan"
                    class="px-4 py-2 hover:bg-[#40916C] rounded-lg transition-all duration-300">Layanan</a>
                <a href="/artikel"
                    class="px-4 py-2 bg-[#40916C] rounded-lg transition-all duration-300">Artikel</a>
                <a href="/login"
                    class="bg-[#52B788] hover:bg-[#74C69D] px-6 py-2 rounded-lg transition-all duration-300 text-center font-medium">Masuk/Daftar</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-24 pb-16 bg-gradient-to-r from-[#1B4332] to-[#2D6A4F] text-white">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">Artikel & Berita</h1>
            <p class="text-xl max-w-3xl mx-auto">Temukan informasi terbaru seputar pengelolaan limbah, keberlanjutan, dan praktik ramah lingkungan</p>
        </div>
    </section>

    <!-- Search and Filter Section -->
    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input type="text" placeholder="Cari artikel..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#18B17C] focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-[#18B17C] text-white rounded-lg hover:bg-[#15A06B] transition-colors">
                        Semua
                    </button>
                    <button class="px-4 py-2 bg-white text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Pengelolaan Limbah
                    </button>
                    <button class="px-4 py-2 bg-white text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Daur Ulang
                    </button>
                    <button class="px-4 py-2 bg-white text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Keberlanjutan
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Article -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-[#042A20] mb-8">Artikel Utama</h2>
            <div class="bg-gradient-to-r from-[#18B17C] to-[#34C78F] rounded-xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="p-8 text-white">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="bg-white/20 px-3 py-1 rounded-full text-sm">Featured</span>
                            <span class="text-white/80">15 Maret 2024</span>
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Mengenal Prinsip 3R+ dalam Pengelolaan Limbah</h3>
                        <p class="text-lg mb-6 text-white/90">
                            Prinsip 3R+ (Reduce, Reuse, Recycle, Recovery) menjadi dasar penting dalam pengelolaan limbah yang efektif. 
                            Artikel ini akan membahas implementasi prinsip tersebut dalam kehidupan sehari-hari dan industri.
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-eye text-white/80"></i>
                                <span class="text-white/80">1,234 views</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock text-white/80"></i>
                                <span class="text-white/80">5 min read</span>
                            </div>
                        </div>
                        <button class="mt-6 bg-white text-[#18B17C] px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                            Baca Artikel Lengkap
                        </button>
                    </div>
                    <div class="bg-gray-200 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-image text-6xl mb-4"></i>
                            <p>Gambar Artikel Utama</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Articles Grid -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-[#042A20] mb-8">Artikel Terbaru</h2>
            
            <!-- Database Articles Placeholder -->
            <div id="database-articles" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <!-- Placeholder untuk artikel dari database -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-image text-4xl mb-2"></i>
                            <p class="text-sm">Gambar Artikel</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-[#18B17C] text-white px-2 py-1 rounded text-xs">Pengelolaan Limbah</span>
                            <span class="text-gray-500 text-sm">12 Maret 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#042A20] mb-3">Judul Artikel dari Database</h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            Deskripsi singkat artikel yang akan diambil dari database. Artikel ini akan menampilkan konten yang relevan dengan pengelolaan limbah.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i>456</span>
                                <span><i class="fas fa-clock mr-1"></i>3 min</span>
                            </div>
                            <button class="text-[#18B17C] font-semibold hover:text-[#15A06B] transition-colors">
                                Baca Selengkapnya →
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-image text-4xl mb-2"></i>
                            <p class="text-sm">Gambar Artikel</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-[#2D6A4F] text-white px-2 py-1 rounded text-xs">Daur Ulang</span>
                            <span class="text-gray-500 text-sm">10 Maret 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#042A20] mb-3">Artikel Daur Ulang dari Database</h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            Artikel tentang daur ulang yang akan diambil dari database. Konten ini akan fokus pada praktik daur ulang yang efektif.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i>789</span>
                                <span><i class="fas fa-clock mr-1"></i>4 min</span>
                            </div>
                            <button class="text-[#18B17C] font-semibold hover:text-[#15A06B] transition-colors">
                                Baca Selengkapnya →
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-image text-4xl mb-2"></i>
                            <p class="text-sm">Gambar Artikel</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-[#52B788] text-white px-2 py-1 rounded text-xs">Keberlanjutan</span>
                            <span class="text-gray-500 text-sm">8 Maret 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#042A20] mb-3">Artikel Keberlanjutan dari Database</h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            Artikel tentang keberlanjutan yang akan diambil dari database. Fokus pada praktik bisnis yang ramah lingkungan.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i>234</span>
                                <span><i class="fas fa-clock mr-1"></i>6 min</span>
                            </div>
                            <button class="text-[#18B17C] font-semibold hover:text-[#15A06B] transition-colors">
                                Baca Selengkapnya →
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Static Articles (Sample Content) -->
            <h3 class="text-2xl font-bold text-[#042A20] mb-6">Artikel Pilihan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Article 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-recycle text-4xl mb-2"></i>
                            <p class="text-sm">Daur Ulang</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-[#18B17C] text-white px-2 py-1 rounded text-xs">Pengelolaan Limbah</span>
                            <span class="text-gray-500 text-sm">5 Maret 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#042A20] mb-3">Cara Memilah Sampah yang Benar</h3>
                        <p class="text-gray-600 mb-4">
                            Pelajari cara memilah sampah organik dan anorganik dengan benar untuk memudahkan proses daur ulang dan pengelolaan limbah.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i>1,567</span>
                                <span><i class="fas fa-clock mr-1"></i>4 min</span>
                            </div>
                            <button class="text-[#18B17C] font-semibold hover:text-[#15A06B] transition-colors">
                                Baca Selengkapnya →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Article 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-leaf text-4xl mb-2"></i>
                            <p class="text-sm">Kompos</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-[#2D6A4F] text-white px-2 py-1 rounded text-xs">Daur Ulang</span>
                            <span class="text-gray-500 text-sm">3 Maret 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#042A20] mb-3">Membuat Kompos dari Sampah Dapur</h3>
                        <p class="text-gray-600 mb-4">
                            Tutorial lengkap cara membuat kompos dari sampah dapur organik. Mengubah limbah menjadi pupuk alami yang bermanfaat.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i>2,345</span>
                                <span><i class="fas fa-clock mr-1"></i>7 min</span>
                            </div>
                            <button class="text-[#18B17C] font-semibold hover:text-[#15A06B] transition-colors">
                                Baca Selengkapnya →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Article 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-industry text-4xl mb-2"></i>
                            <p class="text-sm">Industri</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-[#52B788] text-white px-2 py-1 rounded text-xs">Keberlanjutan</span>
                            <span class="text-gray-500 text-sm">1 Maret 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#042A20] mb-3">Pengelolaan Limbah di Industri</h3>
                        <p class="text-gray-600 mb-4">
                            Strategi pengelolaan limbah yang efektif untuk industri. Mengoptimalkan proses dan mengurangi dampak lingkungan.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i>3,789</span>
                                <span><i class="fas fa-clock mr-1"></i>8 min</span>
                            </div>
                            <button class="text-[#18B17C] font-semibold hover:text-[#15A06B] transition-colors">
                                Baca Selengkapnya →
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-12 gap-2">
                <button class="px-4 py-2 bg-[#18B17C] text-white rounded-lg hover:bg-[#15A06B] transition-colors">1</button>
                <button class="px-4 py-2 border border-[#18B17C] text-[#18B17C] rounded-lg hover:bg-[#18B17C] hover:text-white transition-colors">2</button>
                <button class="px-4 py-2 border border-[#18B17C] text-[#18B17C] rounded-lg hover:bg-[#18B17C] hover:text-white transition-colors">3</button>
                <button class="px-4 py-2 border border-[#18B17C] text-[#18B17C] rounded-lg hover:bg-[#18B17C] hover:text-white transition-colors">Next →</button>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-[#18B17C]">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Butuh Layanan Pengelolaan Limbah?</h2>
            <p class="text-xl text-white mb-8 max-w-2xl mx-auto">
                Konsultasikan kebutuhan pengelolaan limbah Anda dengan tim ahli kami. Dapatkan solusi yang tepat dan berkelanjutan.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/layanan" 
                   class="bg-white text-[#18B17C] hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Lihat Layanan Kami
                </a>
                <a href="/tentang-kami" 
                   class="border-2 border-white text-white hover:bg-white hover:text-[#18B17C] px-8 py-3 rounded-lg font-semibold transition-colors">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <script>
        // Placeholder untuk fungsi pencarian dan filter
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.querySelector('input[placeholder="Cari artikel..."]');
            searchInput.addEventListener('input', function(e) {
                // Implementasi pencarian akan ditambahkan nanti
                console.log('Searching for:', e.target.value);
            });

            // Filter buttons
            const filterButtons = document.querySelectorAll('.flex.gap-2 button');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active state from all buttons
                    filterButtons.forEach(btn => {
                        btn.classList.remove('bg-[#18B17C]', 'text-white');
                        btn.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-300');
                    });
                    
                    // Add active state to clicked button
                    this.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-300');
                    this.classList.add('bg-[#18B17C]', 'text-white');
                    
                    // Implementasi filter akan ditambahkan nanti
                    console.log('Filtering by:', this.textContent);
                });
            });
        });
    </script>
</x-layout>