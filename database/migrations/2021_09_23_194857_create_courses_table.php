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
            $table->integer('state');
            $table->integer('semester');
            $table->integer('hours');
            $table->text('description')->nullable();
            $table->integer('group');
            $table->foreignId('subject_id')
                  ->nullable()
                  ->constrained('subjects')
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
        Schema::dropIfExists('courses');
    }
}
