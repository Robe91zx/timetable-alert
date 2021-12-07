<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumHasSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_has_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curriculum_vcode')->nullable();
            $table->foreign('curriculum_vcode')
                  ->references('vcode')
                  ->on('curriculums')
                  ->cascadeOnUpdate()
                  ->nullOnDelete(); 
            $table->unsignedBigInteger('subject_vcode')->nullable();
            $table->foreign('subject_vcode')
                  ->references('vcode')
                  ->on('subjects')
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
        Schema::dropIfExists('curriculum_has_subjects');
    }
}
