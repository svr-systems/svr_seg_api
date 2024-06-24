<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//LOG
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::group(
        [
            'middleware' => 'auth:api'
        ],
        function () {
            Route::get('logout', [AuthController::class, 'logout']);
        }
    );
});

//AUTH
Route::group(["middleware" => "auth:api"], function () {
    //USERS
    Route::apiResource("users", UserController::class);
    Route::post("users/password_update", [UserController::class, 'passwordUpdate']);

    //ROLES
    Route::get("roles", [RoleController::class, 'index']);
});