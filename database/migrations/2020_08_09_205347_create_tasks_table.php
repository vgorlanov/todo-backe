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
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('project_id')->nullable(true);
            $table->string('title');
            $table->text('body')->nullable(true);
            $table->tinyInteger('done')->default(\App\Models\Task::DONE);
            $table->date('date')->nullable(true);
            $table->integer('weight_project')->nullable(true)->comment('Сортировка в проекте');
            $table->integer('weight_active')->nullable(true)->comment('Сортировка текущих');
            $table->integer('weight_new')->nullable(true)->comment('Сортировка входящих');
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
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
}
