<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentHasCarreersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_has_carreers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_vcode')->nullable()->index();
            $table->foreign('department_vcode')
                  ->references('vcode')
                  ->on('departments')
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
        Schema::dropIfExists('department_has_carreers');
    }
}
