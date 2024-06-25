<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $req)
    {
        try {
            return response()->json([
                "success" => true,
                "message" => "Registros retornados correctamente",
                "data" => User::getAll($req)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "ERR. " . $th
            ], 500);
        }
    }

    public function store(Request $req)
    {
        return $this->storeUpdate($req, null);
    }

    public function show($id)
    {
        try {
            return response()->json([
                "success" => true,
                "message" => "Registro retornado correctamente",
                "data" => User::getItem($id)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "ERR. " . $th
            ], 500);
        }
    }

    public function update(Request $req, $id)
    {
        return $this->storeUpdate($req, $id);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = User::find($id);
            $data->active = false;
            $data->save();

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Registro eliminado correctamente",
                "data" => $this->returnData($data)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                "success" => false,
                "message" => "ERR. " . $th
            ], 200);
        }
    }

    public function storeUpdate($req, $id)
    {
        DB::beginTransaction();
        try {
            $req->merge(
                [
                    "email" => GenController::filter($req->email, "l"),
                    "username" => GenController::filter($req->username, "U")
                ],
            );

            $validator = $this->validateData($req, $id);

            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()->first()
                ], 200);
            }

            if (is_null($id)) {
                $data = new User();
                $data->password = bcrypt(trim($req->password));
                $data->created_by_id = $req->user()->id;
            } else {
                $data = User::find($id);
            }

            $data = $this->saveData($data, $req);

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Registro " . (is_null($id) ? "agregado" : "editado") . " correctamente",
                "data" => $this->returnData($data)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                "success" => false,
                "message" => "ERR. " . $th
            ], 200);
        }
    }

    public function validateData($req, $id)
    {
        $rules = [
            "name" => "string|required|min:2|max:50",
            "username" => "string|required|min:2|max:20|unique:users" . ($id ? ",username," . $id : ""),
            "email" => "string|required|min:2|max:50|unique:users" . ($id ? ",email," . $id : ""),
            "role_id" => "numeric|required",
        ];

        if (is_null($id)) {
            array_push($rules, ["password" => "string" . ($id ? "|required" : "")]);
        }

        return Validator::make(
            $req->all(),
            $rules,
            [
                "username.unique" => "El Usuario ya ha sido registrado",
                "email.unique" => "El Correo elec. ya ha sido registrado",
            ]
        );
    }

    public function saveData($data, $req)
    {
        $data->name = GenController::filter($req->name, "U");
        $data->email = $req->email;
        $data->username = $req->username;
        $data->updated_by_id = $req->user()->id;
        $data->role_id = GenController::filter($req->role_id, "id");
        $data->save();

        return $data;
    }
    public function returnData($data)
    {
        $data->role_name = Role::find($data->role_id)->name;

        $data = [
            "id" => $data->id,
            "name" => $data->name,
            "username" => $data->username,
            "email" => $data->email,
            "role_name" => $data->role_name,
        ];

        return $data;
    }

    public function pwdUpdate(Request $req)
    {
        DB::beginTransaction();
        try {
            $user = User::find($req->id);
            $user->password = bcrypt(trim($req->password));
            $user->updated_by_id = $req->user()->id;
            $user->save();

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Contraseña actualizada correctamente"
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                "success" => false,
                "message" => "ERR. " . $th
            ], 200);
        }
    }
}
