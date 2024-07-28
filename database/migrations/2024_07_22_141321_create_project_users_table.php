<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectUsersTable extends Migration {
  public function up() {
    Schema::create('project_users', function (Blueprint $table) {
      $table->id();
      $table->boolean("active")->default(true);
      $table->boolean("create");
      $table->boolean("read");
      $table->boolean("update");
      $table->boolean("delete");
      $table->foreignId("project_id")->constrained("projects");
      $table->foreignId("user_id")->constrained("users");
    });
  }

  public function down() {
    Schema::dropIfExists('project_users');
  }
}
