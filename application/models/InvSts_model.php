<?php defined('BASEPATH') OR exit("No direct script access allowed");
class InvSts_model extends CI_Model{
	function find($key="", $isActive=""){
		$this->db->select("*");
		if ( empty($key) == FALSE )
			$this->db->where("InvStsID", $key);

        if (empty($isActive) == FALSE ) {
            $q = $this->db->get("vw_delinv_sts");
        }else{
            $q = $this->db->get("vw_inv_sts");
        }
        
		if ( $q->num_rows() == 0 )
			return FALSE;
		return $q->result();
	}

	/*** DATATABLE SERVER SIDE FOR APPLICANT ***/
	function _get_applicant_query($isActive=""){
		$__order 			= array('InvStsID' => 'ASC');
		$__column_search 	= array('InvStsID', 'InvStsCode', 'InvStsName');
		$__column_order     = array('InvStsID', 'InvStsCode', 'InvStsName');

		$this->db->select('*');
        if (empty($isActive) == FALSE) {
            $this->db->from('vw_delinv_sts');
        }else{
            $this->db->from('vw_inv_sts');
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

    function get_applicant($isActive=""){
    	$this->_get_applicant_query($isActive);
    	if ($this->input->post('length') != -1) $this->db->limit($this->input->post('length'), $this->input->post('start'));
    	$query = $this->db->get();
    	return $query->result();
    }

    function get_applicant_count_filtered($isActive=""){
    	$this->_get_applicant_query($isActive);
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    function get_applicant_count_all($isActive=""){
        if (empty($isActive) == FALSE) {
            $this->db->from('vw_delinv_sts');
        }else{
            $this->db->from('vw_inv_sts');
        }
    	return $this->db->count_all_results();
    }
}