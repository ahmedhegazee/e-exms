<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('chapter_id');
            $table->unsignedBigInteger('question_type_id');
            $table->unsignedInteger('questions_count');
            $table->unsignedBigInteger('question_category_id');
            $table->foreign('chapter_id')->on('chapters')->references('id');
            $table->foreign('question_type_id')->on('question_types')->references('id');
            $table->foreign('exam_id')->on('exams')->references('id');
            $table->foreign('question_category_id')->references('id')->on('question_categories');

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
        Schema::dropIfExists('exam_structures');
    }
}
