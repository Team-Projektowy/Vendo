<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            // $table->integer('added_by_user')->unsigned();
            // $table->foreign('added_by_user')->references('id')->on('users');
            // $table->integer('accepted_by_user')->unsigned();
            // $table->foreign('accepted_by_user')->references('id')->on('users');
            // $table->integer('language')->unsigned();
            // $table->foreign('language')->references('id')->on('languages');
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
        Schema::dropIfExists('quizzes');
    }
}
