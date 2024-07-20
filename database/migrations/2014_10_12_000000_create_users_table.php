<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
  public function up() {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->boolean("active")->default(true);
      $table->timestamps();
      $table->foreignId("created_by_id")->constrained("users");
      $table->foreignId("updated_by_id")->constrained("users");
      $table->string('name', 50);
      $table->string('first_surname', 25);
      $table->string('second_surname', 25)->nullable();
      $table->string('avatar', 50)->nullable()->default(null);
      $table->string('nickname', 15)->nullable()->default(null);
      $table->string('email', 50)->unique();
      $table->string('password');
      $table->timestamp('email_verified_at')->nullable();
      $table->rememberToken();
    });
  }

  public function down() {
    Schema::dropIfExists('users');
  }
}
