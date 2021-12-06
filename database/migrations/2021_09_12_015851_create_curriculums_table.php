<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vcode')->index();
            $table->string('code');
            $table->string('name');
            $table->string('description');
            $table->integer('duration');
            $table->unsignedBigInteger('carreer_vcode')->nullable();
            $table->foreign('carreer_vcode')
                  ->references('vcode')
                  ->on('carreers')
                  ->cascadeOnUpdate()
                  ->nullOnDelete(); 
            $table->integer('state');
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
        Schema::dropIfExists('curriculums');
    }
}
