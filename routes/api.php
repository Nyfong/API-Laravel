<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Routes for displaying the register and login forms
Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});

// Routes for handling the registration and login actions
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);