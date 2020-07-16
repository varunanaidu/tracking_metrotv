<?php defined('BASEPATH') OR exit("No direct script access allowed");
class Uac_model extends CI_Model{
	function find($key="", $nav=""){
		$this->db->select("*");
		if ( empty($key) == FALSE )
			$this->db->where("user_id", $key);
        if ( empty($nav) == FALSE )
            $this->db->where("nav_id", $nav);
		$q = $this->db->get("vw_uac");
		if ( $q->num_rows() == 0 )
			return FALSE;
		return $q->result();
	}

	function _get_applicant_query(){
		$__order 			= array('user_id' => 'ASC');
		$__column_search 	= array('user_id', 'user_id');
		$__column_order     = array('user_id', 'user_id');

		$this->db->select('user_id, user_id');
		$this->db->from('vw_list_uac');

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
    	$this->db->from('vw_list_uac');
    	return $this->db->count_all_results();
    }
}