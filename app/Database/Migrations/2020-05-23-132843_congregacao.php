<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
//use Config\Database;

class Congregacao extends Migration
{
	// private $forge;

	// public function __constructor(Database $forge)
	// {
	// 	$this->forge = $forge::forge();
	// }


	public function up()
	{
		$this->forge->addField([
			'congregacao' => [
				'type'	 	 	 => 'INT',
				'constraint' 	 => 5,
				'unsigned'	 	 => true,
				'auto_increment' => true
			],
			'regiao' => [
				'type'		=> 'INT',
				'unsigned'	=> true
			],
			'nome_congregacao' => [
				'type'		 => 'VARCHAR',
				'constraint' => 100,
			],
			'created_at' => [
				'type'	=> 'DATETIME',
				'null'	=> true
			],
			'updated_at' => [
				'type'	=> 'DATETIME',
				'extra' => 'on update CURRENT_TIMESTAMP',
				'null'	=> true
			],
			'deleted_at' => [
				'type'	=> 'DATETIME',
				'null'	=> true
			],
		]);

		$this->forge->addKey('congregacao', true);

		$this->forge->createTable('congregacao');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('congregacao');
	}
}
