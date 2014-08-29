<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Navigation_m extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->_database   = $this->db;
	}

	// Get All Permissions
	public function getPermissions($group_id = null){
		$group_id || $group_id = $this->session->userdata['group_id'];
		$this->db->order_by('order_p, order_c');
		$this->db->join('nav_permissions', 'navigations.id = nav_permissions.nav_id');
		$this->db->where('group_id', $group_id);
		$permissions = $this->get_all();

		return $permissions;
	}

	public function getNavigation(){
		$this->db->order_by('order_p, order_c');
		$result = $this->get_all();
		return $result;
	}
}
