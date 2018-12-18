<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMealsTable extends Migration {

	public function up()
	{
		Schema::create('meals', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('restaurant_id')->unsigned();
			$table->string('name');
			$table->string('description');
			$table->decimal('price');
			$table->string('processing_time');
			$table->string('img');
		});
	}

	public function down()
	{
		Schema::drop('meals');
	}
}