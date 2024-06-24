<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 20);
            $table->boolean("active")->default(true);
            $table->foreignId("created_by_id")->constrained("users");
            $table->foreignId("updated_by_id")->constrained("users");
            $table->foreignId("role_id")->constrained("roles");
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('active');
            $table->dropConstrainedForeignId('created_by_id');
            $table->dropConstrainedForeignId('updated_by_id');
            $table->dropConstrainedForeignId('role_id');
        });
    }
}
