<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vcode')->index();
            $table->string('code');
            $table->integer('group');
            $table->text('description')->nullable();
            $table->integer('semester');
            $table->integer('hours');
            $table->unsignedBigInteger('subject_vcode')->nullable();
            $table->foreign('subject_vcode')
                  ->references('vcode')
                  ->on('subjects')
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
        Schema::dropIfExists('courses');
    }
}
