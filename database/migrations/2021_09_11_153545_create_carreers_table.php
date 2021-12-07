<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarreersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carreers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vcode')->unique()->index();
            $table->string('code');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('website');
            $table->timestamps();
        });        
    }

      
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carreers');
    }
}
