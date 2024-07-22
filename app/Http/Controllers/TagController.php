<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller {
  public function index() {
    try {
      return response()->json([
        "success" => true,
        "message" => "Registros retornados correctamente",
        "data" => Tag::getAll()
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        "success" => false,
        "message" => "ERR. " . $th
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
        "data" => Tag::getItem($id)
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
      $data = Tag::find($id);
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
          "name" => GenController::filter($req->name, "U"),
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
        $data = new Tag();
        $data->created_by_id = $req->user()->id;
      } else {
        $data = Tag::find($id);
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
      "name" => "string|required|min:2|max:30",
      "color" => "string|required|min:7|max:7",
    ];

    return Validator::make(
      $req->all(),
      $rules,
      [
        "name.unique" => "El Nombre ya ha sido registrado"
      ]
    );
  }

  public function saveData($data, $req) {
    $data->name = $req->name;
    $data->color = GenController::filter($req->color, "U");
    $data->updated_by_id = $req->user()->id;
    $data->save();

    return $data;
  }
  public function returnData($data) {
    $data = [
      "id" => $data->id,
      "name" => $data->name,
      "color" => $data->color
    ];

    return $data;
  }
}
