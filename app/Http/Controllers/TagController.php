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
        "ok" => true,
        "msg" => "Registros retornados correctamente",
        "items" => Tag::getItems()
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        "ok" => false,
        "msg" => "ERR. " . $th
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
        "item" => Tag::getItem($id)
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
      $item = Tag::find($id);
      $item->active = false;
      $item->save();

      DB::commit();
      return response()->json([
        "ok" => true,
        "msg" => "Registro eliminado correctamente",
        "item" => Tag::getItem($item->id)
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

      $valid_item = $this->validItem($req, $id);

      if ($valid_item->fails()) {
        return response()->json([
          "ok" => false,
          "msg" => $valid_item->errors()->first(),
          "err" => $valid_item->errors()->first(),
        ], 200);
      }

      $item = Tag::find($id);

      if (!$item) {
        $item = new Tag();
        $item->created_by_id = $req->user()->id;
      }

      $item = $this->saveItem($item, $req);

      DB::commit();
      return response()->json([
        "ok" => true,
        "msg" => "Registro " . (is_null($id) ? "agregado" : "editado") . " correctamente",
        "item" => Tag::getItem($item->id)
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

  public function validItem($req, $id) {
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

  public function saveItem($item, $req) {
    $item->updated_by_id = $req->user()->id;
    $item->name = $req->name;
    $item->color = GenController::filter($req->color, "U");
    $item->save();

    return $item;
  }
}
