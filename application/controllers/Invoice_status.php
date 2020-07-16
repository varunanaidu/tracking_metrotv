<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

class Invoice_status extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('InvSts_model');
	}

	function index()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Master';
		$this->fragment['header_child']		= 'Invoice Status';
		$this->fragment['breadcrumb'] = ['Master', 'Invoice Status'];
		$this->fragment['js']		= base_url('assets/js/pages/inv_sts.js');
		$this->fragment['pagename'] = 'pages/view-inv-sts';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function deleted()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Deleted';
		$this->fragment['header_child']		= 'Invoice Status';
		$this->fragment['breadcrumb'] = ['Deleted', 'Invoice Status'];
		$this->fragment['js']		= base_url('assets/js/pages/inv_sts.js');
		$this->fragment['pagename'] = 'pages/view-delinv-sts';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function view_inv_sts()
	{
		$a = 1;
		$InvStsName;
		$data = array();
		$res = $this->InvSts_model->get_applicant();
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $a;
			$col[] = $row->InvStsCode;
			$col[] = $row->InvStsName;
			$col[] = '<button class="btn btn-sm btn-warning btn-edit" title="Edit" data-id="'.$row->InvStsID.'"><i class="fas fa-pencil-alt"></i></button>&nbsp;<button class="btn btn-sm btn-danger btn-delete" title="Delete" data-id="'.$row->InvStsID.'" data-name="'.$row->InvStsName.'"><i class="fas fa-trash"></i></button>';
			$data[] = $col;
			$a++;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->InvSts_model->get_applicant_count_all(),
			"recordsFiltered" 	=> $this->InvSts_model->get_applicant_count_filtered(),
			"data" 				=> $data,
			"q"					=> $temp //temp for tracing db query

		);
		echo json_encode($output);
		exit;
	}

	function view_delInv_sts()
	{
		$a = 1;
		$InvStsName;
		$data = array();
		$res = $this->InvSts_model->get_applicant($this->input->post('isActive'));
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $a;
			$col[] = $row->InvStsCode;
			$col[] = $row->InvStsName;
			$col[] = '<button class="btn btn-sm btn-info btn-restore" title="Restore" data-id="'.$row->InvStsID.'" data-name="'.$row->InvStsName.'"><i class="fas fa-undo"></i></button>';
			$data[] = $col;
			$a++;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->InvSts_model->get_applicant_count_all($this->input->post('isActive')),
			"recordsFiltered" 	=> $this->InvSts_model->get_applicant_count_filtered($this->input->post('isActive')),
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
		$check = $this->InvSts_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

	function save()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		// PARAMS
		$InvStsCode 	= $this->input->post('InvStsCode');
		$InvStsName 	= $this->input->post('InvStsName');
		$type 		= $this->input->post('type');
		$id 		= $this->input->post('id');

		$type = ($type == 'update') ? 'update' : 'new';

		$data = [
			'InvStsCode'		=> $InvStsCode,
			'InvStsName'		=> $InvStsName,
			'EditBy_date'	=> date('Y-m-d H:i:s'),
			'EditBy'		=> $this->log_user, 
		];

		if ($type == 'new') {
			$data['EntryBy_date'] = date('Y-m-d H:i:s');
			$data['EntryBy'] = $this->log_user;
		}

		if ($type == 'update') {
			$this->sitemodel->update("tab_inv_sts", $data, ["InvStsID"=>$id]);
		}else{
			$result = $this->sitemodel->insert("tab_inv_sts", $data);
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
		$check = $this->InvSts_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		// Delete 
		$data = [
			'isActive' => 1,
			'DeleteBy_date'	=> date('Y-m-d H:i:s'),
			'DeleteBy'		=> $this->log_user, 
		];
		$this->sitemodel->update("tab_inv_sts", $data, ["InvStsID"=>$key]);
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully remove data.";
		echo json_encode($this->response);
		exit;
	}

	function recover(){
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
		$check = $this->InvSts_model->find($key, '1');
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		// Delete 
		$data = [
			'isActive' => 0,
			'DeleteBy_date'	=> NULL,
			'DeleteBy'		=> NULL, 
		];
		$this->sitemodel->update("tab_inv_sts", $data, ["InvStsID"=>$key]);
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully recover data.";
		echo json_encode($this->response);
		exit;
	}
}