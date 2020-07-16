<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

class Navigations extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Navigations_model');
	}

	function index()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Developer';
		$this->fragment['header_child']		= 'Navigation';
		$this->fragment['breadcrumb'] = ['Developer', 'Navigation'];
		$this->fragment['js']		= base_url('assets/js/pages/navigations.js');
		$this->fragment['parent']	= $this->sitemodel->view('vw_nav', 'nav_id, nav_name', array('nav_parent' => '0', 'nav_level' => '0') );
		$this->fragment['check_last'] = $this->sitemodel->view('vw_nav', 'MAX(nav_order) AS LAST', array('nav_parent'=> '0', 'nav_level'=>'0' ));
		$this->fragment['pagename'] = 'pages/view-nav';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function view_nav()
	{
		$a = 1;
		$data = array();
		$res = $this->Navigations_model->get_applicant();
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $a;
			$col[] = $row->nav_name;
			$col[] = $row->nav_ctr;
			$col[] = ($row->parent_name == '') ? 'Root' : $row->parent_name;
			$col[] = '<button class="btn btn-sm btn-warning btn-edit" title="Edit" data-id="'.$row->nav_id.'>"><i class="fas fa-pencil-alt"></i></button>&nbsp;<button class="btn btn-sm btn-danger btn-delete" title="Delete" data-id="'.$row->nav_id.'>" data-name="'.$row->nav_name.'"><i class="fas fa-trash"></i></button>';
			$data[] = $col;
			$a++;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Navigations_model->get_applicant_count_all(),
			"recordsFiltered" 	=> $this->Navigations_model->get_applicant_count_filtered(),
			"data" 				=> $data,
			"q"					=> $temp //temp for tracing db query

		);
		echo json_encode($output);
		exit;
	}

	function find(){
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$key = $this->input->post("key");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($key) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		$check = $this->Navigations_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

	function save()
	{
		$nav_id;
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		// PARAMS
		$nav_name 	= $this->input->post('nav_name');
		$nav_ctr 	= $this->input->post('nav_ctr');
		$nav_parent = $this->input->post('nav_parent');
		$nav_order  = $this->input->post('nav_order');
		$type 		= $this->input->post('type');
		$id 		= $this->input->post('id');

		$type = ($type == 'update') ? 'update' : 'new';

		$data = [
			'nav_name' 		=> $nav_name,
			'nav_ctr'		=> $nav_ctr,
			'nav_parent'	=> $nav_parent,
			'nav_order'		=> $nav_order,
			'nav_level'		=> ($nav_parent == '0') ? '0' : '1',
			'edited_date'	=> date('Y-m-d H:i:s'),
			'edited_by'		=> $this->log_user, 
		];

		if ($type == 'new') {
			$data['create_date'] = date('Y-m-d H:i:s');
			$data['create_by'] = $this->log_user;
		}

		if ($type == 'update') {
			$this->sitemodel->update("tab_nav", $data, ["nav_id"=>$id]);
		}else{
			$result = $this->sitemodel->insert("tab_nav", $data);
		}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = ($type == "update") ? "Successfully modified data." : "Successfully insert data.";
		echo json_encode($this->response);
		exit;

	}

	function delete(){
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$key = $this->input->post("key");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($key) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		$check = $this->Navigations_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		// Delete 
		$this->sitemodel->delete("tab_nav", ["nav_id"=>$key]);
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully remove data.";
		echo json_encode($this->response);
		exit;
	}

	function check_last()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$key = $this->input->post("key");
		/*** Accessing DB Area ***/
		$check = $this->sitemodel->view('vw_nav', 'MAX(nav_order) AS LAST', ['nav_parent'=>$key]);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}
}