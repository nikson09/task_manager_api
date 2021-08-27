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
            $table->id()->comment('Идентификатор задания');
            $table->string('name', 100)->comment('Название задания');
            $table->text('description')->comment('Описание задания');
            $table->date('deadline_date')->nullable()->comment('Дата выполнения');
            $table->foreignId('user_id')->nullable()->constrained('users')->comment('Идентификатор пользователя');
            $table->integer('status_id')->nullable()->comment('Идентификатор статуса');
            $table->boolean('active')->default(true)->comment('Активность задания');
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
