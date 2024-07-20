<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToUsersTable extends Migration {
  public function up() {
    Schema::table('users', function (Blueprint $table) {
      $table->foreignId("role_id")->constrained("roles");
    });
  }

  public function down() {
    Schema::table('users', function (Blueprint $table) {
      $table->dropConstrainedForeignId('role_id');
    });
  }
}
