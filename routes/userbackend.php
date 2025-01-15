<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignUpController; // This Connect the Controllers

Route::post('/backend/signup', [SignUpController::class, 'backend_SignUp']);