<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasklists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('description', 255)->nullable();
            $table->unsignedInteger('creator')->nullable();
            $table->timestamps();

            $table->foreign('creator')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

        Schema::create('task_tasklist', function (Blueprint $table) {
            $table->unsignedInteger('task_id');
            $table->unsignedInteger('tasklist_id');
            
            $table->primary(['task_id', 'tasklist_id']);

            $table->foreign('task_id')
                  ->references('id')
                  ->on('tasks')
                  ->onDelete('cascade');

            $table->foreign('tasklist_id')
                  ->references('id')
                  ->on('tasklists')
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
        Schema::dropIfExists('task_tasklist');  
        Schema::dropIfExists('tasklists');
    }
}
