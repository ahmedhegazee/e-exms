<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatesTrainingExamQuestionPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_exam_question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('training_exam_id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('training_exam_id')->on('training_exams')->references('id');
            $table->foreign('question_id')->on('questions')->references('id');

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
        Schema::dropIfExists('training_exam_question');
    }
}
