<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_roles extends CI_Migration {

	public function up()
	{
		// Drop table 'roles' if it exists
		$this->dbforge->drop_table('roles');

		// Table structure for table 'roles'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'role_type' => array(
				'type' => 'INT',
				'constraint' => '1',
			),
			'role_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '150',
			),
			'group_ids' => array(
				'type' => 'VARCHAR',
				'constraint' => '1000'
			),
			'created_at' => array(
				'type' => 'TIMESTAMP',
				'null' => true,
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('roles');

		// Dumping data for table 'roles'
		$data = array(
			array(
			'id' => '1',
			'role_type' => '1',
			'role_name' => 'cannot_edit_his_own_group',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '2',
			'role_type' => '2',
			'role_name' => 'create_menu',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '3',
			'role_type' => '2',
			'role_name' => 'read_menu',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '4',
			'role_type' => '2',
			'role_name' => 'update_menu',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '5',
			'role_type' => '2',
			'role_name' => 'delete_menu',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '6',
			'role_type' => '1',
			'role_name' => 'update_permissions',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),			array(
			'id' => '7',
			'role_type' => '2',
			'role_name' => 'create_users',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '8',
			'role_type' => '2',
			'role_name' => 'read_users',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '9',
			'role_type' => '2',
			'role_name' => 'update_users',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '10',
			'role_type' => '2',
			'role_name' => 'delete_users',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '11',
			'role_type' => '1',
			'role_name' => 'allow_to_activate_user',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '12',
			'role_type' => '1',
			'role_name' => 'allow_to_deactivate_user',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '13',
			'role_type' => '1',
			'role_name' => 'create_role',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
			array(
			'id' => '14',
			'role_type' => '1',
			'role_name' => 'create_group',
			'group_ids' => 'a:1:{i:1;i:1;}',
			'created_at' => '2014-08-16 03:22:11',
			),
		);

		$this->db->insert_batch('roles', $data);
	}

	public function down()
	{
		$this->dbforge->drop_table('roles');
	}
}
