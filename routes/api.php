<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//LOG
Route::group([
  "prefix" => "auth"
], function () {
  Route::post("log_in", [AuthController::class, "logIn"]);

  Route::group(
    [
      "middleware" => "auth:api"
    ],
    function () {
      Route::get("log_out", [AuthController::class, "logOut"]);
    }
  );
});

//AUTH
Route::group(["middleware" => "auth:api"], function () {
  //PROJECTS
  Route::apiResource("projects", ProjectController::class);

  //TAGS
  Route::apiResource("tags", TagController::class);

  //USERS
  Route::apiResource("users", UserController::class);
  Route::post("users/pwd_update", [UserController::class, "pwdUpdate"]);

  //CATALOGS
  Route::get("priorities", [PriorityController::class, "index"]);
  Route::get("states", [StateController::class, "index"]);
  Route::get("roles", [RoleController::class, "index"]);
});