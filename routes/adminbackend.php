<?php

use Illuminate\Support\Facades\Route;
// Connect the Controllers
use App\Http\Controllers\ProfileController;

Route::get('/backend/admin/getProfile', [ProfileController::class, 'backend_getAdminProfile']);