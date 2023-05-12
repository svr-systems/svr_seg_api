<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiscalRegimesTable extends Migration
{
    public function up()
    {
        Schema::create('fiscal_regimes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 3);
            $table->boolean('active')->default(true);
            $table->foreignId('fiscal_type_id')->nullable()->constrained();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fiscal_regimes');
    }
}