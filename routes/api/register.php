<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;

Route::controller(RegisterController::class)->group(function () {
    Route::post('/register', 'register');
});
