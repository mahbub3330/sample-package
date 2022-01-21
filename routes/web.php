<?php

use Gglink\Sample\Http\Controllers\AuthenticateController;
use Gglink\Sample\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user'], function () {
    Route::get('login', [AuthenticateController::class, 'loginForm']);
    Route::post('login', [AuthenticateController::class, 'login']);
    Route::post('logout', [AuthenticateController::class, 'logout']);
    Route::post('request_token', [AuthenticateController::class, 'requestToken']);

    Route::get('all', [UserController::class, 'index'])->name('index');
    Route::post('add', [UserController::class, 'create']);
    Route::post('delete', [UserController::class, 'destroy']);
    Route::get('detail/{user}', [UserController::class, 'show']);
    Route::get('profile/{user}', [UserController::class, 'profileUser']);
    Route::post('update_profile', [UserController::class, 'profileUser']);
    Route::post('update', [UserController::class, 'profileUser']);

});






