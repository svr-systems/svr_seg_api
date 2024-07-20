<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model {
  use HasFactory;

  public $timestamps = false;

  static public function getAll() {
    $data = State::
      where('active', true)->
      get([
        'id',
        'name',
        'color',
      ]);

    return $data;
  }
}
