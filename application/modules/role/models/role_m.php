<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_m extends MY_Model {

	public $before_create = array('created_at');

	public function __construct()
	{
		parent::__construct();
		$this->_database   = $this->db;
	}

	// Get All Roles
	public function getRoles(){
		$roles = $this->role_m->order_by(['role_type'=>'ASC', 'created_at'=>'ASC'])->get_all();
		foreach ($roles as $k => $obj) {
			$roles[$k]->group_ids = unserialize($obj->group_ids);
		}

		return $roles;
	}

}
