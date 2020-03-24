<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('approved')->default(0);
            $table->string('original_image')->default('/storage/images/original/5APbBDSrH91mMX3MybnJObT1q7ojD28RGJbwewEM.png');
            $table->string('profile_image')->default('/storage/images/profile/wLn6zd0l4uX8SbxUoyUIH01SAbZIO3qg8aTGEHHD.png');
            $table->string('thumbnail_image')->default('/storage/images/thumbnail/wLn6zd0l4uX8SbxUoyUIH01SAbZIO3qg8aTGEHHD.png');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
