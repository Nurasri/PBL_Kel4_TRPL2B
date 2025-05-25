<x-guest>
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
                            Verifikasi Email
                        </h1>

                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang baru.') }}
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
                            </div>
                        @endif

                        <div class="mt-4 flex flex-col space-y-4">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                    {{ __('Kirim Ulang Email Verifikasi') }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-sm font-medium leading-5 text-center text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 active:bg-gray-50 hover:bg-gray-50 focus:outline-none focus:shadow-outline-gray dark:border-gray-600 dark:hover:bg-gray-500 dark:hover:text-gray-300 dark:hover:bg-gray-700 dark:active:bg-gray-600">
                                    {{ __('Keluar') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest>



Saya akan membantu menganalisis dan menyesuaikan fitur-fitur tersebut. Mari kita breakdown dan lihat apa yang sudah ada dan apa yang perlu ditambahkan/diubah:

### 1. Manajemen User
**Status**: Perlu ditambahkan
- CRUD untuk user (admin, perusahaan)
- Manajemen role dan permission
- Aktivasi/deaktivasi user
- Reset password

### 2. Manajemen Perusahaan
**Status**: Perlu ditambahkan
- CRUD profil perusahaan
- Verifikasi perusahaan
- Status aktif/nonaktif
- Riwayat aktivitas

### 3. Berlangganan Aplikasi
**Status**: Sudah ada sebagian
- Sudah ada: Paket langganan, proses langganan
- Perlu ditambahkan:
  - Manajemen paket (CRUD)
  - Riwayat pembayaran
  - Notifikasi pembayaran
  - Status langganan

### 4. Laporan Limbah Harian
**Status**: Sudah ada
- Perlu disesuaikan:
  - Tambah validasi input
  - Integrasi dengan penyimpanan
  - Notifikasi ke admin

### 5. Manajemen Penyimpanan Limbah
**Status**: Perlu diubah
- Tambah field:
  - Kapasitas terpakai
  - Kapasitas tersedia
  - Status (penuh/sebagian/kosong)
- Auto-update kapasitas saat:
  - Laporan harian masuk
  - Limbah dikelola
  - Limbah dipindah

### 6. Pengelolaan Limbah
**Status**: Perlu ditambahkan
- Model baru: `PengelolaanLimbah`
- Fitur:
  - Update status limbah
  - Riwayat pengelolaan
  - Tracking progress
  - Notifikasi status

### 7. Jenis Limbah
**Status**: Perlu digabung
- Gabungkan `KategoriLimbah` dan `JenisLimbah`
- Tambah field:
  - Kode limbah
  - Deskripsi
  - Level bahaya
  - Metode pengelolaan

### 8. Daftar Vendor
**Status**: Sudah ada
- Perlu ditambahkan:
  - Rating vendor
  - Riwayat kerjasama
  - Status aktif/nonaktif
  - Verifikasi vendor

### 9. Laporan Hasil Pengelolaan
**Status**: Perlu ditambahkan
- Model baru: `LaporanPengelolaan`
- Fitur:
  - Input hasil pengelolaan
  - Update stok penyimpanan
  - Generate laporan
  - Export PDF/Excel

### 10. Dashboard
**Status**: Perlu diupdate
- Admin:
  - Statistik limbah
  - Status perusahaan
  - Notifikasi
  - Grafik pengelolaan
- User/Perusahaan:
  - Status penyimpanan
  - Progress pengelolaan
  - Notifikasi
  - Riwayat aktivitas

### 11. Notifikasi
**Status**: Perlu ditambahkan
- Sistem notifikasi real-time
- Tipe notifikasi:
  - Status langganan
  - Update limbah
  - Pengelolaan
  - Pembayaran
  - Verifikasi

Mari kita mulai dengan membuat rencana implementasi. Saya sarankan kita mulai dari:

1. Update database schema untuk fitur baru
2. Buat model dan migration baru
3. Update model yang sudah ada
4. Buat controller baru
5. Update view dan routing

Apakah Anda setuju dengan breakdown ini? Kita bisa mulai dari mana dulu sesuai prioritas Anda.

