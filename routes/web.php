<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
// Import LaporanController, KategoriController, VendorController if they exist or create them.
// For now, we'll use a generic controller or closure for placeholders.
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\JenisLimbahController;
use App\Http\Controllers\PenyimpananController;
use App\Http\Controllers\LaporanHarianController;
use App\Models\Penyimpanan;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

// User profile routes (untuk semua user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Perusahaan Routes
Route::middleware(['auth'])->group(function () {
    // Route untuk membuat profil perusahaan (tanpa middleware perusahaan)
    Route::get('/perusahaan/create', [PerusahaanController::class, 'create'])
        ->name('perusahaan.create');
    Route::post('/perusahaan', [PerusahaanController::class, 'store'])
        ->name('perusahaan.store');

    // Route untuk melihat daftar perusahaan (semua user bisa akses)
    Route::get('/perusahaan', [PerusahaanController::class, 'index'])
        ->name('perusahaan.index');
    
    // PENTING: Dashboard harus di atas route {perusahaan} agar tidak bentrok
    Route::get('/perusahaan/dashboard', [PerusahaanController::class, 'dashboard'])
        ->middleware('perusahaan')
        ->name('perusahaan.dashboard');
    
    // Route untuk melihat detail perusahaan (semua user bisa akses)
    Route::get('/perusahaan/{perusahaan}', [PerusahaanController::class, 'show'])
        ->name('perusahaan.show');

    // Route edit hanya untuk pemilik perusahaan atau admin
    Route::get('/perusahaan/{perusahaan}/edit', [PerusahaanController::class, 'edit'])
        ->middleware('perusahaan')
        ->name('perusahaan.edit');
    Route::put('/perusahaan/{perusahaan}', [PerusahaanController::class, 'update'])
        ->middleware('perusahaan')
        ->name('perusahaan.update');
    Route::resource('/laporan-harian', LaporanHarianController::class);
    Route::resource('/penyimpanan', PenyimpananController::class);
});



// Admin Routes
// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::put('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Perusahaan Management - menggunakan view yang sudah ada
    Route::get('/perusahaan', [AdminController::class, 'perusahaan'])->name('perusahaan.index');
    
    // Jenis Limbah Management - menggunakan view yang sudah ada
    Route::get('/jenis-limbah', [AdminController::class, 'jenisLimbah'])->name('jenis-limbah.index');
    
    // Vendor Management - menggunakan view yang sudah ada
    Route::get('/vendor', [AdminController::class, 'vendor'])->name('vendor.index');
});


require __DIR__ . '/auth.php';
