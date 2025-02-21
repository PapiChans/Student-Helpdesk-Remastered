<?php

use Illuminate\Support\Facades\Route;
use App\Models\AdminProfile;

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

// Ticket
Route::get('/admin/ticket', function () {
    if (Auth::check()) {
        // Check if the user is logged in
        if (Auth::user()->is_admin) {
            // If the user is an admin, redirect to admin page
            return view('admin/ticket');
        } else {
            // If the user is authenticated but not an admin, redirect to user home page
            return redirect()->route('user/home');
        }
    }
    else {
        // If the user is not authenticated, redirect to login page
        return redirect()->route('login');
    }
})->name('admin/ticket');

Route::get('admin/view/ticket', function () {
    if (Auth::check()) {
        // Check if the user is logged in
        if (!Auth::user()->is_admin) {
            // If the user is an admin, redirect to admin home page
            return redirect()->route('user/home');
        } else {
            return view('admin/view-ticket');
        }
    } else {
        // If the user is not authenticated, redirect to login page
        return redirect()->route('login');
    }
})->name('admin/view/ticket');


// Admin Management Page
Route::get('/admin/admin-management', function () {
    $admincheck = AdminProfile::where('user_id', Auth::user()->user_id)->first();
    if (Auth::check()) {
        // Check if the user is logged in
        if (Auth::user()->is_admin) {
            // If the user is not an admin.
            if ($admincheck->is_master_admin != true && $admincheck->is_technician != true) {
                return redirect()->route('admin/home');
            }
            else {
                return view('admin/admin-management');
            }
        } 
        else {
            // If the user is authenticated but not an admin, redirect to user home page
            return redirect()->route('user/home');
        }
    }
    else {
        // If the user is not authenticated, redirect to login page
        return redirect()->route('login');
    }
})->name('admin/admin-management');

// Reports Page
Route::get('admin/reports', function () {
    if (Auth::check()) {
        // Check if the user is logged in
        if (!Auth::user()->is_admin) {
            // If the user is an admin, redirect to admin home page
            return redirect()->route('user/home');
        } else {
            return view('admin/reports');
        }
    } else {
        // If the user is not authenticated, redirect to login page
        return redirect()->route('login');
    }
})->name('admin/reports');