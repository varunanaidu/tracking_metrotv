<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php 

echo json_encode($this->session->userdata(SESS));

 ?>