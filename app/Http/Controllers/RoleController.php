<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller {
  public function index() {
    try {
      return response()->json([
        "success" => true,
        "message" => "Registros retornados correctamente",
        "data" => Role::getAll()
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        "success" => false,
        "message" => "ERR. " . $th
      ], 500);
    }
  }

  public function store(Request $request) {
    //
  }

  public function show(Role $role) {
    //
  }

  public function update(Request $request, Role $role) {
    //
  }

  public function destroy(Role $role) {
    //
  }
}