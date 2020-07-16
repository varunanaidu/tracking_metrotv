$(function () {
	
	var t = $('#returnedTbl').DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "returned/view_returned",
			"type": "POST",
		},
		"lengthMenu"	: [[50, 100, 150, -1], [50, 100, 150, "All"]],
		"pageLength"	: 100,
		"select"		: {'style' : 'multi'},
		"columnDefs" : [{
			"targets"	: [0],
			"visible" : false,
			"className" : "dt-center",
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
		"searchDelay" : 750,
	});

	t.on('click', '.btn-detail', function() {
		var row_id = $(this).data('id');

		$.ajax({
			url: base_url + "returned/find",
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
});