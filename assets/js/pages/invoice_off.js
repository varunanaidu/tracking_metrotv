$(function () {

	$('#btn-new').click(function() {
		$('#invO-form').trigger('reset');
		$('#default-modal').modal('show');
	});

	var mt = $('#invOTbl').DataTable({
		"processing" 	: true,
		"language"		: {
			"processing"	: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide"	: true, 
		"order"			: [ 0 , 'DESC'], 
		"ajax"			: {
			"url"			: base_url + "invoice/view_off_air_invoice",
			"type"			: "POST",
		},
		"lengthMenu"	: [[50, 100, 150, -1], [50, 100, 150, "All"]],
		"pageLength"	: 50,
		"select"		: {'style' : 'multi'},
		"columnDefs" : [{
			"targets"		: [0, 9],
			"visible"		: false,
		},{
			"targets"		: [1],
			"className" 	: "text-center",
		},{
			"targets"		: [5],
			"className" 	: "text-right",
		},{
			"targets"		: [6],
			"className" 	: "text-center",
		},{
			"targets"		: [7],
			"className" 	: "text-right",
		},{
			"targets"		: [8],
			"orderable" 	: false,
			"className" 	: "dt-body-center",
		}],
		"searchDelay" 	: 750
	});

	var dmt = $('#invdOTbl').DataTable({
		"processing" 	: true,
		"language"		: {
			"processing"	: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide"	: true, 
		"order"			: [ 0 , 'DESC'], 
		"ajax"			: {
			"url"			: base_url + "invoice/view_del_off_air",
			"type"			: "POST",
			"data" : { 'isActive' : 1, 'autocomplete' : 1}
		},
		"lengthMenu"	: [[50, 100, 150, -1], [50, 100, 150, "All"]],
		"pageLength"	: 50,
		"select"		: {'style' : 'multi'},
		"columnDefs" : [{
			"targets"		: [0, 9],
			"visible"		: false,
		},{
			"targets"		: [1],
			"className" 	: "text-center",
		},{
			"targets"		: [5],
			"className" 	: "text-right",
		},{
			"targets"		: [6],
			"className" 	: "text-center",
		},{
			"targets"		: [7],
			"className" 	: "text-right",
		},{
			"targets"		: [8],
			"orderable" 	: false,
			"className" 	: "dt-body-center",
		}],
		"searchDelay" 	: 750
	});

	mt.on('select deselect', function() {
		var count = mt.rows( { selected: true } ).count();

		if (count > 0) {
			$('.btn-send').removeAttr('disabled');
		}else{
			$('.btn-send').attr('disabled', '');
		}
	});


	$("#invO-form").ajaxForm({
		dataType: "json",
		url : base_url + 'invoice/save',
		beforeSubmit: function(){
			$('.loading').show();
			$('#btn-submit').removeClass('btn-primary').addClass('btn-warning').prop('disabled', true);
		},
		success: function(data){
			var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
			var sa_type = (data.type == 'done') ? "success" : "warning";
			Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function(){ 
				if (data.type == 'done') {
					window.location.reload();
				}else{
					$('.loading').hide();
				}
			});
		},
		error: function(){
			Swal.fire ( "Failed!", "Error Occurred, Please refresh your browser.", "error" );
		},
		complete: function(){
			$('#btn-submit').removeClass('btn-warning').addClass('btn-primary').prop('disabled', false);
		}
	});



	mt.on('click', '.btn-edit', function () {
		var row_id = $(this).data('id');
		var tr_id = $(this).data('tr');

		$.ajax({
			url: base_url + "invoice/find",
			type: 'post',
			data: { 'key' : row_id, 'key_2' : tr_id },
			dataType: 'json',
			success: function(data){
				if (data.type != 'done'){
					var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
					var sa_type = (data.type == 'done') ? "success" : "error";
					swal({ title:sa_title, type:sa_type, html:data.msg });
				}
				else {
					$('#coreForm').removeAttr('style');
					$('#btn-submit').removeAttr('style');
					$('#tempPONo').removeAttr('style');
					$('.btn-edit-po-no').removeAttr('style');
					$('#chooseBtn').hide();
					$("#id").val ( row_id );
					$("#tr_id").val ( tr_id );
					$("#PeriodMonth").val ( data.msg[0].PeriodMonth );
					$("#PeriodYear").val ( data.msg[0].PeriodYear );
					$("#InvNo").val ( data.msg[0].InvNo );
					$('#PONo').val( data.msg[0].PONo );
					$("#PO_Type").val ( data.msg[0].PO_Type );
					$("#BillingType").val ( data.msg[0].BillingType );
					$("#AgencyName").val ( data.msg[0].AgencyName );
					$("#AgencyAddr").val ( data.msg[0].AgencyAddr );
					$("#AgencyTelp").val ( data.msg[0].AgencyTelp );
					$("#AdvertiserName").val ( data.msg[0].AdvertiserName );
					$("#AdvertiserAddr").val ( data.msg[0].AdvertiserAddr );
					$("#AdvertiserTelp").val ( data.msg[0].AdvertiserTelp );
					$("#ProductName").val ( data.msg[0].ProductName );
					$("#AE_Name").val ( data.msg[0].AE_Name.toUpperCase() );
					$("#AgencyDisc").val ( data.msg[0].AgencyDisc );
					$("#Gross").val ( Math.round(data.msg[0].Gross) );
					$("#Nett").val ( Math.round(data.msg[0].Nett) );
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

	mt.on('click', '.btn-delete', function () {
		var row_id = $(this).data('id');
		var row_name = $(this).data('name');
		var tr_id = $(this).data('tr');
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
					url: base_url + "invoice/delete",
					type: 'post',
					data: { 'key' : row_id ,'key_2' : tr_id },
					dataType: 'json',
					beforeSend : function () {
						$('.loading').show();
					},
					success: function(data){
						var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
						var sa_type = (data.type == 'done') ? "success" : "error";
						Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function(){
							if (data.type == 'done') {
								window.location.reload();
							}else{
								$('.loading').hide();
							}
						});
					}
				});
			}
		});
	});

	$('.btn-send').click(function() {
		var InvID = [];
		var ReceiptSendPkgID = [];
		var data = mt.rows('.selected').data();


		for (var i = 0; i < data.length; i++) {
			InvID[i] = data[i][0];
			ReceiptSendPkgID[i] = data[i][9];
		}

		if (InvID.length > 0) {
			Swal.fire({
				title: 'Send data to GA !',
				type: 'warning',
				html: '<span class="italic">Are you sure to send selected data to GA ?</span>',
				showCancelButton: true,
				confirmButtonText: "Yes, send it!",
				confirmButtonColor: "#DD6B55",
				showLoaderOnConfirm: true,
			}).then(function(result){
				if (result.value) {
					$.ajax({
						url: base_url + "invoice/send_to_ga",
						type: 'post',
						data: { 'key' : InvID, 'key_2' : ReceiptSendPkgID },
						dataType: 'json',
						beforeSend : function () {
							$('.loading').show();
						},
						success: function(data){
							var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
							var sa_type = (data.type == 'done') ? "success" : "error";
							Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function(){
								if (data.type == 'done') {
									window.location.reload();
								}else{
									$('.loading').hide();
								}
							});
						}
					});
				}
			});
		}else{
			Swal.fire('Failed !', 'Choose min 1.', 'warning');
		}
	});

	dmt.on('click', '.btn-restore', function () {
		var row_id = $(this).data('id');
		var row_name = $(this).data('name');
		var tr_id = $(this).data('tr');
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
					url: base_url + "invoice/recover",
					type: 'post',
					data: { 'key' : row_id ,'key_2' : tr_id },
					dataType: 'json',
					beforeSend : function () {
						$('.loading').show();
					},
					success: function(data){
						var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
						var sa_type = (data.type == 'done') ? "success" : "error";
						Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function(){
							if (data.type == 'done') {
								window.location.reload();
							}else{
								$('.loading').hide();
							}
						});
					}
				});
			}
		});
	});

});