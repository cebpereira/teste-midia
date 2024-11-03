<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DocumentController;

Route::controller(DocumentController::class)->group(function () {
    Route::post('/store', 'store');
    Route::get('/show/{id}', 'show');
    Route::get('/find', 'find');
    Route::put('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'delete');
});
