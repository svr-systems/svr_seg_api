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

  static public function getItems() {
    $items = Tag::
      where('active', true)->
      get([
        'id',
        'name',
        'color',
      ]);

    foreach ($items as $key => $item) {
      $item->key = $key;
    }

    return $items;
  }

  static public function getItem($id) {
    $item = Tag::
      find($id, [
        'tags.id',
        'tags.created_at',
        'tags.updated_at',
        'tags.created_by_id',
        'tags.updated_by_id',
        'tags.name',
        'tags.color',
      ]);

    $item->created_by = User::find($item->created_by_id, ['name']);
    $item->updated_by = User::find($item->updated_by_id, ['name']);

    return $item;
  }
}
