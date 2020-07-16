<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');

class Uac extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Uac_model');
		$this->load->model('Navigations_model');
	}

	function index()
	{
		if( !$this->hasLogin() ) redirect('site/login');

		$this->load->library('guzzle');
		$employee = $this->guzzle->guzzle_HRIS('employee/get');
		$data_employee = json_decode($employee);
		$this->fragment['emp'] = $data_employee->data;

		$this->fragment['header_parent'] = 'Developer';
		$this->fragment['header_child']		= 'Uac';
		$this->fragment['breadcrumb'] = ['Developer', 'Uac'];
		$this->fragment['js']		= base_url('assets/js/pages/uac.js');
		$this->fragment['pagename'] = 'pages/view-uac';
		$this->load->view('layout/main-site', $this->fragment);
	}

	function view_list()
	{
		$a = 1;
		$data = array();
		$res = $this->Uac_model->get_applicant();
		$temp = $this->db->last_query();
		// echo $temp;die;

		foreach ($res as $row) {
			$col = array();
			$col[] = $a;
			$col[] = $row->user_id;
			$data[] = $col;
			$a++;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->Uac_model->get_applicant_count_all(),
			"recordsFiltered" 	=> $this->Uac_model->get_applicant_count_filtered(),
			"data" 				=> $data,
			"q"					=> $temp //temp for tracing db query

		);
		echo json_encode($output);
		exit;
	}

	function setup()
	{
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$key = $this->input->post("key");
		/*** Optional Area ***/
		/*** Validate Area ***/
		$html = '<div class="table-responsive"><table class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>#</th>
		<th>Navigation</th>
		<th>Parent</th>
		<th><i class="fa fa-cog"></i></th>
		</tr>
		</thead>
		<tbody>
		';

		$cekNav = $this->Navigations_model->find();

		if ($cekNav) {
			$a = 1;
			foreach ($cekNav as $row) {
				$parent_name = ($row->parent_name == '') ? 'Root' : $row->parent_name; 
				$checked  = '';
				$cekUac = $this->Uac_model->find($key, $row->nav_id);
				if ($cekUac) {
					$checked = 'checked="checked" ';
				}
				$html .= '<tr>
				<td>' . $a . '</td>
				<td>' . $row->nav_name . '</td>
				<td>' . $parent_name . '</td>
				<td> <input type="checkbox" name="ckbox[]" value="'.$row->nav_id.'" '.$checked.' > </td>
				</tr>';
				$a++;
			}
		}

		$html .= '</tbody></table></div>';
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $html;
		echo json_encode($this->response);
		exit;
	}

	function save()
	{
		// echo json_encode($this->input->post());die;
		/*** Check Session ***/
		if ( !$this->hasLogin() ){$this->response['msg'] = "Session expired, Please refresh your browser.";echo json_encode($this->response);exit;}
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$user = $this->input->post("user");
		$ckbox = $this->input->post("ckbox");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($user) ){$this->response['msg'] = "Please choose user.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		$this->sitemodel->delete("tab_uac", ["user_id"=>$user]);
		for($i = 0; $i < count($ckbox); $i++){
			$exp = explode(";", $ckbox[$i]);
			if ( count($exp) > 1 ){
				$find = $this->uac_model->find($user, $exp[0]);
				if ( !$find ){
					$data = [
						"user_id"	=> $user,
						"nav_id"	=> $exp[0],
						"create_date"=> date("Y-m-d H:i:s"),
						"create_by"=> $this->user->getNip()
					];
					$this->sitemodel->insert("tab_uac", $data);
				}
				$data = [
					"user_id"	=> $user,
					"nav_id"	=> $exp[1],
					"create_date"=> date("Y-m-d H:i:s"),
					"create_by"=> $this->user->getNip()
				];
				$this->sitemodel->insert("tab_uac", $data);
			}
			else{
				$data = [
					"user_id"	=> $user,
					"nav_id"	=> $ckbox[$i],
					"create_date"=> date("Y-m-d H:i:s"),
					"create_by"=> $this->user->getNip()
				];
				$this->sitemodel->insert("tab_uac", $data);
			}
		}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully setup user.";
		echo json_encode($this->response);
		exit;
	}
}