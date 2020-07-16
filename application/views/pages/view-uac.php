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
					<div class="card-body">
						<div class="row clearfix">
							<div class="col-12">
								<form method="POST" accept-charset="UTF-8" id="default-form">
									<div class="col-md-3 col-sm-4">
										<div class="form-group">
											<label>Users</label>
											<select id="user" class="form-control" name="user">
												<option selected="" value="">-</option>
												<?php 
												if (isset($emp)) {
													foreach ($emp as $row) {
														?>
														<option value="<?= $row->NIP ?>"><?= $row->NIP . ' - ' . $row->NAME  ?></option>
														<?php 
													}
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-9 col-sm-8">
										<div class="col-xs-12" id="content-uac" style="height:400px;overflow-y:scroll;">
										</div>
										<div class="col-xs-12">
											<button class="btn btn-primary" id="btn-submit">Save</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row clearfix">
							<div class="col-12">
								<div class="table-responsive">
									<table id="userTbl" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>No</th>
												<th>NIK</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- /.card-body -->
				</div>
			</div>
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->