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
            $table->string('name');
            $table->integer('semester');
            $table->string('department');
            $table->integer('total_hour');
            $table->integer('requisite');
            $table->integer('state');
            $table->integer('workshop');
            $table->integer('laboratory');
            $table->integer('equivalence');
            $table->foreignId('curriculum_id')
                  ->nullable()
                  ->constrained('curriculums')
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
        Schema::dropIfExists('subjects');
    }
}
