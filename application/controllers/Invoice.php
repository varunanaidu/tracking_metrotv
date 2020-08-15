<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

/**
 * 
 */
class Invoice extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('guzzle');
		$this->load->model('Invoice_model');
		$this->load->model('Bms_Invoice_model');
		$this->load->model('All_Invoice_model');
		$this->load->model('Off_Invoice_model');
	}

	function manual()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Invoice';
		$this->fragment['header_child']		= 'Manual On Air';
		$this->fragment['breadcrumb'] = ['Invoice', 'Manual On Air Invoice'];
		$this->fragment['js']		= base_url('assets/js/pages/invoice.js');
		$this->fragment['pagename'] = 'pages/view-manual-invoice';
		$this->fragment['months']   = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$this->load->view('layout/main-site', $this->fragment);
	}


	function manual_off()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Invoice';
		$this->fragment['header_child']		= 'Manual Off Air';
		$this->fragment['breadcrumb'] = ['Invoice', 'Manual Off Air Invoice'];
		$this->fragment['js']		= base_url('assets/js/pages/invoice_off.js');
		$this->fragment['pagename'] = 'pages/view-manual-off-invoice';
		$this->fragment['months']   = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$this->load->view('layout/main-site', $this->fragment);
	}

	function bms()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Invoice';
		$this->fragment['header_child']		= 'BMS';
		$this->fragment['breadcrumb'] = ['Invoice', 'BMS Invoice'];
		$this->fragment['js']		= base_url('assets/js/pages/bms_invoice.js');
		$this->fragment['pagename'] = 'pages/view-bms-invoice';
		$this->fragment['months']   = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$this->load->view('layout/main-site', $this->fragment);
	}

	function all()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Invoice';
		$this->fragment['header_child']		= 'All Invoice';
		$this->fragment['breadcrumb'] = ['Invoice', 'All Invoice'];
		$this->fragment['js']		= base_url('assets/js/pages/all_invoice.js');
		$this->fragment['pagename'] = 'pages/view-all-invoice';
		$this->fragment['months']   = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$this->fragment['inv_sts']	= $this->sitemodel->view('vw_inv_sts', '*');
		$this->load->view('layout/main-site', $this->fragment);
	}

	function deleted_manual()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Deleted';
		$this->fragment['header_child']		= 'Manual On Air';
		$this->fragment['breadcrumb'] = ['Deleted', 'Manual On Air'];
		$this->fragment['js']		= base_url('assets/js/pages/invoice.js');
		$this->fragment['pagename'] = 'pages/view-deleted-manual-invoice';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function deleted_manual_off_air()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Deleted';
		$this->fragment['header_child']		= 'Manual Off Air';
		$this->fragment['breadcrumb'] = ['Deleted', 'Manual Off Air'];
		$this->fragment['js']		= base_url('assets/js/pages/invoice_off.js');
		$this->fragment['pagename'] = 'pages/view-deleted-manual-off-air';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function deleted_bms()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Deleted';
		$this->fragment['header_child']		= 'BMS Invoice';
		$this->fragment['breadcrumb'] = ['Deleted', 'Bms Invoice'];
		$this->fragment['js']		= base_url('assets/js/pages/bms_invoice.js');
		$this->fragment['pagename'] = 'pages/view-deleted-bms-invoice';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function view_manual_invoice()
	{
		$isActive 		= $this->input->post('isActive');
		$autocomplete 	= $this->input->post('autocomplete');
		$a = 1;
		$data = array();
		$res = $this->Invoice_model->get_applicant($isActive, $autocomplete);
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $row->InvID;
			$col[] = $row->PeriodYear . ' - ' .  (strlen($row->PeriodMonth) == 1 ? '0'.$row->PeriodMonth : $row->PeriodMonth);
			$col[] = '<strong>'.$row->InvNo.'</strong>' . '<br>' . '<i>'.$row->PONo.'</i> <br> <i>'.$row->PO_Type.'</i>';
			$col[] = '<i>'.$row->AgencyName.'</i> <br> <i>'.$row->AdvertiserName .'</i> <br> <strong>'.$row->ProductName.'</strong>';
			$col[] = $row->AE_Name;
			$col[] = 'Rp. ' . number_format($row->Gross,0,".",".");
			$col[] = $row->AgencyDisc;
			$col[] = 'Rp. ' . number_format($row->Nett,0,".",".");
			$col[] = '<button class="btn btn-sm btn-warning btn-edit" title="Edit" data-id="'.$row->InvID.'" data-tr="'.$row->ReceiptSendPkgID.'"><i class="fas fa-pencil-alt"></i></button>&nbsp;<button class="btn btn-sm btn-danger btn-delete" title="Delete" data-id="'.$row->InvID.'" data-name="'.$row->InvNo.'" data-tr="'.$row->ReceiptSendPkgID.'"><i class="fas fa-trash"></i></button>&nbsp;';
			$col[] = $row->ReceiptSendPkgID;
			$data[] = $col;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Invoice_model->get_applicant_count_all($isActive, $autocomplete),
			"recordsFiltered" 	=> $this->Invoice_model->get_applicant_count_filtered($isActive, $autocomplete),
			"data" 				=> $data,
			"q"					=> $temp //temp for tracing db query

		);
		echo json_encode($output);
		exit;
	}

	function view_off_air_invoice()
	{
		$a = 1;
		$data = array();
		$res = $this->Off_Invoice_model->get_applicant();
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $row->InvID;
			$col[] = $row->PeriodYear . ' - ' .  (strlen($row->PeriodMonth) == 1 ? '0'.$row->PeriodMonth : $row->PeriodMonth);
			$col[] = '<strong>'.$row->InvNo.'</strong>' . '<br>' . '<i>'.$row->PONo.'</i> <br> <i>'.$row->PO_Type.'</i>';
			$col[] = '<i>'.$row->AgencyName.'</i> <br> <i>'.$row->AdvertiserName .'</i> <br> <strong>'.$row->ProductName.'</strong>';
			$col[] = $row->AE_Name;
			$col[] = 'Rp. ' . number_format($row->Gross,0,".",".");
			$col[] = $row->AgencyDisc;
			$col[] = 'Rp. ' . number_format($row->Nett,0,".",".");
			$col[] = '<button class="btn btn-sm btn-warning btn-edit" title="Edit" data-id="'.$row->InvID.'" data-tr="'.$row->ReceiptSendPkgID.'"><i class="fas fa-pencil-alt"></i></button>&nbsp;<button class="btn btn-sm btn-danger btn-delete" title="Delete" data-id="'.$row->InvID.'" data-name="'.$row->InvNo.'" data-tr="'.$row->ReceiptSendPkgID.'"><i class="fas fa-trash"></i></button>&nbsp;';
			$col[] = $row->ReceiptSendPkgID;
			$data[] = $col;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Off_Invoice_model->get_applicant_count_all(),
			"recordsFiltered" 	=> $this->Off_Invoice_model->get_applicant_count_filtered(),
			"data" 				=> $data,
			"q"					=> $temp //temp for tracing db query

		);
		echo json_encode($output);
		exit;
	}

	function view_bms_invoice()
	{
		$data = array();
		$res = $this->Bms_Invoice_model->get_applicant();
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $row->InvID;
			$col[] = $row->PeriodYear . ' - ' .  (strlen($row->PeriodMonth) == 1 ? '0'.$row->PeriodMonth : $row->PeriodMonth);
			$col[] = '<strong>'.$row->InvNo.'</strong>' . '<br>' . '<i>'.$row->PONo.'</i> <br> <i>'.$row->PO_Type.'</i>';
			$col[] = '<i>'.$row->AgencyName.'</i> <br> <i>'.$row->AdvertiserName .'</i> <br> <strong>'.$row->ProductName.'</strong>';
			$col[] = $row->AE_Name;
			$col[] = 'Rp. ' . number_format($row->Gross,0,".",".");
			$col[] = $row->AgencyDisc;
			$col[] = 'Rp. ' . number_format($row->Nett,0,".",".");
			$col[] = '<button class="btn btn-sm btn-danger btn-delete" title="Delete" data-id="'.$row->InvID.'" data-name="'.$row->InvNo.'" data-tr="'.$row->ReceiptSendPkgID.'"><i class="fas fa-trash"></i></button>&nbsp;';
			$col[] = $row->ReceiptSendPkgID;
			$data[] = $col;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Bms_Invoice_model->get_applicant_count_all(),
			"recordsFiltered" 	=> $this->Bms_Invoice_model->get_applicant_count_filtered(),
			"data" 				=> $data,
			"q"					=> $temp //temp for tracing db query

		);
		echo json_encode($output);
		exit;
	}

	function view_all_invoice(){
		$isActive = $this->input->post('isActive');
		$PeriodMonth = $this->input->post('PeriodMonth');
		$PeriodYear = $this->input->post('PeriodYear');
		$InvType = $this->input->post('InvType');
		$InvStsID = $this->input->post('InvStsID');

		$data = array();
		$res = $this->All_Invoice_model->get_applicant($isActive, $PeriodMonth, $PeriodYear, $InvType, $InvStsID);
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $row->InvID;
			$col[] = $row->PeriodYear . ' - ' .  (strlen($row->PeriodMonth) == 1 ? '0'.$row->PeriodMonth : $row->PeriodMonth);
			$col[] = ($row->InvType == 0 ? ($row->autocomplete == 0 ? 'Manual (On Air)' : 'Manual (Off Air)') : 'BMS');
			$col[] = '<strong>'.$row->InvNo.'</strong>' . '<br>' . '<i>'.$row->PONo.'</i> <br> <i>'.$row->PO_Type.'</i>';
			$col[] = '<i>'.$row->AgencyName.'</i> <br> <i>'.$row->AdvertiserName .'</i> <br> <strong>'.$row->ProductName.'</strong>';
			$col[] = $row->AE_Name;
			$col[] = 'Rp. ' . number_format($row->Gross,0,".",".");
			$col[] = $row->AgencyDisc;
			$col[] = 'Rp. ' . number_format($row->Nett,0,".",".");
			$col[] = $row->InvStsName;
			$col[] = date('d M Y H:i:s', strtotime($row->EntryBy_date));
			$col[] = $row->EntryBy;
			$col[] = '<button class="btn btn-sm btn-info btn-detail" title="View" data-id="'.$row->InvID.'" data-tr="'.$row->ReceiptSendPkgID.'"><i class="fas fa-eye"></i></button>&nbsp;';
			$data[] = $col;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->All_Invoice_model->get_applicant_count_all($isActive),
			"recordsFiltered" 	=> $this->All_Invoice_model->get_applicant_count_filtered($isActive, $PeriodMonth, $PeriodYear, $InvType, $InvStsID),
			"data" 				=> $data,
			"q"					=> $temp //temp for tracing db query

		);
		echo json_encode($output);
		exit;
	}

	function view_delManual_invoice()
	{
		$isActive 		= $this->input->post('isActive');
		$autocomplete 	= $this->input->post('autocomplete');
		$a = 1;
		$data = array();
		$res = $this->Invoice_model->get_applicant($isActive, $autocomplete);
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $row->InvID;
			$col[] = $row->PeriodYear . ' - ' .  (strlen($row->PeriodMonth) == 1 ? '0'.$row->PeriodMonth : $row->PeriodMonth);
			$col[] = '<strong>'.$row->InvNo.'</strong>' . '<br>' . '<i>'.$row->PONo.'</i> <br> <i>'.$row->PO_Type.'</i>';
			$col[] = '<i>'.$row->AgencyName.'</i> <br> <i>'.$row->AdvertiserName .'</i> <br> <strong>'.$row->ProductName.'</strong>';
			$col[] = $row->AE_Name;
			$col[] = 'Rp. ' . number_format($row->Gross,0,".",".");
			$col[] = $row->AgencyDisc;
			$col[] = 'Rp. ' . number_format($row->Nett,0,".",".");
			$col[] = '<button class="btn btn-sm btn-info btn-restore" title="Restore" data-id="'.$row->InvID.'" data-name="'.$row->InvNo.'" data-tr="'.$row->ReceiptSendPkgID.'"><i class="fas fa-undo"></i></button>';
			$col[] = $row->ReceiptSendPkgID;
			$data[] = $col;
			$a++;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Invoice_model->get_applicant_count_all($isActive, $autocomplete),
			"recordsFiltered" 	=> $this->Invoice_model->get_applicant_count_filtered($isActive, $autocomplete),
			"data" 				=> $data,
			"q"					=> $temp //temp for tracing db query

		);
		echo json_encode($output);
		exit;
	}

	function view_del_off_air()
	{
		$isActive 		= $this->input->post('isActive');
		$autocomplete 	= $this->input->post('autocomplete');
		$a = 1;
		$data = array();
		$res = $this->Invoice_model->get_applicant($isActive, $autocomplete);
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $row->InvID;
			$col[] = $row->PeriodYear . ' - ' .  (strlen($row->PeriodMonth) == 1 ? '0'.$row->PeriodMonth : $row->PeriodMonth);
			$col[] = '<strong>'.$row->InvNo.'</strong>' . '<br>' . '<i>'.$row->PONo.'</i> <br> <i>'.$row->PO_Type.'</i>';
			$col[] = '<i>'.$row->AgencyName.'</i> <br> <i>'.$row->AdvertiserName .'</i> <br> <strong>'.$row->ProductName.'</strong>';
			$col[] = $row->AE_Name;
			$col[] = 'Rp. ' . number_format($row->Gross,0,".",".");
			$col[] = $row->AgencyDisc;
			$col[] = 'Rp. ' . number_format($row->Nett,0,".",".");
			$col[] = '<button class="btn btn-sm btn-info btn-restore" title="Restore" data-id="'.$row->InvID.'" data-name="'.$row->InvNo.'" data-tr="'.$row->ReceiptSendPkgID.'"><i class="fas fa-undo"></i></button>';
			$col[] = $row->ReceiptSendPkgID;
			$data[] = $col;
			$a++;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Invoice_model->get_applicant_count_all($isActive, $autocomplete),
			"recordsFiltered" 	=> $this->Invoice_model->get_applicant_count_filtered($isActive, $autocomplete),
			"data" 				=> $data,
			"q"					=> $temp //temp for tracing db query

		);
		echo json_encode($output);
		exit;
	}

	function view_delBms_invoice()
	{
		$data = array();
		$res = $this->Bms_Invoice_model->get_applicant($this->input->post('isActive'));
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $row->InvID;
			$col[] = $row->PeriodYear . ' - ' .  (strlen($row->PeriodMonth) == 1 ? '0'.$row->PeriodMonth : $row->PeriodMonth);
			$col[] = '<strong>'.$row->InvNo.'</strong>' . '<br>' . '<i>'.$row->PONo.'</i> <br> <i>'.$row->PO_Type.'</i>';
			$col[] = '<i>'.$row->AgencyName.'</i> <br> <i>'.$row->AdvertiserName .'</i> <br> <strong>'.$row->ProductName.'</strong>';
			$col[] = $row->AE_Name;
			$col[] = 'Rp. ' . number_format($row->Gross,0,".",".");
			$col[] = $row->AgencyDisc;
			$col[] = 'Rp. ' . number_format($row->Nett,0,".",".");
			$col[] = '<button class="btn btn-sm btn-info btn-restore" title="Restore" data-id="'.$row->InvID.'" data-name="'.$row->InvNo.'" data-tr="'.$row->ReceiptSendPkgID.'"><i class="fas fa-undo"></i></button>';
			$col[] = $row->ReceiptSendPkgID;
			$data[] = $col;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Bms_Invoice_model->get_applicant_count_all($this->input->post('isActive')),
			"recordsFiltered" 	=> $this->Bms_Invoice_model->get_applicant_count_filtered($this->input->post('isActive')),
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
		$key = $this->input->post("key_2");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($key) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		$check = $this->Invoice_model->find($key);
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
		$InvNo 			= $this->input->post('InvNo');
		$InvType 		= $this->input->post('InvType');
		$PONo 			= $this->input->post('PONo');
		$PO_Type 		= $this->input->post('PO_Type');
		$AgencyName 	= $this->input->post('AgencyName');
		$AgencyAddr 	= $this->input->post('AgencyAddr');
		$AgencyTelp 	= $this->input->post('AgencyTelp');
		$AdvertiserName = $this->input->post('AdvertiserName');
		$AdvertiserAddr = $this->input->post('AdvertiserAddr');
		$AdvertiserTelp = $this->input->post('AdvertiserTelp');
		$ProductName 	= $this->input->post('ProductName');
		$AE_Name 		= $this->input->post('AE_Name');
		$AgencyDisc 	= $this->input->post('AgencyDisc');
		$Nett 			= $this->input->post('Nett');
		$Gross 			= $this->input->post('Gross');
		$PeriodMonth 	= $this->input->post('PeriodMonth');
		$PeriodYear 	= $this->input->post('PeriodYear');
		$BillingType 	= $this->input->post('BillingType');
		$autocomplete 	= $this->input->post('autocomplete');
		$type 			= $this->input->post('type');
		$id 			= $this->input->post('id');
		$tr_id 			= $this->input->post('tr_id');

		$type = ($type == 'update') ? 'update' : 'new';

		$check = $this->sitemodel->view('vw_manual_invoice', '*', ['InvNo'=>$this->input->post('InvNo')]);
		if ($check) {
			if ( $type == 'new' ) {
				$this->response['msg'] = "Invoice already exists.";
				echo json_encode($this->response);
				exit;
			}
		}

		$data = [
			'InvNo'				=>	$InvNo,
			'InvType'			=>	$InvType,
			'PONo'				=>	$PONo,
			'PO_Type'			=>	$PO_Type,
			'AgencyName'		=>	$AgencyName,
			'AgencyAddr'		=>	$AgencyAddr,
			'AgencyTelp'		=>	$AgencyTelp,
			'AdvertiserName'	=>	$AdvertiserName,
			'AdvertiserAddr'	=>	$AdvertiserAddr,
			'AdvertiserTelp'	=>	$AdvertiserTelp,
			'ProductName'		=>	$ProductName,
			'AE_Name'			=>	$AE_Name,
			'AgencyDisc'		=>	$AgencyDisc,
			'Nett'				=>	$Nett,
			'Gross'				=>	$Gross,
			'PeriodMonth' 		=> 	$PeriodMonth,
			'PeriodYear' 		=> 	$PeriodYear,
			'BillingType' 		=> 	$BillingType,
			'autocomplete' 		=> 	$autocomplete,
			'EditBy_date'		=>	date('Y-m-d H:i:s'),
			'EditBy'			=>	$this->log_user, 
		];



		if ($type == 'new') {
			$data['EntryBy_date'] = date('Y-m-d H:i:s');
			$data['EntryBy'] = $this->log_user;
		}

		if ($type == 'update') {
			$this->sitemodel->update("tab_invoice", $data, ["InvID"=>$id]);

			$data_track = [
				'EditBy'		=> $this->log_user, 
				'EditBy_date'	=> date('Y-m-d H:i:s'),
			];

			$this->sitemodel->update("tr_tracking", $data_track, ["ReceiptSendPkgID"=>$tr_id]);
		}else{
			$result = $this->sitemodel->insert("tab_invoice", $data);

			$data_track = [
				'InvID' 		=> $result,
				'InvStsID' 		=> '1',
				'EntryBy'		=> $this->log_user,
				'EntryBy_date'	=> date('Y-m-d H:i:s'),
				'EditBy'		=> $this->log_user, 
				'EditBy_date'	=> date('Y-m-d H:i:s'),
			];
			$this->sitemodel->insert("tr_tracking", $data_track);
		}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = ($type == "update") ? "Successfully modified data." : "Successfully insert data.";
		echo json_encode($this->response);
		exit;

	}

	function delete(){
		// echo json_encode($this->input->post());die;
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$InvID = $this->input->post("key");
		$ReceiptSendPkgID = $this->input->post("key_2");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($InvID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		if ( empty($ReceiptSendPkgID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		$check = $this->Invoice_model->find($ReceiptSendPkgID);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		// Delete 
		$data = [
			'isActive' 		=> 1,
			'DeleteBy_date'	=> date('Y-m-d H:i:s'),
			'DeleteBy'		=> $this->log_user, 
		];
		$this->sitemodel->update("tab_invoice", $data, ["InvID"=>$InvID]);
		$data_track = [
			'isActive' 		=> 1,
			'DeleteBy_date'	=> date('Y-m-d H:i:s'),
			'DeleteBy'		=> $this->log_user, 
		];
		$this->sitemodel->update("tr_tracking", $data_track, ["ReceiptSendPkgID"=>$ReceiptSendPkgID]);
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
		$InvID = $this->input->post("key");
		$ReceiptSendPkgID = $this->input->post("key_2");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($InvID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		if ( empty($ReceiptSendPkgID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		$check = $this->Invoice_model->find($ReceiptSendPkgID, '1');
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		// Delete 
		$data = [
			'isActive' 		=> 0,
			'DeleteBy_date'	=> NULL,
			'DeleteBy'		=> NULL, 
		];
		$this->sitemodel->update("tab_invoice", $data, ["InvID"=>$InvID]);
		$data_track = [
			'isActive' 		=> 0,
			'DeleteBy_date'	=> NULL,
			'DeleteBy'		=> NULL, 
		];
		$this->sitemodel->update("tr_tracking", $data_track, ["ReceiptSendPkgID"=>$ReceiptSendPkgID]);
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully recover data.";
		echo json_encode($this->response);
		exit;
	}

	function send_to_ga()
	{
		// echo json_encode($this->input->post());die;
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$key = $this->input->post("key");
		$key_2 = $this->input->post("key_2");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($key) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		if ( empty($key_2) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/

		$length = sizeof($key);

		for ( $i = 0; $i < $length; $i++) { 
			/*** Accessing DB Area ***/
			$check = $this->Invoice_model->find($key_2[$i]);
			if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
			$data = [
				'InvID' 		=> $key[$i],
				'InvStsID' 		=> '2',
				'EntryBy'		=> $this->log_user,
				'EntryBy_date'	=> date('Y-m-d H:i:s'),
				'EditBy'		=> $this->log_user, 
				'EditBy_date'	=> date('Y-m-d H:i:s'),
			];
			$this->sitemodel->insert("tr_tracking", $data);
		}

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully Send Data to GA.";
		echo json_encode($this->response);
		exit;
	}

	function list_order_num()
	{
		$orders = $this->guzzle->guzzle_get_invoices('track/orders', $this->input->post('PeriodMonth'), $this->input->post('PeriodYear'));
		$data_orders = json_decode($orders);

		if ($data_orders->results == 0) {
			$this->response['msg'] = "No data found.";
			echo json_encode($this->response);
			exit; 
		}

		$this->response['type'] = 'done';
		$this->response['msg'] = $data_orders->rows;
		echo json_encode($this->response);
		exit;
	}

	function search_order_no()
	{
		$check = array();
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$order_no 		= $this->input->post('order_no');

		$orders = $this->guzzle->guzzle_get_invoices('track/orders', $this->input->post('PeriodMonth'), $this->input->post('PeriodYear'));
		$data_orders = json_decode($orders);
		$lengthContent = sizeof($data_orders->rows);

		// ##########################################################################

		for ( $i = 0 ; $i < $lengthContent; $i++) { 
			if ($data_orders->rows[$i]->order_no == $order_no) {
				$check = $data_orders->rows[$i];
			}
		}

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

	function get_bms_invoice()
	{;
		$data_bms 		= array();
		$data_mnl		= array();
		$checked		= '';

		$invoices = $this->guzzle->guzzle_get_invoices('track/invoices', $this->input->post('PeriodMonth'), $this->input->post('PeriodYear'));
		$data_invoices = json_decode($invoices);
		$lengthContent = sizeof($data_invoices->rows);

		// ##########################################################################

		$check = $this->sitemodel->view('vw_manual_invoice', 'PONo', ['PeriodMonth'=>$this->input->post('PeriodMonth'), 'PeriodYear'=>$this->input->post('PeriodYear')]);

		if ($check) {
			foreach ($check as $row) {
				$col = array();
				$col[] = $row->PONo;
				$data_mnl[] = $col;
			}
		}

		// ##########################################################################

		for ( $i = 0 ; $i < $lengthContent; $i++) { 

			$check = $this->sitemodel->view('vw_manual_invoice', 'PONo', [ 'PONo' => $data_invoices->rows[$i]->order_no, 'PeriodMonth'=>$this->input->post('PeriodMonth'), 'PeriodYear'=>$this->input->post('PeriodYear') ] );
			$check2 = $this->sitemodel->view('vw_bms_invoice', 'PONo', [ 'PONo' => $data_invoices->rows[$i]->order_no, 'PeriodMonth'=>$this->input->post('PeriodMonth'), 'PeriodYear'=>$this->input->post('PeriodYear') ] );
			if ($check == 0 && $check2 == 0) {
				$checked ='checked';
			}else{
				$checked ='not checked';
			}

			$col = array();
			$col[] = $data_invoices->rows[$i]->order_no;
			$col[] = '<button class="btn btn-sm btn-info btn-detail" title="Detail" data-id="'.$data_invoices->rows[$i]->order_no.'"><i class="fas fa-eye"></i></button>&nbsp;';
			$col[] = $checked;
			$col[] = $data_invoices->rows[$i]->invoice_no;
			$col[] = $data_invoices->rows[$i]->agency_name;
			$col[] = $data_invoices->rows[$i]->advertiser_name;
			$data_bms[] = $col;
		}

		$output = array(
			"data_bms" 	=> $data_bms,
			"data_mnl" 	=> $data_mnl,
		);
		echo json_encode($output);
		exit;
	}

	function search_order_no_bms()
	{
		$check = array();
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$order_no 		= $this->input->post('order_no');
		$invoices = $this->guzzle->guzzle_get_invoices('track/invoices', $this->input->post('PeriodMonth'), $this->input->post('PeriodYear'));
		$data_invoices = json_decode($invoices);
		$lengthContent = sizeof($data_invoices->rows);

		// ##########################################################################

		for ( $i = 0 ; $i < $lengthContent; $i++) { 
			if ($data_invoices->rows[$i]->order_no == $order_no) {
				$check = $data_invoices->rows[$i];
			}
		}

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

	function import_invoice()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$invoice_no 		= $this->input->post('invoice_no');
		if ( empty($invoice_no) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}

		$lengthInvoices 	= sizeof($invoice_no);
		$invoices 			= $this->guzzle->guzzle_get_invoices('track/invoices', $this->input->post('PeriodMonth'), $this->input->post('PeriodYear'));
		$data_invoices 		= json_decode($invoices);
		$lengthContent 		= sizeof($data_invoices->rows);

		// ############################################################################################################################################

		for ( $i = 0; $i < $lengthInvoices; $i++) { 

			$specific = $this->guzzle->guzzle_get_invoices('track/invoices',$this->input->post('PeriodMonth'), $this->input->post('PeriodYear'), ['invoice_no'=>$invoice_no[$i]] );
			$data_specific = json_decode($specific);

			// echo json_encode($data_specific);

			if ($data_specific->results == 1) {
				$data_bms_inv = [
					'InvNo'				=>	$data_specific->rows[0]->invoice_no,
					'InvType'			=>	1,
					'PONo'				=>	$data_specific->rows[0]->order_no,
					'PO_Type'			=>	$data_specific->rows[0]->po_type,
					'AgencyName'		=>	$data_specific->rows[0]->agency_name,
					'AgencyAddr'		=>	$data_specific->rows[0]->agency_address,
					'AgencyTelp'		=>	$data_specific->rows[0]->agency_telp,
					'AdvertiserName'	=>	$data_specific->rows[0]->advertiser_name,
					'AdvertiserAddr'	=>	$data_specific->rows[0]->advertiser_address,
					'AdvertiserTelp'	=>	$data_specific->rows[0]->advertiser_telp,
					'ProductName'		=>	$data_specific->rows[0]->product_name,
					'AE_Name'			=>	strtoupper($data_specific->rows[0]->ae_name),
					'AgencyDisc'		=>	$data_specific->rows[0]->discount,
					'Nett'				=>	$data_specific->rows[0]->total,
					'Gross'				=>	$data_specific->rows[0]->sub_total,
					'PeriodMonth' 		=> 	$this->input->post('PeriodMonth'),
					'PeriodYear' 		=> 	$this->input->post('PeriodYear'),
					'autocomplete'		=>	0,
					'BillingType' 		=> 	$data_specific->rows[0]->billing_type,
					'EntryBy_date'		=>	date('Y-m-d H:i:s'),
					'EntryBy'			=>	$this->log_user, 
					'EditBy_date'		=>	date('Y-m-d H:i:s'),
					'EditBy'			=>	$this->log_user, 
				];

				$result = $this->sitemodel->insert("tab_invoice", $data_bms_inv);

				$data_track = [
					'InvID' 		=> $result,
					'InvStsID' 		=> '1',
					'EntryBy'		=> $this->log_user,
					'EntryBy_date'	=> date('Y-m-d H:i:s'),
					'EditBy'		=> $this->log_user, 
					'EditBy_date'	=> date('Y-m-d H:i:s'),
				];
				$this->sitemodel->insert("tr_tracking", $data_track);
			}

		}
		// die;
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully import data.";
		echo json_encode($this->response);
		exit;
		// ###########################################################################################################################################
	}
}