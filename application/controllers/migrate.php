<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(ENVIRONMENT != 'development'){
			show_404();
		}
		$this->load->library('migration');
	}

	function latest() {
		$this->load->migration->latest();
	}

	function version($number=0) {
		$x = $this->migration->version($number);
		echo $x;
		/*if ( ! $this->migration->version($number))
		{
			show_error($this->migration->error_string());
		}*/
	}

}
