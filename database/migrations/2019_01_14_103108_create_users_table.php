<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name', 64);
            $table->string('login_id', 20)->nullable();
            $table->string('pwd', 255);
            $table->string('cell', 20);
            $table->string('email', 64)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:有效 0: 删除');
            $table->string('photo', 255)->default('')->nullable();
            $table->tinyInteger('gender')->default(0)->comment('0： 未知 1: 男 2： 女');
            $table->string('addr', 255)->nullable();
            $table->tinyInteger('lock_status')->default(0)->comment('0： 未激活 1：激活  2： 激活锁定');
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
        //
        Schema::dropIfExists('users');
    }
}
