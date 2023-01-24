<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category1_id');
            $table->unsignedBigInteger('category2_id');
            $table->string('client_id');
            $table->string('user_id');
            $table->tinyInteger('priority', false, true)->comment('0=低い 1=通常 2=高い')->default(1);
            $table->string('title');
			$table->dateTime('opened_at')->nullable();
            $table->dateTime('drafted_at')->nullable();
			$table->dateTime('colsed_at')->nullable();
			$table->dateTime('deadline_at')->nullable();
			$table->unsignedInteger('progress')->default('0');
			$table->json('check_items')->default('[]')->nullable();
			$table->string('json_file', 100)->nullable()->comment('チェック内容をJSON形式で保存。ファイルパスを格納');
			$table->dateTime('locked_at')->nullable();
			$table->unsignedInteger('sort_num')->default('0');
			$table->json('participants')->default('[]')->nullable();
			$table->unsignedBigInteger('locked_user_id')->nullable();
			$table->dateTime('deleted_at')->nullable();
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
        Schema::dropIfExists('checklists');
    }
}
