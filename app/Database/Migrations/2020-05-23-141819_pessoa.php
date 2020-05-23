<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pessoa extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'pessoa' => [
				'type'	=> 'INT',
				'constraint'  	 => 11,
				'unsigned' 	 	 => true,
				'auto_increment' => true
			],
			'nome_compl' => [
				'type'		 => 'VARCHAR',
				'constraint' => 100
			],
			'cpf' => [
				'type'		 => 'VARCHAR',
				'constraint' => 15
			],
			'email' => [
				'type'		 => 'VARCHAR',
				'constraint' => 150
			],
			'telefone' => [
				'type'		 => 'VARCHAR',
				'constraint' => 50
			],
			'data_nascimento'	=> [
				'type' => 'DATE',
			],
			'sexo' => [
				'type' => 'CHAR',
				'constraint' => 1
			],
			'congregacao' => [
				'type'	 	 	 => 'INT',
				'constraint' 	 => 11,
				'unsigned'		 => true
			],
			'senha' => [
				'type'		 => 'VARCHAR',
				'constraint' => 255
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

		$this->forge->addKey('pessoa', true);
		$this->forge->addForeignKey('congregacao', 'congregacao', 'congregacao', 'CASCADE', 'CASCADE');
		$this->forge->createTable('pessoa');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('pessoa');
	}
}
