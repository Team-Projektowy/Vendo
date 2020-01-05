<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('can_propose_questions');
            $table->boolean('can_manage_questions');
            $table->boolean('can_use_generated_quizzes');
            $table->boolean('can_generate_quizzes');
            $table->boolean('can_manage_quizzes');
            $table->boolean('can_manage_users');
            $table->boolean('full_privileges');
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
        Schema::dropIfExists('roles');
    }
}
