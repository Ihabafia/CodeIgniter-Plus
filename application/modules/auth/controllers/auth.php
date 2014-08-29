<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('my_auth');
		$this->load->database();

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		Modules::run('auth/make_sure_is_logged_in');
	}

	//redirect if needed, otherwise display the user list
	function index() {
		if (!Modules::run('role/has_role', 'read_users')) //remove this elseif if you want to enable this for non-admins
		{
			m('w', t('access_denied'));
			redirect('/home');
		}
		else
		{
			$this->template->title(t('adminList'));
			//set the flash data error message if there is one
			$message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			if(!empty($message))
				$data['message'] = m('en', $message);

			//list the users
			$data['users'] = $this->auth_m->users();
		}

		if(!is_array($data) || !isset($data)) $data =[];
		//$admin = $this->my_auth->in_group('admin'); echo $admin;
		$data['active'] = "users";
		$this->template->parentTitle(t('adminActions'));
		$this->template->build('v_index', $data);
	}

	//log the user in
	function login() {
		if ($this->my_auth->logged_in()) {
			redirect('/home');
		}

		if($this->input->post()){
			//validate form input
			$this->form_validation->set_rules('identity', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() != true)
			{
				$data['message'] = m('en', validation_errors());
			} else {
				if ($this->my_auth->login($this->input->post('identity', TRUE), $this->input->post('password', TRUE)))
				{
					//Get User Roles
					$this->get_roles();

					$direct = $this->session->userdata('direct');

					if (isset($direct) && $direct != 'favicon.ico') {
						$this->session->unset_userdata('direct');
					} else{
						$direct = '/home';
					}
					redirect($direct);
				}
				else
				{
					$data['message'] = m('en', $this->my_auth->errors());
				}
			}
		}

		if(!isset($data) or !is_array($data)) $data =[];
		$this->template->title(t('login'));
		$this->template->set_layout('login');
		$this->template->build('v_login', $data);
	}

	public function get_roles($id=null){

		$id || $id = $this->session->userdata('group_id');

		$roles = $this->roles($id);
		$this->set_session($roles);
	}

	public function roles($id=null){

		$id || $id = $this->session->userdata('group_id');
		return $this->auth_m->get_all_roles($id);
	}

	public function set_session($vars){

		$this->session->set_userdata('roles', $vars);
	}
	//log the user out
	function logout() {
		if(!$this->session->userdata('user_id')){
			m('w', t('loggedOut'));
			redirect('/login');
		}
		$this->my_auth->logout();
		m('s', $this->my_auth->messages());
		redirect('/login');
	}

	//Create or Edit a user
	function edit($id=null)	{
		if($id != null){
			//Edit User
			if (!$this->my_auth->logged_in() || (!$this->my_auth->is_admin() && !($this->my_auth->user()->row()->id == $id)))
			{
				redirect('auth');
			}

			$passwordChanged = false;
			$user = $this->my_auth->user($id)->row();
			if(!is_object($user))
				redirect('auth/edit');
			//$groups=$this->my_auth->groups()->result_array();
			//$currentGroups = $this->my_auth->get_users_groups($id)->result();

			$this->template->title(t('editUserTitle', $this->_fullname($user)));

			//validate form input
			$this->form_validation->set_rules('email', t('edit_user_validation_email_label'), 'required|valid_email|xss_clean');
			$this->form_validation->set_rules('mobile', t('mobile'), 'required|xss_clean');
			if ($this->my_auth->is_admin())
			{
				$this->form_validation->set_rules('user_code_id', t('userCodeId'), 'required|xss_clean');
				$this->form_validation->set_rules('username', t('username'), 'required|xss_clean');
				$this->form_validation->set_rules('first_name', t('edit_user_validation_fname_label'), 'required|xss_clean');
				$this->form_validation->set_rules('last_name', t('edit_user_validation_lname_label'), 'required|xss_clean');
				$this->form_validation->set_rules('group_id', t('edit_user_validation_groups_label'), 'required');
			}

			if($this->input->post()){
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id', TRUE))
				{
					$data['message'] = m('en', t('error_csrf'));
				}

				$data = array(
					'email'			=> $this->input->post('email', TRUE),
					'mobile'		=> $this->input->post('mobile', TRUE),
				);


				// Only allow updating groups if user is admin
				if ($this->my_auth->is_admin())
				{
					$data['user_code_id']	= $this->input->post('user_code_id', TRUE);
					$data['first_name']	= $this->input->post('first_name', TRUE);
					$data['last_name']	= $this->input->post('last_name', TRUE);
					$data['group_id']	= $this->input->post('group_id', TRUE);
				}

				//update the password if it was posted
				if ($this->input->post('password') or $this->input->post('password_confirm', TRUE))
				{
					$this->form_validation->set_rules('password', t('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
					$this->form_validation->set_rules('password_confirm', t('edit_user_validation_password_confirm_label'), 'required|matches[password]');
					$passwordChanged = true;
					$data['password'] = $this->input->post('password', TRUE);
				}

				if ($this->form_validation->run() === TRUE)
				{
					if($this->my_auth->update($user->id, $data)){
						m('s', t('userEdited', $this->_fullname($user)));
						if(!$this->my_auth->is_admin() and $passwordChanged){
							$this->my_auth->logout();
							m('s', t('passwordChanged'));
							redirect('/login');
						}
						if($this->my_auth->is_admin())
							redirect('auth');
						else
							redirect('/auth/edit/'.$id);
					} else {
						m('e', $this->my_auth->errors());
					}
				} else {
					$data['message'] = m('en', validation_errors());
				}
			}

			//display the edit user form
			$data['csrf'] = $this->_get_csrf_nonce();
			$data['id'] = $user->id;

			//pass the user to the view
			$data['user'] = $user;
			$data['groups_options'] = Modules::run('group/get_groups');

		} else {
			// Add User
			$this->template->title(t('createUser'));
			$tables = $this->config->item('tables','ion_auth');

			if(!isset($data['user']) || !is_object($data['user']))
				$data['user'] = $this->_createEmptyUser();

			$data['id'] = '';
			$data['csrf'] = '';
			$data['groups_options'] = Modules::run('group/get_groups');

			if($this->input->post()){
				//validate form input
				$this->form_validation->set_rules('user_code_id', t('userCodeId'), 'required|xss_clean');
				$this->form_validation->set_rules('username', t('username'), 'required|xss_clean');
				$this->form_validation->set_rules('password', t('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', t('create_user_validation_password_confirm_label'), 'required|matches[password]');
				$this->form_validation->set_rules('first_name', t('create_user_validation_fname_label'), 'required|xss_clean');
				$this->form_validation->set_rules('last_name', t('create_user_validation_lname_label'), 'required|xss_clean');
				$this->form_validation->set_rules('email', t('create_user_validation_email_label'), 'required|valid_email|is_unique['.$tables['users'].'.email]');
				$this->form_validation->set_rules('mobile', t('mobile'), 'required|xss_clean');
				$this->form_validation->set_rules('group_id', t('group'), 'required');

				if ($this->form_validation->run() == true)
				{
					$username = strtolower($this->input->post('username', TRUE));
					$email    = strtolower($this->input->post('email', TRUE));
					$password = $this->input->post('password', TRUE);

					$additional_data = array(
						'user_code_id'	=> $this->input->post('user_code_id', TRUE),
						'first_name'	=> $this->input->post('first_name', TRUE),
						'last_name'		=> $this->input->post('last_name', TRUE),
						'mobile'		=> $this->input->post('mobile', TRUE),
						'group_id'		=> $this->input->post('group_id', TRUE),
					);

					if($this->my_auth->register($username, $password, $email, $additional_data)){

						//check to see if we are creating the user
						//redirect them back to the admin page
						m('s', $this->my_auth->messages());
						redirect("/auth");
					} else {
						$data['message'] = m('en', $this->my_auth->errors());
					}
				} else {
					$data['message'] = m('en', validation_errors());
				}
			}
		}

		$data['active'] = "users";
		$this->template->parentTitle(t('adminActions'));
		$this->template->build('v_edit_user', $data);
	}

	//forgot password
	function forgot_password()
	{
		if ($this->my_auth->logged_in()) {
			redirect('/home');
		}

		if($this->input->post()){

			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$this->form_validation->set_rules('email', t('username'), 'required|xss_clean');
			}
			else
			{
				$this->form_validation->set_rules('email', t('email'), 'required|valid_email');
			}


			if ($this->form_validation->run() != true)
			{
				$data['message'] = m('en', validation_errors());
			}
			else
			{
				// get identity from username or email
				if ( $this->config->item('identity', 'ion_auth') == 'username' ){
					$identity = $this->my_auth->where('username', strtolower($this->input->post('email', TRUE)))->users()->row();
				}
				else
				{
					$identity = $this->my_auth->where('email', strtolower($this->input->post('email', TRUE)))->users()->row();
				}

				if(empty($identity)) {
					m('e', t('forgot_password_email_not_found'));
					//$this->session->set_flashdata('message', $this->my_auth->messages());
					redirect("forgot_password");
				}

				//run the forgotten password method to email an activation code to the user
				$forgotten = $this->my_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

				if ($forgotten)
				{
					//if there were no errors
					//$this->session->set_flashdata('message', $this->my_auth->messages());
					m('s', $this->my_auth->messages());
					redirect("login"); //we should display a confirmation page here instead of the login page
				}
				else
				{
					$this->session->set_flashdata('message', $this->my_auth->errors());
					m('e', $this->my_auth->errors());
					redirect("forgot_password");
				}
			}
		}

		if ( $this->config->item('identity', 'ion_auth') == 'username' ){
			$data['identity_label'] = $this->lang->line('username');
			$data['icon'] = '<span class="glyphicon glyphicon-user"></span>';
		}
		else
		{
			$data['identity_label'] = $this->lang->line('email');
			$data['icon'] = '<span class="glyphicon glyphicon-envelope"></span>';
		}


		$this->template->title(t('forgot_password'));
		$this->template->set_layout('login');
		$this->template->build('v_forgot_password', $data);
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if ($this->my_auth->logged_in()) {
			redirect('/home');
		}

		if (!$code)
		{
			show_404();
		}

		$user = $this->my_auth->forgotten_password_check($code);

		if ($user)
		{

			if($this->input->post()){
				//if the code is valid then display the password reset form
				$this->form_validation->set_rules('new', t('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
				$this->form_validation->set_rules('new_confirm', t('reset_password_validation_new_password_confirm_label'), 'required|matches[new]');

				if ($this->form_validation->run() != true)
				{
					//display the form

					//set the flash data error message if there is one
					$data['message'] = m('en', validation_errors());
					//$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
					//render
					//$this->_render_page('auth/reset_password', $data);
				}
				else
				{
					// do we have a valid request?
					if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id', TRUE))
					{

						//something fishy might be up
						$this->my_auth->clear_forgotten_password_code($code);

						m('w', t('error_csrf'));
						redirect('login');

					}
					else
					{
						// finally change the password
						$identity = $user->{$this->config->item('identity', 'ion_auth')};

						$change = $this->my_auth->reset_password($identity, $this->input->post('new', TRUE));

						if ($change)
						{
							//if the password was successfully changed
							m('s', $this->my_auth->messages());
							//$this->session->set_flashdata('message', $this->my_auth->messages());
							//$this->logout();
							redirect('login');
						}
						else
						{
							m('e', $this->my_auth->errors());
							//$this->session->set_flashdata('message', $this->my_auth->errors());
							redirect('reset_password/' . $code);
						}
					}
				}
			}

			$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$data['min_password_length'].'}.*$',
				'class'=> 'form-control',
				'placeholder' => t('new_passwordPH'),
			);
			$data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$data['min_password_length'].'}.*$',
				'class'=> 'form-control',
				'placeholder' => t('n_p_confirmPH'),
			);
			$data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			$data['csrf'] = $this->_get_csrf_nonce();
			$data['code'] = $code;


			$this->template->title(t('forgot_password'));
			$this->template->set_layout('login');
			$this->template->build('v_reset_password', $data);
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			m('e', $this->my_auth->errors());
			//$this->session->set_flashdata('message', $this->my_auth->errors());
			redirect("forgot_password");
		}
	}

	//activate the user
	function activate($id, $code=false)
	{
		if ($code !== false) {
			$activation = $this->my_auth->activate($id, $code);
		} else if (Modules::run('role/has_role', 'allow_to_activate_user')){
			$activation = $this->my_auth->activate($id);
		} else {
			m('w', t('notAuthorized', t('activate')));
			redirect('home');
		}

		if ($activation)
		{
			//redirect them to the auth page
			//$this->session->set_flashdata('message', $this->my_auth->messages());
			m('s', $this->my_auth->messages());
			redirect("auth");
		}
		else
		{
			//redirect them to the forgot password page
			//$this->session->set_flashdata('message', $this->my_auth->errors());
			m('e', $this->my_auth->errors());
			redirect("forgot_password");
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		$id = (int) $id;
		if($id == 1){
			m('w', t('notAllowedDeactivateAdmin'));
			redirect('home');
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', t('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', t('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$data['csrf'] = $this->_get_csrf_nonce();
			$data['user'] = $this->my_auth->user($id)->row();

			$data['active'] = "users";
			$this->template->parentTitle(t('adminActions'));
			$this->template->title(t('deactivate_heading'));
			$this->template->build('v_deactivate_user', $data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm', TRUE) == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id', TRUE))
				{
					//show_error($this->lang->line('error_csrf'));
					m('e', $this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->my_auth->logged_in() && Modules::run('role/has_role', 'allow_to_deactivate_user'))
				{
					$this->my_auth->deactivate($id);
					m('s', t('deactivate_success'));
				} else {
					m('w', t('notAuthorized', t('deactivate')));
				}
			}

			//redirect them back to the auth page
			redirect('auth');
		}
	}

	// create a new group
	function create_group()
	{
		if (!Modules::run('role/has_role', 'create_group')) {
			m('w', t('notAuthorized', t('createGroup')));
			redirect('/home');
		}

		if($this->input->post()){
			//validate form input
			$this->form_validation->set_rules('group_name', t('create_group_validation_name_label'), 'required|alpha_dash|xss_clean');
			$this->form_validation->set_rules('description', t('create_group_validation_desc_label'), 'xss_clean');

			if ($this->form_validation->run() == TRUE)
			{
				$new_group_id = $this->my_auth->create_group($this->input->post('group_name', TRUE), $this->input->post('description', TRUE));
				if($new_group_id)
				{
					m('s', $this->my_auth->messages());
					redirect("auth");
				}
			}
			else
			{
				$data['message'] = m('en', validation_errors());
			}
		}

		$data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_name'),
		);
		$data['description'] = array(
			'name'  => 'description',
			'id'    => 'description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('description'),
		);

		//$this->_render_page('auth/create_group', $this->data);
		$data['active'] = "users";
		$this->template->title(t('create_group_title'));
		$this->template->build('v_create_group', $data);
	}

	//edit a group
	function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('auth');
		}

		/*if (!$this->my_auth->logged_in() || !$this->my_auth->is_admin())
		{
			redirect('auth');
		}*/
		if($this->input->post()){
			//validate form input
			$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash|xss_clean');
			$this->form_validation->set_rules('group_description', $this->lang->line('edit_group_validation_desc_label'), 'xss_clean');

			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->my_auth->update_group($id, $this->input->post('group_name', TRUE), $this->input->post('group_description', TRUE));

				if($group_update)
				{
					//$this->session->set_flashdata('message', t('edit_group_saved'));
					m('s', t('edit_group_saved'));
				}
				else
				{
					//$this->session->set_flashdata('message', $this->my_auth->errors());
					m('e', t($this->my_auth->errors()));
				}
				redirect("auth");
			}
		}

		$group = $this->my_auth->group($id)->row();


		//pass the user to the view
		$data['group'] = $group;

		$data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_name', $group->name),
		);
		$data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);
		//$this->_render_page('auth/edit_group', $this->data);
		$data['active'] = "users";
		$this->template->title(t('edit_group_titleS', $group->name));
		$this->template->build('v_edit_group', $data);
	}








	/*
	 * 		Checking the session in ajax to logout
	 * 		if the session is expired
	 */
	public function checkSession() {
		if (!($this->session->userdata('user_id'))) {
			$data['session'] = 'Expired';
			echo json_encode($data);
			return;
		}
	}


	function _fullname($obj){
		if(is_object($obj)){
			return $obj->first_name.' '.$obj->last_name;
		}
	}

	// Create Empty User
	function _createEmptyUser(){
		$return					= new stdClass();
		$return->user_code_id	= '';
		$return->username		= '';
		$return->password		= '';
		$return->passwordConf	= '';
		$return->first_name		= '';
		$return->last_name		= '';
		$return->mobile			= '';
		$return->email			= '';
		$return->group_id		= '';

		return $return;
	}

	function _get_csrf_nonce() {
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce() {
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function make_sure_is_logged_in() {
		/*$this->load->library('auth/ion_auth');
		$this->load->library('auth/my_auth');*/
		/*$this->load->library('bcrypt');*/

		$no_redirect = array('login', 'logout', 'forgot_password', 'reset_password');
		if (!$this->my_auth->logged_in() && !in_array($this->router->method, $no_redirect)) {
			$this->session->set_userdata('direct', current_url());
			redirect('/login');
		}

		return true;
	}

	function fullname(){
		//$this->make_sure_is_logged_in();
		//$data['widget'] = '<span class="glyphicon glyphicon-user"></span> '.$this->session->userdata('fullname');
		return anchor('auth/edit/'.$this->session->userdata('user_id'),'<span class="glyphicon glyphicon-user"></span> '.$this->session->userdata('fullname'));
		//$this->load->view('v_widget',$data);
	}

}
