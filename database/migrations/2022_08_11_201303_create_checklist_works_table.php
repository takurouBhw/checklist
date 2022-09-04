<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('capmpany_id');
            $table->unsignedBigInteger('branch_office_id');
            $table->unsignedBigInteger('checklist_id');
            $table->tinyInteger('master_flag')->default(1);
            $table->tinyInteger('priority')->default(1);
            $table->unsignedBigInteger('category1_id');
            $table->unsignedBigInteger('category2_id');
            $table->unsignedBigInteger('category3_id')->nullable();
            $table->integer('year');
            $table->integer('month');
            $table->dateTime('drafted_at')->nullable();
            $table->dateTime('opened_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->string('user_id',32);
            $table->string('title', 100);
            $table->text('check_item' )->nullable();
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
        Schema::dropIfExists('checklist_works');
    }
}
