<?php
class Controller extends MX_Controller {

	public function __construct() {
		parent::__construct();

		Modules::run('auth/make_sure_is_logged_in');

		$this->load->model('_m');
	}

	public function index(){


		$data = [
		];

		$this->template->build('v_index', $data);
	}


}