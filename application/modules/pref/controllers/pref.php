<?php
class Pref extends MX_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(){

	}

	public function _site_name(){
		$site_name = "Brand";
		return $site_name;
	}

	public function _group_roles(){
		$roles = ['create', 'read', 'update', 'delete'];
		return $roles;
	}

	public function _copyright($lang){

		$author_name = t('businessName');
		return $author_name;
	}
}
