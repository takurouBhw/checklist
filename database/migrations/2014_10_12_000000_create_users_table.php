<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id',32)->unique()->comment('ユーザーID UUID');
            $table->string('name',50)->comment('ユーザー名');
            $table->unsignedBigInteger('company_id')->comment('所属会社');
            $table->unsignedBigInteger('duty_station_id')->comment('所属部署');
            $table->unsignedBigInteger('branch_office_id')->comment('所属支店');
            $table->string('email',255)->unique();
            $table->string('phone', 15)->comment('電話番号')->nullable();
            $table->softDeletes()->comment('退社日。※論理削除用');
            $table->tinyInteger('role')->unsigned()->default(0)
            ->comment('権限: 0=開発者 1=所有者 2=管理者 5=ユーザー');
            $table->timestamp('email_verified_at')->nullable();
            $table->dateTime('last_logined_at')->nullable()->comment('最終ログイン日時');
            $table->bigInteger('last_checklist_id')->nullable()->comment('最終チェック作業ID');
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
