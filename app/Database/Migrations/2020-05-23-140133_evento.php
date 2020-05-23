<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Evento extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'evento' => [
				'type' 		  	 => 'INT',
				'constraint'  	 => 11,
				'unsigned' 	 	 => true,
				'auto_increment' => true
			],
			'nome_evento' => [
				'type'		 => 'VARCHAR',
				'constraint' => 100
			],
			'data'	=> [
				'type' => 'DATE',
				'null' => true
			],
			'vagas'	=>	[
				'type' => 'INT',
				'null' => true
			],
			'hora'	=> [
				'type'	=> 'TIME',
				'null'	=> true
			],
			'valor'	=> [
				'type' 		 => 'DECIMAL',
				'constraint' => '10,2'
			],
			'status' => [
				'type' 	   => 'INT',
				'unsigned' => true
			],
			'cep' => [
				'type'		 => 'VARCHAR',
				'constraint' => 15,
				'null' => true
			],
			'estado' => [
				'type'		 => 'VARCHAR',
				'constraint' => 2,
				'null' => true
			],
			'cidade' => [
				'type'		 => 'VARCHAR',
				'constraint' => 100,
				'null' => true
			],
			'endereco' => [
				'type'		 => 'VARCHAR',
				'constraint' => 150
			],
			'numero' => [
				'type' 	   => 'INT',
				'unsigned' => true,
				'null' => true
			],
			'complemento' => [
				'type'		 => 'VARCHAR',
				'constraint' => 50,
				'null' => true
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

		$this->forge->addKey('evento', true);
		$this->forge->createTable('evento');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('evento');
	}
}
