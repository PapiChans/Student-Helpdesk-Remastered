<?php

use Illuminate\Support\Facades\Route;
// Connect the Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\TicketController;

Route::get('/backend/user/getProfile', [ProfileController::class, 'backend_getUserProfile']);

// Home
Route::get('/backend/user/getTickets', [HomeController::class, 'backend_getTickets']);