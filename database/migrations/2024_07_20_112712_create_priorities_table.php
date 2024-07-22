<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrioritiesTable extends Migration {
  public function up() {
    Schema::create('priorities', function (Blueprint $table) {
      $table->id();
      $table->boolean("active")->default(true);
      $table->string('name', 30);
      $table->string('color', 7);
    });
  }

  public function down() {
    Schema::dropIfExists('priorities');
  }
}
