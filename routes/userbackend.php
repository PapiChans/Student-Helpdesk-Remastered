<?php

use Illuminate\Support\Facades\Route;
// Connect the Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\TicketController;
use App\Http\Controllers\User\KnowledgebaseController;

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
Route::get('/backend/user/checkTicketRatings/{ticket_number}', [TicketController::class, 'backend_checkTicketRatings']);
Route::post('/backend/user/addTicketComment', [TicketController::class, 'backend_addTicketComment']);
Route::post('/backend/user/addTicketRating/{ticket_number}', [TicketController::class, 'backend_addTicketRating']);

// Knowledgebase
Route::get('/backend/user/getFolders', [KnowledgebaseController::class, 'backend_getFolders']);
Route::get('/backend/user/getTopics/{folder_id}', [KnowledgebaseController::class, 'backend_getTopics']);
Route::get('/backend/user/getTopicInfo/{topic_id}', [KnowledgebaseController::class, 'backend_getTopicInfo']);
