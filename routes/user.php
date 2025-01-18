<?php

use Illuminate\Support\Facades\Route;
use App\Models\CustomUserTable;
use Illuminate\Support\Facades\Auth;

Route::get('user/home', function () {
    if (Auth::check()) {
        // Check if the user is logged in
        if (Auth::user()->is_admin) {
            // If the user is an admin, redirect to admin home page
            return redirect()->route('admin/home');
        } else {
            // If the user is authenticated but not an admin, redirect to user home page
            return view('user/home');
        }
    } else {
        // If the user is not authenticated, redirect to login page
        return redirect()->route('login');
    }
})->name('user/home');