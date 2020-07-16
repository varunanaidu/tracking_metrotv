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
						<h3 class="card-title"><?= $header_child ?> Invoice</h3>
						<button type="button" class="btn btn-default btn-sm" title="" id="btn-new" style="float: right;">
							<i class="fa fa-plus text-blue"></i> New Entry</button>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-3">
									<button type="button" class="btn btn-sm btn-success btn-send" title="Send" disabled="">Send to GA</button>&nbsp;
									<button type="button" class="btn btn-sm btn-info btn-sAll" id="sAll" title="Select All" style="display: none;">Select All</button>
								</div>
							</div>
						</div>
						<div class="card-body">
							<table id="invOTbl" class="table table-bordered table-hover table-striped" style="font-size: 10pt !important; table-layout: fixed;">
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

		<div id="default-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
			<div class="loading" style="display: none;">Loading&#8230;</div>
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<form method="POST" id="invO-form" accept-charset="UTF-8">
						<div class="modal-header">
							<h4 class="modal-title strong"><?=$header_child?> Invoice - <span id="modal-type">New Entry</span></h4>
							<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
						</div>
						<div class="modal-body">
							<hr style="border-top:2px solid maroon">
							<div class="row clearfix">
								<div class="form-group col-md-6">
									<select class="form-control" name="PeriodMonth" id="PeriodMonth">
										<option value="">Choose Month</option>
										<?php 
										if (isset($months)) {
											for ( $i = 0; $i < sizeof($months) ; $i++) { 
												?>
												<option value="<?= $i+1 ?>"><?= $months[$i] ?></option>
												<?php 
											}
										}
										?>
									</select>
								</div>
								<div class="form-group col-md-6">
									<select class="form-control" name="PeriodYear" id="PeriodYear">
										<option value="">Choose Year</option>
										<?php 
										for ( $i = date('Y') ; $i > date('Y') - 5 ; $i--) { 
											?>
											<option><?= $i ?></option>
											<?php 
										}
										?>
									</select>
								</div>
							</div>
							<hr style="border-top:2px solid maroon">
								<div class="row clearfix">							
									<div class="form-group col-md-6">
										<label>PO No. <span class="text-red">*</span></label>
										<input type="text" class="form-control" id="PONo" maxlength="100" name="PONo" value="" placeholder="..." required>
									</div>
									<div class="form-group col-md-6">
										<label>Invoice No. <span class="text-red">*</span></label>
										<input type="text" class="form-control" id="InvNo" maxlength="100" name="InvNo" value="" placeholder="..." required>
										<input type="hidden" name="InvType" id="InvType" value="0">
										<input type="hidden" name="autocomplete" id="autocomplete" value="1">
									</div>
								</div>
								<hr style="border-top:2px solid maroon">
								<div class="row clearfix">
									<div class="form-group col-md-6">
										<label>PO Type<span class="text-red">*</span></label>
										<input type="text" name="PO_Type" id="PO_Type" class="form-control" placeholder="...">
									</div>
									<div class="form-group col-md-6">
										<label>Billing Type<span class="text-red">*</span></label>
										<input type="text" name="BillingType" id="BillingType" class="form-control" placeholder="...">
									</div>
								</div>
								<hr style="border-top:2px solid maroon">
								<div class="row clearfix">
									<div class="form-group col-md-8">
										<label>Agency Name<span class="text-red">*</span></label>
										<input type="text" class="form-control" id="AgencyName" maxlength="100" name="AgencyName" value="" placeholder="...">
									</div>
									<div class="form-group col-md-4">
										<label>Agency Telp<span class="text-red">*</span></label>
										<input type="text" class="form-control" id="AgencyTelp" maxlength="100" name="AgencyTelp" value="" placeholder="...">
									</div>
									<div class="form-group col-md-12">
										<label>Agency Address<span class="text-red">*</span></label>
										<input type="text" class="form-control" id="AgencyAddr" maxlength="100" name="AgencyAddr" value="" placeholder="...">
									</div>
								</div>
								<hr style="border-top:2px solid maroon">
								<div class="row clearfix">
									<div class="form-group col-md-8">
										<label>Advertiser Name<span class="text-red">*</span></label>
										<input type="text" class="form-control" id="AdvertiserName" maxlength="100" name="AdvertiserName" value="" placeholder="...">
									</div>
									<div class="form-group col-md-4">
										<label>Advertiser Telp<span class="text-red">*</span></label>
										<input type="text" class="form-control" id="AdvertiserTelp" maxlength="100" name="AdvertiserTelp" value="" placeholder="...">
									</div>
									<div class="form-group col-md-12">
										<label>Advertiser Address<span class="text-red">*</span></label>
										<input type="text" class="form-control" id="AdvertiserAddr" maxlength="100" name="AdvertiserAddr" value="" placeholder="...">
									</div>
								</div>
								<hr style="border-top:2px solid maroon">
								<div class="row clearfix">
									<div class="form-group col-md-6">
										<label>Product <span class="text-red">*</span></label>
										<input type="text" class="form-control" id="ProductName" maxlength="100" name="ProductName" value="" placeholder="...">
									</div>
									<div class="form-group col-md-6">
										<label>AE <span class="text-red">*</span></label>
										<input type="text" class="form-control" id="AE_Name" maxlength="100" name="AE_Name" value="" placeholder="...">
									</div>
								</div>
								<hr style="border-top:2px solid maroon">
								<div class="row clearfix">
									<div class="form-group col-md-4">
										<label>(%)Discount <span class="text-red">*</span></label>
										<input type="number" class="form-control" step="any" id="AgencyDisc" maxlength="100" name="AgencyDisc" value="" placeholder="...">
									</div>
									<div class="form-group col-md-4">
										<label>Gross <span class="text-red">*</span></label>
										<input type="number" class="form-control" id="Gross" maxlength="100" name="Gross" value="" placeholder="...">
									</div>
									<div class="form-group col-md-4">
										<label>Nett <span class="text-red">*</span></label>
										<input type="number" class="form-control" id="Nett" maxlength="100" name="Nett" value="" placeholder="...">
									</div>
								</div>
						</div>
						<div class="modal-footer">
							<input type="text" class="collapse" id="type" name="type" value="">
							<input type="text" class="collapse" id="id" name="id" value="">
							<input type="text" class="collapse" id="tr_id" name="tr_id" value="">
							<button type="submit" id="btn-submit" class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
<!-- /.content-wrapper -->