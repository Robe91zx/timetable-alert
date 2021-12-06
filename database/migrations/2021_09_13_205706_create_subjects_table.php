<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vcode')->index();
            $table->string('code');
            $table->string('name');
            $table->integer('semester');
            $table->integer('hours');
            $table->unsignedBigInteger('faculty_vcode')->nullable();
            $table->foreign('faculty_vcode')
                  ->references('vcode')
                  ->on('faculties')
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
        Schema::dropIfExists('subjects');
    }
}
