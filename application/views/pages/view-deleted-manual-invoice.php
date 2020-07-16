<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<?php 
						if (isset($breadcrumb)) {
							foreach ($breadcrumb as $row) {
								?>
								<li class="breadcrumb-item"><?= $row ?></li>
								<?php 
							}
						}
						?>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title"><?= $header_child ?></h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body table-responsive">
						<table id="invdMTbl" class="table table-bordered table-hover table-striped" style="font-size: 10pt !important;">
							<thead>
								<tr>
									<th width="5">id</th>
									<th width="50">Year Month</th>
									<th>INVOICE NO. /<br> PO NO. /<br> PO TYPE</th>
									<th>AGENCY NAME /<br> ADVERTISER NAME /<br> PRODUCT NAME</th>
									<th>AE NAME</th>
									<th width="70">Gross</th>
									<th width="50">(%)Disc</th>
									<th width="70">Nett</th>
									<th style="text-align: right;" width="70"><i class="fas fa-cogs"></i></th>
									<th width="5">tr-id</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->