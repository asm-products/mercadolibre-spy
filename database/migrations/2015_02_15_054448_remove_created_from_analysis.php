<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCreatedFromAnalysis extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('analysis', function(Blueprint $table)
		{
			$table->dropColumn('created');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('analysis', function(Blueprint $table)
		{
			$table->datetime('created');
		});
	}

}
