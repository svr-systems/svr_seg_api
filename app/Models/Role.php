<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {
  use HasFactory;

  static public function getAll() {
    $data = Role::
      where('active', true)->
    get([
        'id',
        'name',
      ]);

    return $data;
  }
}