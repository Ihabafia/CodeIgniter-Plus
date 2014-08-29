<?php
class Error extends MX_Controller {

	public function __construct() {
		parent::__construct();

		//$this->load->model('error_m');
		$this->load->language('error');
	}

	public function index()
	{
		$data['site_name'] = Modules::run('pref/_site_name');
		$data['title'] = $this->lang->line('not_found');
		$data['header'] = $this->load->view('blocks/header.php', $data, true);
		$data['nav'] = Modules::run('navigation/build');
		$data['body'] = $this->load->view('v_error', array(), true);
		$data['copyright'] = $this->load->view('blocks/copyright', array(), true);

		$this->load->view('show_error', $data);
	}

}
