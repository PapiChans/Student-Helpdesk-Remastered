<?php

use Illuminate\Support\Facades\Route;
// Connect the Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminManagementController;

// Get Profile
Route::get('/backend/admin/getProfile', [ProfileController::class, 'backend_getAdminProfile']);

// Admin Management
Route::get('/backend/admin/getAdmin', [AdminManagementController::class, 'backend_getAdmin']);

Route::post('/backend/admin/addOffice', [AdminManagementController::class, 'backend_addOffice']);
Route::get('/backend/admin/getOffice', [AdminManagementController::class, 'backend_getOffice']);
Route::get('/backend/admin/getOneOffice/{office_id}', [AdminManagementController::class, 'backend_getOneOffice']);
Route::put('/backend/admin/editOffice/{office_id}', [AdminManagementController::class, 'backend_editOffice']);
Route::delete('/backend/admin/removeOffice/{office_id}', [AdminManagementController::class, 'backend_removeOffice']);