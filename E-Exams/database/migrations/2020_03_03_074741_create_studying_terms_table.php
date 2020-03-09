<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyingTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studying_terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('term');
            $table->unsignedBigInteger('studying_year_id');
            $table->foreign('studying_year_id')->references('id')->on('studying_years');
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
        Schema::dropIfExists('studying_terms');
    }
}
