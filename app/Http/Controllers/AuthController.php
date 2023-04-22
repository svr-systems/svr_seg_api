<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $req)
    {
        try {
            if (
                !Auth::attempt([
                    "email" => $req->email,
                    "password" => $req->password
                ])
            ) {
                return response()->json([
                    "auth" => false,
                    "message" => "Datos de acceso inválidos"
                ], 200);
            }

            $token = Auth::user()->createToken("authToken")->accessToken;
            $user = User::find(Auth::id(), [
                "id",
                "name",
                "email",
            ]);

            return response()->json([
                "auth" => true,
                "message" => "Datos de acceso validos",
                "token" => $token,
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "auth" => false,
                "message" => "ERR. " . $th
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });

            return response()->json([
                "success" => true,
                "message" => "Sesión finalizada correctamente"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "ERR. " . $th
            ], 200);
        }
    }
}