<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->decimal('delivery_cost')->nullable();
			$table->decimal('app_commission');
			$table->boolean('payment_method');
			$table->decimal('total')->nullable();
			$table->text('note')->nullable();
			$table->enum('status', array('new', 'current', 'old'));
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}