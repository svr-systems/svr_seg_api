<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration {
  public function up() {
    Schema::create('tags', function (Blueprint $table) {
      $table->id();
      $table->boolean("active")->default(true);
      $table->timestamps();
      $table->foreignId("created_by_id")->constrained("users");
      $table->foreignId("updated_by_id")->constrained("users");
      $table->string('name', 30);
      $table->string('color', 7);
    });
  }

  public function down() {
    Schema::dropIfExists('tags');
  }
}
