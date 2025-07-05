<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Naima Sustainability</title>
    <link rel="shorcut icon" href="/images/icon.jpeg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
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

        * {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-white text-gray-900">

    {{ $slot }}

    <!-- Footer -->
    <footer class="bg-[#063C2E] text-white py-12">
        <div class="container mx-auto px-4 grid grid-cols-3 gap-8">
            <div>
                <a href="/" class="inline-block">
                    <img src="/images/logo2.png" alt="NAIMA Sustainability" class="h-8 mb-4 hover:opacity-80 transition-opacity cursor-pointer">
                </a>
                <p class="text-sm">Kami hadir untuk yang telah atau akan menerapkan pengelolaan perusahaan saat
                    memulai, ingin memperbaiki, hingga ingin mencapai level yang lebih tinggi dalam aspek keberlanjutan.
                </p>
                <div class="flex gap-4 mt-4">
                    <a href="#" class="text-white hover:text-gray-300"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white hover:text-gray-300"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div>
                <h3 class="font-bold mb-4">Alamat Kantor</h3>
                <p class="text-sm">Mustang No.14a, Dadok Tunggul Hitam, <b>Kec. Koto Tangah, Kota Padang, Sumatera
                        Barat 25586</b></p>
                <p class="text-sm mt-4">Email:<br>naima.sustainability@gmail.com</p>
                <p class="text-sm mt-4">Telepon:<br>+62 823 4567 890</p>
            </div>
            <div>
                <h3 class="font-bold mb-4">Subscribe to Naima</h3>
                <p class="text-sm mb-4">Dapatkan info ter-update dari Naima</p>
                <div class="flex gap-2">
                    <input type="email" placeholder="Email"
                        class="flex-1 p-2 rounded bg-white/10 border border-white/20">
                    <button class="bg-[#00A67C] px-4 py-2 rounded hover:bg-[#008F6B] transition-all">Submit</button>
                </div>
            </div>
        </div>
        <div class="container mx-auto px-4 mt-8 pt-8 border-t border-white/20 text-center text-sm">
            <p>© {{ date('Y') }} Naima. All Rights Reserved.</p>
        </div>
    </footer>

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
