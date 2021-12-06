<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegeCarreersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_carreers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('college_vcode')->nullable()->index();
            $table->foreign('college_vcode')
                  ->references('vcode')
                  ->on('colleges')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->unsignedBigInteger('carreer_vcode')->nullable()->index();
            $table->foreign('carreer_vcode')
                  ->references('vcode')
                  ->on('carreers')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();  
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
        Schema::dropIfExists('college_carreers');
    }
}
