<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration {
  public function up() {
    Schema::create('projects', function (Blueprint $table) {
      $table->id();
      $table->boolean("active")->default(true);
      $table->timestamps();
      $table->foreignId("created_by_id")->constrained("users");
      $table->foreignId("updated_by_id")->constrained("users");
      $table->string('name', 50);
      $table->text('description');
      $table->date('start_date');
      $table->date('end_date')->nullable();
      $table->string('logo', 50)->nullable();
      $table->foreignId("user_property_id")->constrained("users");
      $table->foreignId("state_id")->constrained("states");
      $table->foreignId("priority_id")->constrained("priorities");
    });
  }

  public function down() {
    Schema::dropIfExists('projects');
  }
}
