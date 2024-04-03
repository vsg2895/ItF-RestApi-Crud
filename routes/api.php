<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PhoneBookController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/register','register')->name('register');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth:api');
});


Route::apiResource('phone-books', PhoneBookController::class);
