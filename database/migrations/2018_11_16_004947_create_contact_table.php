<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactTable extends Migration {

	public function up()
	{
		Schema::create('contact', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->enum('type', array('suggestion', 'complaint', 'inquiry'));
			$table->string('name');
			$table->string('email')->nullable();
			$table->bigInteger('phone')->nullable();
			$table->longText('message');
		});
	}

	public function down()
	{
		Schema::drop('contact');
	}
}