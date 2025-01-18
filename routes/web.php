<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        // Check if the user is logged in
        if (Auth::user()->is_admin) {
            // If the user is an admin, redirect to admin home page
            return redirect()->route('admin/home');
        } else {
            // If the user is authenticated but not an admin, redirect to user home page
            return redirect()->route('user/home');
        }
    } else {
        // If the user is not authenticated.
        return view('homepage');
    }
})->name('homepage');

Route::get('/login', function () {
    if (Auth::check()) {
        // Check if the user is logged in
        if (Auth::user()->is_admin) {
            // If the user is an admin, redirect to admin home page
            return redirect()->route('admin/home');
        } else {
            // If the user is authenticated but not an admin, redirect to user home page
            return redirect()->route('user/home');
        }
    } else {
        // If the user is not authenticated.
        return view('login');
    }
})->name('login'); // Route Naminng for Finding Routes

Route::get('/signup', function () {
    if (Auth::check()) {
        // Check if the user is logged in
        if (Auth::user()->is_admin) {
            // If the user is an admin, redirect to admin home page
            return redirect()->route('admin/home');
        } else {
            // If the user is authenticated but not an admin, redirect to user home page
            return redirect()->route('user/home');
        }
    } else {
        // If the user is not authenticated.
        return view('signup');
    }
})->name('signup');

Route::get('/forgot-password', function () {
    if (Auth::check()) {
        // Check if the user is logged in
        if (Auth::user()->is_admin) {
            // If the user is an admin, redirect to admin home page
            return redirect()->route('admin/home');
        } else {
            // If the user is authenticated but not an admin, redirect to user home page
            return redirect()->route('user/home');
        }
    } else {
        // If the user is not authenticated.
        return view('forgot-passwoord');
    }
})->name('forgot-password');

// This will Includes all the other route files.
require base_path('routes/admin.php');
require base_path('routes/adminbackend.php');
require base_path('routes/user.php');
require base_path('routes/userbackend.php');
require base_path('routes/auth.php');
// require base_path('routes/preloaddata.php'); // Used for Preloading data, make it disabled after the data loads