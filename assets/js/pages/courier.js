$(document).ready(function() {

	$('.btn-sForm').on('click', function() {
		
		$('#courier-form').trigger('reset');

		$('#default-modal').modal('show');
	});
	
	var t = $("#courierTbl").DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "courier/view_courier",
			"type": "POST",
		},
		"searchDelay" : 750,
		"columnDefs"	: [{
			"targets"	: [0, 4],
			"orderable"	: false
		}],
	});
	
	var dt = $("#delCourierTbl").DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "courier/view_courier",
			"type": "POST",
			"data" : { 'isActive' : 2}
		},
		"searchDelay" : 750,
		"columnDefs"	: [{
			"targets"	: [0, 4],
			"orderable"	: false
		}],
	});
	
	$("#courier-form").ajaxForm({
		dataType: "json",
		url : base_url + 'courier/save',
		beforeSubmit: function(){
			$('#btn-submit').removeClass('btn-primary').addClass('btn-warning').prop('disabled', true);
		},
		success: function(data){
			var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
			var sa_type = (data.type == 'done') ? "success" : "warning";
			Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function(){ 
				if (data.type == 'done') window.location.reload(); 
			});
		},
		error: function(){
			Swal.fire ( "Failed!", "Error Occurred, Please refresh your browser.", "error" );
		},
		complete: function(){
			$('#btn-submit').removeClass('btn-warning').addClass('btn-primary').prop('disabled', false);
		}
	});
// EDIT
t.on('click', '.btn-edit', function () {
	var row_id = $(this).data('id');
	$.ajax({
		url: base_url + "courier/find",
		type: 'post',
		data: { 'key' : row_id },
		dataType: 'json',
		success: function(data){
			if (data.type != 'done'){
				var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
				var sa_type = (data.type == 'done') ? "success" : "error";
				Swal.fire({ title:sa_title, type:sa_type, html:data.msg });
			}
			else {
				$("#id").val ( row_id );
				$("#CourierName").val ( data.msg[0].CourierName );
				$("#CourierCode").val ( data.msg[0].CourierCode );
				$("#CourierStatus").val ( data.msg[0].CourierStatus );
				$("#type").val ( "update" );

				var mod = $('#default-modal');
				mod.find('#modal-type').text( 'Edit Entry' );
				mod.modal('show');
			}
		},
		error : function(){
			Swal.fire ( "(500)", "Error Occurred, Please refresh your browser.", "error" );
		}
	});
});
// DELETE
t.on('click', '.btn-delete', function () {
	var row_id = $(this).data('id');
	var row_name = $(this).data('name');
	Swal.fire({
		title: 'Delete data !',
		type: 'warning',
		html: '<span class="italic">Are you sure to delete <strong>' + row_name + '</strong> ?</span>',
		showCancelButton: true,
		confirmButtonText: "Yes, delete it!",
		confirmButtonColor: "#DD6B55",
		showLoaderOnConfirm: true,
	}).then(function(result){
		if (result.value) {
			$.ajax({
				url: base_url + "courier/delete",
				type: 'post',
				data: { 'key' : row_id },
				dataType: 'json',
				success: function(data){
					var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
					var sa_type = (data.type == 'done') ? "success" : "error";
					Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function(){
						if (data.type == 'done') window.location.reload();
					});
				}
			});
		}else{
			Swal.fire('Canceled', 'Cancel deleted data', 'warning');
		}
	});
});


// RESTORE
dt.on('click', '.btn-restore', function () {
	var row_id = $(this).data('id');
	var row_name = $(this).data('name');
	Swal.fire({
		title: 'Recover data !',
		type: 'warning',
		html: '<span class="italic">Are you sure to recover <strong>' + row_name + '</strong> ?</span>',
		showCancelButton: true,
		confirmButtonText: "Yes, recover it!",
		confirmButtonColor: "#DD6B55",
		showLoaderOnConfirm: true,
	}).then(function(result){
		if (result.value) {
			$.ajax({
				url: base_url + "courier/recover",
				type: 'post',
				data: { 'key' : row_id },
				dataType: 'json',
				success: function(data){
					var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
					var sa_type = (data.type == 'done') ? "success" : "error";
					Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function(){
						if (data.type == 'done') window.location.reload();
					});
				}
			});
		}else{
			Swal.fire('Canceled', 'Cancel restore data', 'warning');
		}
	});
});

});