<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nav_permission_m extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->_database   = $this->db;
	}

	// Get All Permissions
	public function getPermissionsM($nav_id){
		$permissions = $this->get_many_by('nav_id', $nav_id);
		if(count($permissions) > 0){
			foreach ($permissions as $permission) {
				$result[] = $permission->group_id;
			}
		} else {
			$result = array();
		}

		return $result;
	}

}
