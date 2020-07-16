$(function () {
	$("#sAll").click(function(){
		$('input:checkbox').not(this).prop('checked', this.checked);
	});

	var t = $('#messengerTbl').DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "messenger/view_messenger",
			"type": "POST",
		},
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
			"targets"	: [8],
			"orderable" : false,
			"className" : "dt-body-center",
		}],
		"searchDelay" : 750,
	});

	t.on('click', '.btn-detail', function() {
		var row_id = $(this).data('id');

		$.ajax({
			url: base_url + "messenger/find",
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

					$('#default-modal').modal('show');
				}
			},
			error : function(){
				Swal.fire ( "(500)", "Error Occurred, Please refresh your browser.", "error" );
			}
		});
	});

	$('.btn-external').click(function() {

		var data = {'key' : 1};
		var ReceiptSendPkgID = [];
		var data_row = t.rows('.selected').data();

		for (var i = 0; i < data_row.length; i++) {
			ReceiptSendPkgID[i] = data_row[i][0];
		}

		if (ReceiptSendPkgID.length > 0) {
			$.ajax({
				url : base_url + 'messenger/get_courier',
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
				url : base_url + 'messenger/get_courier',
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
					url: base_url + "messenger/send_to_courier",
					type: 'post',
					data: {
						'ReceiptSendPkgID'	: ReceiptSendPkgID,
						'CourierID'			: CourierID,
						'CourierStatus'		: CourierStatus,
					},
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