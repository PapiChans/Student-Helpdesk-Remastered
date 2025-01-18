<?php

use Illuminate\Support\Facades\Route;
// Connect the Controllers
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\LogInController;
use App\Http\Controllers\Auth\LogOutController;

// Authentication
Route::post('/backend/signup', [SignUpController::class, 'backend_SignUp']);
Route::post('/backend/login', [LoginController::class, 'backend_LogIn']);
Route::get('/backend/logout', [LogOutController::class, 'backend_LogOut']);