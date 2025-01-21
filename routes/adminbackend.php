<?php

use Illuminate\Support\Facades\Route;
// Connect the Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminManagementController;

// Get Profile
Route::get('/backend/admin/getProfile', [ProfileController::class, 'backend_getAdminProfile']);

// Admin Management
Route::get('/backend/admin/getAdmin', [AdminManagementController::class, 'backend_getAdmin']);