<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Model
*
* Version: 2.6.0
*
* Author:  Ben Edmunds
* 		   ben.edmunds@gmail.com
*	  	   @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Last Change: 3.22.13
*
* Changelog:
* * 3-22-13 - Additional entropy added - 52aa456eef8b60ad6754b31fbdcc77bb
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

class Auth_m extends MY_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->config('auth/ion_auth', TRUE);
		$this->join			   = $this->config->item('join', 'ion_auth');
		$this->tables		   = $this->config->item('tables', 'ion_auth');
	}


	// Get All Roles of a User
	public function get_all_roles($id=null){
		$user_roles = [];
		$this->load->model('role/role_m');
		$all_roles = $this->role_m->get_all();
		foreach ($all_roles as $role) {
			$groups = unserialize($role->group_ids);
			if(in_array($id, $groups))
				$user_roles[$role->id] = $role->role_name;
		}

		if(is_array($user_roles))
			return serialize($user_roles);

		return false;
	}

	/**
	 * Get User Object
	 *
	 * @return bool
	 * @author Ihab Abu Afia
	 **/
	public function users($id=""){
		/*->select($this->identity_column . ', username, email, '.$this->tables['users'].'.id, first_name, last_name, password, active, last_login, group_id, '.$this->tables['groups'].'.name, '.$this->tables['groups'].'.description, '.$this->tables['groups'].'.discount, '.$this->tables['groups'].'.roles')*/
		if($id)
			$this->db->where($this->tables['users'].'.id',$id);
		$query =
				$this->db->select('*, '.$this->tables['groups'].'.name as group_name, '.$this->tables['users'].'.id as id ')
				->join($this->tables['groups'], $this->tables['users'].'.'.$this->join['groups'].' = '.$this->tables['groups'].'.id', 'left')
				->get($this->tables['users']);
		return $query->result();
	}


}

