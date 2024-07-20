<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
  use HasFactory;

  protected function serializeDate(\DateTimeInterface $date) {
    return \Carbon\Carbon::instance($date)->toISOString(true);
  }

  protected $casts = [
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
  ];

  static public function getAll() {
    $data = Tag::
      where('active', true)->
      get([
        'id',
        'name',
        'color',
      ]);

    return $data;
  }
}
