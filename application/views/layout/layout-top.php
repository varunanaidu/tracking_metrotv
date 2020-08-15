<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Tracking Invoice</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/dist/css/adminlte.min.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/daterangepicker/daterangepicker.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- Sweetalert -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/sweetalert2/sweetalert2.min.css">
	<!-- Select -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/select2/css/select2.min.css">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
	<!-- DataTables -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/datatables-select/css/select.bootstrap4.min.css">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

	<style type="text/css">
		a.active.parent{
			background-color: #e52e3f !important;
		}
		a.active.child{
			color: #e52e3f !important;
		}
		a:hover{
			color: #e52e3f !important;
		}
		.dataTables_filter, .dataTables_paginate{
			float: right;
		}
		.sameMonthly{
			background-color: #98ff3a;
		}
		/*.dt-buttons{
			display: flex;
			justify-content: center;
			}*/
		</style>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">

			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<!-- Left navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
					</li>
				</ul>

				<!-- Right navbar links -->
				<ul class="navbar-nav ml-auto">
					<!-- Notifications Dropdown Menu -->
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown" href="#">
							<i class="far fa-user"></i> <?php echo $this->session->userdata(SESS)->log_name ?>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
							<div class="dropdown-divider"></div>
							<p class="text-center"><?php echo $this->session->userdata(SESS)->log_user ?></p>
							<p class="text-center"><?php echo $this->session->userdata(SESS)->log_name ?></p>
							<div class="dropdown-divider"></div>
							<a href="<?= base_url('site/signout'); ?>" class="dropdown-item dropdown-footer">Sign out</a>
						</div>
					</li>
				</ul>

			</nav>
			<!-- /.navbar -->

			<!-- Main Sidebar Container -->
			<aside class="main-sidebar sidebar-light-primary elevation-4">
				<!-- Brand Logo -->
				<a href="javascript:void(0)" class="brand-link">
					<img src="<?php echo base_url(); ?>assets/adminlte/dist/img/tracking-new.png">
				</a>

				<!-- Sidebar -->
				<div class="sidebar">

					<!-- Sidebar Menu -->
					<nav class="mt-2">
						<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

							<?php 
							if (isset($menu_header) and $menu_header != 0) {
								foreach ($menu_header as $row) {
									?>
									<li class="nav-item has-treeview <?php echo ( $header_parent == $row->nav_name ? 'menu-open' : '' ) ?> ">
										<a href="#" class="nav-link <?php echo ( $header_parent == $row->nav_name ? 'active parent' : '' ) ?> " >
											<i class="nav-icon fas fa-th"></i>
											<p>
												<?= $row->nav_name ?>
												<i class="fas fa-angle-left right"></i>
											</p>
										</a>
										<?php 
										if (isset($menu_child) and $menu_child != 0) {
											?>
											<ul class="nav nav-treeview">
												<?php 
												foreach ($menu_child as $row2) {
													if ($row2->nav_parent == $row->nav_id) {
														?>
														<li class="nav-item">
															<a href="<?= base_url($row2->nav_ctr) ?>" class="nav-link <?php echo ( $header_child == $row2->nav_name ? 'active child' : '' ) ?> ">
																<i class="far fa-circle nav-icon"></i>
																<p><?= $row2->nav_name ?></p>
															</a>
														</li>
														<?php 
													}
												}
												?>
											</ul>
											<?php 
										}
										?>
									</li>
									<?php 
								}
							}
							?>
							<li class="nav-item">
								<a href="<?= base_url('find') ?>" class="nav-link">
									<i class="nav-icon fas fa-search nav-icon"></i>
									<p>Tracking</p>
								</a>
							</li>
						</ul>
					</nav>
					<!-- /.sidebar-menu -->
				</div>
				<!-- /.sidebar -->
			</aside>