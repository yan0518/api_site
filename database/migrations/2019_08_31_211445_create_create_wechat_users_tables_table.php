<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCreateWechatUsersTablesTable.
 */
class CreateCreateWechatUsersTablesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wechat_users', function(Blueprint $table) {
            $table->increments('id');
			$table->string('cell', 20)->default('');
			$table->string('subscribe', 255)->default('');
			$table->string('openID', 255)->default('');
			$table->string('nickname', 255)->default('');
            $table->tinyInteger('sex')->default(0)->comment('用户的性别，值为1时是男性，值为2时是女性，值为0时是未知');
			$table->string('city', 255)->default('');
			$table->string('country', 255)->default('');
			$table->string('province', 255)->default('');
			$table->string('language', 255)->default('');
			$table->string('headimgurl', 255)->default('');
			$table->integer('subscribe_time')->default(0);
			$table->string('remark', 255)->default('');
			$table->string('groupid', 255)->default('');
			$table->string('unionid', 255)->default('');
            $table->tinyInteger('status')->default(1)->comment('1:有效 0: 删除');
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
		Schema::drop('wechat_users');
	}
}
