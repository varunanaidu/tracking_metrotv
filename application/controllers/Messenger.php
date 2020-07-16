<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

/**
 * 
 */
class Messenger extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Messenger_model');
	}

	function index()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['data_courier'] = $this->sitemodel->view('vw_courier', '*');

		$this->fragment['header_parent'] = 'Tracking';
		$this->fragment['header_child']		= 'Messenger';
		$this->fragment['breadcrumb'] = ['Tracking', 'Messenger'];
		$this->fragment['js']		= base_url('assets/js/pages/messenger.js');
		$this->fragment['pagename'] = 'pages/view-messenger';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function view_messenger()
	{
		$data = array();
		$res = $this->Messenger_model->get_applicant();
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$messenger = ( empty($row->CourierStatus) == FALSE ? ( $row->CourierStatus == 1 ? '(External) ' . $row->CourierCode . '-' . $row->CourierName : '(Internal) ' . $row->CourierCode . '-' . $row->CourierName ) : '' );
			$button = '<button class="btn btn-sm btn-info btn-detail" title="Detail" data-id="'.$row->ReceiptSendPkgID.'"><i class="fas fa-eye"></i></button>&nbsp;';
			
			$col[] = $row->ReceiptSendPkgID;
			$col[] = $row->PeriodYear . ' - ' .  (strlen($row->PeriodMonth) == 1 ? '0'.$row->PeriodMonth : $row->PeriodMonth);
			$col[] = '<strong>'.$row->InvNo.'</strong>' . '<br>' . '<i>'.$row->PONo.'</i> <br> <i>'.$row->PO_Type.'</i>';
			$col[] = '<i>'.$row->AgencyName.'</i> <br> <i>'.$row->AdvertiserName .'</i> <br> <strong>'.$row->ProductName.'</strong>';
			$col[] = $row->AE_Name;
			$col[] = number_format($row->Gross,0,".",".");
			$col[] = $row->AgencyDisc;
			$col[] = number_format($row->Nett,0,".",".");
			$col[] = $button;
			$data[] = $col;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Messenger_model->get_applicant_count_all(),
			"recordsFiltered" 	=> $this->Messenger_model->get_applicant_count_filtered(),
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
		$check = $this->Messenger_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

	function get_courier()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$key = $this->input->post("key");
		/*** Validate Area ***/
		if ( empty($key) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		$check = $this->sitemodel->view('vw_courier', '*', array('CourierStatus' => $key ) );
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		$this->response['cStatus'] = $key;
		echo json_encode($this->response);
		exit;
	}

	function send_to_courier()
	{
		// echo json_encode($this->input->post());die;
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$ReceiptSendPkgID 	= $this->input->post("ReceiptSendPkgID");
		$CourierID 			= $this->input->post("CourierID");
		$CourierStatus 		= $this->input->post("CourierStatus");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($ReceiptSendPkgID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		if ( empty($CourierID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		if ( empty($CourierStatus) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}


		$InvStsID = ( ($CourierStatus == 1) ? '4' : '5' );

		$length_ReceiptSendPkgID = sizeof($ReceiptSendPkgID);

		for ($i = 0; $i < $length_ReceiptSendPkgID; $i++) { 
			/*** Accessing DB Area ***/
			$check = $this->Messenger_model->find($ReceiptSendPkgID[$i]);
			if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}

			foreach ($check as $row) {
				$data = [
					'InvID'		=> $row->InvID,
					'InvStsID'	=> $InvStsID,
					'CourierID'	=> $CourierID,
					'SendDate'		=> date('Y-m-d H:i:s'),
					'EntryBy'		=> $this->log_user,
					'EntryBy_date'	=> date('Y-m-d H:i:s'),
					'EditBy'		=> $this->log_user, 
					'EditBy_date'	=> date('Y-m-d H:i:s'),
				];

				$this->sitemodel->insert("tr_tracking", $data);
			}

		}

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = 'Successfully Send Invoice.';
		echo json_encode($this->response);
		exit;
	}
}