<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\Frontend\ArtikelController as FrontendArtikelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\JenisLimbahController;
use App\Http\Controllers\PenyimpananController;
use App\Http\Controllers\LaporanHarianController;
use App\Http\Controllers\KategoriArtikelController;
use App\Http\Controllers\PengelolaanLimbahController;
use App\Http\Controllers\LaporanHasilPengelolaanController;

    Route::get('/', function () {
    return view('frontend.welcome');
});
// Frontend routes (public access)
Route::prefix('artikel')->name('frontend.artikel.')->group(function () {
    Route::get('/', [FrontendArtikelController::class, 'index'])->name('index');
    Route::get('/search', [FrontendArtikelController::class, 'search'])->name('search');
    Route::get('/kategori/{slug}', [FrontendArtikelController::class, 'byKategori'])->name('kategori');
    Route::get('/{slug}', [FrontendArtikelController::class, 'show'])->name('show');
});

// Authentication routes
require __DIR__.'/auth.php';

// Routes yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Profile routes (untuk semua user yang sudah login)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard routes berdasarkan role
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isPerusahaan()) {
            return redirect()->route('perusahaan.dashboard');
        }
        return redirect()->route('profile.edit');
    })->name('dashboard');

    // Routes untuk membuat perusahaan (accessible by authenticated users)
    Route::get('/perusahaan/create', [PerusahaanController::class, 'create'])->name('perusahaan.create');
    Route::post('/perusahaan', [PerusahaanController::class, 'store'])->name('perusahaan.store');

    // Perusahaan index route (accessible by all authenticated users)
    Route::get('/perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan.index');

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // User management
        Route::resource('users', UserController::class);
        Route::put('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/users/{user}/password/edit', [UserController::class, 'editPassword'])->name('users.password.edit');
        Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password.update');

        // Perusahaan management
        Route::get('/perusahaan', [PerusahaanController::class, 'adminIndex'])->name('perusahaan.index');
        Route::get('/perusahaan/{perusahaan}', [PerusahaanController::class, 'adminShow'])->name('perusahaan.show');

        // Vendor management
        Route::resource('vendor', VendorController::class);
        Route::get('/vendor/create', [VendorController::class, 'create'])->name('vendor.create');
        Route::post('/vendor', [VendorController::class, 'store'])->name('vendor.store');
        Route::get('/vendor/{vendor}/edit', [VendorController::class, 'edit'])->name('vendor.edit');
        Route::put('/vendor/{vendor}', [VendorController::class, 'update'])->name('vendor.update');
        Route::delete('/vendor/{vendor}', [VendorController::class, 'destroy'])->name('vendor.destroy');
        Route::put('/vendor/{vendor}/toggle-status', [VendorController::class, 'toggleStatus'])->name('vendor.toggle-status');

        // Kategori artikel
        Route::resource('kategori-artikel', KategoriArtikelController::class);
        Route::post('/kategori-artikel/update-urutan', [KategoriArtikelController::class, 'updateUrutan'])->name('kategori-artikel.update-urutan');

        // Backend Artikel (Admin)
        Route::resource('artikel', ArtikelController::class);
        Route::post('/artikel/bulk-action', [ArtikelController::class, 'bulkAction'])->name('artikel.bulk-action');
    });
    // Kategori artikel
    Route::resource('kategori-artikel', KategoriArtikelController::class);

    // Perusahaan routes
    Route::middleware('perusahaan')->group(function () {
        Route::get('/perusahaan/dashboard', [PerusahaanController::class, 'dashboard'])->name('perusahaan.dashboard');

        // profil perusahaan
        Route::get('/perusahaan/{perusahaan}', [PerusahaanController::class, 'show'])->name('perusahaan.show');
        Route::get('/perusahaan/{perusahaan}/edit', [PerusahaanController::class, 'edit'])->name('perusahaan.edit');
        Route::put('/perusahaan/{perusahaan}', [PerusahaanController::class, 'update'])->name('perusahaan.update');

        // Laporan Harian
        Route::get('/laporan-harian/create', [LaporanHarianController::class, 'create'])->name('laporan-harian.create');
        Route::post('/laporan-harian', [LaporanHarianController::class, 'store'])->name('laporan-harian.store');
        Route::get('/laporan-harian/{laporanHarian}/edit', [LaporanHarianController::class, 'edit'])->name('laporan-harian.edit');
        Route::put('/laporan-harian/{laporanHarian}', [LaporanHarianController::class, 'update'])->name('laporan-harian.update');
        Route::delete('/laporan-harian/{laporanHarian}', [LaporanHarianController::class, 'destroy'])->name('laporan-harian.destroy');
        Route::post('/laporan-harian/{laporanHarian}/submit', [LaporanHarianController::class, 'submit'])->name('laporan-harian.submit');
        Route::post('/laporan-harian/bulk-action', [LaporanHarianController::class, 'bulkAction'])->name('laporan-harian.bulk-action');

        // pengelolaan limbah
        Route::resource('pengelolaan-limbah', PengelolaanLimbahController::class);

        // Update status pengelolaan
        Route::put('/pengelolaan-limbah/{pengelolaanLimbah}/update-status', [PengelolaanLimbahController::class, 'updateStatus'])
            ->name('pengelolaan-limbah.update-status');

        // Export pengelolaan limbah
        Route::get('/pengelolaan-limbah/export/csv', [PengelolaanLimbahController::class, 'export'])
            ->name('pengelolaan-limbah.export');

        // API routes untuk pengelolaan limbah
        Route::prefix('api')->name('api.')->group(function () {
            Route::get('/pengelolaan-limbah/{pengelolaanLimbah}/stok-info', [PengelolaanLimbahController::class, 'getStokInfo'])
                ->name('pengelolaan-limbah.stok-info');

            Route::get('/pengelolaan-limbah/penyimpanan-by-jenis', [PengelolaanLimbahController::class, 'getPenyimpananByJenisLimbah'])
                ->name('pengelolaan-limbah.penyimpanan-by-jenis');

            Route::get('/pengelolaan-limbah/jenis-limbah-details', [PengelolaanLimbahController::class, 'getJenisLimbahDetails'])
                ->name('pengelolaan-limbah.jenis-limbah-details');

            Route::get('/pengelolaan-limbah/statistics', [PengelolaanLimbahController::class, 'getStatistics'])
                ->name('pengelolaan-limbah.statistics');
        });

        // API penyimpanan
        Route::get('/api/jenis-limbah-info', [LaporanHarianController::class, 'getJenisLimbahInfo'])
            ->name('api.jenis-limbah-info');
        Route::get('/api/laporan-statistics', [LaporanHarianController::class, 'getStatistics'])
            ->name('api.laporan-statistics');

        // Penyimpanan
        Route::resource('penyimpanan', PenyimpananController::class);
        Route::put('/penyimpanan/{penyimpanan}/update-kapasitas', [PenyimpananController::class, 'updateKapasitas'])
            ->name('penyimpanan.update-kapasitas');

        // API routes untuk AJAX requests
        Route::prefix('api')->name('api.')->group(function () {
            Route::get('/penyimpanan-by-jenis-limbah', [LaporanHarianController::class, 'getPenyimpananByJenisLimbah'])
                ->name('penyimpanan-by-jenis-limbah');
        });
        // Laporan Hasil Pengelolaan
        Route::resource('laporan-hasil-pengelolaan', LaporanHasilPengelolaanController::class);
        Route::get('/laporan-hasil-pengelolaan/export/csv', [LaporanHasilPengelolaanController::class, 'export'])
            ->name('laporan-hasil-pengelolaan.export');
        Route::get('/laporan-hasil-pengelolaan/{laporanHasilPengelolaan}/dokumentasi/{index}', [LaporanHasilPengelolaanController::class, 'downloadDokumentasi'])
            ->name('laporan-hasil-pengelolaan.download-dokumentasi');

        // API endpoints
        Route::get('/api/pengelolaan-selesai', [LaporanHasilPengelolaanController::class, 'getPengelolaanSelesai'])
            ->name('api.pengelolaan-selesai');
    });


    // Perusahaan profile routes (untuk membuat dan mengelola profil perusahaan)
    Route::get('/perusahaan/create', [PerusahaanController::class, 'create'])->name('perusahaan.create');
    Route::post('/perusahaan', [PerusahaanController::class, 'store'])->name('perusahaan.store');

    // Jenis Limbah routes (accessible by both admin and perusahaan with different permissions)
    Route::resource('jenis-limbah', JenisLimbahController::class);

    // Vendor bisa dilihat oleh semua user (untuk memilih saat pengelolaan limbah)
    Route::get('/vendor', [VendorController::class, 'index'])->name('vendor.index');
    Route::get('/vendor/{vendor}', [VendorController::class, 'show'])->name('vendor.show');

    // API endpoint untuk AJAX
    Route::get('api/vendors/by-jenis-layanan', [VendorController::class, 'getByJenisLayanan'])
        ->name('vendor.by-jenis-layanan');

    // API routes untuk AJAX requests
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/jenis-limbah', [JenisLimbahController::class, 'apiIndex'])->name('jenis-limbah.index');
        Route::get('/jenis-limbah/{jenisLimbah}', [JenisLimbahController::class, 'apiShow'])->name('jenis-limbah.show');
    });

    Route::get('/laporan-harian', [LaporanHarianController::class, 'index'])->name('laporan-harian.index');
    Route::get('/laporan-harian/{laporanHarian}', [LaporanHarianController::class, 'show'])->name('laporan-harian.show');
    Route::get('/laporan-harian/export/csv', [LaporanHarianController::class, 'export'])->name('laporan-harian.export');



    // Perusahaan index route (accessible by all authenticated users)
    Route::get('/perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan.index');

    // User management routes (accessible by admin only)
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::put('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/users/{user}/password/edit', [UserController::class, 'editPassword'])->name('users.password.edit');
        Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password.update');
    });
});
