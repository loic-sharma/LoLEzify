<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChampionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('champions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->boolean('top');
			$table->boolean('mid');
			$table->boolean('jungler');
			$table->boolean('adc');
			$table->boolean('support');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('champions');
	}

}
