<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCreateDoctorsTablesTable.
 */
class CreateCreateDoctorsTablesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctors', function(Blueprint $table) {
            $table->increments('id');
 			$table->string('name', 64);
            $table->string('hospital', 64)->default('');
            $table->integer('department')->default(0);
            $table->integer('position')->default(0);
            $table->string('cell', 20)->default('');
            $table->string('saler', 64)->default('');
            $table->string('sale_cell', 20)->default('');
            $table->string('photo', 255)->default('');
            $table->string('uuid', 255)->default('');
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
		Schema::drop('doctors');
	}
}
