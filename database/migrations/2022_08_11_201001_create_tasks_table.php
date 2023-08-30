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
            $table->string('task_title',100);
            $table->text('memo')->default('');
            $table->unsignedInteger('sort_no');
            $table->unsignedBigInteger('todo_id');
            // $table->foreignId('user_id')->constrained()->comment('作成者ID');
            $table->unsignedInteger('user_id')->nullable();
            $table->boolean('is_done')->default(0);
            $table->timestamps();
            $table->softDeletes();
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
