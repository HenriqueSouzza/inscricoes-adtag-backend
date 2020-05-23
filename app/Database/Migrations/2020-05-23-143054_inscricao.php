<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Inscricao extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'inscricao' => [
				'type'	=> 'INT',
				'constraint'  	 => 11,
				'unsigned' 	 	 => true,
				'auto_increment' => true
			],
			'pessoa' => [
				'type'	 	 	 => 'INT',
				'constraint' 	 => 11,
				'unsigned'		 => true
			],
			'evento' => [
				'type'	 	 	 => 'INT',
				'constraint' 	 => 11,
				'unsigned'		 => true
			],
			'data_inscricao' => [
				'type'	=> 'DATETIME',
			],
			'forma_pagamento' => [
				'type'		 => 'VARCHAR',
				'constraint' => 15
			],
			'data_pagamento' => [
				'type'	=> 'DATETIME',
				'null'	=> true
			],
			'link_boleto' => [
				'type'		 => 'VARCHAR',
				'constraint' => 255,
				'null'	=> true
			],
			'code_transaction' => [
				'type'		 => 'VARCHAR',
				'constraint' => 50
			],
			'status' => [
				'type'		 => 'VARCHAR',
				'constraint' => 5
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

		$this->forge->addKey('inscricao', true);
		$this->forge->addForeignKey('pessoa', 'pessoa', 'pessoa', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('evento', 'evento', 'evento', 'CASCADE', 'CASCADE');
		$this->forge->createTable('inscricao');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('inscricao');
	}
}
