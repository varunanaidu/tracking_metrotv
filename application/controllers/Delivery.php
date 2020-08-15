<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

/**
 * 
 */
class Delivery extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Delivery_model');
	}

	function index()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['data_courier'] = $this->sitemodel->view('vw_courier', '*');

		$this->fragment['header_parent'] = 'Process';
		$this->fragment['header_child']		= 'Delivery';
		$this->fragment['breadcrumb'] = ['Process', 'Delivery'];
		$this->fragment['js']		= base_url('assets/js/pages/delivery.js');
		$this->fragment['pagename'] = 'pages/view-delivery';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function view_delivery()
	{
		$data = array();
		$res = $this->Delivery_model->get_applicant();
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();

			$messenger = ( empty($row->CourierStatus) == FALSE ? ( $row->CourierStatus == 1 ? '(External) ' . $row->CourierCode . '-' . $row->CourierName : '(Internal) ' . $row->CourierCode . '-' . $row->CourierName ) : '' );

			$button = '<button class="btn btn-sm btn-info btn-detail" title="Detail" data-id="'.$row->ReceiptSendPkgID.'"><i class="fas fa-eye"></i></button>&nbsp;';

			if ( empty($row->ResiNoFromCourier) && ($row->InvStsCode == '3A' || $row->InvStsCode == '3B') ) {
				$button .= '<button class="btn btn-sm btn-warning btn-resi " title="Input Resi "  data-id="'.$row->ReceiptSendPkgID.'" ><i class="fas fa-pencil-alt"></i></button>&nbsp;';
			}

			if ( empty($row->ResiNoFromCourier) == FALSE && $row->InvStsCode != '4A' ) {
				$button .= '<button class="btn btn-sm btn-success btn-received " title="Recieved by client"  data-id="'.$row->ReceiptSendPkgID.'" ><i class="fas fa-check"></i></button>&nbsp;<button class="btn btn-sm btn-danger btn-return" title="Package Return"  data-id="'.$row->ReceiptSendPkgID.'" ><i class="fas fa-times"></i></button>&nbsp;';
			}

			$button.= '<button type="button" class="btn btn-sm btn-primary btn-rollback" title="Rollback" data-id="'.$row->ReceiptSendPkgID.'" data-invoice="'.$row->InvID.'"><i class="fas fa-undo"></i></button>&nbsp;';

			$SendDate = ( empty($row->SendDate) == FALSE ? date('d M Y H:i:s', strtotime($row->SendDate)) : '' );

			$col[] = $row->ReceiptSendPkgID;
			$col[] = $row->PeriodYear . ' - ' .  (strlen($row->PeriodMonth) == 1 ? '0'.$row->PeriodMonth : $row->PeriodMonth);
			$col[] = '<strong>'.$row->InvNo.'</strong>' . '<br>' . '<i>'.$row->PONo.'</i> <br> <i>'.$row->PO_Type.'</i>';
			$col[] = '<i>'.$row->AgencyName.'</i> <br> <i>'.$row->AdvertiserName .'</i> <br> <strong>'.$row->ProductName.'</strong>';
			$col[] = $row->AE_Name;
			$col[] = 'Rp. '.number_format($row->Gross,0,".",".");
			$col[] = $row->AgencyDisc;
			$col[] = 'Rp. '.number_format($row->Nett,0,".",".");
			$col[] = $SendDate;
			$col[] = $messenger;
			$col[] = $row->ResiNoFromCourier;
			$col[] = ($row->InvType == 0 ? ($row->autocomplete == 0 ? 'Manual (On Air)' : 'Manual (Off Air)') : 'BMS');
			$col[] = $button;
			$col[] = $row->InvID;
			$data[] = $col;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Delivery_model->get_applicant_count_all(),
			"recordsFiltered" 	=> $this->Delivery_model->get_applicant_count_filtered(),
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
		$check = $this->Delivery_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

	function find_rollback(){
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
		$check = $this->Delivery_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		foreach ($check as $row) {
			$InvStsID = $row->InvStsID;
			$condi = [
				'InvStsID <'	=>	$InvStsID,
				'InvStsID !=' 	=> ($row->CourierStatus == 1 ? 5 : 4)
			];
			$invoice_status = $this->sitemodel->view('vw_inv_sts', '*', $condi);
			// echo $this->db->last_query();die;
			$this->response['data_invoice_status'] = $invoice_status;
		}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

	function update_resi()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$ReceiptSendPkgID 	= $this->input->post("ReceiptSendPkgID");
		$ResiNoFromCourier 	= $this->input->post("ResiNoFromCourier");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($ReceiptSendPkgID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		if ( empty($ResiNoFromCourier) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}

		/*** Accessing DB Area ***/
		$check = $this->Delivery_model->find($ReceiptSendPkgID);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}

		foreach ($check as $row) {
			$data_track = [
				// 'InvID' 			=> $row->InvID,
				// 'InvStsID' 			=> $row->InvStsID,
				// 'CourierID' 		=> $row->CourierID,
				'ResiNoFromCourier'	=> $ResiNoFromCourier,
				// 'SendDate'			=> $row->SendDate,
				// 'EntryBy'			=> $this->log_user,
				// 'EntryBy_date'		=> date('Y-m-d H:i:s'),
				'EditBy'			=> $this->log_user, 
				'EditBy_date'		=> date('Y-m-d H:i:s'),
			];
			// $this->sitemodel->insert("tr_tracking", $data_track);
			$this->sitemodel->update("tr_tracking", $data_track, ["ReceiptSendPkgID"=>$ReceiptSendPkgID]);
		}

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = 'Successfully Add Receipt Number.';
		echo json_encode($this->response);
		exit;
	}

	function received_invoice()
	{
		// echo json_encode($this->input->post());die;
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$ReceiptSendPkgID 	= $this->input->post("id2");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($ReceiptSendPkgID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}

		if ( isset($_FILES['ReceiptPathFileName']['name']) ) {
			$file = $_FILES['ReceiptPathFileName']['name'];
			$exp = explode(".", $file);
			$end = strtolower(end($exp));

			$fileUpload = md5($file.date("YmdHis")).".".$end;

			/*** Accessing DB Area ***/
			$check = $this->Delivery_model->find($ReceiptSendPkgID);
			if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}

			foreach ($check as $row) {
				$data_track = [
					'ReceiptSendPkgReceiver'	=> $this->input->post('ReceiptSendPkgReceiver'),
					'InvID'						=> $row->InvID,
					'InvStsID'					=> '6',
					'CourierID'					=> $row->CourierID,
					'ResiNoFromCourier'			=> $row->ResiNoFromCourier,
					'ReceiptPathFileName'		=> $fileUpload,
					'SendDate'					=> $row->SendDate,
					'EntryBy'					=> $this->log_user,
					'EntryBy_date'				=> date('Y-m-d H:i:s'),
					'EditBy'					=> $this->log_user, 
					'EditBy_date'				=> date('Y-m-d H:i:s'),
				];

				$this->sitemodel->insert("tr_tracking", $data_track);
			}

			$this->compress_image($_FILES['ReceiptPathFileName']['tmp_name'], "assets/images/invoices/".$fileUpload, 75);
		}else{

			/*** Accessing DB Area ***/
			$check = $this->Delivery_model->find($ReceiptSendPkgID);
			if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}

			foreach ($check as $row) {
				$data_track = [
					'ReceiptSendPkgReceiver'	=> $this->input->post('ReceiptSendPkgReceiver'),
					'InvID'						=> $row->InvID,
					'InvStsID'					=> '6',
					'CourierID'					=> $row->CourierID,
					'ResiNoFromCourier'			=> $row->ResiNoFromCourier,
					'ReceiptPathFileName'		=> '',
					'SendDate'					=> $row->SendDate,
					'EntryBy'					=> $this->log_user,
					'EntryBy_date'				=> date('Y-m-d H:i:s'),
					'EditBy'					=> $this->log_user, 
					'EditBy_date'				=> date('Y-m-d H:i:s'),
				];

				$this->sitemodel->insert("tr_tracking", $data_track);
			}			
		}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = 'Successfully received by client.';
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
			$check = $this->Delivery_model->find($ReceiptSendPkgID[$i]);
			if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}

			foreach ($check as $row) {
				$data = [
					'InvID'			=> $row->InvID,
					'InvStsID'		=> $InvStsID,
					'CourierID'		=> $CourierID,
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

	function return_invoice(){
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$ReceiptSendPkgID 	= $this->input->post("ReceiptSendPkgID");
		$ReasonReturned 	= $this->input->post("ReasonReturned");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($ReceiptSendPkgID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		if ( empty($ReasonReturned) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}

		/*** Accessing DB Area ***/
		$check = $this->Delivery_model->find($ReceiptSendPkgID);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}

		foreach ($check as $row) {
			$data_track = [
				'InvID' 			=> $row->InvID,
				'InvStsID' 			=> 8,
				'CourierID' 		=> $row->CourierID,
				'ResiNoFromCourier'	=> $row->ResiNoFromCourier,
				'ReasonReturned'	=> $ReasonReturned,
				'SendDate'			=> $row->SendDate,
				'EntryBy'			=> $this->log_user,
				'EntryBy_date'		=> date('Y-m-d H:i:s'),
				'EditBy'			=> $this->log_user, 
				'EditBy_date'		=> date('Y-m-d H:i:s'),
			];
			$this->sitemodel->insert("tr_tracking", $data_track);
		}

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = 'Successfully Return Invoice';
		echo json_encode($this->response);
		exit;

	}

	function check_invoice(){
		$InvID 	= $this->input->post("InvID");

		$data = array();

		if ( empty($InvID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}

		$length_InvID = sizeof($InvID);

		for ( $i = 0; $i < $length_InvID	; $i++) { 
			$check = $this->sitemodel->view('vw_tracking', '*', array('InvID' => $InvID[$i]), false, 'EditBy_date DESC', '1' );
			foreach ($check as $row) {
				$data[] = $row->InvStsCode;
			}
		}
		echo json_encode($data);
	}

	function rollback()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$ReceiptSendPkgID 	= $this->input->post("ReceiptSendPkgID");
		$InvID 				= $this->input->post("InvID");
		$InvStsID 			= $this->input->post("InvStsID");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($ReceiptSendPkgID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		if ( empty($InvID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		if ( empty($InvStsID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}

		/*** Accessing DB Area ***/
		$check = $this->sitemodel->view('vw_tracking', '*', ['ReceiptSendPkgID'=>$ReceiptSendPkgID]);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}

		$data_track = [
			'isActive' 		=> 1,
			'DeleteBy_date'	=> date('Y-m-d H:i:s'),
			'DeleteBy'		=> $this->log_user, 
		];

		$condition = [
			'InvID'			=> $InvID,
			'InvStsID >'	=> $InvStsID,
			'isActive'		=> 0
		];

		$this->sitemodel->update('tr_tracking', $data_track, $condition);

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = 'Successfully Rollback Invoice';
		echo json_encode($this->response);
		exit;
	}

}