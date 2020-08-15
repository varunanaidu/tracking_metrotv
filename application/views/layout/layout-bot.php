<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<footer class="main-footer">
	<div class="float-right d-none d-sm-block">
		<b>Version</b> 1.0
	</div>
	<strong>Copyright &copy; 2020-<?= date('Y') ?> <a href="javascript:void(0)">TrackID - Metro TV</a>.</strong> All rights
	reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
	<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<script type="text/javascript">var base_url = '<?php echo base_url(); ?>' </script>
<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/datatables-select/js/dataTables.select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/datatables-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>


<!-- JQUERY FORM -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/adminlte/dist/js/demo.js"></script>
<!-- Sweetalert -->
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- SELECT2 -->
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/select2/js/select2.min.js"></script>
<!-- CHART JS -->
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- Page Script -->
<?php 
if (isset($js)) {
	?>
	<script src="<?= $js ?>"></script>
	<?php 
}
?>
</body>
</html>