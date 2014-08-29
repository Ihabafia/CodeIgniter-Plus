<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _m extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->_database   = $this->db;
	}

	/*public function xxxxx ()	{

	}*/

}
