<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('project_id')->nullable(true);
            $table->string('title');
            $table->text('body')->nullable(true);
            $table->tinyInteger('done')->default(\App\Task::DONE);
            $table->jsonb('orders')->nullable(true);
            $table->date('date')->nullable(true);
            $table->smallInteger('every')->nullable(true);
            $table->softDeletes();
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
        Schema::dropIfExists('tasks');
    }
}
