<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

/**
 * 
 */
class Received extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Received_model');
	}

	function index()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->fragment['data_courier'] = $this->sitemodel->view('vw_courier', '*');

		$this->fragment['header_parent'] = 'Process';
		$this->fragment['header_child']		= 'Received';
		$this->fragment['breadcrumb'] = ['Process', 'Received'];
		$this->fragment['js']		= base_url('assets/js/pages/received.js');
		$this->fragment['pagename'] = 'pages/view-received';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function view_received()
	{
		$data = array();
		$res = $this->Received_model->get_applicant();
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();

			$messenger = ( empty($row->CourierStatus) == FALSE ? ( $row->CourierStatus == 1 ? '(External) ' . $row->CourierCode . '-' . $row->CourierName : '(Internal) ' . $row->CourierCode . '-' . $row->CourierName ) : '' );

			$button = '<button class="btn btn-sm btn-info btn-detail" title="Detail" data-id="'.$row->ReceiptSendPkgID.'"><i class="fas fa-eye"></i></button>&nbsp;<a class="btn btn-sm btn-success btn-pdf" title="Print" href="'.base_url('received/laporan_pdf/').$row->ReceiptSendPkgID.'" target="_blank"><i class="fas fa-print"></i></a>&nbsp;';

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
			$col[] = $button;
			$data[] = $col;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Received_model->get_applicant_count_all(),
			"recordsFiltered" 	=> $this->Received_model->get_applicant_count_filtered(),
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
		$check = $this->Received_model->find($key);
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
		$check = $this->Received_model->find($key);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		foreach ($check as $row) {
			$InvStsID = $row->InvStsID;
			$condi = [
				'InvStsID <'  => $InvStsID,
				'InvStsID !=' => ($row->CourierStatus == 1 ? 5 : 4)
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

	public function laporan_pdf($ReceiptSendPkgID){
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}

		/*** Accessing DB Area ***/
		$check = $this->Received_model->find($ReceiptSendPkgID);
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		/*foreach ($check as $row) {
			echo base_url('assets/images/invoices/') . $row->ReceiptPathFilename;die;
		}*/

		$data = array(
			"result" => $check
		);

		$this->load->library('pdf');

		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = "laporan-testing.pdf";
		$this->pdf->load_view('laporan_pdf', $data);

	}

}