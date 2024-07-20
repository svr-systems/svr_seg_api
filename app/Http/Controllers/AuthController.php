<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
  public function logIn(Request $req) {
    try {
      if (
        !Auth::attempt([
          "email" => $req->email,
          "password" => $req->password
        ])
      ) {
        return response()->json([
          "ok" => false,
          "msg" => "Datos de acceso inválidos",
          "err" => null
        ], 200);
      }

      $token = Auth::user()->createToken("authToken")->accessToken;
      $user = User::
        join("roles", "roles.id", "users.role_id")->
        find(Auth::id(), [
          "users.id",
          "users.name",
          "users.first_surname",
          "users.second_surname",
          "users.nickname",
          "users.email",
          "users.role_id",
          "roles.name AS role_name",
        ]);

      $user->full_name = GenController::filter($user->name . " " . $user->first_surname . " " . $user->second_surname, "U");

      return response()->json([
        "ok" => true,
        "msg" => "Datos de acceso validos",
        "data" => [
          "auth" => true,
          "token" => $token,
          "user" => $user
        ]
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        "ok" => false,
        "msg" => "Error. Contacte al equipo de desarrollo",
        "err" => "ERROR => " . $th
      ], 200);
    }
  }

  public function logOut(Request $request) {
    try {
      $request->user()->tokens->each(function ($token, $key) {
        $token->delete();
      });

      return response()->json([
        "ok" => true,
        "msg" => "Sesión finalizada correctamente"
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        "ok" => false,
        "msg" => "Error. Contacte al equipo de desarrollo",
        "err" => "ERROR => " . $th
      ], 200);
    }
  }
}
