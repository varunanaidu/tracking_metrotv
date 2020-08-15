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
					<div class="card-body">
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
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="chart">
									<canvas id="invChart" style="min-height: 300px; height: 300px; max-height: 300px;"></canvas>
								</div>
							</div>
						</div>
					</div>
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