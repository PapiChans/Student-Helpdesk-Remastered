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
            return view('user/home');
        }
    } else {
        // If the user is not authenticated, redirect to login page
        return redirect()->route('login');
    }
})->name('user/home');

Route::get('user/ticket', function () {
    if (Auth::check()) {
        // Check if the user is logged in
        if (Auth::user()->is_admin) {
            // If the user is an admin, redirect to admin home page
            return redirect()->route('admin/home');
        } else {
            return view('user/ticket');
        }
    } else {
        // If the user is not authenticated, redirect to login page
        return redirect()->route('login');
    }
})->name('user/ticket');

Route::get('user/view/ticket', function () {
    if (Auth::check()) {
        // Check if the user is logged in
        if (Auth::user()->is_admin) {
            // If the user is an admin, redirect to admin home page
            return redirect()->route('admin/home');
        } else {
            return view('user/view-ticket');
        }
    } else {
        // If the user is not authenticated, redirect to login page
        return redirect()->route('login');
    }
})->name('user/view/ticket');