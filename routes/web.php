<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
// Import LaporanController, KategoriController, VendorController if they exist or create them.
// For now, we'll use a generic controller or closure for placeholders.
use App\Http\Controllers\JenisLimbahController;
use App\Http\Controllers\PenyimpananController;
use App\Http\Controllers\LaporanHarianController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PerusahaanController;

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

    // Route yang membutuhkan middleware perusahaan
    Route::middleware('perusahaan')->group(function () {
        Route::get('/perusahaan/dashboard', [PerusahaanController::class, 'dashboard'])
            ->name('perusahaan.dashboard');
        Route::get('/perusahaan/{perusahaan}', [PerusahaanController::class, 'show'])
            ->name('perusahaan.show');
        Route::get('/perusahaan/{perusahaan}/edit', [PerusahaanController::class, 'edit'])
            ->name('perusahaan.edit');
        Route::put('/perusahaan/{perusahaan}', [PerusahaanController::class, 'update'])
            ->name('perusahaan.update');
        Route::delete('/perusahaan/{perusahaan}', [PerusahaanController::class, 'destroy'])
            ->name('perusahaan.destroy');

        // Route untuk laporan harian perusahaan
        Route::resource('laporan-harian', LaporanHarianController::class);
        Route::resource('penyimpanan', PenyimpananController::class);
    });
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);
    Route::get('users/{user}/password', [UserController::class, 'editPassword'])->name('users.password.edit');
    Route::put('users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password.update');
    Route::put('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Perusahaan Management
    Route::get('/perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan.index');
    Route::get('/perusahaan/{perusahaan}', [PerusahaanController::class, 'show'])->name('perusahaan.show');

    // Resource Management
    Route::resource('laporan-harian', LaporanHarianController::class);
    Route::resource('jenis-limbah', JenisLimbahController::class);
    Route::resource('penyimpanan', PenyimpananController::class);
    Route::resource('vendor', VendorController::class);
});

require __DIR__ . '/auth.php';
