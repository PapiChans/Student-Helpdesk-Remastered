<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin/home', function () {
    if (Auth::check()) {
        // Check if the user is logged in
        if (Auth::user()->is_admin) {
            // If the user is an admin, redirect to admin home page
            return view('admin/home');
        } else {
            // If the user is authenticated but not an admin, redirect to user home page
            return redirect()->route('user/home');
        }
    }
    else {
        // If the user is not authenticated, redirect to login page
        return redirect()->route('login');
    }
})->name('admin/home');