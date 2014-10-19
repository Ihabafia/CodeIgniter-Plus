<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_session extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'session_id' => array(
				'type' => 'VARCHAR',
				'constraint' => '40'
				),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '16'
				),
			'user_agent' => array(
				'type' => 'VARCHAR',
				'constraint' => '150'
				),
			'last_activity' => array(
				'type' => 'INT',
				'constraint' => '10'
				),
			'user_data' => array(
				'type' => 'TEXT'
				)
			));

		$this->dbforge->add_key('session_id', TRUE);
		$this->dbforge->create_table('ci_sessions');
	}

	public function down()
	{
		$this->dbforge->drop_table('ci_sessions');
	}
}
