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
            $table->unsignedBigInteger('category_id');
            $table->string('user_id');
            $table->tinyInteger('priority', false, true)->comment('0=低い 1=通常 2=高い');
            $table->string('title');
            $table->dateTime('drafted_at')->nullable();
            $table->dateTime('opened_at')->nullable();
            $table->dateTime('colsed_at')->nullable();
            $table->double('progress')->default(0);
            $table->dateTime('locked_at')->nullable();
            $table->integer('sort_num')->default(0);
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
        Schema::dropIfExists('checklists');
    }
}
