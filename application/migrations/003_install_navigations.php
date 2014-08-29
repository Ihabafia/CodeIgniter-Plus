<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_navigations extends CI_Migration {

	public function up()
	{
		// Drop table 'navigations' if it exists
		$this->dbforge->drop_table('navigations');

		// Table structure for table 'navigations'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'title_en' => array(
				'type' => 'VARCHAR',
				'constraint' => '80',
			),
			'title_ar' => array(
				'type' => 'VARCHAR',
				'constraint' => '80',
			),
			'url' => array(
				'type' => 'VARCHAR',
				'constraint' => '300',
			),
			'parent_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'DEFAULT' => 0
			),
			'class' => array(
				'type' => 'VARCHAR',
				'constraint' => '30',
			),
			'order_p' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'DEFAULT' => 0
			),
			'order_c' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'DEFAULT' => 0
			),
			'group_ids' => array(
				'type' => 'VARCHAR',
				'constraint' => '1000',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('navigations');

		// Dumping data for table 'navigation'
		$data = array(
			array(
				'id' => '1',
				'title_en' => 'Navigation',
				'url' => '#',
				'parent_id' => '0',
				'class' => 'navigation',
				'order_p' => '1',
				'order_c' => '0',
			),
			array(
				'id' => '2',
				'title_en' => 'Manage Menus',
				'url' => '/navigation',
				'parent_id' => '1',
				'class' => 'navigation',
				'order_p' => '1',
				'order_c' => '1',
			),
			array(
				'id' => '3',
				'title_en' => 'Create Menu Item',
				'url' => '/navigation/create',
				'parent_id' => '1',
				'class' => 'navigation',
				'order_p' => '1',
				'order_c' => '2',
			),
			array(
				'id' => '4',
				'title_en' => 'Menu Permissions',
				'url' => '/navigation/permissions',
				'parent_id' => '1',
				'class' => 'navigation',
				'order_p' => '1',
				'order_c' => '3',
			),
			array(
				'id' => '5',
				'title_en' => '---',
				'url' => '#',
				'parent_id' => '1',
				'class' => '',
				'order_p' => '1',
				'order_c' => '4',
			),
			array(
				'id' => '6',
				'title_en' => 'Manage Roles',
				'url' => '/role',
				'parent_id' => '1',
				'class' => 'navigation',
				'order_p' => '1',
				'order_c' => '5',
			),
			array(
				'id' => '7',
				'title_en' => 'Users',
				'url' => '#',
				'parent_id' => '0',
				'class' => 'users',
				'order_p' => '7',
				'order_c' => '0',
			),
			array(
				'id' => '8',
				'title_en' => 'Manage Users',
				'url' => '/auth',
				'parent_id' => '7',
				'class' => 'users',
				'order_p' => '7',
				'order_c' => '1',
			),
		);
		$this->db->insert_batch('navigations', $data);
	}

	public function down()
	{
		$this->dbforge->drop_table('navigations');
	}
}
