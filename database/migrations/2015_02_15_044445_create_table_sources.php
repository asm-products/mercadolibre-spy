<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSources extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('analysis_id');
			$table->string('type');
			$table->datetime('last_cron_run');
			$table->string('filters');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sources');
	}

}
