<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistTodoWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_todo_works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('checklist_id');
            $table->string('user_id', 32);
            $table->tinyInteger('headline')->unsigned()->default(0)->comment('見出しフラグ:　見出しにするとチェック項目から除外');
            $table->tinyInteger('attention')->unsigned()->default(0)->comment('注目項目');
            $table->text('check_item')->nullable()->comment('チェック内容');
            $table->tinyInteger('checked')->unsigned()->default(0);
            $table->text('memo');
            $table->integer('second');
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
        Schema::dropIfExists('checklist_todo_works');
    }
}
