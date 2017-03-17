<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_attempts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('count');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->boolean('result')->nullable();
            $table->string('answer')->nullable();
            $table->unsignedInteger('session_id');
            $table->unsignedInteger('task_id');

            $table->unique(['count', 'session_id', 'task_id']);

            $table->foreign('session_id')
                  ->references('id')
                  ->on('sessions')
                  ->onDelete('cascade');

            $table->foreign('task_id')
                  ->references('id')
                  ->on('tasks')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_attempts');
    }
}
