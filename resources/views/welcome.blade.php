<x-layout>

    {{-- Tentang Kami --}}
    <section id="about" class="py-8 container mx-auto px-4">
        <h2 class="text-2xl font-bold text-center mb-12">Tentang Kami</h2>
        <div class="bg-[#18B17C] text-black rounded-2xl p-10 max-w-6xl mx-auto mt-10">
            <h2 class="text-3xl font-bold">Mari Mengenal Website <br>EcoCycle kami</h2>
            <p class="mt-6 text-lg">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus quam sed libero commodo consequat.
                Phasellus vitae massa enim. Donec mollis, velit a efficitur sagittis, eros lacus volutpat tortor,
                accumsan volutpat nibh arcu finibus nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Aliquam sed leo augue. Pellentesque lobortis elementum elit, a pretium lectus dignissim nec.
                Pellentesque ut nisl auctor, tempus velit quis, mattis metus. Donec mi lorem, eleifend sed dapibus id,
                congue a enim.

                Aenean consequat aliquam leo, id rutrum augue scelerisque non. Pellentesque lacinia varius orci in
                lobortis. Fusce gravida sapien ante. Proin cursus dui nulla, mattis hendrerit tellus consectetur vitae.
                Sed a aliquet nulla. Aenean et tempor nibh, vitae efficitur nisl. Fusce blandit volutpat vehicula. Donec
                et urna odio. Ut ut odio consectetur diam sagittis cursus. Sed nibh enim, aliquet ac quam quis, tempus
                interdum quam.

            </p>
            <p class="mt-4 text-lg">
                In eleifend aliquam quam, in bibendum urna lobortis vel. Aliquam odio tortor, faucibus quis lacus sed,
                elementum ultrices ligula. Mauris scelerisque pretium eros, vitae dapibus turpis ultricies sed. Nulla
                bibendum justo vitae odio ornare, non mollis eros lacinia. Integer eget ultrices libero. Aenean faucibus
                libero ut semper varius. Donec in nisi ut nisi maximus finibus.
            </p>
        </div>
    </section>

    {{-- Visi dan misi --}}
    <section class="py-8 container mx-auto px-4">
        <div
            class="bg-[#002d26] rounded-xl p-6 flex flex-col md:flex-row items-center md:items-start gap-6 max-w-5xl mx-auto my-8 text-white">
            <!-- Konten Kiri -->
            <div class="md:w-1/2">
                <h2 class="text-2xl font-bold mb-4">
                    Visi dan
                    <span class="bg-[#18B17C] text-black px-2 py-1 rounded-md">Misi</span>
                </h2>
                <p class="text-lg leading-relaxed">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                    pariatur.
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id
                    est laborum.
                </p>
            </div>

            <!-- Gambar Kanan -->
            <div class="md:w-1/2">
                <img src="/images/visi_misi.png" alt="Checklist Ilustrasi" class="w-full rounded-xl object-cover" />
            </div>
        </div>

    </section>



    <!-- Service Categories -->
    <section id="layanan" class="py-8 container mx-auto px-4">
        <h2 class="text-2xl font-bold text-center mb-12">Layanan Kami</h2>
        <div class="grid grid-cols-3 gap-8 max-w-3xl mx-auto">
            <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow cursor-pointer"
                onclick="showContent('strategi')">
                <i class="fas fa-handshake text-4xl mb-4"></i>
                <p class="text-base font-medium">STRATEGI BISNIS</p>
            </div>
            <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow cursor-pointer"
                onclick="showContent('manajemen')">
                <i class="fas fa-cogs text-4xl mb-4"></i>
                <p class="text-base font-medium">MANAJEMEN LIMBAH</p>
            </div>
            <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow cursor-pointer"
                onclick="showContent('pengelolaan')">
                <i class="fas fa-recycle text-4xl mb-4"></i>
                <p class="text-base font-medium">PENGELOLAAN LIMBAH</p>
            </div>
        </div>

        <!-- Hidden content sections -->
        <div id="strategi" class="hidden mt-8 p-6 bg-white rounded-lg shadow-lg">
            <h3 class="text-xl font-bold mb-4">Strategi Bisnis</h3>
            <p>Kami menyediakan layanan konsultasi strategi bisnis yang komprehensif untuk membantu perusahaan Anda
                mengoptimalkan pengelolaan limbah dan mencapai tujuan keberlanjutan.</p>
        </div>

        <div id="manajemen" class="hidden mt-8 p-6 bg-white rounded-lg shadow-lg">
            <h3 class="text-xl font-bold mb-4">Manajemen Limbah</h3>
            <p>Layanan manajemen limbah kami mencakup perencanaan, implementasi, dan monitoring sistem pengelolaan
                limbah yang efektif dan sesuai dengan regulasi.</p>
        </div>

        <div id="pengelolaan" class="hidden mt-8 p-6 bg-white rounded-lg shadow-lg">
            <h3 class="text-xl font-bold mb-4">Pengelolaan Limbah</h3>
            <p>Kami menawarkan solusi pengelolaan limbah end-to-end, termasuk pengumpulan, pemilahan, pengolahan, dan
                daur ulang limbah dengan cara yang ramah lingkungan.</p>
        </div>

        <script>
            function showContent(id) {
                // Hide all content sections first
                document.querySelectorAll('#strategi, #manajemen, #pengelolaan').forEach(el => {
                    el.classList.add('hidden');
                });
                // Show the selected content
                document.getElementById(id).classList.remove('hidden');
            }
        </script>
    </section>

    {{-- Kenapa pilih EcoCycle --}}
    <section class="py-8 container mx-auto px-4">
        <!-- Persegi panjang hijau full-width -->
        <div class="w-full bg-[#34C78F] py-10 px-6">
            <!-- Kontainer isi dengan lebar terbatas -->
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-10">

                <!-- Gambar orang -->
                <div class="flex-shrink-0">
                    <div
                        class="border-4 border-dashed border-white rounded-full p-2 w-64 h-64 flex items-center justify-center overflow-hidden">
                        <img src="/images/people2.jpg" alt="Orang" class="object-cover w-full h-full">
                    </div>
                </div>

                <!-- Teks konten -->
                <div class="text-white space-y-4">
                    <h2 class="text-2xl md:text-3xl font-bold">
                        Mengapa Anda Disarankan Memilih EcoCycle?
                    </h2>
                    <p class="text-lg">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <ul class="list-disc list-inside text-lg space-y-1">
                        <li>Peningkatan Efisiensi</li>
                        <li>Penghematan Biaya</li>
                        <li>Pengembangan Kemampuan Tim Internal</li>
                    </ul>
                </div>

            </div>
        </div>

    </section>
    <!-- Main Services -->
    <section class="py-16 text-white" style="background-color: #042A20;">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-2xl font-bold mb-4 max-w-3xl mx-auto">Kami hadir untuk memberikan Solusi untuk
                berbagai masalah yang dihadapi organisasi dalam menerapkan aspek keberlanjutan</h2>

            <div class="grid grid-cols-2 gap-6 max-w-4xl mx-auto">
                <div class="service-card bg-[#0B4D3C] p-6 rounded-lg">
                    <div class="flex items-start gap-4">
                        <img src="/images/unggulan/transformasi.png" alt="" class="w-15 h-15 mt-2">
                        <div>
                            <h3 class="font-bold mb-2">TRANSFORMASI KEBERLANJUTAN</h3>
                            <p class="text-sm">Memberikan solusi untuk organisasi dalam menerapkan strategy dan model
                                operasional organisasi</p>
                        </div>
                    </div>
                </div>
                <div class="service-card bg-[#0B4D3C] p-6 rounded-lg">
                    <div class="flex items-start gap-4">
                        <img src="/images/unggulan/strategi.png" alt="" class="w-15 h-15">
                        <div>
                            <h3 class="font-bold mb-2">MEREALISASIKAN STRATEGI FUNGSIONAL</h3>
                            <p class="text-sm">Membantu strategi dan proses yang tepat untuk mencapai tujuan dan target
                                keberlanjutan</p>
                        </div>
                    </div>
                </div>
                <div class="service-card bg-[#0B4D3C] p-6 rounded-lg">
                    <div class="flex items-start gap-4">
                        <img src="/images/unggulan/distrupsi.png" alt="" class="w-15 h-15 mt-2">
                        <div>
                            <h3 class="font-bold mb-2">MENGHADAPI DISRUPSI</h3>
                            <p class="text-sm">Memberikan solusi dan proses untuk organisasi dalam menghadapi perubahan
                                secara efektif</p>
                        </div>
                    </div>
                </div>
                <div class="service-card bg-[#0B4D3C] p-6 rounded-lg">
                    <div class="flex items-start gap-4">
                        <img src="/images/unggulan/citra.png" alt="" class="w-15 h-15 mt-2">
                        <div>
                            <h3 class="font-bold mb-2">MEMBANGUN CITRA KEBERLANJUTAN</h3>
                            <p class="text-sm">Membantu peningkatan dan sistem keberlanjutan organisasi untuk mencapai
                                citra positif</p>
                        </div>
                    </div>
                </div>
                <div class="service-card bg-[#0B4D3C] p-6 rounded-lg col-span-2">
                    <div class="flex items-start gap-4">
                        <img src="/images/unggulan/efisiensi.png" alt="" class="w-15 h-15 mt-2">
                        <div>
                            <h3 class="font-bold mb-2">EFISIENSI ORGANISASI</h3>
                            <p class="text-sm">Memberikan praktik baik yang menunjang organisasi untuk lebih efektif
                                dalam mencapai efisiensi</p>
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


</x-layout>
