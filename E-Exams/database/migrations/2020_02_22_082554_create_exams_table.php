<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subject_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('exam_time');//h:m
            $table->unsignedInteger('marks');
//            $table->unsignedInteger('exam_type');//1 for midterm , 2 for quiz , 3 for final
            $table->string('exam_code')->nullable();
            $table->integer('examined')->default(0);
            $table->foreign('subject_id')->on('subjects')->references('id');

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
        Schema::dropIfExists('exams');
    }
}
