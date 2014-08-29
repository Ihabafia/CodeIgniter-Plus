<?php
class Navigation extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('navigation_m');
		$this->form_validation->set_error_delimiters('<div>', '</div>');
	}

	public function _remap($method, $params = array())
	{
	    $method = 'process_'.$method;
	    if (method_exists($this, $method))
	    {
	        return call_user_func_array(array($this, $method), $params);
	    }
	    show_404();
	}

	public function process_index(){
		if(!Modules::run('role/has_role', 'read_menu'))
		{
			m('w', t('access_denied'));
			redirect('home');
		}
		$this->db->order_by('order_p, order_c');
		$menu_array = $this->navigation_m->get_all();
		$list = ''; $ol = false;
		$s = 0;
		for ($m=0; $m < count($menu_array); $m++) {
			$item = $menu_array[$m];
			if($item->parent_id == 0){ //main item
				$tree[$s] = array('id' => $item->id);
				$pId = $item->id;
				$pIdm = $s;
				$s++;
				$list .='
					<li id="element-'.$item->id.'" class="dd-item dd3-item" data-id="'.$item->id.'">
						<div class="dd-handle dd3-handle"> </div><div class="dd3-content">'.$item->title_en.' ==> <a href="navigation/create/'.$item->id.'">'.t('edit').'</a> -- <a href="#" id="navDelete-' . $item->id . '" class="delnav" >'.t('delete').'</a></div>';
				if($m+1 < count($menu_array) and $menu_array[$m+1]->parent_id != 0){
					$list .='<ol class="dd-list">';
					$ol = true;
				} else {
					$list .='</li>';
				}
			} elseif ($item->parent_id > 0){ //Sub item
				$extra_class = ($item->title_en == '---' or strcasecmp($item->title_en, 'divider') == 0)? 'separator':'';
				if($item->parent_id == $pId){
					$tree[$pIdm]['children'][$item->order_c-1] = array('id' => $item->id);
					$list .= '
						<li id="element-'.$item->id.'" class="dd-item dd3-item" data-id="'.$item->id.'">
							<div class="dd-handle dd3-handle"></div><div class="dd3-content '.$extra_class.'">'.$item->title_en.' ==> <a href="navigation/create/'.$item->id.'">'.t('edit').'</a> -- <a href="#" id="navDelete-' . $item->id . '" class="delnav" >'.t('delete').'</a></div>
						</li>';
					if(($m+1 < count($menu_array) and $menu_array[$m]->parent_id != 0 and $menu_array[$m+1]->parent_id == 0)){
						$list .= '</ol></li>';
						$ol = false;
					}
				}
			}
		}
		if($ol) $list .= '</ol></li>';

		$data['list'] = $list;
		$data['active'] = 'navigation';

		$this->template->set_metadata('', APPPATH.'modules/navigation/_assets/js/jquery.nestable.js', 'js');
		$this->template->set_metadata('', APPPATH.'modules/navigation/_assets/js/ajax.js', 'js');
		$this->template->set_metadata('', base_url().'_assets/js/jquery-ui-1.10.3.custom.min.js', 'js');
		$this->template->parentTitle(t('adminActions'));
		$this->template->title(t('navigationSort'));

		$this->template->build('v_index', $data);
	}

	public function process_permissions(){
		if(!Modules::run('role/has_role', 'update_permissions'))
		{
			m('w', t('access_denied'));
			redirect('home');
		}

		if($this->input->post()){
			$permissions = $this->input->post();
			unset($permissions['submit']);
			$this->db->truncate('nav_permissions');
			$this->load->module('nav_permission');
			foreach ($permissions as $id => $nav_id) {
				foreach ($nav_id as $group_id) {
					$data['nav_id'] = $id;
					$data['group_id'] = $group_id;

					$this->nav_permission_m->insert($data, true);
				}
			}

			m('s', t('permissionsAssignedTrue'));
			$this->session->unset_userdata('menu_data');
			redirect('/navigation/permissions');
		}
		$this->load->library('table');

		$groups = Modules::run('group/get_groupsObj');
		$groupTitles[] = t('menuPermissionTitle');

		foreach ($groups as $obj) {
			$groupTitles[] = humanize($obj->name);
		}

		$tmpl = ['table_open' => '<table id="permissions" class="table table-striped table-bordered table-hover smaller" cellspacing="0" width="100%">',];
		$this->table->set_template($tmpl);

		$this->table->set_heading($groupTitles);

		//$this->db->order_by('order_p, order_c');
		$menu_array = $this->navigation_m->getNavigation();

		for ($m=0; $m < count($menu_array); $m++) {
			$item = $menu_array[$m];

			if($item->parent_id == 0){ //main item
				$row[] = "<strong>".$item->title_en."</strong>";

			} elseif ($item->parent_id > 0){ //Sub item
				if($item->title_en == '---' or strcasecmp($item->title_en, 'divider') == 0) $item->title_en = '<div class="divider_display">- - - - - Divider - - - - -</div>';
				$row[] = '<div style = "padding-left: 25px;">'.$item->title_en.'</div>';

			}

			$permissions = Modules::run('nav_permission/getPermissions', $item->id);

			foreach ($groups as $group) {
				//$group_ids = is_array($item->group_id)? $item->group_ids : array();
				$checkBox = in_array($group->id, $permissions) ? $this->_create_check($item->id, $group->id, TRUE) : $this->_create_check($item->id, $group->id, FALSE);
				$row[] = $checkBox;
			}

			$this->table->add_row($row);
			$row = array();
		}

		$data['printTable'] =  $this->table->generate();
		$data['active'] = 'navigation';

		$this->template->parentTitle(t('adminActions'));
		$this->template->title(t('navPermissions'));

		$this->template->build('v_permissions', $data);
	}

	// Create Check Box
	public function _create_check($name, $id, $l=FALSE){
		$hidden = '';
		if($l == true)
			$checked = 'checked=checked';
		else
			$checked = '';

		return '<input type="checkbox" name="'.$name.'[]" value="'.$id.'" '.$checked.' />';
	}

	// Create Check Box
	public function _create_check_hidden($name, $id, $l=FALSE){
		return '<input type="hidden" name="'.$name.'[]" value="'.$id.'" />';
	}

	// Sort the Navigation Data and Store it
	public function process_sort(){
		if(!Modules::run('role/has_role', 'read_menu'))
		{
			m('w', t('access_denied'));
			redirect('home');
		}

		if(!$this->input->is_ajax_request()){
			show_404('direct to navigation/sort');
		} else {
			$data = $this->input->post('dataI');

			$order_c = 0;
			for ($i=0; $i < count($data); $i++) {
				$pId = $data[$i]['id'];

				$dataO['order_p']	= $i+1;
				$dataO['order_c']	= 0;
				$dataO['parent_id']	= 0;
				$parents			= $this->_get_parents();
				$dataO['class']		= underscore($parents[$pId]->title_en);

				$this->navigation_m->update($pId, $dataO, true);
				if(isset($data[$i]['children'])){
					foreach ($data[$i]['children'] as $key => $value) {
						$order_c ++;
						$cId = $value['id'];

						$dataO['order_p']	= $i+1;
						$dataO['order_c']	= $order_c;
						$dataO['parent_id']	= (int) $pId;
						$dataO['class']		= underscore($parents[$pId]->title_en);
						$this->navigation_m->update($cId, $dataO, true);
					}
					$order_c = 0;
				}
			}
			$this->session->unset_userdata('menu_data');
			$return['m'] = m('s', t('navUpdated'));
			echo json_encode($return);
		}
	}

	// Build the Navigation
	public function build($active=''){
		if(isset($this->session->userdata['user_id'])){
			if(isset($this->session->userdata['menu_data'])){
				$data = $this->session->userdata['menu_data'];
			} else {
				$data = $this->navigation_m->getPermissions();
				$this->session->set_userdata('menu_data', $data);
			}
			$this->_create_nav($data, $active);
		}
	}

	public function build_test($group_id){
		$this->session->unset_userdata('menu_data');
		$data = $this->navigation_m->getPermissions($group_id);
		$this->_create_nav($data, '');
		//$this->_build_the_nav($nav);
	}


	// Build the Navigation
	public function _create_nav($menu_array, $active){
		if(empty($this->session->userdata['group_id']))
			return false;

		$list = "\n\t\t\t\t".'<ul class="nav navbar-nav">'."\n"; $ol = false;
		//$s = 0;
		$class = '';
		for ($m=0; $m < count($menu_array); $m++) {
			$item = $menu_array[$m];
			if($item->parent_id == 0){ //main item

				/*if(!in_array($this->session->userdata('user_id'), $item->group_ids))
					continue;*/

				$pId = $item->id;
				if($active == $item->class)
					$class = 'active';

				if($m+1 < count($menu_array) and $menu_array[$m+1]->parent_id != 0){
					$list .= "\t\t\t\t\t".'<li class="dropdown '.$class.'">'."\n";
					$list .= "\t\t\t\t\t\t".'<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$item->title_en.' <b class="caret"></b></a>'."\n";
					$list .= "\t\t\t\t\t\t".'<ul class="dropdown-menu">'."\n";
					$ol = true;
					$class = '';
				} else {
					$list .= "\t\t\t\t\t".'<li class="'.$class.'"><a href="'.$item->url.'">'.$item->title_en.'</a></li>'."\n";
					$class = '';
				}
			} elseif ($item->parent_id > 0){ //Sub item
				if($item->title_en == '---' or strcasecmp($item->title_en, 'divider') == 0){
						$list .= '<li class="divider"></li>';
					if(($m+1 < count($menu_array) and $menu_array[$m]->parent_id != 0 and $menu_array[$m+1]->parent_id == 0)){
						$list .= "\t\t\t\t\t\t\t".'</ul>'."\n\t\t\t\t\t\t\t".'</li>';
						$ol = false;
					}
					continue;
				}

				if($item->parent_id == $pId){
					$list .= "\t\t\t\t\t\t\t".'<li><a href="'.$item->url.'">'.$item->title_en.'</a></li>'."\n";

					if(($m+1 < count($menu_array) and $menu_array[$m]->parent_id != 0 and $menu_array[$m+1]->parent_id == 0)){
						$list .= "\t\t\t\t\t\t\t".'</ul>'."\n\t\t\t\t\t\t\t".'</li>';
						$ol = false;
					}
				}
			}
		}
		if($ol) $list .= "\t\t\t\t\t\t".'</ul>'."\n\t\t\t\t\t".'</li>';
		$list .= "\n\t\t\t\t".'</ul>'."\n";
		$list .= $this->get_other_nav();

		$data['nav'] = $list;

		if($this->ion_auth->logged_in())
			$this->load->view('v_navigation', $data);
	}

	public function process_navDelete(){
		$id = $this->input->post('nav_id');
		if(!Modules::run('role/has_role', 'delete_menu'))
		{
			m('w', t('notAllowedToDelete'));
			echo json_encode(true);
		} else {
			$delete = 0;
			if(!$this->input->is_ajax_request()){
				show_404();
			} else {
				$child = $this->navigation_m->get_by('parent_id', $id);
				if(isset($child->id)){
					$return['m'] = m('w', t('navHasChild'));
				} else {
					$delete = $this->navigation_m->delete($id);
					$this->session->unset_userdata('menu_data');
					if($delete){
						$return['m'] = m('s', t('navDeleted'));
					} else {
						$return['m'] = m('e', t('navNotDeleted'));
					}
				}
			}

			$return['nav_id'] = $id;

			echo json_encode($return);
		}
	}

	// Get the name and the Logout
	public function get_other_nav(){

		$fullname = Modules::run('auth/fullname');

		$return = "\t\t\t\t".'<ul class="nav navbar-nav navbar-right">
					<li>'.$fullname.'</li>
					<li><a href="/logout" class="bold">'.t('logout').'</a></li>
				</ul>';

		return $return;
	}

	// Get Data from Posting form
	public function _get_data_from_post(){
		$data['title_en'] 	= $this->input->post('title_en', true);
		$data['url']		= $this->input->post('url', true);
		return $data;
	}

	// Get Data from Database
	public function _get_data_from_db($id=""){

		$return = $this->navigation_m->as_array()->get($id);
		if(is_array($return))
			return $return;
		else
			return false;
	}

	// Create Navigation Menu
	public function process_create(){
		if(!Modules::run('role/has_role', ['create_menu','update_menu'], true))
		{
			m('w', t('access_denied'));
			redirect('home');
		}
		$nav_id = $this->uri->segment(3);
		$data = $this->_get_data_from_post();

		if($this->input->post()){
			$this->form_validation->set_rules('title_en', t('navTitle'), 'required|xss_clean');
			$this->form_validation->set_rules('url', t('navURL'), 'required|xss_clean');

			if($this->form_validation->run() == false){
				$data['message'] = m('en', validation_errors());
			} else {
				unset($data['formBtn']);
				if($nav_id > 0){
					//Edit
					$update = $this->navigation_m->update($nav_id, $data, true);
					m('s', t('navEdited'));
				} else {
					//Insert
					$insert = $this->navigation_m->insert($data, true);
					m('s', t('navInserted'));
				}
				$this->session->unset_userdata('menu_data');
				redirect('/navigation');
			}
		}

		if($nav_id > 0){
			$this->template->title(t('editNavigation'));
			$data = $this->_get_data_from_db($nav_id);
			$data['formBtn'] = t('edit');
		} else {
			$this->template->title(t('createNewNavigation'));
			$data['formBtn'] = t('create');
		}

		$data['active'] = 'navigation';
		$this->template->parentTitle(t('adminActions'));

		$this->template->build('v_edit_navigation', $data);
	}

	// Submitting the form
	public function _get_parents(){
		$result = $this->navigation_m->get_many_by('parent_id', 0);
		foreach ($result as $row) {
			$return[$row->id] = $row;
		}
		return $return;
	}
}
