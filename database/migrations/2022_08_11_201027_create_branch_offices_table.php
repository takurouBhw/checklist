<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_offices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned()->comment('多対一: 本社');
            $table->string('name', 100)->comment('支社社名');
            $table->string('postal_code', 8);
            $table->string('address', 255);
            $table->string('email', 255)->unique();
            $table->string('phone', 15);
            $table->string('representative')->nullable();
            $table->string('responsible')->nullable();
            $table->string('url')->nullable();

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
        Schema::dropIfExists('branch_offices');
    }
}
