<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/artikel', function () {
    return view('artikel');
});

Route::get('/tentang-kami', function () {
    return view('tentang-kami');
});

Route::get('/layanan', function () {
    return view('layanan');
});

