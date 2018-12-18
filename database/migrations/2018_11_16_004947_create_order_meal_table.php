<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderMealTable extends Migration {

	public function up()
	{
		Schema::create('order_meal', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('order_id')->unsigned();
			$table->integer('meal_id')->unsigned();
			$table->decimal('price');
			$table->integer('qty');
			$table->text('special_order');
		});
	}

	public function down()
	{
		Schema::drop('order_meal');
	}
}