<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersToConfirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answersToConfirm', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');
            $table->boolean('isCorrect');
            $table->integer('idQuestion')->references('id')->on('questions_to_confirms');
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
        Schema::dropIfExists('answers_to_confirms');
    }
}
