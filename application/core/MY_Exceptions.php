<?php defined('BASEPATH') OR exit('No direct script access allowed');

// application/core/MY_Exceptions.php
class MY_Exceptions extends CI_Exceptions {

	public function __construct() {
		parent::__construct();
	}

	public function _remap($method, $params = array()) {
		try {
			if (!method_exists($this, $method))
				throw new Exception404();
			return call_user_func_array(array($this, $method), $params);
		} catch(Exception404 $e) {
			$this->show_404();
		}
	}

	public function show_404($page = '', $log_error = TRUE)
	{
		include APPPATH . 'config/routes.php';
		// By default we log this, but allow a dev to skip it
		if ($log_error)
		{
			log_message('error', '404 Page Not Found --> '.$page);
		}

		if(!empty($route['404_override']) ){
			$CI =& get_instance();
			$CI->output->set_output('');
			$CI->output->set_status_header('404');

			$h = "404 Page Not Found";
			$m = "The page you requested was not found.";
			echo Modules::run('error',$h,$m);
			//echo $CI->output->get_output();
			exit;
		}
	}
}
