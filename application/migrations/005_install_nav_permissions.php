<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_nav_permissions extends CI_Migration {

	public function up()
	{
		// Drop table 'nav_permissions' if it exists
		$this->dbforge->drop_table('nav_permissions');

		// Table structure for table 'nav_permissions'
		$this->dbforge->add_field(array(
			'nav_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'null' => FALSE,
			),
			'group_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'null' => FALSE,
			)
		));
		$this->dbforge->create_table('nav_permissions');

		// Dumping data for table 'navigation'
		$data = array(
			array(
				'nav_id' => '1',
				'group_id' => '1',
			),
			array(
				'nav_id' => '2',
				'group_id' => '1',
			),
			array(
				'nav_id' => '3',
				'group_id' => '1',
			),
			array(
				'nav_id' => '4',
				'group_id' => '1',
			),
			array(
				'nav_id' => '5',
				'group_id' => '1',
			),
			array(
				'nav_id' => '6',
				'group_id' => '1',
			),
			array(
				'nav_id' => '7',
				'group_id' => '1',
			),
			array(
				'nav_id' => '8',
				'group_id' => '1',
			),
		);
		$this->db->insert_batch('nav_permissions', $data);
	}

	public function down()
	{
		$this->dbforge->drop_table('nav_permissions');
	}
}
