<?php
class Group extends MX_Controller {


	public function __construct() {
		parent::__construct();

		Modules::run('auth/make_sure_is_logged_in');

		$this->load->model('group_m');
		$this->_table = 'ion_groups';
		$this->_database   = $this->db;

	}

	/*public function _remap()
	{
		show_404('No direct access allowed');
	}*/

	public function index(){
		//$this->template->set_theme('ehab_theme');
		//$this->template->set_layout('one_col');

		//$this->template->set_partial('subHeading',	'blocks/homeSH');
		//$this->template->set_partial('js',			'blocks/homeJS');

		//m('e', t('cantDelete'));

		$data = [
		];

		$this->template->build('v_index', $data);
	}

	// Get all Groups
	public function get_groups(){
		//$group_options[0] = t('chooseGroup');
		$group_options = $this->group_m->dropdown('description');
		array_unshift_assoc($group_options, "", t('chooseGroup'));
		if($this->session->userdata['group_name'] == 'administrator')
			unset($group_options['1']);
		if($this->session->userdata['group_name'] == 'sales_director'){
			unset($group_options['1']);
			unset($group_options['2']);
		}

		//array_unshift($group_options, t('chooseGroup'));

		return $group_options;
	}

	// Get all groups as Object
	public function get_groupsObj(){
		return $this->group_m->get_all();
	}


}