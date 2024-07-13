<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DocMgrController extends Controller {
  public static function save($file, $folder) {
    //HOW TO USE: $avatar = DocMgrController::save($req->file("avatar_doc"), "User");
    //HOW TO USE OBJ: $item = DocMgrController::save($req->file("item_doc_" . $key), "User");
    if (!empty($file)) {
      $file_name = Str::random(40) . "." . $file->getClientOriginalExtension();
      Storage::disk($folder)->put($file_name, file_get_contents($file));

      return $file_name;
    }

    return null;
  }
}
