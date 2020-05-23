<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NotificacaoPagseguro extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'notificacao' => [
				'type'	=> 'INT',
				'constraint'  	 => 11,
				'unsigned' 	 	 => true,
				'auto_increment' => true
			],
			'notificationCode' => [
				'type'		 => 'VARCHAR',
				'constraint' => 50
			],
			'notificationType' => [
				'type'		 => 'VARCHAR',
				'constraint' => 50
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

		$this->forge->addKey('notificacao', true);
		$this->forge->createTable('notificacao_pagseguro');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('notificacao_pagseguro');
	}
}
