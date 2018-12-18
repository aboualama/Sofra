<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('facebook')->nullable();
			$table->string('twitter')->nullable();
			$table->string('commission_rate');
			$table->string('instagram')->nullable();
			$table->string('about')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}