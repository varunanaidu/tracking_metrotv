$(function () {
	var selected = [];

	$('#generateBtn').click(function() {
		$('#default-modal').modal('show');
	});

	var t = $('#invBTbl').DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [ 0 , 'DESC'], 
		"ajax": {
			"url": base_url + "invoice/view_bms_invoice",
			"type": "POST",
		},
		"lengthMenu"	: [[50, 100, 150, -1], [50, 100, 150, "All"]],
		"pageLength"	: 50,
		"select"		: {'style' : 'multi'},
		"columnDefs" : [{
			"targets"	: [0,9],
			"visible"	: false,
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
		"searchDelay" : 750
	});

	var dt = $('#invdBTbl').DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "invoice/view_delBms_invoice",
			"type": "POST",
			"data" : { 'isActive' : 1}
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

	dt.on('click', '.btn-restore', function () {
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

	$('.dataTables_length select').on('change', function() {
		if ( $(this).val() == -1 ) {
			$('#selectCont').removeAttr('style');
		}
	});

	$("#selectAll").click(function(){
		if ($(this).is(':checked')) {
			t.rows().select();
		}else{
			t.rows().deselect();
		}
	});

	t.on('select deselect', function() {
		var count = t.rows( { selected: true } ).count();

		if (count > 0) {
			$('.btn-send').removeAttr('disabled');
		}else{
			$('.btn-send').attr('disabled', '');
		}
	});

	t.on('click', '.btn-delete', function () {
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
		var data = t.rows('.selected').data();


		for (var i = 0; i < data.length; i++) {
			InvID[i] = data[i][0];
			ReceiptSendPkgID[i] = data[i][9];
		}

		console.log(data);

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
			url : base_url + 'invoice/get_bms_invoice',
			dataType : 'JSON',
			type : 'POST',
			data : data,
			beforeSend : function () {
				$('.loading').show();
			},
			success : function (data) {
				$('#bmsTbl').DataTable().destroy();
				$('#mnlTbl').DataTable().destroy();

				$('#bmsTbl tbody').html('');
				$('#mnlTbl tbody').html('');


				for (var i = 0; i < data.data_bms.length; i++) {
					$('#bmsTbl tbody').append('<tr><td>'+data.data_bms[i][0]+'</td><td>'+data.data_bms[i][1]+'</td><td>'+data.data_bms[i][2]+'</td><td>'+data.data_bms[i][3]+'</td><td>'+data.data_bms[i][4]+'</td><td>'+data.data_bms[i][5]+'</td></tr>')
				}
				for (var i = 0; i < data.data_mnl.length; i++) {
					$('#mnlTbl tbody').append('<tr><td>'+data.data_mnl[i][0]+'</td></tr>')
				}
				$('.loading').hide();
				$('#modalBody').removeAttr('style');

				var mt = $('#mnlTbl').DataTable();

				var bt = $('#bmsTbl').DataTable({
					'dom'			: 'flrBtip', 
					'order'			: [[0,'asc']],
					'columnDefs'	: [{
						'orderable': false,    
						'targets': [1]
					},{
						'visible': false,    
						'targets': [2, 3, 4, 5]
					}], 
					"lengthMenu"	: [[10, 25, 50, -1], [10, 25, 50, "All"]],
					'select'		: {
						'style'	: 'multi'
					},
					'buttons'		: [{
						'text'	: 'Import Data',
						'attr'	: {
							'class' : 'btn btn-md btn-success btn-import'
						}
					}],
					initComplete	: function () {
						var api = this.api();
						api.rows().every(function (rI, tL, rL) {
							var data = this.data();
							if (data[2] === 'checked') {
								api.row(rI).select();
							}
						});
					}
				});

				bt.on('click', '.btn-detail', function() {
					var data = {
						'PeriodMonth' : $('#PeriodMonth').val(),
						'PeriodYear' : $('#PeriodYear').val(),
						'order_no'	 : $(this).data('id'),
					};

					$.ajax({
						url : base_url + 'invoice/search_order_no_bms',
						dataType : 'JSON',
						type : 'POST',
						data : data,
						beforeSend : function () {
							$('.loading').show();
						},
						success : function (data) {
							if (data.type == 'done') {
								$('.loading').hide();

								$('#InvNo').text(data.msg.invoice_no);
								$('#PONo').text(data.msg.order_no);
								$('#PO_Type').text(data.msg.po_type);
								$('#BillingType').text(data.msg.billing_type);
								$('#AgencyName').text(data.msg.agency_name);
								$('#AgencyAddr').text(data.msg.agency_address);
								$('#AgencyTelp').text(data.msg.agency_telp);
								$('#AdvertiserName').text(data.msg.advertiser_name);
								$('#AdvertiserAddr').text(data.msg.advertiser_address);
								$('#AdvertiserTelp').text(data.msg.advertiser_telp);
								$('#ProductName').text(data.msg.product_name);
								$('#AE_Name').text(data.msg.ae_name);
								$('#AgencyDisc').text(data.msg.discount);
								$('#Gross').text(data.msg.sub_total);
								$('#Nett').text(data.msg.total);

								$('#default-modal2').modal('show');
							}else{
								$('.loading').hide();
							}
						}
					});
				});

				$('.btn-import').click(function() {
					var invoice_no = [];
					var row = bt.rows('.selected').data();


					for (var i = 0; i < row.length; i++) {
						invoice_no[i] = row[i][3];
					}

					var data = {
						'PeriodMonth' : $('#PeriodMonth').val(),
						'PeriodYear' : $('#PeriodYear').val(),
						'invoice_no'	 : invoice_no,
					};

					Swal.fire({
						title: 'Import selected invoice !',
						type: 'warning',
						html: '<span class="italic">Are you sure want to import '+row.length+' selected invoices ?</span>',
						showCancelButton: true,
						confirmButtonText: "Yes, import it!",
						confirmButtonColor: "#DD6B55",
						showLoaderOnConfirm: true,
					}).then(function(result){
						if (result.value) {
							$.ajax({
								url: base_url + "invoice/import_invoice",
								type: 'post',
								data: data,
								dataType: 'json',
								beforeSend : function () {
									$('.loading').show();
								},
								success: function(data){
									$('.loading').hide();
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

			}
		});

});
});