$(function () {

	$('#btn-new').click(function() {
		$('#invM-form').trigger('reset');
		$('#coreForm').css('display', 'none');
		$('#btn-submit').css('display', 'none');
		$('#chooseBtn').show();
		$('#type').val();
		$('#id').val();
		$('#default-modal').modal('show');
	});

	$('#PONo').select2();

	$('#chooseBtn').on('click', function() {

		var data = {
			'PeriodMonth' : $('#PeriodMonth').val(),
			'PeriodYear' : $('#PeriodYear').val(),
		}

		if (!data.PeriodMonth || !data.PeriodYear) {
			Swal.fire( "Failed!", "Column must not be empty.", "warning" );
			return;
		}

		$.ajax({
			url : base_url + 'invoice/list_order_num',
			dataType : 'JSON',
			type : 'POST',
			data : data,
			beforeSend : function () {
				$('.loading').show();
			},
			success : function (data) {
				if (data.type == 'done') {
					$('.loading').hide();
					$('#PONo').html('<option>-</option>');
					for (var i = 0; i < data.msg.length; i++) {
						$('#PONo').append('<option value="'+data.msg[i].order_no+'">'+data.msg[i].order_no+'</option>')
					}
					$('#coreForm').removeAttr('style');
					$('#btn-submit').removeAttr('style');
				}else{
					Swal.fire("Failed!", data.msg, "warning").then(function () {
						$('#PeriodMonth').val('');
						$('#PeriodYear').val('');
						$('.loading').hide();
					});
				}
			}
		});

	});

	$('#PONo').on('change', function() {

		var data = {
			'order_no'    : $(this).val(),
			'PeriodMonth' : $('#PeriodMonth').val(),
			'PeriodYear' : $('#PeriodYear').val(),
		}

		if (!data.order_no) {
			Swal.fire( "Failed!", "Column must not be empty.", "warning" );
			return;
		}

		$.ajax({
			url : base_url + 'invoice/search_order_no',
			dataType : 'JSON',
			type : 'POST',
			data : data,
			beforeSend : function () {
				$('.loading').show();
			},
			success : function (data) {
				if (data.type == 'done') {
					$('.loading').hide();
					var temp = data.msg.total_gross * data.msg.discount / 100;
					var nett = data.msg.total_gross - temp;

					$('#PO_Type').val(data.msg.po_type);
					$('#BillingType').val(data.msg.billing_type);
					$('#AgencyName').val(data.msg.agency_name);
					$('#AgencyAddr').val(data.msg.agency_address);
					$('#AgencyTelp').val(data.msg.agency_telp);
					$('#AdvertiserName').val(data.msg.advertiser_name);
					$('#AdvertiserAddr').val(data.msg.advertiser_address);
					$('#AdvertiserTelp').val(data.msg.advertiser_telp);
					$('#ProductName').val(data.msg.product_name);
					$('#AE_Name').val(data.msg.ae_name.toUpperCase());
					$('#AgencyDisc').val(data.msg.discount);
					$('#Gross').val(Math.round(data.msg.total_gross));
					// $('#Gross').val(data.msg.total_gross.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
					$('#Nett').val(Math.round(nett));
					// $('#Nett').val(nett.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
				}
			}
		});

	});


	var mt = $('#invMTbl').DataTable({
		"processing" 	: true,
		"language"		: {
			"processing"	: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide"	: true, 
		"order"			: [ 0 , 'DESC'], 
		"ajax"			: {
			"url"			: base_url + "invoice/view_manual_invoice",
			"type"			: "POST",
			"data" : { 'isActive' : 0, 'autocomplete' : 0}
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

	$('.dataTables_length select').on('change', function() {
		if ( $(this).val() == -1 ) {
			$('#sAll').removeAttr('style');
		}
	});

	mt.on('select deselect', function() {
		var count = mt.rows( { selected: true } ).count();

		if (count > 0) {
			$('.btn-send').removeAttr('disabled');
		}else{
			$('.btn-send').attr('disabled', '');
		}
	});

	$('#sAll').click(function() {
		mt.rows().select();
	});

	var dmt = $('#invdMTbl').DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "invoice/view_delManual_invoice",
			"type": "POST",
			"data" : { 'isActive' : 1, 'autocomplete' : 0}
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
		"searchDelay" : 750,
	});


	
	$("#invM-form").ajaxForm({
		dataType: "json",
		url : base_url + 'invoice/save',
		beforeSubmit: function(){
			$('.loading').show();
			$('#btn-submit').removeClass('btn-primary').addClass('btn-warning').prop('disabled', true);
		},
		success: function(data){
			var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
			var sa_type = (data.type == 'done') ? "success" : "warning";
			if (data.type == 'done') {
				Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function(){ 
					window.location.reload(); 
				});
			}else{
				Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function () {
					$('.loading').hide();
				});
			}
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
					$('#PONo').html('<option value="'+data.msg[0].PONo+'">'+data.msg[0].PONo+'</option>');
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

	$('.btn-edit-po-no').click(function() {
		var tempPONo = $('#PONo').val();

		var data = {
			'PeriodMonth' : $('#PeriodMonth').val(),
			'PeriodYear' : $('#PeriodYear').val(),
		}

		$.ajax({
			url : base_url + 'invoice/list_order_num',
			dataType : 'JSON',
			type : 'POST',
			data : data,
			beforeSend : function () {
				$('.loading').show();
			},
			success : function (data) {
				$('.loading').hide();
				$('.btn-edit-po-no').css('display', 'none');
				$('#PONo').html('<option>-</option>');
				for (var i = 0; i < data.length; i++) {
					$('#PONo').append('<option value="'+data[i].order_no+'">'+data[i].order_no+'</option>')
				}
				$('#PONo').val(tempPONo);
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