<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/articles', function () {
    return view('articles');
});

Route::get('/login', function () {
    return view('auth.login');
});

// Route untuk memproses form login
Route::post('/login', function () {
    // TODO: Implement login logic
    return redirect('/');
});
