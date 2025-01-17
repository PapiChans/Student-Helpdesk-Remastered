<?php

use Illuminate\Support\Facades\Route;
// Connect the Controollers
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\LogInController;

// Authentication
Route::post('/backend/signup', [SignUpController::class, 'backend_SignUp']);
Route::post('/backend/login', [LoginController::class, 'backend_LogIn']);