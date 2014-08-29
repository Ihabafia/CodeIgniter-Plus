<?php
class Nav_permission extends MX_Controller {

	public function __construct() {
		parent::__construct();

		Modules::run('auth/make_sure_is_logged_in');

		$this->load->model('nav_permission_m');
	}

	public function getPermissions($id){

		return $this->nav_permission_m->getPermissionsM($id);
	}


}
