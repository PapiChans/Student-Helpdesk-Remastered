<?php

use Illuminate\Support\Facades\Route;
// Connect the Controllers
use App\Http\Controllers\ProfileController;

Route::get('/backend/user/getProfile', [ProfileController::class, 'backend_getUserProfile']);