<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanHarianController;
use App\Http\Controllers\PerusahaanDashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\AdminAppDashboardController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PerusahaanRegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/register-perusahaan', [PerusahaanRegisterController::class, 'showForm'])->name('perusahaan.register');
// Route::post('/register-perusahaan', [PerusahaanRegisterController::class, 'register'])->name('perusahaan.register.submit');


// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });

// Route::middleware(['auth', 'admin.app'])->group(function () {
//     Route::get('/admin/dashboard', [AdminAppDashboardController::class, 'index'])->name('admin.dashboard');
// });

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminAppDashboardController::class, 'index'])->name('admin.dashboard');
// });

// Route::middleware(['auth', 'perusahaan'])->group(function () {
//     Route::get('/perusahaan/dashboard', [PerusahaanDashboardController::class, 'index'])->name('perusahaan.dashboard');
// });

// // Login Routes
// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [LoginController::class, 'login']);
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// // Registration Routes
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);

// // Password Reset Routes
// Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::resource('laporan-harian', LaporanHarianController::class);

