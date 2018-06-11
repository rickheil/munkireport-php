<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class Sophos extends Migration
{
	private $tableName = 'sophos';

	public function up()
	{
		$capsule = new Capsule();
        $migrateData = false;
		
		$capsule::schema()->create($this->tableName, function (Blueprint $table) {
        $table->increments('id');

		$table->string('serial_number')->unique();
		$table->string('installed');
		$table->string('running');
		$table->string('product_version');
		$table->string('engine_version');
		$table->string('virus_data_version');
		$table->string('user_interface_version');

		$table->index('serial_number');
		$table->index('installed');
		$table->index('running');
		$table->index('product_version');
		$table->index('engine_version');
		$table->index('virus_data_version');
		$table->index('user_interface_version');

	});
	}

	public function down()
	{
	// todo
	}
}	
		
