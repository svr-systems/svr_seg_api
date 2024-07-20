<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

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

  public function store(Request $request) {
    //
  }

  public function show(Tag $tag) {
    //
  }

  public function update(Request $request, Tag $tag) {
    //
  }

  public function destroy(Tag $tag) {
    //
  }
}
