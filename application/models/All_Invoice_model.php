<?php defined('BASEPATH') OR exit("No direct script access allowed");
class All_Invoice_model extends CI_Model{
	function find($key="", $isActive=""){
		$this->db->select("*");
		if ( empty($key) == FALSE )
			$this->db->where("InvID", $key);

		if (empty($isActive) == FALSE ) {
			$q = $this->db->get("vw_deltracking");
		}else{
			$q = $this->db->get("vw_tracking");
		}
		if ( $q->num_rows() == 0 )
			return FALSE;
		return $q->result();
	}

	/*** DATATABLE SERVER SIDE FOR APPLICANT ***/
	function _get_applicant_query($isActive="", $PeriodMonth="", $PeriodYear="", $InvType="", $InvStsID=""){
		$__order 			= array('InvID' => 'DESC');
        $__column_search    = array('InvID', 'InvType', 'PeriodYear', 'PeriodMonth', 'InvNo', 'PONo', 'PO_Type', 'AgencyName', 'AdvertiserName', 'ProductName', 'AE_Name', 'Gross', 'AgencyDisc', 'Nett', 'InvStsName', 'EntryBy_date', 'EntryBy');
        $__column_order     = array('InvID', 'InvType', 'PeriodYear', 'InvNo', 'AgencyName', 'AE_Name', 'Gross', 'AgencyDisc', 'Nett', 'InvStsName', 'EntryBy_date', 'EntryBy');
        // $check_tr = $this->get_InvId_from_tracking();

        $this->db->select('*');
        if (empty($isActive) == FALSE) {
         $this->db->from('vw_deltracking');
     }
     else{
         $this->db->from('vw_tracking');
     }

     if (empty($PeriodMonth) == FALSE) {
         $this->db->where('PeriodMonth', $PeriodMonth);
     }

     if (empty($PeriodYear) == FALSE) {
         $this->db->where('PeriodYear', $PeriodYear);
     }

     if (empty($InvType) == FALSE) {
        switch ($InvType) {
            case 'M1':
            $this->db->where('InvType', '0');
            $this->db->where('autocomplete', '1');
                break;
            case 'M0':
            $this->db->where('InvType', '0');
            $this->db->where('autocomplete', '0');
                break;
            case 'B':
            $this->db->where('InvType', '1');
                break;
            default:
                # code...
                break;
        }
     }

     if (empty($InvStsID) == FALSE) {
         $this->db->where('InvStsID', $InvStsID);
     }

     /*foreach ($check_tr as $row) {
        $this->db->where('InvID !=', $row->InvID);
    }*/


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

    function get_applicant($isActive="", $PeriodMonth="", $PeriodYear="", $InvType="", $InvStsID=""){
        $this->_get_applicant_query($isActive, $PeriodMonth, $PeriodYear, $InvType, $InvStsID);
        if ($this->input->post('length') != -1) $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function get_applicant_count_filtered($isActive="", $PeriodMonth="", $PeriodYear="", $InvType="", $InvStsID=""){
    	$this->_get_applicant_query($isActive, $PeriodMonth, $PeriodYear, $InvType, $InvStsID);
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    function get_applicant_count_all($isActive=""){

    	if (empty($isActive) == FALSE) {
    		$this->db->from('vw_deltracking');
    	}else{
    		$this->db->from('vw_tracking');
    	}

    	return $this->db->count_all_results();
    }

    function get_InvId_from_tracking()
    {
        $this->db->select('InvID');
        $this->db->from('vw_tracking');
        $this->db->group_by('InvID');
        $query = $this->db->get();
        return $query->result();
    }
}