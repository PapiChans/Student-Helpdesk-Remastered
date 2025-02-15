<?php

use Illuminate\Support\Facades\Route;
// Connect the Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\TicketController;

Route::get('/backend/user/getProfile', [ProfileController::class, 'backend_getUserProfile']);

// Home
Route::get('/backend/user/getTickets', [HomeController::class, 'backend_getTickets']);

// Ticket
Route::post('/backend/user/addTicket', [TicketController::class, 'backend_addTicket']);
Route::get('/backend/user/getOffice', [TicketController::class, 'backend_getOffice']);

// View Ticket
Route::get('/backend/user/getTicketInfo/{ticket_number}', [TicketController::class, 'backend_getTicketInfo']);
Route::get('/backend/user/getTicketComment/{ticket_number}', [TicketController::class, 'backend_getTicketComment']);
Route::get('/backend/user/getAuditTrails/{ticket_number}', [TicketController::class, 'backend_getAuditTrail']);
Route::post('/backend/user/addTicketComment', [TicketController::class, 'backend_addTicketComment']);
