<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectModulesTable extends Migration {
  public function up() {
    Schema::create('project_modules', function (Blueprint $table) {
      $table->id();
      $table->boolean("active")->default(true);
      $table->string('icon', 30)->nullable();
      $table->string('name', 50);
      $table->foreignId("project_id")->constrained("projects");
    });
  }

  public function down() {
    Schema::dropIfExists('project_modules');
  }
}
