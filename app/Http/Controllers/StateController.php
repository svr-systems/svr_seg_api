<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller {
  public function index() {
    try {
      return response()->json([
        "success" => true,
        "message" => "Registros retornados correctamente",
        "data" => State::getAll()
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

  public function show(State $state) {
    //
  }

  public function update(Request $request, State $state) {
    //
  }

  public function destroy(State $state) {
    //
  }
}
