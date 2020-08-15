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
						<div class="row">
							<div class="col-2 form-group">
								<select class="form-control" id="filterYear">
									<?php 
									for ( $i = date('Y') ; $i > date('Y') - 5 ; $i--) { 
										?>
										<option <?= ($i == date('Y') ? 'selected=""' : '' ) ?> ><?= $i ?></option>
										<?php 
									}
									?>
								</select>
							</div>
							<div class="col-2 form-group">
								<select class="form-control" id="filterMonth">
									<?php 
									if (isset($months)) {
										for ( $i = 0; $i < sizeof($months) ; $i++) { 
											?>
											<option <?= ( $i+1 == date('m') ? 'selected=""' : '' ) ?> value="<?= $i+1 ?>"><?= $months[$i] ?></option>
											<?php 
										}
									}
									?>
								</select>
							</div>
							<div class="col-2 form-group">
								<button class="btn btn-md btn-info btn-filter">Filter</button>
								<span id="btnExportCont">
								</span>
							</div>
						</div>
						<table id="reportTbl" class="table table-bordered table-striped table-hover" style="font-size: 10pt !important;">
							<thead>
								<tr>
									<th rowspan="2" style="text-align: center;">Invoice</th>
									<th colspan="2" style="text-align: center;">Entry By Billing</th>
									<th colspan="2" style="text-align: center;">Send to GA</th>
									<th colspan="2" style="text-align: center;">Approve by GA</th>
									<th colspan="2" style="text-align: center;">Delivery</th>
									<th colspan="2" style="text-align: center;">Received by Client</th>
									<th colspan="2" style="text-align: center;">Returned by Client</th>
								</tr>
								<tr>
									<th style="text-align: center;">Jumlah</th>
									<th style="text-align: center;">%</th>
									<th style="text-align: center;">Jumlah</th>
									<th style="text-align: center;">%</th>
									<th style="text-align: center;">Jumlah</th>
									<th style="text-align: center;">%</th>
									<th style="text-align: center;">Jumlah</th>
									<th style="text-align: center;">%</th>
									<th style="text-align: center;">Jumlah</th>
									<th style="text-align: center;">%</th>
									<th style="text-align: center;">Jumlah</th>
									<th style="text-align: center;">%</th>
								</tr>
							</thead>
							<tbody id="reportCont" style="text-align: center;"></tbody>
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

	<div id="default-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title strong" id="titleLabel"></h4>
					<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row clearfix">
						<div class="col-md-12">
							<label id="info"></label>
						</div>
						<div class="col-md-12 table-responsive">
							<table class="table table-bordered table-striped table-hover" id="detailTbl">
								<thead>
									<tr>
										<th></th>
										<th>Invoice No</th>
										<th>PO No</th>
										<th>Last Status</th>
									</tr>
								</thead>
								<tbody id="detailTblBody"></tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /.content-wrapper -->