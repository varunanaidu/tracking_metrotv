$(function () {

	$('.btn-sForm').on('click', function() {
		$('#invsts-form').trigger('reset');

		$('#default-modal').modal('show');
	});

	var t = $("#invstsTbl").DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "invoice_status/view_inv_sts",
			"type": "POST"
		},
		"searchDelay" : 750,
		"columnDefs"	: [{
			"targets"	: [0,3],
			"orderable"	: false
		}],
	});
	var dt = $("#delinvstsTbl").DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "invoice_status/view_delInv_sts",
			"type": "POST",
			"data" : {"isActive" : 1}
		},
		"searchDelay" : 750,
		"columnDefs"	: [{
			"targets"	: [0,3],
			"orderable"	: false
		}],
	});
	
	$("#invsts-form").ajaxForm({
		dataType: "json",
		url : base_url + 'invoice_status/save',
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
		url: base_url + "invoice_status/find",
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
				$("#InvStsCode").val ( data.msg[0].InvStsCode );
				$("#InvStsName").val ( data.msg[0].InvStsName );
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
				url: base_url + "invoice_status/delete",
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
				url: base_url + "invoice_status/recover",
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
		}
	});
});
});