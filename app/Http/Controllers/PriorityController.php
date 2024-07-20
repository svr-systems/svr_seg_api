<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller {
  public function index() {
    try {
      return response()->json([
        "success" => true,
        "message" => "Registros retornados correctamente",
        "data" => Priority::getAll()
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

  public function show(Priority $priority) {
    //
  }

  public function update(Request $request, Priority $priority) {
    //
  }

  public function destroy(Priority $priority) {
    //
  }
}
