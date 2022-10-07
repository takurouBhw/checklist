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
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_office_id')->nullable();
            $table->unsignedTinyInteger('master_flag')->default('1')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('priority')->default('1')->nullable();
            $table->unsignedBigInteger('category1_id');
            $table->unsignedBigInteger('category2_id');
            $table->unsignedBigInteger('category3_id')->nullable();
            $table->unsignedBigInteger('category4_id')->nullable();
            $table->string('checklist_title', 100);
            $table->unsignedInteger('year');
            $table->unsignedInteger('month');
            $table->dateTime('drafted_at')->nullable();
            $table->dateTime('opened_at')->nullable();
            $table->dateTime('colsed_at')->nullable();
            $table->dateTime('deadline_at')->nullable();
            $table->unsignedInteger('progress')->default('0');
            $table->json('check_item')->default('[]')->nullable();
            $table->string('json_file', 100)->nullable()->comment('チェック内容をJSON形式で保存。ファイルパスを格納');
            $table->dateTime('locked_at')->nullable();
            $table->unsignedInteger('sort_num')->default('0');
            $table->json('participants')->default('[]')->nullable();
            $table->json('check_items')->default('[]')->nullable();
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
        Schema::dropIfExists('checklist_works');
    }
}
