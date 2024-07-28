<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectModule;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller {

  public function index() {
    try {
      return response()->json([
        "success" => true,
        "message" => "Registros retornados correctamente",
        "data" => Project::getItems()
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
        "data" => Project::getItem($id)
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
      $data = Project::find($id);
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
      $validator = $this->validateData($req, $id);

      if ($validator->fails()) {
        return response()->json([
          "ok" => false,
          "msg" => $validator->errors()->first(),
          "err" => $validator->errors()->first(),
        ], 200);
      }

      if (is_null($id)) {
        $data = new Project();
        $data->created_by_id = $req->user()->id;
      } else {
        $data = Project::find($id);
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
      "name" => "required|string|min:2|max:50",
      "description" => "required|string|min:2",
      "start_date" => "required|date_format:Y-m-d",
      "end_date" => "nullable|date_format:Y-m-d|after_or_equal:start_date",
      "user_property_id" => "required",
      "state_id" => "required",
      "priority_id" => "required",
      "logo_doc" => "nullable|mimes:jpg,jpeg,png,webp,svg,bmp|max:768",
    ];

    return Validator::make(
      $req->all(),
      $rules,
      [
        "end_date.after_or_equal" => "La fecha de Termino no puede ser menor a la de Inicio"
      ]
    );
  }

  public function saveData($data, $req) {
    $data->updated_by_id = $req->user()->id;
    $data->name = GenController::filter($req->name, "U");
    $data->description = trim($req->description);
    $data->start_date = $req->start_date;
    $data->end_date = $req->end_date;
    $data->logo = DocMgrController::save($req->logo, $req->file("logo_doc"), $req->logo_dlt, "Project");
    $data->user_property_id = GenController::filter($req->user_property_id, "id");
    $data->state_id = GenController::filter($req->state_id, "id");
    $data->priority_id = GenController::filter($req->priority_id, "id");
    $data->save();

    $req->project_modules = json_decode($req->project_modules);
    foreach ($req->project_modules as $item) {
      $project_module = ProjectModule::find($item->id);

      if (!$project_module) {
        $project_module = new ProjectModule();
      }

      $project_module->active = GenController::filter($item->active, "b");

      if ($project_module->active) {
        $project_module->name = GenController::filter($item->name, "U");
        $project_module->icon = GenController::filter($item->icon, "l");
        $project_module->project_id = GenController::filter($data->id, "id");
      }

      $project_module->save();
    }

    $req->project_users = json_decode($req->project_users);
    foreach ($req->project_users as $item) {
      $project_user = ProjectUser::find($item->id);

      if (!$project_user) {
        $project_user = new ProjectUser();
      }

      $project_user->active = GenController::filter($item->active, "b");

      if ($project_user->active) {
        $project_user->create = GenController::filter($item->create, "b");
        $project_user->read = GenController::filter($item->read, "b");
        $project_user->update = GenController::filter($item->update, "b");
        $project_user->delete = GenController::filter($item->delete, "b");
        $project_user->project_id = GenController::filter($data->id, "id");
        $project_user->user_id = GenController::filter($item->user_id, "id");
      }

      $project_user->save();
    }

    return $data;
  }
  public function returnData($data) {
    $data = [
      "id" => $data->id,
      "name" => $data->name,
    ];

    return $data;
  }
}
