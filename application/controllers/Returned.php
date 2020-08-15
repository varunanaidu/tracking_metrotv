<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

/**
 * 
 */
class Returned extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Returned_model');
	}

	function index()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['header_parent'] = 'Process';
		$this->fragment['header_child']		= 'Returned';
		$this->fragment['breadcrumb'] = ['Process', 'Returned'];
		$this->fragment['js']		= base_url('assets/js/pages/returned.js');
		$this->fragment['pagename'] = 'pages/view-returned';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function view_returned()
	{
		$data = array();
		$res = $this->Returned_model->get_applicant();
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();

			$messenger = ( empty($row->CourierStatus) == FALSE ? ( $row->CourierStatus == 1 ? '(External) ' . $row->CourierCode . '-' . $row->CourierName : '(Internal) ' . $row->CourierCode . '-' . $row->CourierName ) : '' );

			$button = '<button class="btn btn-sm btn-info btn-detail" title="Detail" data-id="'.$row->ReceiptSendPkgID.'"><i class="fas fa-eye"></i></button>&nbsp;';

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
			$col[] = $row->ReasonReturned;
			$col[] = ($row->InvType == 0 ? ($row->autocomplete == 0 ? 'Manual (On Air)' : 'Manual (Off Air)') : 'BMS');
			$col[] = $button;
			$data[] = $col;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Returned_model->get_applicant_count_all(),
			"recordsFiltered" 	=> $this->Returned_model->get_applicant_count_filtered(),
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
		$check = $this->Returned_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

}