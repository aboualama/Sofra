<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->integer('area_id')->unsigned();
			$table->string('email')->nullable();
			$table->string('password');
			$table->enum('delivery_time', array('c', 'd', 'b', 'a'));
			$table->enum('delivery_method', array('c', 'd', 'b', 'a'))->nullable();
			$table->integer('minimum')->unsigned()->nullable();
			$table->integer('delivery_fee')->unsigned()->nullable();
			$table->string('phone');
			$table->string('whatsapp')->nullable();
			$table->string('img')->nullable();
			$table->boolean('status');
			$table->string('api_token', 60);
            $table->string('pin_code')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}