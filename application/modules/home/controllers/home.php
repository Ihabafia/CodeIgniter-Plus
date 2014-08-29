<?php
class Home extends MX_Controller {

	public function __construct() {

		parent::__construct();

		Modules::run('auth/make_sure_is_logged_in');
		$this->load->model('home_m');
	}

	public function index(){

		$this->template->parentTitle('');
		$this->template->title('Home Page');

		$data = [];
		$data['active'] = '';

		$this->template->build('v_index', $data);
	}

	public function change($lang = "english", $class, $method='', $param=""){
		/* $this->config->set_item('lang', $lang); */
		$this->session->set_userdata('lang',$lang);
		$this->lang->is_loaded = array();
		$this->lang->language = array();
		/* $this->lang->load('form_validation', $type);
		$this->lang->load('message', $type); */

		if(empty($method)) $method = 'index';
			redirect("/".$class."/".$method."/".$param);
	}
}
