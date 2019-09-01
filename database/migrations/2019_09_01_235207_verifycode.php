<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class Verifycode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('verifycode', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cell', 20);
            $table->string('content', 255)->nullable();
            $table->string('code', 20);
            $table->tinyInteger('type')->default(0)->comment('0: 默认 1: 注册验证码 2:激活验证码  3: 忘记密码验证码');
            $table->tinyInteger('status')->default(1)->comment('1:有效 0: 删除 9:禁用');
            $table->dateTime('verify_at')->comment('验证时间')->nullable();
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
        //
        Schema::dropIfExists('verifycode');
    }
}
