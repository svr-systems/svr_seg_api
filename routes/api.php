<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//LOG
Route::group([
  'prefix' => 'auth'
], function () {
  Route::post('log_in', [AuthController::class, 'logIn']);

  Route::group(
    [
      'middleware' => 'auth:api'
    ],
    function () {
      Route::get('log_out', [AuthController::class, 'logOut']);
    }
  );
});

//AUTH
Route::group(["middleware" => "auth:api"], function () {
  //TAGS
  Route::apiResource("tags", TagController::class);

  //USERS
  Route::apiResource("users", UserController::class);
  Route::post("users/pwd_update", [UserController::class, 'pwdUpdate']);

  //ROLES
  Route::get("roles", [RoleController::class, 'index']);
});