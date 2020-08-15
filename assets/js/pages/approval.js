$(function () {
	$("#sAll").click(function(){
		$('input:checkbox').not(this).prop('checked', this.checked);
	});

	var t = $('#approvalTbl').DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "approval/view_tracking",
			"type": "POST",
		},
		"lengthMenu"	: [[50, 100, 150, -1], [50, 100, 150, "All"]],
		"pageLength"	: 100,
		"select"		: {'style' : 'multi'},
		"columnDefs" : [{
			"targets"	: [0],
			"visible" 	: false,
			"className" : "dt-body-center",
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
			"targets"	: [9],
			"orderable" : false,
			"className" : "dt-body-center",
		}],
		"searchDelay" : 750,
	});

	t.on('select deselect', function() {
		var count = t.rows( { selected: true } ).count();

		if (count > 0) {
			$('.btn-accept').removeAttr('disabled');
			$('.btn-return').removeAttr('disabled');
		}else{
			$('.btn-accept').attr('disabled', '');
			$('.btn-return').attr('disabled', '');
		}
	});


	$('.btn-accept').click(function() {
		var ReceiptSendPkgID = [];
		var data = t.rows('.selected').data();

		for (var i = 0; i < data.length; i++) {
			ReceiptSendPkgID[i] = data[i][0];
		}

		if (ReceiptSendPkgID.length > 0) {
			Swal.fire({
				title: 'Accept Invoice !',
				type: 'warning',
				html: '<span class="italic">Are you sure ?</span>',
				showCancelButton: true,
				confirmButtonText: "Yes, accept it!",
				confirmButtonColor: "#DD6B55",
				showLoaderOnConfirm: true,
			}).then(function(result){
				if (result.value) {
					$.ajax({
						url: base_url + "approval/accept_invoice",
						type: 'post',
						data: {
							'ReceiptSendPkgID'	: ReceiptSendPkgID,
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
		}else{
			Swal.fire('Failed !', 'Choose min 1.', 'warning');
		}
		
	});


	$('.btn-return').click(function() {
		var ReceiptSendPkgID = [];
		var data = t.rows('.selected').data();

		for (var i = 0; i < data.length; i++) {
			ReceiptSendPkgID[i] = data[i][0];
		}

		if (ReceiptSendPkgID.length > 0) {
			Swal.fire({
				title: 'Return Invoice !',
				type: 'warning',
				html: '<span class="italic">Are you sure ?</span>',
				showCancelButton: true,
				confirmButtonText: "Yes, return it!",
				confirmButtonColor: "#DD6B55",
				showLoaderOnConfirm: true,
			}).then(function(result){
				if (result.value) {
					$.ajax({
						url: base_url + "approval/return_invoice",
						type: 'post',
						data: {
							'ReceiptSendPkgID'	: ReceiptSendPkgID,
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
		}else{
			Swal.fire('Failed !', 'Choose min 1.', 'warning');
		}

		
	});

	t.on('click', '.btn-detail', function() {
		var row_id = $(this).data('id');

		$.ajax({
			url: base_url + "approval/find",
			type: 'post',
			data: { 'key' : row_id },
			dataType: 'json',
			success: function(data){
				if (data.type != 'done'){
					var sa_title = (data.type == 'done') ? "Success!" : "Failed!";
					var sa_type = (data.type == 'done') ? "success" : "error";
					swal({ title:sa_title, type:sa_type, html:data.msg });
				}
				else {

					var Nett = data.msg[0].Nett;
					var n = Nett.length;

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
					// $("#Nett").text ( (data.msg[0].Nett/1000).toFixed(3) );
					$("#Nett").text ( data.msg[0].Nett );
					$("#Gross").text ( data.msg[0].Gross );

					$('#default-modal').modal('show');
				}
			},
			error : function(){
				swal ( "(500)", "Error Occurred, Please refresh your browser.", "error" );
			}
		});

	});

	
});