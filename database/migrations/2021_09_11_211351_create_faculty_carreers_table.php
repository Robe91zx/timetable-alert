<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyCarreersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_carreers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faculty_vcode')->nullable()->index();
            $table->foreign('faculty_vcode')
                  ->references('vcode')
                  ->on('faculties')
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
        Schema::dropIfExists('faculty_carreers');
    }
}
