<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

/**
 * 
 */
class Approval extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Approval_model');
	}

	function index()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Process';
		$this->fragment['header_child']		= 'Approval';
		$this->fragment['breadcrumb'] = ['Process', 'Approval'];
		$this->fragment['js']		= base_url('assets/js/pages/approval.js');
		$this->fragment['pagename'] = 'pages/view-approval';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function view_tracking()
	{
		// echo json_encode($this->input->post());die;
		$data = array();
		$res = $this->Approval_model->get_applicant();
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $row->ReceiptSendPkgID;
			$col[] = $row->PeriodYear . ' - ' .  (strlen($row->PeriodMonth) == 1 ? '0'.$row->PeriodMonth : $row->PeriodMonth);
			$col[] = '<strong>'.$row->InvNo.'</strong>' . '<br>' . '<i>'.$row->PONo.'</i> <br> <i>'.$row->PO_Type.'</i>';
			$col[] = '<i>'.$row->AgencyName.'</i> <br> <i>'.$row->AdvertiserName .'</i> <br> <strong>'.$row->ProductName.'</strong>';
			$col[] = $row->AE_Name;
			$col[] = number_format($row->Gross,0,".",".");
			$col[] = $row->AgencyDisc;
			$col[] = number_format($row->Nett,0,".",".");
			$col[] = ($row->InvType == 0 ? ($row->autocomplete == 0 ? 'Manual (On Air)' : 'Manual (Off Air)') : 'BMS');
			$col[] = '<button class="btn btn-sm btn-info btn-detail" title="Detail" data-id="'.$row->ReceiptSendPkgID.'"><i class="fas fa-eye"></i></button>&nbsp;';
			$data[] = $col;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Approval_model->get_applicant_count_all(),
			"recordsFiltered" 	=> $this->Approval_model->get_applicant_count_filtered(),
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
		$check = $this->Approval_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

	function accept_invoice()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$ReceiptSendPkgID 	= $this->input->post("ReceiptSendPkgID");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($ReceiptSendPkgID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}

		$length_ReceiptSendPkgID = sizeof($ReceiptSendPkgID);

		for ($i = 0; $i < $length_ReceiptSendPkgID; $i++) { 
			/*** Accessing DB Area ***/
			$check = $this->Approval_model->find($ReceiptSendPkgID[$i]);
			if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}

			foreach ($check as $row) {
				$data = [
					'InvID'		=> $row->InvID,
					'InvStsID'	=> '3',
					'EntryBy'		=> $this->log_user,
					'EntryBy_date'	=> date('Y-m-d H:i:s'),
					'EditBy'		=> $this->log_user, 
					'EditBy_date'	=> date('Y-m-d H:i:s'),
				];
				$this->sitemodel->insert('tr_tracking', $data);
			}
		}

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = 'Successfully Receive Data.';
		echo json_encode($this->response);
		exit;
	}

	function return_invoice()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$ReceiptSendPkgID 	= $this->input->post("ReceiptSendPkgID");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($ReceiptSendPkgID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}

		$length_ReceiptSendPkgID = sizeof($ReceiptSendPkgID);

		for ($i = 0; $i < $length_ReceiptSendPkgID; $i++) { 
			/*** Accessing DB Area ***/
			$check = $this->Approval_model->find($ReceiptSendPkgID[$i]);
			if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}

			$data_track = [
				'isActive' 		=> 1,
				'DeleteBy_date'	=> date('Y-m-d H:i:s'),
				'DeleteBy'		=> $this->log_user, 
			];

			$this->sitemodel->update('tr_tracking', $data_track, array( 'ReceiptSendPkgID' => $ReceiptSendPkgID[$i] ) );
		}

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = 'Successfully Return Data.';
		echo json_encode($this->response);
		exit;
	}
}