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
							<div class="col-6 form-group">
								<button type="button" class="btn btn-sm btn-success btn-accept" title="Accept" disabled="">Accept</button>
								<button type="button" class="btn btn-sm btn-danger btn-return" title="Return" disabled="">Return</button>
							</div>
						</div>
						<table id="approvalTbl" class="table table-bordered table-hover" style="font-size: 10pt !important;">
							<thead>
								<tr>
									<th width="5">id</th>
									<th width="50">Year Month</th>
									<th>INVOICE NO. /<br> PO NO. /<br> PO TYPE</th>
									<th>AGENCY NAME /<br> ADVERTISER NAME /<br> PRODUCT NAME</th>
									<th>AE NAME</th>
									<th width="70">Gross</th>
									<th width="20">(%)Disc</th>
									<th width="70">Nett</th>
									<th width="70">Type</th>
									<th width="70"><i class="fas fa-cogs"></i></th>
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

	<div id="default-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row clearfix">
						<div class="col-md-12">
							<hr style="border-top:2px solid maroon">

							<table style="width:100%;font-size:14px;">
								<tr>
									<td style="min-width:250px;" valign="top">Invoice No</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="InvNo"></td>
								</tr>
								<tr>
									<td style="min-width:250px;" valign="top">PO Number</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="PONo"></td>
								</tr>
								<tr>
									<td style="min-width:250px;" valign="top">PO Type</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="PO_Type"></td>
								</tr>
								<tr>
									<td style="min-width:250px;" valign="top">Billing Type</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="BillingType"></td>
								</tr>
							</table>

						</div>
						<div class="col-md-12">
							<hr style="border-top:2px solid maroon">

							<table style="width:100%;font-size:14px;">
								<tr>
									<td style="min-width:250px;" valign="top">Agency</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="AgencyName"></td>
								</tr>
								<tr>
									<td style="min-width:250px;" valign="top">Address</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="AgencyAddr"></td>
								</tr>
								<tr>
									<td style="min-width:250px;" valign="top">Telephone</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="AgencyTelp"></td>
								</tr>
							</table>
						</div>
						<div class="col-md-12">
							<hr style="border-top:2px solid maroon">

							<table style="width:100%;font-size:14px;">
								<tr>
									<td style="min-width:250px;" valign="top">Agency</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="AdvertiserName"></td>
								</tr>
								<tr>
									<td style="min-width:250px;" valign="top">Address</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="AdvertiserAddr"></td>
								</tr>
								<tr>
									<td style="min-width:250px;" valign="top">Telephone</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="AdvertiserTelp"></td>
								</tr>
							</table>
						</div>
						<div class="col-md-12">
							<hr style="border-top:2px solid maroon">

							<table style="width:100%;font-size:14px;">
								<tr>
									<td style="min-width:250px;" valign="top">Product</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="ProductName"></td>
								</tr>
								<tr>
									<td style="min-width:250px;" valign="top">AE</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="AE_Name"></td>
								</tr>
								<tr>
									<td style="min-width:250px;" valign="top">Gross</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="Gross"></td>
								</tr>
								<tr>
									<td style="min-width:250px;" valign="top">(%) Disc</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="AgencyDisc"></td>
								</tr>
								<tr>
									<td style="min-width:250px;" valign="top">Nett</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="Nett"></td>
								</tr>
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