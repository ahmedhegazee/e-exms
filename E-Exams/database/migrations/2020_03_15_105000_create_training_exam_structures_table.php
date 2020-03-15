<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingExamStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_exam_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('training_exam_id');
            $table->unsignedBigInteger('chapter_id');
            $table->unsignedBigInteger('question_type_id');
            $table->unsignedInteger('questions_count');
            $table->char('category');
            $table->foreign('chapter_id')->on('chapters')->references('id');
            $table->foreign('question_type_id')->on('question_types')->references('id');
            $table->foreign('training_exam_id')->on('training_exams')->references('id');

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
        Schema::dropIfExists('training_exam_structures');
    }
}
