<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_ion_auth extends CI_Migration {

	public function up()
	{
		// Drop table 'ion_groups' if it exists
		$this->dbforge->drop_table('ion_groups');

		// Table structure for table 'ion_groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'discount' => array(
				'type' => 'DECIMAL',
				'constraint' => '4,4',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('ion_groups');

		// Dumping data for table 'ion_groups'
		$data = array(
			array(
				'id' => '1',
				'name' => 'administrator',
				'description' => 'Administrator'
			),
			array(
				'id' => '2',
				'name' => 'members',
				'description' => 'Member'
			)
		);
		$this->db->insert_batch('ion_groups', $data);


		// Drop table 'ion_users' if it exists
		$this->dbforge->drop_table('ion_users');

		// Table structure for table 'ion_users'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'group_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
			),
			'ip_address' => array(
				'type' => 'VARBINARY',
				'constraint' => '16'
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '80',
			),
			'salt' => array(
				'type' => 'VARCHAR',
				'constraint' => '40'
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'
			),
			'activation_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'forgotten_password_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'forgotten_password_time' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'remember_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
			'last_login' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'active' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'first_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			),
			'last_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			),
			'user_code_id' => array(
				'type' => 'VARCHAR',
				'constraint' => '10',
			),
			'mobile' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
				'null' => TRUE
			),
			'company' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			)

		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('ion_users');

		// Dumping data for table 'ion_users'
		// sha1 password is 'password' => '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4',
		$data = array(
			'id' => '1',
			'ip_address' => 0x7f000001,
			'username' => 'administrator',
			'password' => '$2y$08$rzIyTfEQc3uf555IaoPE3u2ZMMShTMWu.qU4e4notrQcBKjHkvFAK',
			'salt' => '9462e8eee0',
			'email' => 'admin@admin.com',
			'activation_code' => '',
			'forgotten_password_code' => NULL,
			'created_on' => '1268889823',
			'last_login' => '1268889823',
			'active' => '1',
			'first_name' => 'Admin',
			'last_name' => 'istrator',
			'company' => 'ADMIN',
			'mobile' => '0',
			'group_id' => 1,
		);
		$this->db->insert('ion_users', $data);


		// Drop table 'ion_users_groups' if it exists
		$this->dbforge->drop_table('ion_users_groups');

		// Table structure for table 'ion_users_groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			),
			'group_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('ion_users_groups');

		// Dumping data for table 'ion_users_groups'
		$data = array(
			array(
				'id' => '1',
				'user_id' => '1',
				'group_id' => '1',
			),
			array(
				'id' => '2',
				'user_id' => '1',
				'group_id' => '2',
			)
		);
		$this->db->insert_batch('ion_users_groups', $data);


		// Drop table 'ion_login_attempts' if it exists
		$this->dbforge->drop_table('ion_login_attempts');

		// Table structure for table 'ion_login_attempts'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'ip_address' => array(
				'type' => 'VARBINARY',
				'constraint' => '16'
			),
			'login' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null', TRUE
			),
			'time' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('ion_login_attempts');
	}

	public function down()
	{
		$this->dbforge->drop_table('ion_users');
		$this->dbforge->drop_table('ion_groups');
		$this->dbforge->drop_table('ion_users_groups');
		$this->dbforge->drop_table('ion_login_attempts');
	}
}
