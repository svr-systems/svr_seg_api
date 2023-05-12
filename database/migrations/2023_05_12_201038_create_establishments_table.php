<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentsTable extends Migration
{
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('legal_name', 100)->nullable()->default(null);
            $table->string('legal_code', 13)->nullable()->default(null);
            $table->string('legal_zip', 5)->nullable()->default(null);
            $table->string('url_img', 100)->nullable()->default(null);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreignId('created_by_id')->constrained('users');
            $table->foreignId('updated_by_id')->constrained('users');
            $table->foreignId('fiscal_type_id')->nullable()->constrained();
            $table->foreignId('fiscal_regime_id')->nullable()->constrained();
        });
    }

    public function down()
    {
        Schema::dropIfExists('establishments');
    }
}
