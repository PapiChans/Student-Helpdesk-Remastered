<?php

use Illuminate\Support\Facades\Route;

Route::get('/user/home', function () {
    return view('user/home');
});