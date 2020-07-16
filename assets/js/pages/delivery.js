$(function () {
	$("#sAll").click(function(){
		$('input:checkbox').not(this).prop('checked', this.checked);
	});

	var t = $('#deliveryTbl').DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "delivery/view_delivery",
			"type": "POST",
		},
		"lengthMenu"	: [[50, 100, 150, -1], [50, 100, 150, "All"]],
		"pageLength"	: 100,
		"select"		: {'style' : 'multi'},
		"columnDefs" : [{
			"targets"	: [0],
			"visible" 	: false,
			"className" : "dt-body-center"
		},{
			"targets"	: [1],
			"className" : "text-center",
		},{
			"targets"	: [5],
			"className" : "text-right",
		},{
			"targets"	: [6],
			"className" : "text-center",
		},{
			"targets"	: [7],
			"className" : "text-right",
		},{
			"targets"	: [11],
			"orderable" : false,
			"className" : "dt-center",
		}],
		"searchDelay" : 750
	});

	t.on('select deselect', function() {
		var InvID = [];
		var data_row = t.rows( { selected: true } ).data();

		for (var i = 0; i < data_row.length; i++) {
			InvID[i] = data_row[i][12];
		}

		if (InvID.length > 0) {
			$.ajax({
				url : base_url + 'delivery/check_invoice',
				type : 'post',
				dataType : 'json',
				data : {'InvID' : InvID},
				success : function(data){
					for (var i = 0; i < data.length; i++) {
						if (data[i] == '2') {
							$('.btn-external').removeAttr('disabled');
							$('.btn-internal').removeAttr('disabled');
						}else{
							$('.btn-external').attr('disabled', '');
							$('.btn-internal').attr('disabled', '');
							return;
						}
					}
				}
			});
		}else{
			$('.btn-external').attr('disabled', '');
			$('.btn-internal').attr('disabled', '');
		}


		/*var count = t.rows( { selected: true } ).count();

		if (count > 0) {
			$('.btn-external').removeAttr('disabled');
			$('.btn-internal').removeAttr('disabled');
		}else{
			$('.btn-external').attr('disabled', '');
			$('.btn-internal').attr('disabled', '');
		}*/
	});

	t.on('click', '.btn-detail', function() {
		var row_id = $(this).data('id');

		$.ajax({
			url: base_url + "delivery/find",
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

					var Nett = data.msg[0].Nett;
					var n = Nett.length;
					console.log(n);

					$("#InvNo").text ( data.msg[0].InvNo );
					$("#PONo").text ( data.msg[0].PONo );
					$("#PO_Type").text ( data.msg[0].PO_Type );
					$("#BillingType").text ( data.msg[0].BillingType );
					$("#AgencyName").text ( data.msg[0].AgencyName );
					$("#AgencyAddr").text ( data.msg[0].AgencyAddr );
					$("#AgencyTelp").text ( data.msg[0].AgencyTelp );
					$("#AdvertiserName").text ( data.msg[0].AdvertiserName );
					$("#AdvertiserAddr").text ( data.msg[0].AdvertiserAddr );
					$("#AdvertiserTelp").text ( data.msg[0].AdvertiserTelp );
					$("#AdvertiserName").text ( data.msg[0].AdvertiserName );
					$("#ProductName").text ( data.msg[0].ProductName );
					$("#AE_Name").text ( data.msg[0].AE_Name );
					$("#AgencyDisc").text ( data.msg[0].AgencyDisc );
					$("#Nett").text ( data.msg[0].Nett );
					$("#Gross").text ( data.msg[0].Gross );
					$("#ResiNumber").text ( data.msg[0].ResiNoFromCourier );

					$('#default-modal').modal('show');
				}
			},
			error : function(){
				Swal.fire ( "(500)", "Error Occurred, Please refresh your browser.", "error" );
			}
		});
	});

	t.on('click', '.btn-resi', function() {
		var row_id = $(this).data('id');

		$.ajax({
			url: base_url + "delivery/find",
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
					$("#id").val ( data.msg[0].ReceiptSendPkgID );

					$('#resi-modal').modal('show');
				}
			},
			error : function(){
				Swal.fire ( "(500)", "Error Occurred, Please refresh your browser.", "error" );
			}
		});
	});


	$('#resiBtn').click(function() {
		var data = {
			'ResiNoFromCourier' : $('#ResiNoFromCourier').val(), 
			'ReceiptSendPkgID'	: $('#id').val(),
		};

		$.ajax({
			url : base_url + 'delivery/update_resi',
			type : 'post',
			dataType : 'json',
			data : data,
			beforeSend : function () {
				$('.loading').show();
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
		});
	});

	t.on('click', '.btn-received', function() {

		var row_id = $(this).data('id');

		$.ajax({
			url: base_url + "delivery/find",
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
					$("#id2").val ( data.msg[0].ReceiptSendPkgID );

					$('#received-modal').modal('show');
				}
			},
			error : function(){
				Swal.fire ( "(500)", "Error Occurred, Please refresh your browser.", "error" );
			}
		});
	});

	t.on('click', '.btn-return', function() {

		// alert('Return Clicked');

		var row_id = $(this).data('id');

		$.ajax({
			url: base_url + "delivery/find",
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
					$("#id3").val ( data.msg[0].ReceiptSendPkgID );

					$('#return-modal').modal('show');
				}
			},
			error : function(){
				Swal.fire ( "(500)", "Error Occurred, Please refresh your browser.", "error" );
			}
		}); 
	});

	$('#returnBtn').click(function() {
		var data = {
			'ReasonReturned' : $('#ReasonReturned').val(), 
			'ReceiptSendPkgID'	: $('#id3').val(),
		};

		$.ajax({
			url : base_url + 'delivery/return_invoice',
			type : 'post',
			dataType : 'json',
			data : data,
			beforeSend : function () {
				$('.loading').show();
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
		});
	});
	
	$("#received-form").ajaxForm({
		url : base_url + "delivery/received_invoice",
		dataType : "JSON",
		beforeSubmit : function(){
			$('.loading').show();
			$("#btn-save").html ( "Please wait..." ).removeClass("btn-primary").addClass("btn-warning").prop("disabled", true);
		},
		success : function(data){
			if ( data.type == 'done' ){
				Swal.fire({
					title : "Success!", 
					html : data.msg, 
					type : "success"
				}).then(function () {
					window.location.reload();
				});
			}
			else{
				Swal.fire({
					title : "Error!", 
					html : data.msg, 
					type : "error"
				}).then(function () {
					Swal.close();
					$('.loading').hide();
					$("#btn-save").html ( "Receive" ).removeClass("btn-warning").addClass("btn-primary").prop("disabled", false);
				});
			}
		}
	});

	$('.btn-external').click(function() {

		var data 				= {'key' : 1};
		var ReceiptSendPkgID	= [];
		var data_row 			= t.rows('.selected').data();

		for (var i = 0; i < data_row.length; i++) {
			ReceiptSendPkgID[i] = data_row[i][0];
		}

		if (ReceiptSendPkgID.length > 0) {

			$.ajax({
				url : base_url + 'delivery/get_courier',
				type : 'post',
				dataType : 'json',
				data : data,
				success :function (data) {
					if (data.type == 'done') {
						$('#CourierID').html('<option>...</option>');
						for (var i = 0; i < data.msg.length; i++) {
							$('#CourierID').append('<option value="'+data.msg[i].CourierID+'" >'+data.msg[i].CourierName+'</option>');
						}
						$('#CourierStatus').val(data.cStatus);
						$('#courier-modal').modal('show');
					}else{
						Swal.fire('Failed !', data.msg,	'error');
					}
				}
			});

		}else{
			Swal.fire('Failed !', 'Choose min 1.', 'warning');
		}
	});


	$('.btn-internal').click(function() {

		var data = {'key' : 2};
		var ReceiptSendPkgID = [];
		var data_row = t.rows('.selected').data();

		for (var i = 0; i < data_row.length; i++) {
			ReceiptSendPkgID[i] = data_row[i][0];
		}

		if (ReceiptSendPkgID.length > 0) {
			$.ajax({
				url : base_url + 'delivery/get_courier',
				type : 'post',
				dataType : 'json',
				data : data,
				success :function (data) {
					if (data.type == 'done') {
						$('#CourierID').html('<option>...</option>');
						for (var i = 0; i < data.msg.length; i++) {
							$('#CourierID').append('<option value="'+data.msg[i].CourierID+'" >'+data.msg[i].CourierName+'</option>');
						}
						$('#CourierStatus').val(data.cStatus);
						$('#courier-modal').modal('show');
					}else{
						Swal.fire('Failed !', data.msg,	'error');
					}
				}
			});
		}else{
			Swal.fire('Failed !', 'Choose min 1.', 'warning');
		}
	});

	$('#sendBtn').click(function () {
		var ReceiptSendPkgID = [];
		var CourierID = $('#CourierID').val();
		var CourierStatus = $('#CourierStatus').val();
		var data_row = t.rows('.selected').data();


		for (var i = 0; i < data_row.length; i++) {
			ReceiptSendPkgID[i] = data_row[i][0];
		}

		Swal.fire({
			title: 'Send Invoice !',
			type: 'warning',
			html: '<span class="italic">Are you sure ?</span>',
			showCancelButton: true,
			confirmButtonText: "Yes, send it!",
			confirmButtonColor: "#DD6B55",
			showLoaderOnConfirm: true,
		}).then(function(result){
			if (result.value) {
				$.ajax({
					url: base_url + "delivery/send_to_courier",
					type: 'post',
					data: {
						'ReceiptSendPkgID'	: ReceiptSendPkgID,
						'CourierID'			: CourierID,
						'CourierStatus'		: CourierStatus,
					},
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

	t.on('click', '.btn-rollback', function() {

		var row_id = $(this).data('id');
		var inv_id = $(this).data('invoice');

		$.ajax({
			url: base_url + "delivery/find_rollback",
			type: 'post',
			data: { 'key' : row_id },
			dataType: 'json',
			success : function (data) {
				if (data.type == 'done') {
					$('#InvStsID').html('<option>...</option>');
					for (var i = 0; i < data.data_invoice_status.length; i++) {
						$('#InvStsID').append('<option value="'+data.data_invoice_status[i].InvStsID+'" >'+data.data_invoice_status[i].InvStsName+'</option>')
					}
					$('#id4').val(row_id);
					$('#inv_id').val(inv_id);
					$('#rollback-modal').modal('show');
				}else{
					Swal.fire('Failed !', data.msg,	'error');
				}
			}
		});
	});

	$('#rollBtn').click(function() {
		var data = {
			'InvStsID' 			: $('#InvStsID').val(),
			'ReceiptSendPkgID'	: $('#id4').val(),
			'InvID'				: $('#inv_id').val()
		};

		$.ajax({
			url: base_url + "delivery/rollback",
			type: 'post',
			data: data,
			dataType: 'json',
			success : function (data) {
				var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
				var sa_type = (data.type == 'done') ? "success" : "warning";
				if (data.type == 'done') {
					Swal.fire({ title:sa_title, type:sa_type, html:data.msg }).then(function(){ 
						window.location.reload(); 
					});
				}else{
					Swal.fire({ title:sa_title, type:sa_type, html:data.msg });
				}
			}
		});
	});

})