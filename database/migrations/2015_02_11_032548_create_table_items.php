<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItems extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('analysis_id');
			$table->integer('source_id');
			$table->string('following');
			$table->string('meli_id');
			$table->datetime('finish_date');
			$table->string('title');
			$table->datetime('published_at');
			$table->integer('seller_id');
			$table->float('price');
			$table->string('currency');
			$table->string('buying_mode');
			$table->string('category_id');
			$table->integer('sold');
			$table->integer('visits');
			$table->integer('available_units');
			$table->string('publication_type');
			$table->datetime('last_cron_run');
			$table->string('url');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('items');
	}

}
