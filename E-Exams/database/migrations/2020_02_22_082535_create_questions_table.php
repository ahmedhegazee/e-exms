<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question_content');
//            $table->char('category')->default('A');
            $table->unsignedBigInteger('question_type_id');
            $table->unsignedBigInteger('question_category_id');
            $table->unsignedBigInteger('chapter_id');
//            $table->unsignedInteger('is_public')->default(1);//0 is private  , 1 f is public
            $table->unsignedInteger('correct_answer')->default(0);
            $table->foreign('chapter_id')->references('id')->on('chapters');
            $table->foreign('question_type_id')->references('id')->on('question_types');
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
        Schema::dropIfExists('questions');
    }
}
