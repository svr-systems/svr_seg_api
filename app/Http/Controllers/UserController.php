<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller {
  public function index(Request $req) {
    try {
      return response()->json([
        "ok" => true,
        "msg" => "Registros retornados correctamente",
        "data" => User::getAll($req)
      ], 200);
    } catch (\Throwable $err) {
      return response()->json([
        "ok" => false,
        "msg" => "Error. Contacte al equipo de desarrollo",
        "err" => "ERROR => " . $err
      ], 500);
    }
  }

  public function store(Request $req) {
    return $this->storeUpdate($req, null);
  }

  public function show($id) {
    try {
      return response()->json([
        "ok" => true,
        "msg" => "Registro retornado correctamente",
        "data" => User::getItem($id)
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        "ok" => false,
        "msg" => "Error. Contacte al equipo de desarrollo",
        "err" => "ERROR => " . $th
      ], 500);
    }
  }

  public function update(Request $req, $id) {
    return $this->storeUpdate($req, $id);
  }

  public function destroy($id) {
    DB::beginTransaction();
    try {
      $data = User::find($id);
      $data->active = false;
      $data->save();

      DB::commit();
      return response()->json([
        "ok" => true,
        "msg" => "Registro eliminado correctamente",
        "data" => $this->returnData($data)
      ], 200);
    } catch (\Throwable $th) {
      DB::rollback();
      return response()->json([
        "ok" => false,
        "msg" => "Error. Contacte al equipo de desarrollo",
        "err" => "ERROR => " . $th
      ], 200);
    }
  }

  public function storeUpdate($req, $id) {
    DB::beginTransaction();
    try {
      $req->merge(
        [
          "email" => GenController::filter($req->email, "l"),
          "nickname" => GenController::filter($req->nickname, "U")
        ],
      );

      $validator = $this->validateData($req, $id);

      if ($validator->fails()) {
        return response()->json([
          "ok" => false,
          "msg" => $validator->errors()->first(),
          "err" => $validator->errors()->first(),
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
        "ok" => true,
        "msg" => "Registro " . (is_null($id) ? "agregado" : "editado") . " correctamente",
        "data" => $this->returnData($data)
      ], 200);
    } catch (\Throwable $th) {
      DB::rollback();
      return response()->json([
        "ok" => false,
        "msg" => "Error. Contacte al equipo de desarrollo",
        "err" => "ERROR => " . $th
      ], 200);
    }
  }

  public function validateData($req, $id) {
    $rules = [
      "name" => "string|required|min:2|max:50",
      "first_surname" => "string|required|min:2|max:25",
      "nickname" => "string|required|min:2|max:15|unique:users" . ($id ? ",nickname," . $id : ""),
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
        "nickname.unique" => "El Usuario ya ha sido registrado",
        "email.unique" => "El Correo elec. ya ha sido registrado",
      ]
    );
  }

  public function saveData($data, $req) {
    $data->name = GenController::filter($req->name, "U");
    $data->first_surname = GenController::filter($req->first_surname, "U");
    $data->second_surname = GenController::filter($req->second_surname, "U");
    $data->avatar = DocMgrController::save($req->file("avatar_doc"), "User");
    $data->nickname = $req->nickname;
    $data->email = $req->email;
    $data->updated_by_id = $req->user()->id;
    $data->role_id = GenController::filter($req->role_id, "id");
    $data->save();

    return $data;
  }
  public function returnData($data) {
    $data->role_name = Role::find($data->role_id)->name;

    $data = [
      "id" => $data->id,
      "name" => $data->name,
      "first_surname" => $data->first_surname,
      "second_surname" => $data->second_surname,
      "nickname" => $data->nickname,
      "email" => $data->email,
      "role_name" => $data->role_name,
      "full_name" => GenController::filter($data->name . " " . $data->first_surname . " " . $data->second_surname, "U")
    ];

    return $data;
  }

  public function pwdUpdate(Request $req) {
    DB::beginTransaction();
    try {
      $user = User::find($req->id);
      $user->password = bcrypt(trim($req->password));
      $user->updated_by_id = $req->user()->id;
      $user->save();

      DB::commit();
      return response()->json([
        "ok" => true,
        "msg" => "Contraseña actualizada correctamente"
      ], 200);
    } catch (\Throwable $th) {
      DB::rollback();
      return response()->json([
        "ok" => false,
        "msg" => "Error. Contacte al equipo de desarrollo",
        "err" => "ERROR => " . $th
      ], 200);
    }
  }
}
