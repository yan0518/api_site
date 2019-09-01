<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePatientsTable.
 */
class CreatePatientsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patients', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64)->default('');
            $table->string('cell', 64)->default('');
            $table->string('birthday', 64)->default('');
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
		Schema::drop('patients');
	}
}
