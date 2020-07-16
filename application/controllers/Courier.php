<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

class Courier extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Courier_model');
	}

	function index()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Master';
		$this->fragment['header_child']		= 'Courier';
		$this->fragment['breadcrumb'] = ['Master', 'Courier'];
		$this->fragment['js']		= base_url('assets/js/pages/courier.js');
		$this->fragment['pagename'] = 'pages/view-courier';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function deleted()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Deleted';
		$this->fragment['header_child']		= 'Courier';
		$this->fragment['breadcrumb'] = ['Deleted', 'Courier'];
		$this->fragment['js']		= base_url('assets/js/pages/courier.js');
		$this->fragment['pagename'] = 'pages/view-deleted-courier';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function view_courier()
	{
		$a = 1;
		$data = array();
		$res = $this->Courier_model->get_applicant($this->input->post('isActive'));
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$button = ( empty($this->input->post('isActive')) ) ? '<button class="btn btn-sm btn-warning btn-edit" title="Edit" data-id="'.$row->CourierID.'"><i class="fas fa-pencil-alt"></i></button>&nbsp;<button class="btn btn-sm btn-danger btn-delete" title="Delete" data-id="'.$row->CourierID.'" data-name="'.$row->CourierName.'"><i class="fas fa-trash"></i></button>' : '<button class="btn btn-sm btn-info btn-restore" title="Restore" data-id="'.$row->CourierID.'" data-name="'.$row->CourierName.'"><i class="fas fa-undo"></i></button>';
			
			$col[] = $a;
			$col[] = $row->CourierCode;
			$col[] = $row->CourierName;
			$col[] = ($row->CourierStatus == 1) ? 'External Messenger' : 'Internal Messenger';
			$col[] = $button;
			$data[] = $col;
			$a++;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Courier_model->get_applicant_count_all($this->input->post('isActive')),
			"recordsFiltered" 	=> $this->Courier_model->get_applicant_count_filtered($this->input->post('isActive')),
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
		$check = $this->Courier_model->find($key);
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
		$CourierCode 	= $this->input->post('CourierCode');
		$CourierName 	= $this->input->post('CourierName');
		$CourierStatus = $this->input->post('CourierStatus');
		$type 		= $this->input->post('type');
		$id 		= $this->input->post('id');

		$type = ($type == 'update') ? 'update' : 'new';

		$data = [
			'CourierCode' 		=> $CourierCode,
			'CourierName'		=> $CourierName,
			'CourierStatus'	=> $CourierStatus,
			'EditBy_date'	=> date('Y-m-d H:i:s'),
			'EditBy'		=> $this->log_user, 
		];

		if ($type == 'new') {
			$data['EntryBy_date'] = date('Y-m-d H:i:s');
			$data['EntryBy'] = $this->log_user;
		}

		if ($type == 'update') {
			$this->sitemodel->update("tab_courier", $data, ["CourierID"=>$id]);
		}else{
			$result = $this->sitemodel->insert("tab_courier", $data);
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
		$check = $this->Courier_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		// Delete 
		$data = [
			'isActive' => 2,
			'DeleteBy_date'	=> date('Y-m-d H:i:s'),
			'DeleteBy'		=> $this->log_user, 
		];
		$this->sitemodel->update("tab_courier", $data, ["CourierID"=>$key]);
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
		$check = $this->Courier_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		// Delete 
		$data = [
			'isActive' 		=> 1,
			'DeleteBy_date'	=> NULL,
			'DeleteBy'		=> NULL, 
		];
		$this->sitemodel->update("tab_courier", $data, ["CourierID"=>$key]);
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully recover data.";
		echo json_encode($this->response);
		exit;
	}
}