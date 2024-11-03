<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name("api.login");
    Route::get('token', [AuthController::class, 'token'])->name("api.token");

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/user', [AuthController::class, 'user'])->name("api.user");
        Route::post('/logout', [AuthController::class, 'logout'])->name("api.logout");
    });
});

Route::prefix("user")->group(base_path("routes/api/register.php"));

Route::middleware(["auth:sanctum"])->group(function () {
    Route::prefix("documents")->group(base_path("routes/api/document.php"));
});
