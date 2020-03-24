<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('subject_name');
            $table->string('subject_code')->unique();
            $table->unsignedInteger('term');//1for firs term, 2 for second term
            $table->unsignedBigInteger('level_id');
//            $table->unsignedBigInteger('studying_term_id');
//            $table->integer('credit_hours');
            $table->unsignedBigInteger('professor_id');
            $table->foreign('professor_id')->on('professors')->references('id');
//            $table->foreign('studying_term_id')->on('studying_terms')->references('id');
            $table->foreign('level_id')->on('levels')->references('id');

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
