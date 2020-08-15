$(function () {

	$('.btn-sForm').on('click', function() {
		$('#nav-form').trigger('reset');

		$('#default-modal').modal('show');
	});

	$('.btn-order').on('click', function(event) {
		event.preventDefault();
		
		$('#order-modal').modal('show');
	});

	$('#orderTbl').on('click', '.btn-up, .btn-down', function(event) {
		event.preventDefault();

		var row = $(this).parents("tr:first");
		if ($(this).is(".btn-up")) {
			row.insertBefore(row.prev());
		} else {
			row.insertAfter(row.next());
		}
	});

	$('#orderTbl2').on('click', '.btn-up-2, .btn-down-2', function(event) {
		event.preventDefault();

		var row = $(this).parents("tr:first");
		if ($(this).is(".btn-up-2")) {
			row.insertBefore(row.prev());
		} else {
			row.insertAfter(row.next());
		}
	});

	$('#orderTbl').on('click', '.btn-detail', function(event) {
		event.preventDefault();

		var key = {'nav_parent' : $(this).data('id')};

		$.ajax({
			url : base_url + 'navigations/find_parent',
			type : 'POST',
			dataType : 'JSON',
			data : key,
			success : function (data) {
				if (data.type == 'done') {
					$('#orderTbl2 tbody').html('');
					for (var i = 0; i < data.msg.length; i++) {
						$('#orderTbl2 tbody').append('<tr class="row_nav_2" data-id="'+data.msg[i].nav_id+'"><td>'+data.msg[i].nav_name+'</td><td><a><i class="fas fa-arrow-up btn-up-2"></i></a> <a><i class="fas fa-arrow-down btn-down-2"></i></a></td></tr>')
					}

					$('#order-modal-2').modal('show');
				}
			}
		});
	});

	var t = $("#navTbl").DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "navigations/view_nav",
			"type": "POST"
		},
		"searchDelay" : 750,
		"columnDefs"	: [{
			"targets"	: [0,4],
			"orderable"	: false
		}]
	});
	
	$("#nav-form").ajaxForm({
		dataType: "json",
		url : base_url + 'navigations/save',
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

	$('#order-form').on('submit', function(event) {
		event.preventDefault();

		var nav = [];

		$('.row_nav').each(function(index, el) {
			nav.push( $(el).data('id') );
		});

		console.log(nav);

		$.ajax({
			url : base_url + 'navigations/order_nav',
			type : 'POST',
			dataType : 'JSON',
			data : {'nav' : nav},
			success: function(data){
				var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
				var sa_type = (data.type == 'done') ? "success" : "warning";
				Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function(){ 
					if (data.type == 'done') window.location.reload(); 
				});
			},
		});
	});

	$('#order-form-2').on('submit', function(event) {
		event.preventDefault();

		var nav = [];

		$('.row_nav_2').each(function(index, el) {
			nav.push( $(el).data('id') );
		});

		console.log(nav);

		$.ajax({
			url : base_url + 'navigations/order_nav_child',
			type : 'POST',
			dataType : 'JSON',
			data : {'nav' : nav},
			success: function(data){
				var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
				var sa_type = (data.type == 'done') ? "success" : "warning";
				Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function(){ 
					if (data.type == 'done') $('#order-modal-2').modal('hide');
				});
			},
		});
	});

	$('#nav_parent').change(function(e) {

		var nav_parent = $(this).val();

		$.ajax({
			url : base_url + "navigations/check_last",
			type : "POST",
			dataType : "JSON",
			data : {'key' : nav_parent},
			success : function (data) {
				if (data.type == 'done') {
					var nav_order = Number(data.msg[0].LAST) + 1;
					$('#nav_order').val(nav_order);
				}
			}
		});

	});


// EDIT
t.on('click', '.btn-edit', function () {
	var row_id = $(this).data('id');
	$.ajax({
		url: base_url + "navigations/find",
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
				$("#nav_name").val ( data.msg[0].nav_name );
				$("#nav_ctr").val ( data.msg[0].nav_ctr );
				$("#nav_parent").val ( data.msg[0].nav_parent );
				$("#nav_order").val ( data.msg[0].nav_order );
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
				url: base_url + "navigations/delete",
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
			Swal.fire('Canceled', 'Canceled remove data', 'warning');
		}
	});
});
});