<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>TrackID</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="manifest" href="site.webmanifest"> -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/front/img/favicon.ico">

	<!-- CSS here -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/slicknav.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/flaticon.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/animate.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/magnific-popup.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/fontawesome-all.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/themify-icons.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/slick.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/nice-select.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/table.css">
	<!-- Sweetalert -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/sweetalert2/sweetalert2.min.css">

	<style type="text/css" media="screen">

		#search-btn{
			background-color: #0d47a1;
			padding: 30px 50px !important;
		}

		#invTbl .cella:hover{
			background-color: #0d47a1;
			color: white;
		}

		a:hover{
			background-color: yellow;
			color: blue !important;
		}

	</style>
</head>
<body>
	<!--? Preloader Start -->
	<div id="preloader-active">
		<div class="preloader d-flex align-items-center justify-content-center">
			<div class="preloader-inner position-relative">
				<div class="preloader-circle"></div>
				<div class="preloader-img pere-text">
					<img src="<?php echo base_url(); ?>assets/front/img/logo/loder.jpg" alt="">
				</div>
			</div>
		</div>
	</div>
	<!-- Preloader Start -->
	<header>

	</header>
	<main class="slider-height">
		<!--? slider Area Start-->
		<button id="backBtn" class="btn btn-primary">Back to Menu</button>
		<button id="signOutBtn" class="btn btn-primary float-right">Sign Out</button>

		<div class="slider-area ">
			<div class="slider-active">
				<!-- Single Slider -->
				<div class="single-slider d-flex align-items-center">
					<div class="container">
						<div class="row">
							<div class="col-xl-9 col-lg-9">
								<div class="hero__caption">
									<!--  <h1>Safe & Reliable <span>Logistic</span> Solutions!</h1> -->
								</div>
								<!--Hero form -->
								<form id="find-form" method="POST" class="search-box">
									<div class="input-form">
										<input type="text" placeholder="Input Invoice Number or PO Number or Product Name or AE Name" name="inputInvoice" id="inputInvoice" required="">
									</div>
									<div class="search-form">
										<button type="submit" class="btn btn-primary" id="search-btn demo">Track</button>
									</div>	
								</form>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- slider Area End-->
		<!--? our info Start -->
		<div class="our-info-area pt-20" id="containerBox" style="display: none;">
			<div class="container">
				<div class="rowa">
					<div class="col-xl-12 col-lg-12">
						<div class="wrap-tablea100" id="invTbl_cont">
							<div class="tablea" id="invTbl">
								<div class="rowa headera">
									<div class="cella">
										Invoice (click inv. no. to see details)
									</div>
								</div>
								<div class="rowa">
									<div class="cella data" data-title="Invoice">No Data</div>
								</div>
							</div>
						</div>
					</div>
				</div> 
				<div id="childContainer" style="display: none;">
					<div class="limitera">
						<div class="container-tablea100">
							<div class="wrap-tablea100">
								<div class="tablea">
									<div class="rowa headera">
										<div class="cella">
											Invoice No
										</div>
										<div class="cella">
											PO No
										</div>
										<div class="cella">
											Agency
										</div>
										<div class="cella">
											Advertiser
										</div>
										<div class="cella">
											AE Name
										</div>
										<div class="cella">
											Status Pengiriman
										</div>
									</div>
									<div class="rowa" id="detail_body">
										<div class="cella">No Data</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="limitera">
						<div class="container-tablea100">
							<div class="wrap-tablea100" style="width: 890px;">
								<div class="tablea" id="resTbl">
									<div class="rowa headera">
										<div class="cella">
											Tanggal
										</div>
										<div class="cella">
											Status
										</div>
										<div class="cella">
											Keterangan
										</div>
									</div>
									<div class="rowa">
										<div class="cella">No Data</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- our info End -->

		<div id="default-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
					</div>
					<div class="modal-body">
						<div class="row clearfix">
							<div class="col-lg-12">
								<img src="" alt="" id="imgContainer" style="width: inherit;">
							</div>
						</div>
					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div>
	</main>
	<footer>
		<!--? Footer Start-->
		<div class="footer">
			<p> More Information : MIS (ext. 22005/22039/22040) </p>
		</div>
	</footer>
	<!-- Scroll Up -->
	<div id="back-top" >
		<a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
	</div>

	<!-- JS here -->
	<script type="text/javascript">var base_url = '<?php echo base_url(); ?>' </script>
	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/front/js/vendor/modernizr-3.5.0.min.js"></script>
	<!-- Jquery, Popper, Bootstrap -->
	<!-- <script src="<?php echo base_url(); ?>assets/front/js/vendor/jquery-1.12.4.min.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/front/js/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/front/js/bootstrap.min.js"></script>
	<!-- Jquery Mobile Menu -->
	<script src="<?php echo base_url(); ?>assets/front/js/jquery.slicknav.min.js"></script>

	<!-- Jquery Slick , Owl-Carousel Plugins -->
	<script src="<?php echo base_url(); ?>assets/front/js/owl.carousel.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/front/js/slick.min.js"></script>
	<!-- One Page, Animated-HeadLin -->
	<script src="<?php echo base_url(); ?>assets/front/js/wow.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/front/js/animated.headline.js"></script>
	<script src="<?php echo base_url(); ?>assets/front/js/jquery.magnific-popup.js"></script>

	<!-- Nice-select, sticky -->
	<script src="<?php echo base_url(); ?>assets/front/js/jquery.nice-select.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/front/js/jquery.sticky.js"></script>

	<!-- contact js -->
	<script src="<?php echo base_url(); ?>assets/front/js/contact.js"></script>
	<script src="<?php echo base_url(); ?>assets/front/js/jquery.form.js"></script>
	<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/front/js/mail-script.js"></script>
	<script src="<?php echo base_url(); ?>assets/front/js/jquery.ajaxchimp.min.js"></script>

	<!-- Jquery Plugins, main Jquery -->	
	<script src="<?php echo base_url(); ?>assets/front/js/plugins.js"></script>
	<script src="<?php echo base_url(); ?>assets/front/js/main.js"></script>
	<script src="<?php echo base_url(); ?>assets/adminlte/plugins/moment/moment.min.js"></script>
	<!-- Sweetalert -->
	<script src="<?php echo base_url(); ?>assets/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/pages/find.js"></script>
</body>
</html>