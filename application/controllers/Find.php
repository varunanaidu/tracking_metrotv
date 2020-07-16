<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Find extends MY_Controller {

	public function index()
	{
		if (!$this->hasLogin()) {
			redirect('site/login');
		}

		$this->load->view('front/index');
	}

	public function get_inv()
	{
		$i = 0;
		$__column_search = array('InvNo, PONo, ProductName, AE_Name');
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$inputInvoice = $this->input->post('inputInvoice');
		/*** Validate Area ***/
		if ( empty($inputInvoice) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}

		$this->db->select('*');
		$this->db->from('vw_tracking');
		$this->db->like('InvNo', $inputInvoice);
		$this->db->or_like('PONo', $inputInvoice);
		$this->db->or_like('ProductName', $inputInvoice);
		$this->db->or_like('AE_Name', $inputInvoice);
		$this->db->group_by('InvID');
		$query = $this->db->get();
		// echo json_encode($this->db->last_query());die;
		$check = $query->result();
		// echo json_encode($check);die;
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

	public function search()
	{
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$InvID = $this->input->post('inputInvoice');
		/*** Validate Area ***/
		if ( empty($InvID) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		$check = $this->sitemodel->view('vw_tracking', '*', ['InvID'=>$InvID]);
		$check2 = $this->sitemodel->custom_query('
			SELECT * FROM vw_tracking WHERE vw_tracking.InvID = '.$InvID.' ORDER BY vw_tracking.ReceiptSendPkgID DESC LIMIT 1');
		if (!$check) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		if (!$check2) {$this->response['msg'] = "No data found.";echo json_encode($this->response);exit;}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		$this->response['msg_2'] = $check2;
		echo json_encode($this->response);
		exit;
	}
}