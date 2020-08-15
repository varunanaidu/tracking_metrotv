
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// TEST GITIGNORE IF IT'S WORK

require_once APPPATH."libraries/Libcurl.php";

class Site extends MY_Controller {
	
	private $__SUPERADMIN = [
		'1193748', /*** Seftian Alfredo ***/
	];

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (!$this->hasLogin()) {
			redirect('site/login');
		}

		if ($this->fragment['menu_header'] == 0) {

			redirect('find');

		}else{

			$this->fragment['header_parent'] = 'Dashboard';
			$this->fragment['header_child']		= 'Dashboard';
			$this->fragment['breadcrumb'] = ['Dashboard', 'Dashboard'];
			$this->fragment['pagename'] = 'pages/view-dashboard.php';
			$this->fragment['js']		= base_url('assets/js/pages/dashboard.js');
			$this->fragment['months']   = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

			$this->load->view('layout/main-site', $this->fragment);

		}

	}

	public function find()
	{
		// echo json_encode($this->input->post());die;
		$PeriodMonth	= $this->input->post('PeriodMonth');
		$PeriodYear		= $this->input->post('PeriodYear');
		$temp 			= array();

		$check = $this->sitemodel->custom_query('SELECT * FROM vw_inv_sts WHERE InvStsID IN (1,2,3,4,5,6,8) ORDER BY InvStsID ASC');

		foreach ($check as $row) {
			$data = array();
			$data2 = array();
			$data['InvStsName'] = $row->InvStsName;

			$q1 = 'SELECT COUNT(ReceiptSendPkgID) AS Total, InvStsName FROM vw_tracking WHERE InvStsID = '.$row->InvStsID.' AND PeriodMonth = '.$PeriodMonth.' AND PeriodYear = '.$PeriodYear.' AND InvType = 0 AND autocomplete = 1';
			$check_q1 = $this->sitemodel->custom_query($q1);

			foreach ($check_q1 as $row_q1) {
				$data['manual_off_air'] = $row_q1->Total;
			}

			$q2 = 'SELECT COUNT(ReceiptSendPkgID) AS Total, InvStsName FROM vw_tracking WHERE InvStsID = '.$row->InvStsID.' AND PeriodMonth = '.$PeriodMonth.' AND PeriodYear = '.$PeriodYear.' AND InvType = 0 AND autocomplete = 0';
			$check_q2 = $this->sitemodel->custom_query($q2);

			foreach ($check_q2 as $row_q2) {
				$data['manual_on_air'] = $row_q2->Total;
			}

			$q3 = 'SELECT COUNT(ReceiptSendPkgID) AS Total, InvStsName FROM vw_tracking WHERE InvStsID = '.$row->InvStsID.' AND PeriodMonth = '.$PeriodMonth.' AND PeriodYear = '.$PeriodYear.' AND InvType = 1 ';
			$check_q3 = $this->sitemodel->custom_query($q3);

			foreach ($check_q3 as $row_q3) {
				$data['bms'] = $row_q3->Total;
			}

			$this->response['data'][] = $data;
		}

		$this->response['type'] = 'done';
		echo json_encode($this->response);
		exit;
	}

	public function login()
	{
		/*** Check Session ***/
		if( $this->hasLogin() ) redirect();
		$this->load->view('login_page');
	}

	public function signin()
	{
		/*** Check Session ***/
		if( $this->hasLogin() ) redirect();
		/*** Check POST or GET ***/
		if ( !$_POST ){
			$this->response['msg'] = "Invalid parameters.";
			echo json_encode($this->response);
			exit;
		}
		/*** Params ***/
		$server = $this->input->post("server") ?? $_SERVER['REMOTE_ADDR'];
		$temp = explode(".", $server);
		$server = ($temp[0] == "103") ? $_SERVER['REMOTE_ADDR'] : $server;
		$browser = $_SERVER['HTTP_USER_AGENT'];
		/*** Required Area ***/
		$username = trim($this->input->post("username"));
		$password = $this->input->post("userpass");
		$ckbox = $this->input->post("ckbox");
		/*** Validate Area ***/
		if ( empty($username) or empty($password) ){
			$this->response['msg'] = "Input username or password.";
			echo json_encode($this->response);
			exit;
		}
		$ckbox = isset($ckbox) ? "on" : "off";
		/*** Accessing DB Area ***/
		$post = [
			"username"	=> $username,
			"password"	=> $password,
			"onlines"	=> $ckbox,
			"server"	=> $server,
		];

		/*$temp = new stdClass;
		$rest = [];
		$data = new stdClass;

		$temp->CEMPNIP = '1193748';
		$temp->CEMPNAME = 'Seftian Alfredo';
		$temp->DATE_JOINGROUP = '01-06-2019';
		$temp->CDPTNO = '003';
		$temp->CDPTDESC = 'FIN ADM & TS - TEKNIK';
		$temp->CDICNO = '032';
		$temp->CDICDESC = 'IT';
		$temp->CSDPNO = '208';
		$temp->CSDPDESC = 'MIS';
		$temp->CDACNO = '123';
		$temp->CDACDESC = 'MIS';
		$temp->CJBTDESC = 'PROGRAMMER';
		$temp->CEMPEMAILADDR = 'SEFTIAN.ALFREDO@METROTVNEWS.COM';
		$temp->CEMPGENDER = 'L';
		$temp->DATE_BIRTH = '02-09-1997';
		$temp->CGOLNO = '2';
		$temp->APPROVELEVEL = null;
		$temp->BIO_APPROVAL_REQ = '13-MAR-20';
		$temp->IS_SPECIALLOGIN = null;


		$rest[] = $temp;

		$data->rest = $rest;*/
		
		$curl = new Libcurl("employee", "login");
		$data = $curl->__pages($post);
		if ( $data == null ){
			$this->response['msg'] = "Failed to fetch from servers.";
			echo json_encode($this->response);
			exit;
		}
		
		if ( $data->type == "failed" ){
			$this->response["msg"] = $data->msg;
			echo json_encode($this->response);
			exit;
		}
		$items = $data->rest[0];
		$logger = [
			"cempnip"	=> $username,
			"ip_address"=> $server,
			"browser"	=> $browser,
			"log_login"	=> date("Y-m-d H:i:s")
		];
		$this->sitemodel->insert("loglogin", $logger);
		$__isSPECIALLOGIN = ($items->IS_SPECIALLOGIN == '1');
		$__isSUPERADMIN = in_array($username, $this->__SUPERADMIN);
		if ($__isSPECIALLOGIN == FALSE){
			/*** NOT SPECIAL LOGIN (ORDINARY USER EMPLOYEE) ***/
			$sess = [
				"log_user"		=> $items->CEMPNIP,
				"log_name"		=> proper_lang($items->CEMPNAME, false),
				"log_join"		=> $items->DATE_JOINGROUP,
				"log_prs"		=> '1',									/*** Company [TEMPORARY - PLEASE UPDATE IF CHANGED] ***/
				"log_cdpt"		=> proper_lang($items->CDPTNO), 		/*** Direktorat ***/         
				"log_dir"		=> proper_lang($items->CDPTDESC), 		/*** Direktorat Name ***/
				"log_cdic"		=> proper_lang($items->CDICNO), 		/*** Division ***/
				"log_div"		=> proper_lang($items->CDICDESC), 		/*** Division Name ***/
				"log_csdp"		=> proper_lang($items->CSDPNO), 		/*** Departemen ***/
				"log_dept"		=> proper_lang($items->CSDPDESC), 		/*** Departemen Name ***/
				"log_cdac"		=> proper_lang($items->CDACNO), 		/*** Section ***/
				"log_sect"		=> proper_lang($items->CDACDESC), 		/*** Section Name ***/
				"log_post"		=> proper_lang($items->CJBTDESC), 		/*** Jabatan / Posisi ***/
				"log_email"		=> strtolower($items->CEMPEMAILADDR), 	/*** Email ***/
				"log_gender"	=> $items->CEMPGENDER, 					/*** Gender ***/
				"log_dob"		=> $items->DATE_BIRTH, 					/*** DOB (Added 2019-06-24) ***/
				"log_gold"		=> proper_lang($items->CGOLNO),			//! NEW APPROVAL LEVEL => UNTUK SISTEM APPROVAL CUTI/ABSEN, ETC
				"log_level"		=> proper_lang($items->APPROVELEVEL),	//! OLD APPROVAL LEVEL
				"log_update"	=> empty($items->BIO_APPROVAL_REQ) ? FALSE : TRUE,
			];
		}
		else {
			/*** SPECIAL LOGIN (SPECIAL USER WITHOUT EMPLOYEE DATA) ***/
			$sess = [
				"log_user"		=> $username,
				"log_name"		=> isset($items->CEMPNAME) ? proper_lang($items->CEMPNAME, false) : $username,
				"log_join"		=> isset($items->DATE_JOINGROUP) ? $items->DATE_JOINGROUP : date('d F Y'),
				"log_prs"		=> '1',																		/*** Company [TEMPORARY - PLEASE UPDATE IF CHANGED] ***/
				"log_cdpt"		=> isset($items->CDPTNO) ? proper_lang($items->CDPTNO) : '', 				/*** Direktorat ***/         
				"log_dir"		=> isset($items->CDPTDESC) ? proper_lang($items->CDPTDESC) : '', 			/*** Direktorat Name ***/
				"log_cdic"		=> isset($items->CDICNO) ? proper_lang($items->CDICNO) : '', 				/*** Division ***/
				"log_div"		=> isset($items->CDICDESC) ? proper_lang($items->CDICDESC) : '', 			/*** Division Name ***/
				"log_csdp"		=> isset($items->CSDPNO) ? proper_lang($items->CSDPNO) : '', 				/*** Departemen ***/
				"log_dept"		=> isset($items->CSDPDESC) ? proper_lang($items->CSDPDESC) : '', 			/*** Departemen Name ***/
				"log_cdac"		=> isset($items->CDACNO) ? proper_lang($items->CDACNO) : '', 				/*** Section ***/
				"log_sect"		=> isset($items->CDACDESC) ? proper_lang($items->CDACDESC) : '', 			/*** Section Name ***/
				"log_post"		=> isset($items->CJBTDESC) ? proper_lang($items->CJBTDESC) : '', 			/*** Jabatan / Posisi ***/
				"log_email"		=> isset($items->CEMPEMAILADDR) ? strtolower($items->CEMPEMAILADDR) : '', 	/*** Email ***/
				"log_gender"	=> isset($items->CEMPGENDER) ? $items->CEMPGENDER : 'L', 					/*** Gender ***/
				"log_dob"		=> isset($items->DATE_BIRTH) ? $items->DATE_BIRTH : '', 					/*** DOB (Added 2019-06-24) ***/
				"log_gold"		=> isset($items->CGOLNO) ? proper_lang($items->CGOLNO) : '',
				"log_level"		=> isset($items->APPROVELEVEL) ? proper_lang($items->APPROVELEVEL) : '',
				"log_update"	=> TRUE
			];
		}
		if ($__isSUPERADMIN){
			$sess['__nimdarepus'] = '1';
		}
		$this->session->set_userdata(SESS, (object)$sess);
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully login.";
		$this->response['url'] = $this->input->post('url');
		echo json_encode($this->response);
		exit;
	}
	
	function signout(){
		$post = [
			"user"	=> $this->user->getNip(),
		];
		$curl = new Libcurl("employee", "logout");
		$curl->__pages($post);
		$this->session->sess_destroy();
		redirect ( base_url("site/login") );
	}
}