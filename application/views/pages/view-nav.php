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
						<button type="button" class="btn btn-default btn-sm btn-sForm" title="" style="float: right;">
							<i class="fa fa-plus text-blue"></i> New Entry</button>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<button type="button" class="btn btn-sm btn-success btn-order"><i class="fas fa-sort"></i> Order Menu</button>
						</div>
						<div class="card-body table-responsive">
							<table id="navTbl" class="table table-bordered table-hover" style="font-size: 10pt !important;">
								<thead>
									<tr>
										<th width="20" style="text-align: left;">#</th>
										<th style="text-align: center;">Name</th>
										<th style="text-align: center;">Controller</th>
										<th style="text-align: center;">Parent</th>
										<th width="80" style="text-align: right;"><i class="fas fa-cogs"></i></th>
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
					<form method="POST" id="nav-form" accept-charset="UTF-8">
						<div class="modal-header">
							<h4 class="modal-title strong"><?=$header_child?> - <span id="modal-type">New Entry</span></h4>
							<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
						</div>
						<div class="modal-body">
							<div class="row clearfix">
								<div class="form-group col-md-6">
									<label>Navigation Name <span class="text-red">*</span></label>
									<input type="text" class="form-control" id="nav_name" maxlength="100" name="nav_name" value="" placeholder="..." required>
								</div>
								<div class="form-group col-md-6">
									<label>Controller Name <span class="text-red">*</span></label>
									<input type="text" class="form-control" id="nav_ctr" maxlength="100" name="nav_ctr" value="" placeholder="..." required>
								</div>
								<div class="form-group col-md-6">
									<label>Parent Name <span class="text-red">*</span></label>
									<select class="form-control" id="nav_parent" name="nav_parent" required="">
										<option value="0">Root</option>
										<?php 
										if (isset($parent) and $parent != 0) {
											foreach ($parent as $row) {
												?>
												<option value="<?= $row->nav_id ?>"><?= $row->nav_name ?></option>
												<?php 
											}
										}
										?>	
									</select>
								</div>
								<?php 
								if (isset($check_last) and $check_last != 0) {
									foreach ($check_last as $row) {
										?>
										<div class="form-group col-md-6">
											<label>Navigation Order <span class="text-red">*</span></label>
											<input type="number" class="form-control" id="nav_order" maxlength="100" name="nav_order" value="<?= $row->LAST+1 ?>" placeholder="..." required="">
										</div>
										<?php 
									}
								}
								?>
							</div>
						</div>
						<div class="modal-footer">
							<input type="text" class="collapse" id="type" name="type" value="">
							<input type="text" class="collapse" id="id" name="id" value="">
							<button type="submit" id="btn-submit" class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div id="order-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<form id="order-form" accept-charset="UTF-8">
						<div class="modal-header">
							<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
						</div>
						<div class="modal-body">
							<div class="row clearfix">
								<div class="form-group col-md-12 table-responsive">
									<table class="table table-bordered table-hover" id="orderTbl">
										<thead>
											<tr>
												<th>Nav Name</th>
												<th>Options</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											if (isset($parent_menu) and $parent_menu != 0) {
												foreach ($parent_menu as $row) {
													?>
													<tr class="row_nav" data-id="<?= $row->nav_id ?>">
														<td class="row_nav_name"><?= $row->nav_name ?></td>
														<td><a><i class="fas fa-arrow-up btn-up"></i></a> <a><i class="fas fa-arrow-down btn-down"></i></a><a><i class="fas fa-eye btn-detail" data-id="<?= $row->nav_id ?>"></i></a></td>
													</tr>
													<?php 
												}
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" id="btn-submit-2" class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div id="order-modal-2" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<form id="order-form-2" accept-charset="UTF-8">
						<div class="modal-header">
							<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
						</div>
						<div class="modal-body">
							<div class="row clearfix">
								<div class="form-group col-md-12 table-responsive">
									<table class="table table-bordered table-hover" id="orderTbl2">
										<thead>
											<tr>
												<th>Nav Name</th>
												<th>Options</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" id="btn-submit-3" class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
<!-- /.content-wrapper -->