<?php

namespace App\Models;

use App\Http\Controllers\DocMgrController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {
  use HasFactory;

  protected function serializeDate(\DateTimeInterface $date) {
    return \Carbon\Carbon::instance($date)->toISOString(true);
  }

  protected $casts = [
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
  ];

  static public function getItems() {
    $items = Project::
      where('active', true)->
      get([
        'id',
        'name',
        'start_date',
        'end_date',
        'logo',
        'user_property_id',
        'state_id',
        'priority_id',
      ]);

    foreach ($items as $key => $item) {
      $item->key = $key;
      $item->logo_b64 = DocMgrController::getB64($item->logo, "Project");
      $item->state = State::find($item->state_id, ["name", "color"]);
      $item->priority = Priority::find($item->priority_id, ["name", "color"]);
      $item->user_property = User::find($item->user_property_id, ["nickname", "avatar"]);
      $item->user_property->avatar_b64 = DocMgrController::getB64($item->user_property->avatar, "User");
    }

    return $items;
  }

  static public function getItem($id) {
    $item = Project::find($id);

    $item->created_by = User::find($item->created_by_id, ['name']);
    $item->updated_by = User::find($item->updated_by_id, ['name']);
    $item->state = State::find($item->state_id, ["name", "color"]);
    $item->priority = Priority::find($item->priority_id, ["name", "color"]);
    $item->user_property = User::find($item->user_property_id, ["nickname", "avatar"]);
    $item->user_property->avatar_b64 = DocMgrController::getB64($item->user_property->avatar, "User");

    $item->logo_doc = null;
    $item->logo_dlt = false;
    $item->logo_b64 = DocMgrController::getB64($item->logo, "Project");

    $item->project_modules = ProjectModule::
      where("active", true)->
      where("project_id", $item->id)->
      get();

    $item->project_users = ProjectUser::
      where("active", true)->
      where("project_id", $item->id)->
      get();

    foreach ($item->project_users as $project_user) {
      $project_user->user = User::find($project_user->user_id, ["nickname", "avatar"]);
      $project_user->user->avatar_b64 = DocMgrController::getB64($project_user->user->avatar, "User");
    }

    return $item;
  }
}
