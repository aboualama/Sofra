<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->timestamps();
			$table->increments('id');
			$table->integer('restaurant_id')->unsigned();
			$table->string('name');
			$table->string('description');
			$table->decimal('price');
			$table->date('offer_from');
			$table->date('offer_to');
			$table->string('img');
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}