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
						<div class="card-body table-responsive">
							<table id="invstsTbl" class="table table-bordered table-hover" style="font-size: 10pt;">
								<thead>
									<tr>
										<th width="20" style="text-align: left;">#</th>
										<th style="text-align: center;">Code</th>
										<th style="text-align: center;">Name</th>
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
					<form method="POST" id="invsts-form" accept-charset="UTF-8">
						<div class="modal-header">
							<h4 class="modal-title strong"><?=$header_child?> - <span id="modal-type">New Entry</span></h4>
							<button type="button" class="close text-red" data-dismiss="modal" tabindex="-1">&times;</button>
						</div>
						<div class="modal-body">
							<div class="row clearfix">
								<div class="form-group col-md-6">
									<label>Status Code <span class="text-red">*</span></label>
									<input type="text" class="form-control" id="InvStsCode" maxlength="100" name="InvStsCode" value="" placeholder="..." required>
								</div>
								<div class="form-group col-md-6">
									<label>Status Name <span class="text-red">*</span></label>
									<input type="text" class="form-control" id="InvStsName" maxlength="100" name="InvStsName" value="" placeholder="..." required>
								</div>
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
	</div>
<!-- /.content-wrapper -->