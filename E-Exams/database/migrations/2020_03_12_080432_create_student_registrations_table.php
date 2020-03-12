<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('studying_term_id');
            $table->unsignedBigInteger('studying_year_id');
            $table->foreign('student_id')->on('students')->references('id');
            $table->foreign('level_id')->on('levels')->references('id');
            $table->foreign('department_id')->on('departments')->references('id');
            $table->foreign('studying_term_id')->on('studying_terms')->references('id');
            $table->foreign('studying_year_id')->on('studying_years')->references('id');
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
        Schema::dropIfExists('student_registrations');
    }
}
