<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCreateDoctorPatientsTablesTable.
 */
class CreateCreateDoctorPatientsTablesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctor_patients', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id')->defalut(0);
            $table->integer('patient_id')->defalut(0);
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
		Schema::drop('doctor_patients');
	}
}
