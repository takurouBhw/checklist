<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategory1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category1s', function (Blueprint $table) {
            $table->id();
            $table->string('category1_name');
            $table->integer('sort_num')->default(0);
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();

            $table->index('category1_name');
			$table->index('sort_num');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category1s');
    }
}
