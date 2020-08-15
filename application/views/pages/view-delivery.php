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
								<button type="button" class="btn btn-sm btn-info btn-external" title="Send Using External" disabled="">External Messenger</button>
								<button type="button" class="btn btn-sm btn-info btn-internal" title="Send Using Internal" disabled="">Internal Messenger</button>
							</div>
						</div>
						<table id="deliveryTbl" class="table table-bordered table-hover table-striped" style="font-size: 10pt !important;">
							<thead>
								<tr>
									<th width="5">id</th>
									<th width="50">Year Month</th>
									<th>INVOICE NO. /<br> PO NO. /<br> PO TYPE</th>
									<th>AGENCY NAME /<br> ADVERTISER NAME /<br> PRODUCT NAME</th>
									<th>AE NAME</th>
									<th width="70">Gross</th>
									<th width="10">(%)Disc</th>
									<th width="70">Nett</th>
									<th>Send Date</th>
									<th>Messenger</th>
									<th>Receipt Number</th>
									<th>Type</th>
									<th><i class="fas fa-cogs"></i></th>
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
						<div class="col-md-12">
							<hr style="border-top:2px solid maroon">

							<table style="width:100%;font-size:14px;">
								<tr>
									<td style="min-width:250px;" valign="top">No Resi</td>
									<td style="width:2%;" valign="top">:</td>
									<td style="width:88%;" id="ResiNumber"></td>
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

	<div id="courier-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row clearfix">
						<div class="form-group col-md-12">
							<label>Choose Courier : </label>
							<select name="CourierID" id="CourierID" class="form-control"></select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="text" class="collapse" name="CourierStatus" id="CourierStatus">
					<button type="button" id="sendBtn" class="btn btn-sm btn-primary">Send</button>
				</div>
			</div>
		</div>
	</div>

	<div id="resi-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title strong">Update Receipt Number</h5>
					<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row clearfix">
						<div class="form-group col-md-12">
							<label>Input Resi Number : </label>
							<input type="text" class="form-control" name="ResiNoFromCourier" id="ResiNoFromCourier" placeholder="...">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="text" class="collapse" name="id" id="id" value="">
					<button type="button" id="resiBtn" class="btn btn-sm btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>

	<div id="rollback-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title strong">Rollback Invoice</h5>
					<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row clearfix">
						<div class="form-group col-md-12">
							<label>Rollback To : </label>
							<select class="form-control" name="InvStsID" id="InvStsID"></select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="text" class="collapse" name="inv_id" id="inv_id" value="">
					<input type="text" class="collapse" name="id4" id="id4" value="">
					<button type="button" id="rollBtn" class="btn btn-sm btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>

	<div id="received-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-sm">
			<form method="POST" id="received-form" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title strong">Received by clients</h5>
						<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
					</div>
					<div class="modal-body">
						<div class="row clearfix">
							<div class="form-group col-md-12">
								<label>Upload Foto : </label>
								<input type="file" class="form-control" name="ReceiptPathFileName" id="ReceiptPathFileName" accept="image/*" >
							</div>
							<div class="form-group col-md-12">
								<label>Receiver</label>
								<input type="text" name="ReceiptSendPkgReceiver" id="ReceiptSendPkgReceiver" class="form-control">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="text" class="collapse" name="id2" id="id2" value="">
						<button type="submit" id="btn-save" class="btn btn-sm btn-primary">Receive</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div id="return-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title strong">Return Invoice</h5>
					<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row clearfix">
						<div class="form-group col-md-12">
							<label>Reason : </label>
							<input type="text" class="form-control" name="ReasonReturned" id="ReasonReturned" placeholder="...">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="text" class="collapse" name="id3" id="id3" value="">
					<button type="button" id="returnBtn" class="btn btn-sm btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
	
</div>
<!-- /.content-wrapper -->