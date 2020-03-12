<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatesStudyingTermStudyingYearPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     */
    public function up()
    {
        Schema::create('studying_term_studying_year', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('studying_year_id');
            $table->unsignedBigInteger('studying_term_id');
            $table->tinyInteger('is_current')->default(0);//0 for is not the current term, 1 for the current term
            $table->tinyInteger('is_available')->default(0);//0 for  is not available for students registration , 1 for  students registration
            $table->tinyInteger('is_ended')->default(0);//0 for not ending the term , 1 for ending the term
            $table->foreign('studying_year_id')->references('id')->on('studying_years');
            $table->foreign('studying_term_id')->references('id')->on('studying_terms');


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
        Schema::dropIfExists('studying_term_studying_year');
    }
}
