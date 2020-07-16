<?php defined('BASEPATH') OR exit("No direct script access allowed");
/**
 * 
 */
class Messenger_model extends CI_Model
{
	function find($key=""){
		$this->db->select("*");
		if ( empty($key) == FALSE )
			$this->db->where("ReceiptSendPkgID", $key);
		$q = $this->db->get("vw_tracking");
		if ( $q->num_rows() == 0 )
			return FALSE;
		return $q->result();
	}

	/*** DATATABLE SERVER SIDE FOR APPLICANT ***/
	function _get_applicant_query(){
		$__order 			= array('ReceiptSendPkgID' => 'DESC');
        $__column_search    = array('ReceiptSendPkgID', 'PeriodYear', 'PeriodMonth', 'InvNo', 'PONo', 'PO_Type', 'AgencyName', 'AdvertiserName', 'ProductName', 'AE_Name', 'Gross', 'AgencyDisc', 'Nett');
        $__column_order     = array('ReceiptSendPkgID', 'PeriodYear', 'InvNo', 'AgencyName', 'AE_Name', 'Gross', 'AgencyDisc', 'Nett');
        $check_tr           = $this->get_InvId_from_tracking();

        $this->db->select('*');
        $this->db->from('vw_received_by_ga_invoices');

        foreach ($check_tr as $row) {
            $this->db->where('InvID !=', $row->InvID);
        }
        $i = 0;
        $search_value = $this->input->post('search')['value'];
        foreach ($__column_search as $item){
           if ($search_value){
                if ($i === 0){ // looping awal
                	$this->db->group_start(); 
                	$this->db->like("UPPER({$item})", strtoupper($search_value), FALSE);
                }
                else{
                	$this->db->or_like("UPPER({$item})", strtoupper($search_value), FALSE);
                }
                if (count($__column_search) - 1 == $i) $this->db->group_end(); 
            }
            $i++;
        }

        /* order by */
        if ($this->input->post('order') != null){
        	$this->db->order_by($__column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } 
        else if (isset($__order)){
        	$order = $__order;
        	$this->db->order_by(key($order), $order[key($order)]);
        }

    }

    function get_applicant(){
    	$this->_get_applicant_query();
    	if ($this->input->post('length') != -1) $this->db->limit($this->input->post('length'), $this->input->post('start'));
    	$query = $this->db->get();
    	return $query->result();
    }

    function get_applicant_count_filtered(){
    	$this->_get_applicant_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    function get_applicant_count_all(){
        $this->db->from('vw_received_by_ga_invoices');
        return $this->db->count_all_results();
    }

    function get_InvId_from_tracking()
    {
        $this->db->select('InvID');
        $this->db->from('vw_tracking');
        $this->db->where('InvStsID >', 3);
        $query = $this->db->get();
        return $query->result();
    }
}