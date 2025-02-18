<?php

use Illuminate\Support\Facades\Route;
// Connect the Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TicketController;

// Get Profile
Route::get('/backend/admin/getProfile', [ProfileController::class, 'backend_getAdminProfile']);

// Home
Route::post('backend/admin/getTicketCountByDate', [HomeController::class, 'backend_getTicketCountByDate']);
Route::get('backend/admin/getTicketCount', [HomeController::class, 'backend_getTicketCount']);

// Tickets
Route::get('/backend/admin/getTickets', [TicketController::class, 'backend_getTickets']);

// View Ticket
Route::get('/backend/admin/getTicketInfo/{ticket_number}', [TicketController::class, 'backend_getTicketInfo']);
Route::get('/backend/admin/getTicketComment/{ticket_number}', [TicketController::class, 'backend_getTicketComment']);
Route::get('/backend/admin/getAuditTrails/{ticket_number}', [TicketController::class, 'backend_getAuditTrail']);
Route::post('/backend/admin/addTicketComment', [TicketController::class, 'backend_addTicketComment']);
Route::post('/backend/admin/changeTicketOffice', [TicketController::class, 'backend_changeTicketOffice']);
Route::put('/backend/admin/resolveTicket/{ticket_number}', [TicketController::class, 'backend_resolveTicket']);
Route::put('/backend/admin/closeTicket/{ticket_number}', [TicketController::class, 'backend_closeTicket']);

// Admin Management
Route::post('/backend/admin/addAdmin', [AdminManagementController::class, 'backend_addAdmin']);
Route::get('/backend/admin/getAdmin', [AdminManagementController::class, 'backend_getAdmin']);
Route::get('/backend/admin/getOneAdmin/{admin_id}', [AdminManagementController::class, 'backend_getOneAdmin']);
Route::put('/backend/admin/editAdmin/{profile_id}', [AdminManagementController::class, 'backend_editAdmin']);
Route::delete('/backend/admin/removeAdmin/{admin_id}', [AdminManagementController::class, 'backend_removeAdmin']);

Route::post('/backend/admin/addOffice', [AdminManagementController::class, 'backend_addOffice']);
Route::get('/backend/admin/getOffice', [AdminManagementController::class, 'backend_getOffice']);
Route::get('/backend/admin/getOneOffice/{office_id}', [AdminManagementController::class, 'backend_getOneOffice']);
Route::put('/backend/admin/editOffice/{office_id}', [AdminManagementController::class, 'backend_editOffice']);
Route::delete('/backend/admin/removeOffice/{office_id}', [AdminManagementController::class, 'backend_removeOffice']);