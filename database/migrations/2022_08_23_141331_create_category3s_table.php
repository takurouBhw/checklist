<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategory3sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category3s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category1_id');
            $table->unsignedBigInteger('category2_id');
            $table->string('name');
            $table->integer('sort_num')->default(0);
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
        Schema::dropIfExists('category3s');
    }
}
