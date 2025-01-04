<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/forgot-password', function () {
    return view('forgot-password');
});

// This will Includes all the other route files.
require base_path('routes/admin.php');
require base_path('routes/adminbackend.php');
require base_path('routes/user.php');
require base_path('routes/userbackend.php');