<?php
class Role extends MX_Controller {

	public function __construct() {
		parent::__construct();
		Modules::run('auth/make_sure_is_logged_in');

		$this->load->model('role_m');
	}

	function index()
	{
		$this->load->library('table');

		if(!Modules::run('role/has_role', 'update_permissions'))
		{
			m('w', t('access_denied'));
			redirect('/home');
		}
		else
		{
			if($this->input->post()){
				$roles = $this->input->post();
				unset($roles['submit']);
				foreach ($roles as $id => $role) {
					array_unshift($role, '1');
					$group_ids = serialize($role);
					$this->role_m->update($id, ['group_ids'=>$group_ids], TRUE);
				}
				Modules::run('auth/get_roles');
				m('s', t('rolesAssignedTrue'));
				redirect('/role');
			} else {
				$this->template->title(t('pageTitle'));
				//set the flash data error message if there is one
				$message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				if(!empty($message))
					m('e', $message);

				$this->_set_table('roleList');

				$roles = $this->role_m->getRoles();
				//dump_exit($roles);
				//$groups = $this->ion_auth->groups()->result_array();
				$groups = Modules::run('group/get_groupsObj');

				$groupTitles[] = t('roleNameTitle');

				foreach ($groups as $obj) {
					//if($obj->name == 'administrator') continue;
					$groupTitles[] = humanize($obj->name);
				}

				$this->table->set_heading($groupTitles);

				foreach ($roles as $key => $value) {
					$row[] = "<strong>".humanize($value->role_name)."</strong><br />".$value->role_name;

					foreach ($groups as $group) {
						/*if($group->name == 'administrator') {
							continue;
						} else*/
						$checkBox = (in_array($group->id, $value->group_ids)? $this->_create_check($value->id, $group->id, TRUE) : $this->_create_check($value->id, $group->id, FALSE));
						$row[] = $checkBox;
					}
					$this->table->add_row($row);
					$row = array();
				}
				//$this->table->set_caption(t('otherRoles'));

				$data['printTable'] =  $this->table->generate();
			}

			$data['active'] = 'navigation';
			$data['message'] = m('wn', t('userWithCare'));
			$this->template->parentTitle(t('adminActions'));
			$this->template->build('v_index', $data);
		}

	}



	// Create role
	public function create(){

		if(!Modules::run('role/has_role', 'create_role'))
		{
			m('w', t('access_denied'));
			redirect('/home');
		}

		if(!isset($data['role']) || !is_object($data['role']))
			$data['role'] = $this->_createEmptyRole();
		//$data['role']->id = $roleId;
		$this->template->title(t('createRoleTitle'));

		if($this->input->post()){
			$this->form_validation->set_rules('role_type', 'roleType', 'required|xss_clean');
			$this->form_validation->set_rules('role_name', t('roleName'), 'required|alpha_space|xss_clean');

			if ($this->form_validation->run() == true)
			{
				$data['role']->role_type = $this->input->post('role_type');
				$data['role']->role_name = underscore(strtolower($this->input->post('role_name')));
				$data['role']->group_ids = serialize(array(1=>1));

				if($data['role']->role_type == 1){
					$this->role_m->insert($data['role'], true);
					m('s', t('roleInserted', $data['role']->role_name));
					Modules::run('auth/get_roles');
					redirect('/role');
				} else {
					$originalRole = $data['role']->role_name;
					$roles = Modules::run('pref/_group_roles');
					foreach ($roles as $role) {
						$data['role']->role_name = $role.'_'.$originalRole;
						$this->role_m->insert($data['role'], true);
					}
					m('s', t('groupRoleInserted', $originalRole));
					Modules::run('auth/get_roles');
					redirect('/role');
				}

			} else {
				$data['message'] = m('en', validation_errors());
			}

		} /*else {

			}
		}*/
		Modules::run('auth/get_roles');
		$data['active'] = 'navigation';
		$this->template->parentTitle(t('adminActions'));
		$this->template->build('v_edit_role', $data);
	}

	/**
	 * has_role
	 *
	 * @return bool
	 * @author Ihab Abu Afia
	 **/
	public function has_role($role_check, $check_all = false)
	{
		if (!is_array($role_check))
		{
			$role_check = array($role_check);
		}

		$roles = unserialize($this->session->userdata['roles']);

		foreach ($role_check as $key => $value)
		{
			$roles = (is_string($value)) ? $roles : array_keys($roles);

			/**
			 * if !all (default), in_array
			 * if all, !in_array
			 */
			if (in_array($value, $roles) xor $check_all)
			{
				/**
				 * if !all (default), true
				 * if all, false
				 */
				return !$check_all;
			}
		}

		/**
		 * if !all (default), false
		 * if all, true
		 */
		return $check_all;
	}



	// Create Check Box
	public function _create_check($name, $id, $l=FALSE){
		$hidden = $disabled  = '';
		if($l == true)
			$checked = 'checked=checked';
		else
			$checked = '';
		if($id == 1){
			$disabled = ' disabled';
			$hidden = $this->_create_check_hidden($name, $id, TRUE);
		}

		return '<input type="checkbox" name="'.$name.'[]" value="'.$id.'" '.$checked.' '.$disabled.' />'.$hidden;
	}

	// Create Check Box
	public function _create_check_hidden($name, $id, $l=FALSE){
		return '<input type="hidden" name="'.$name.'[]" value="'.$id.'" />';
	}

	// Set The Table Template
	public function _set_table($id=''){
		if(!empty($id))
			$tId = 'id = "'.$id.'"';
		$tmpl = array (
			'table_open'          => '<table '.$tId.' class="table table-striped table-bordered table-hover smaller" cellspacing="0" width="100%">',
			);

		$this->table->set_template($tmpl);
	}


	// Create Empty Role
	public function _createEmptyRole(){
		$return = new stdClass();
		$return->role_name = '';
		$return->role_type = '';

		return $return;
	}



}
