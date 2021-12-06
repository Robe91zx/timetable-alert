<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faculty_vcode')->nullable()->index();
            $table->foreign('faculty_vcode')
                  ->references('vcode')
                  ->on('faculties')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->unsignedBigInteger('department_vcode')->nullable()->index();
            $table->foreign('department_vcode')
                  ->references('vcode')
                  ->on('departments')
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
        Schema::dropIfExists('faculty_departments');
    }
}
