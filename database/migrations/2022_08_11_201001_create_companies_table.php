<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('client_key',64)->comment('クライアントキー');
            $table->string('name',100)->comment('会社名');
            $table->string('postal_code', 8)->comment('郵便番号');
            $table->string('address', 255)->comment('住所');
            $table->string('email', 255)->unique();
            $table->string('phone', 15)->comment('電話番号');
            $table->string('representative', 100)->nullable()->comment('代表者');
            $table->string('responsible', 100)->nullable()->comment('担当者');
            $table->string('url')->nullable()->comment('ホームページ');
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
        Schema::dropIfExists('companies');
    }
}
