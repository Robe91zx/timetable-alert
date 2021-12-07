<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyHasCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_has_colleges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faculty_vcode')->index()->nullable();
            $table->foreign('faculty_vcode')
                  ->references('vcode')
                  ->on('faculties')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->unsignedBigInteger('college_vcode')->index()->nullable();
            $table->foreign('college_vcode')
                  ->references('vcode')
                  ->on('colleges')
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
        Schema::dropIfExists('faculty_has_colleges');
    }
}
