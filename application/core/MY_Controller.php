<?php if ( !defined('BASEPATH') )exit('No direct script access allowed');
	
class MY_Controller extends CI_Controller{

	protected $response = [];
	protected $log_user = '';
	protected $log_email = '';
	protected $fragment = [];
	
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		
		if ($this->hasLogin()) {
			$this->log_user = $this->session->userdata(SESS)->log_user;
			$this->log_email = $this->session->userdata(SESS)->log_email;
			$this->fragment['menu_header'] = $this->sitemodel->render_nav_head($this->session->userdata(SESS)->log_user);
			$this->fragment['menu_child'] = $this->sitemodel->render_nav_child($this->session->userdata(SESS)->log_user);
		}
	}
	
	function hasLogin() {
		return $this->session->userdata(SESS);
	}

	function compress_image($source_url, $destination_url, $quality) {
		$info = getimagesize($source_url);

		if ($info['mime'] == 'image/jpeg')
			$image = imagecreatefromjpeg($source_url);
		elseif ($info['mime'] == 'image/gif')
			$image = imagecreatefromgif($source_url);
		elseif ($info['mime'] == 'image/png')
			$image = imagecreatefrompng($source_url);
		imagejpeg($image, $destination_url, $quality);

		return true;
	}
}