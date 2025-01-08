<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreLoadData;

Route::get('/test/backend/createMasterAdmin', [PreLoadData::class, 'createMasterAdmin']);