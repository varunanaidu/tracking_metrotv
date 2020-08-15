<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

class Report extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Report';
		$this->fragment['header_child']		= 'Report';
		$this->fragment['breadcrumb'] = ['Report', 'Report'];
		$this->fragment['js']		= base_url('assets/js/pages/report.js');
		$this->fragment['pagename'] = 'pages/view-report';
		$this->fragment['months']   = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

		$this->fragment['data_status'] = $this->sitemodel->view('vw_inv_sts', '*');
		$this->load->view('layout/main-site', $this->fragment);
	}

	function find()
	{
		$PeriodMonth				= $this->input->post('PeriodMonth');
		$PeriodYear					= $this->input->post('PeriodYear');
		$invoices 					= array();
		$manual_off_air_invoices 	= array();
		$manual_on_air_invoices 	= array();
		$bms_invoices 				= array();
		$total_manual_off_air		= 0;
		$total_manual_on_air		= 0;
		$total_bms					= 0;

		$q1 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>1, 'InvStsID'=>1]);
		$manual_off_air_invoices['EntryByBilling'] = $q1;
		foreach ($q1 as $row) {
			if ($row->TOTAL != 0) {
				$total_manual_off_air = $row->TOTAL;
				$preq1 = ( $row->TOTAL/$total_manual_off_air ) * 100;
				array_push($manual_off_air_invoices['EntryByBilling'], round($preq1));
			}else{
				array_push($manual_off_air_invoices['EntryByBilling'], 0);
			}
		}
		$q2 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>1,  'InvStsID'=>2]);
		$manual_off_air_invoices['SendToGA'] = $q2;
		if ($total_manual_off_air != 0) {
			foreach ($q2 as $row) {
				$preq2 = round(($row->TOTAL / $total_manual_off_air) * 100, 2);
				array_push($manual_off_air_invoices['SendToGA'], round($preq2));
			}
		}else{
			array_push($manual_off_air_invoices['SendToGA'], 0);
		}
		$q3 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>1,  'InvStsID'=>3]);
		$manual_off_air_invoices['ApproveByGA'] = $q3;
		if ($total_manual_off_air != 0) {
			foreach ($q3 as $row) {
				$preq3 = round(($row->TOTAL / $total_manual_off_air) * 100, 2);
				array_push($manual_off_air_invoices['ApproveByGA'], round($preq3));
			}
		}else{
			array_push($manual_off_air_invoices['ApproveByGA'], 0);
		}
		$q4 = $this->sitemodel->custom_query('
			SELECT COUNT(ReceiptSendPkgID) AS TOTAL FROM vw_tracking WHERE PeriodMonth = '.$PeriodMonth.' AND PeriodYear = '.$PeriodYear.' AND InvType = 0 AND autocomplete = 1 AND InvStsID IN (4,5)
			');
		$manual_off_air_invoices['Delivery'] = $q4;
		if ($total_manual_off_air != 0) {
			foreach ($q4 as $row) {
				$preq4 = round(($row->TOTAL / $total_manual_off_air) * 100, 2);
				array_push($manual_off_air_invoices['Delivery'], round($preq4));
			}
		}else{
			array_push($manual_off_air_invoices['Delivery'], 0);
		}
		$q5 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>1,  'InvStsID'=>6]);
		$manual_off_air_invoices['Received'] = $q5;
		if ($total_manual_off_air != 0) {
			foreach ($q5 as $row) {
				$preq5 = round(($row->TOTAL / $total_manual_off_air) * 100, 2);
				array_push($manual_off_air_invoices['Received'], round($preq5));
			}
		}else{
			array_push($manual_off_air_invoices['Received'], 0);
		}
		$q6 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>1,  'InvStsID'=>8]);
		$manual_off_air_invoices['Returned'] = $q6;
		if ($total_manual_off_air != 0) {
			foreach ($q6 as $row) {
				$preq6 = round(($row->TOTAL / $total_manual_off_air) * 100, 2);
				array_push($manual_off_air_invoices['Returned'], round($preq6));
			}
		}else{
			array_push($manual_off_air_invoices['Returned'], 0);
		}

		$invoices['manual_off_air'] = $manual_off_air_invoices;

		// ##########################################################################################################################################

		$r1 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>0, 'InvStsID'=>1]);
		$manual_on_air_invoices['EntryByBilling'] = $r1;
		foreach ($r1 as $row) {
			if ($row->TOTAL != 0) {
				$total_manual_on_air = $row->TOTAL;
				$prer1 = ( $row->TOTAL/$total_manual_on_air ) * 100;
				array_push($manual_on_air_invoices['EntryByBilling'], round($prer1));
			}else{
				array_push($manual_on_air_invoices['EntryByBilling'], 0);
			}
		}
		$r2 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>0, 'InvStsID'=>2]);
		$manual_on_air_invoices['SendToGA'] = $r2;
		if ($total_manual_on_air != 0) {
			foreach ($r2 as $row) {
				$prer2 = round(($row->TOTAL / $total_manual_on_air) * 100, 2);
				array_push($manual_on_air_invoices['SendToGA'], round($prer2));
			}
		}else{
			array_push($manual_on_air_invoices['SendToGA'], 0);
		}
		$r3 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>0, 'InvStsID'=>3]);
		$manual_on_air_invoices['ApproveByGA'] = $r3;
		if ($total_manual_on_air != 0) {
			foreach ($r3 as $row) {
				$prer3 = round(($row->TOTAL / $total_manual_on_air) * 100, 2);
				array_push($manual_on_air_invoices['ApproveByGA'], round($prer3));
			}
		}else{
			array_push($manual_on_air_invoices['ApproveByGA'], 0);
		}
		$r4 = $this->sitemodel->custom_query('
			SELECT COUNT(ReceiptSendPkgID) AS TOTAL FROM vw_tracking WHERE PeriodMonth = '.$PeriodMonth.' AND PeriodYear = '.$PeriodYear.' AND InvType = 0 AND autocomplete = 0 AND InvStsID IN (4,5)
			');
		$manual_on_air_invoices['Delivery'] = $r4;
		if ($total_manual_on_air != 0) {
			foreach ($r4 as $row) {
				$prer4 = round(($row->TOTAL / $total_manual_on_air) * 100, 2);
				array_push($manual_on_air_invoices['Delivery'], round($prer4));
			}
		}else{
			array_push($manual_on_air_invoices['Delivery'], 0);
		}
		$r5 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>0, 'InvStsID'=>6]);
		$manual_on_air_invoices['Received'] = $r5;
		if ($total_manual_on_air != 0) {
			foreach ($r5 as $row) {
				$prer5 = round(($row->TOTAL / $total_manual_on_air) * 100, 2);
				array_push($manual_on_air_invoices['Received'], round($prer5));
			}
		}else{
			array_push($manual_on_air_invoices['Received'], 0);
		}
		$r6 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>0, 'InvStsID'=>8]);
		$manual_on_air_invoices['Returned'] = $r6;
		if ($total_manual_on_air != 0) {
			foreach ($r6 as $row) {
				$prer6 = round(($row->TOTAL / $total_manual_on_air) * 100, 2);
				array_push($manual_on_air_invoices['Returned'], round($prer6));
			}
		}else{
			array_push($manual_on_air_invoices['Returned'], 0);
		}

		$invoices['manual_on_air'] = $manual_on_air_invoices;

		// ##########################################################################################################################################
		
		$s1 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>1, 'InvStsID'=>1]);
		$bms_invoices['EntryByBilling'] = $s1;
		foreach ($s1 as $row) {
			if ($row->TOTAL != 0) {
				$total_bms = $row->TOTAL;
				$pres1 = ( $row->TOTAL/$total_bms ) * 100;
				array_push($bms_invoices['EntryByBilling'], round($pres1));
			}else{
				array_push($bms_invoices['EntryByBilling'], 0);
			}
		}
		$s2 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>1, 'InvStsID'=>2]);
		$bms_invoices['SendToGA'] = $s2;
		if ($total_bms != 0) {
			foreach ($s2 as $row) {
				$pres2 = round(($row->TOTAL / $total_bms) * 100, 2);
				array_push($bms_invoices['SendToGA'], round($pres2));
			}
		}else{
			array_push($bms_invoices['SendToGA'], 0);
		}
		$s3 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>1, 'InvStsID'=>3]);
		$bms_invoices['ApproveByGA'] = $s3;
		if ($total_bms != 0) {
			foreach ($s3 as $row) {
				$pres3 = round(($row->TOTAL / $total_bms) * 100, 2);
				array_push($bms_invoices['ApproveByGA'], round($pres3));
			}
		}else{
			array_push($bms_invoices['ApproveByGA'], 0);
		}
		$s4 = $this->sitemodel->custom_query('
			SELECT COUNT(ReceiptSendPkgID) AS TOTAL FROM vw_tracking WHERE PeriodMonth = '.$PeriodMonth.' AND PeriodYear = '.$PeriodYear.' AND InvType = 1 AND InvStsID IN (4,5)
			');
		$bms_invoices['Delivery'] = $s4;
		if ($total_bms != 0) {
			foreach ($s4 as $row) {
				$pres4 = round(($row->TOTAL / $total_bms) * 100, 2);
				array_push($bms_invoices['Delivery'], round($pres4));
			}
		}else{
			array_push($bms_invoices['Delivery'], 0);
		}
		$s5 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>1, 'InvStsID'=>6]);
		$bms_invoices['Received'] = $s5;
		if ($total_bms != 0) {
			foreach ($s5 as $row) {
				$pres5 = round(($row->TOTAL / $total_bms) * 100, 2);
				array_push($bms_invoices['Received'], round($pres5));
			}
		}else{
			array_push($bms_invoices['Received'], 0);
		}
		$s6 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>1, 'InvStsID'=>8]);
		$bms_invoices['Returned'] = $s6;
		if ($total_bms != 0) {
			foreach ($s6 as $row) {
				$pres6 = round(($row->TOTAL / $total_bms) * 100, 2);
				array_push($bms_invoices['Returned'], round($pres6));
			}
		}else{
			array_push($bms_invoices['Returned'], 0);
		}

		$invoices['bms_invoice'] = $bms_invoices;

		// ##########################################################################################################################################

		// echo json_encode($total_bms);die;

		$this->response['msg']  = $invoices;
		$this->response['type'] = 'done';
		echo json_encode($this->response);
		exit;
	}

	public function details_invoice()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		$detailsInv = $this->input->post('detailsInv');
		$InvType = $this->input->post('InvType');
		$PeriodYear = $this->input->post('PeriodYear');
		$PeriodMonth = $this->input->post('PeriodMonth');

		switch ($InvType) {
			case 'm1':

			switch ($detailsInv) {
				case 'not_send_to_ga':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_manual_off_air_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 2
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				case 'not_approve_by_ga':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_manual_off_air_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 3
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				case 'not_send_to_clients':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_manual_off_air_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 4
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				case 'not_received_by_clients':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_manual_off_air_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 6
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				
				default:
					# code...
				break;
			}
			$this->response['title'] = 'Manual Off Air Invoices';
			break;
			case 'm0':

			switch ($detailsInv) {
				case 'not_send_to_ga':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_manual_on_air_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 2
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				case 'not_approve_by_ga':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_manual_on_air_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 3
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				case 'not_send_to_clients':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_manual_on_air_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 4
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				case 'not_received_by_clients':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_manual_on_air_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 6
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				
				default:
					# code...
				break;
			}
			$this->response['title'] = 'Manual On Air Invoices';
			break;
			case 'b':

			switch ($detailsInv) {
				case 'not_send_to_ga':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_bms_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 2
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				case 'not_approve_by_ga':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_bms_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 3
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				case 'not_send_to_clients':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_bms_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 4
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				case 'not_received_by_clients':
				$check = $this->sitemodel->custom_query("
					SELECT * FROM view_tracking_bms_invoices WHERE PeriodYear = ".$PeriodYear." AND PeriodMonth = ".$PeriodMonth." AND InvStsID < 6
					");
				if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
				$this->response['msg'] = $check;
				break;
				
				default:
					# code...
				break;
			}
			$this->response['title'] = 'BMS Invoices';
			break;
			
			default:
				# code...
			break;
		}

		$this->response['type'] = 'done';
		echo json_encode($this->response);
		exit;
	}

	public function report_pdf($PeriodYear, $PeriodMonth)
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$invoices 					= array();
		$manual_off_air_invoices 	= array();
		$manual_on_air_invoices 	= array();
		$bms_invoices 				= array();
		$total_manual_off_air		= 0;
		$total_manual_on_air		= 0;
		$total_bms					= 0;

		$q1 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>1, 'InvStsID'=>1]);
		$manual_off_air_invoices['EntryByBilling'] = $q1;
		foreach ($q1 as $row) {
			if ($row->TOTAL != 0) {
				$total_manual_off_air = $row->TOTAL;
				$preq1 = ( $row->TOTAL/$total_manual_off_air ) * 100;
				array_push($manual_off_air_invoices['EntryByBilling'], round($preq1));
			}else{
				array_push($manual_off_air_invoices['EntryByBilling'], 0);
			}
		}
		$q2 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>1,  'InvStsID'=>2]);
		$manual_off_air_invoices['SendToGA'] = $q2;
		if ($total_manual_off_air != 0) {
			foreach ($q2 as $row) {
				$preq2 = round(($row->TOTAL / $total_manual_off_air) * 100, 2);
				array_push($manual_off_air_invoices['SendToGA'], round($preq2));
			}
		}else{
			array_push($manual_off_air_invoices['SendToGA'], 0);
		}
		$q3 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>1,  'InvStsID'=>3]);
		$manual_off_air_invoices['ApproveByGA'] = $q3;
		if ($total_manual_off_air != 0) {
			foreach ($q3 as $row) {
				$preq3 = round(($row->TOTAL / $total_manual_off_air) * 100, 2);
				array_push($manual_off_air_invoices['ApproveByGA'], round($preq3));
			}
		}else{
			array_push($manual_off_air_invoices['ApproveByGA'], 0);
		}
		$q4 = $this->sitemodel->custom_query('
			SELECT COUNT(ReceiptSendPkgID) AS TOTAL FROM vw_tracking WHERE PeriodMonth = '.$PeriodMonth.' AND PeriodYear = '.$PeriodYear.' AND InvType = 0 AND autocomplete = 1 AND InvStsID IN (4,5)
			');
		$manual_off_air_invoices['Delivery'] = $q4;
		if ($total_manual_off_air != 0) {
			foreach ($q4 as $row) {
				$preq4 = round(($row->TOTAL / $total_manual_off_air) * 100, 2);
				array_push($manual_off_air_invoices['Delivery'], round($preq4));
			}
		}else{
			array_push($manual_off_air_invoices['Delivery'], 0);
		}
		$q5 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>1,  'InvStsID'=>6]);
		$manual_off_air_invoices['Received'] = $q5;
		if ($total_manual_off_air != 0) {
			foreach ($q5 as $row) {
				$preq5 = round(($row->TOTAL / $total_manual_off_air) * 100, 2);
				array_push($manual_off_air_invoices['Received'], round($preq5));
			}
		}else{
			array_push($manual_off_air_invoices['Received'], 0);
		}
		$q6 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>1,  'InvStsID'=>8]);
		$manual_off_air_invoices['Returned'] = $q6;
		if ($total_manual_off_air != 0) {
			foreach ($q6 as $row) {
				$preq6 = round(($row->TOTAL / $total_manual_off_air) * 100, 2);
				array_push($manual_off_air_invoices['Returned'], round($preq6));
			}
		}else{
			array_push($manual_off_air_invoices['Returned'], 0);
		}

		$invoices['manual_off_air'] = $manual_off_air_invoices;

		// ##########################################################################################################################################

		$r1 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>0, 'InvStsID'=>1]);
		$manual_on_air_invoices['EntryByBilling'] = $r1;
		foreach ($r1 as $row) {
			if ($row->TOTAL != 0) {
				$total_manual_on_air = $row->TOTAL;
				$prer1 = ( $row->TOTAL/$total_manual_on_air ) * 100;
				array_push($manual_on_air_invoices['EntryByBilling'], round($prer1));
			}else{
				array_push($manual_on_air_invoices['EntryByBilling'], 0);
			}
		}
		$r2 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>0, 'InvStsID'=>2]);
		$manual_on_air_invoices['SendToGA'] = $r2;
		if ($total_manual_on_air != 0) {
			foreach ($r2 as $row) {
				$prer2 = round(($row->TOTAL / $total_manual_on_air) * 100, 2);
				array_push($manual_on_air_invoices['SendToGA'], round($prer2));
			}
		}else{
			array_push($manual_on_air_invoices['SendToGA'], 0);
		}
		$r3 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>0, 'InvStsID'=>3]);
		$manual_on_air_invoices['ApproveByGA'] = $r3;
		if ($total_manual_on_air != 0) {
			foreach ($r3 as $row) {
				$prer3 = round(($row->TOTAL / $total_manual_on_air) * 100, 2);
				array_push($manual_on_air_invoices['ApproveByGA'], round($prer3));
			}
		}else{
			array_push($manual_on_air_invoices['ApproveByGA'], 0);
		}
		$r4 = $this->sitemodel->custom_query('
			SELECT COUNT(ReceiptSendPkgID) AS TOTAL FROM vw_tracking WHERE PeriodMonth = '.$PeriodMonth.' AND PeriodYear = '.$PeriodYear.' AND InvType = 0 AND autocomplete = 0 AND InvStsID IN (4,5)
			');
		$manual_on_air_invoices['Delivery'] = $r4;
		if ($total_manual_on_air != 0) {
			foreach ($r4 as $row) {
				$prer4 = round(($row->TOTAL / $total_manual_on_air) * 100, 2);
				array_push($manual_on_air_invoices['Delivery'], round($prer4));
			}
		}else{
			array_push($manual_on_air_invoices['Delivery'], 0);
		}
		$r5 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>0, 'InvStsID'=>6]);
		$manual_on_air_invoices['Received'] = $r5;
		if ($total_manual_on_air != 0) {
			foreach ($r5 as $row) {
				$prer5 = round(($row->TOTAL / $total_manual_on_air) * 100, 2);
				array_push($manual_on_air_invoices['Received'], round($prer5));
			}
		}else{
			array_push($manual_on_air_invoices['Received'], 0);
		}
		$r6 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>0, 'autocomplete'=>0, 'InvStsID'=>8]);
		$manual_on_air_invoices['Returned'] = $r6;
		if ($total_manual_on_air != 0) {
			foreach ($r6 as $row) {
				$prer6 = round(($row->TOTAL / $total_manual_on_air) * 100, 2);
				array_push($manual_on_air_invoices['Returned'], round($prer6));
			}
		}else{
			array_push($manual_on_air_invoices['Returned'], 0);
		}

		$invoices['manual_on_air'] = $manual_on_air_invoices;

		// ##########################################################################################################################################
		
		$s1 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>1, 'InvStsID'=>1]);
		$bms_invoices['EntryByBilling'] = $s1;
		foreach ($s1 as $row) {
			if ($row->TOTAL != 0) {
				$total_bms = $row->TOTAL;
				$pres1 = ( $row->TOTAL/$total_bms ) * 100;
				array_push($bms_invoices['EntryByBilling'], round($pres1));
			}else{
				array_push($bms_invoices['EntryByBilling'], 0);
			}
		}
		$s2 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>1, 'InvStsID'=>2]);
		$bms_invoices['SendToGA'] = $s2;
		if ($total_bms != 0) {
			foreach ($s2 as $row) {
				$pres2 = round(($row->TOTAL / $total_bms) * 100, 2);
				array_push($bms_invoices['SendToGA'], round($pres2));
			}
		}else{
			array_push($bms_invoices['SendToGA'], 0);
		}
		$s3 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>1, 'InvStsID'=>3]);
		$bms_invoices['ApproveByGA'] = $s3;
		if ($total_bms != 0) {
			foreach ($s3 as $row) {
				$pres3 = round(($row->TOTAL / $total_bms) * 100, 2);
				array_push($bms_invoices['ApproveByGA'], round($pres3));
			}
		}else{
			array_push($bms_invoices['ApproveByGA'], 0);
		}
		$s4 = $this->sitemodel->custom_query('
			SELECT COUNT(ReceiptSendPkgID) AS TOTAL FROM vw_tracking WHERE PeriodMonth = '.$PeriodMonth.' AND PeriodYear = '.$PeriodYear.' AND InvType = 1 AND InvStsID IN (4,5)
			');
		$bms_invoices['Delivery'] = $s4;
		if ($total_bms != 0) {
			foreach ($s4 as $row) {
				$pres4 = round(($row->TOTAL / $total_bms) * 100, 2);
				array_push($bms_invoices['Delivery'], round($pres4));
			}
		}else{
			array_push($bms_invoices['Delivery'], 0);
		}
		$s5 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>1, 'InvStsID'=>6]);
		$bms_invoices['Received'] = $s5;
		if ($total_bms != 0) {
			foreach ($s5 as $row) {
				$pres5 = round(($row->TOTAL / $total_bms) * 100, 2);
				array_push($bms_invoices['Received'], round($pres5));
			}
		}else{
			array_push($bms_invoices['Received'], 0);
		}
		$s6 = $this->sitemodel->view('vw_tracking', 'COUNT(ReceiptSendPkgID) AS TOTAL', ['PeriodMonth'=>$PeriodMonth, 'PeriodYear'=>$PeriodYear, 'InvType'=>1, 'InvStsID'=>8]);
		$bms_invoices['Returned'] = $s6;
		if ($total_bms != 0) {
			foreach ($s6 as $row) {
				$pres6 = round(($row->TOTAL / $total_bms) * 100, 2);
				array_push($bms_invoices['Returned'], round($pres6));
			}
		}else{
			array_push($bms_invoices['Returned'], 0);
		}

		$invoices['bms_invoice'] = $bms_invoices;

		$data = array(
			'result' => $invoices,
			'PeriodYear' => $PeriodYear,
			'PeriodMonth' => $PeriodMonth,
		);

		$this->load->library('pdf');

		$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->filename = "report-invoice.pdf";
		$this->pdf->load_view('report_invoice', $data);
	}

}