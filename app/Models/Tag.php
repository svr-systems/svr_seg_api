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

    foreach ($data as $key => $item) {
      $item->key = $key;
    }

    return $data;
  }

  static public function getItem($id) {
    $data = Tag::
      find($id, [
        'tags.id',
        'tags.created_at',
        'tags.updated_at',
        'tags.created_by_id',
        'tags.updated_by_id',
        'tags.name',
        'tags.color',
      ]);

    $data->created_by = User::find($data->created_by_id, ['name']);
    $data->updated_by = User::find($data->updated_by_id, ['name']);

    return $data;
  }
}
