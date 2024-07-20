<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model {
  use HasFactory;

  public $timestamps = false;

  static public function getAll() {
    $data = Priority::
      where('active', true)->
      get([
        'id',
        'name',
        'color',
      ]);

    return $data;
  }
}
