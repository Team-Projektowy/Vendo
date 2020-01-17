<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->string('text');
            $table->integer('category')->unsigned();
            $table->foreign('category')->references('id')->on('categories');
            $table->string('language');
            $table->integer('added_by_user')->unsigned();
            $table->foreign('added_by_user')->references('id')->on('users');
            // $table->integer('accepted_by_user')->unsigned();
            // $table->foreign('accepted_by_user')->references('id')->on('users');
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
