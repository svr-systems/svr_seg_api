<?php

namespace App\Models;

use App\Http\Controllers\DocMgrController;
use App\Http\Controllers\GenController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {
  use HasApiTokens, HasFactory, Notifiable;

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected function serializeDate(\DateTimeInterface $date) {
    return \Carbon\Carbon::instance($date)->toISOString(true);
  }

  protected $casts = [
    'email_verified_at' => 'datetime',
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
  ];

  static public function getItems($req) {
    $items = User::
      join('roles', 'roles.id', 'users.role_id')->
      where('users.active', true)->
      where('users.id', '!=', $req->id)->
      orderBy('users.name')->
      get([
        'users.id',
        'users.name',
        'users.first_surname',
        'users.second_surname',
        'users.nickname',
        'users.avatar',
        'users.email',
        'roles.name AS role_name'
      ]);

    foreach ($items as $key => $item) {
      $item->key = $key;
      $item->full_name = GenController::filter($item->name . " " . $item->first_surname . " " . $item->second_surname, "U");
      $item->avatar_b64 = DocMgrController::getB64($item->avatar, "User");
    }

    return $items;
  }

  static public function getItem($id) {
    $item = User::
      join('roles', 'roles.id', 'users.role_id')->
      find($id, [
        'users.id',
        'users.created_at',
        'users.updated_at',
        'users.created_by_id',
        'users.updated_by_id',
        'users.name',
        'users.first_surname',
        'users.second_surname',
        'users.avatar',
        'users.nickname',
        'users.email',
        'users.role_id',
        'roles.name AS role_name',
      ]);

    $item->created_by = User::find($item->created_by_id, ['name']);
    $item->updated_by = User::find($item->updated_by_id, ['name']);

    $item->avatar_doc = null;
    $item->avatar_dlt = false;
    $item->avatar_b64 = DocMgrController::getB64($item->avatar, "User");

    return $item;
  }
}
