$( function () {

	reportTbl( $('#filterMonth').val(), $('#filterYear').val() );

	function reportTbl(filterMonth='', filterYear='') {

		$.ajax({
			url : base_url + 'report/find',
			type : 'POST',
			dataType : 'JSON',
			data : {
				'PeriodMonth' : filterMonth,
				'PeriodYear' : filterYear,
			},
			success : function (data) {
				if (data.type == 'done') {
					$('#btnExportCont').html('');
					$('#btnExportCont').append('<a class="btn btn-md btn-success" target="_blank" href="'+base_url+'report/report_pdf/'+filterYear+'/'+filterMonth+'">PDF</a>')
					$('#reportCont').html('');
					$('#reportCont').append('<tr><td>Manual Off Air Invoices</td><td>'+data.msg.manual_off_air.EntryByBilling[0].TOTAL+'</td><td>'+data.msg.manual_off_air.EntryByBilling[1]+'</td><td><a class="detailInv" data-details="not_send_to_ga" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="m1">'+data.msg.manual_off_air.SendToGA[0].TOTAL+'</a></td><td>'+data.msg.manual_off_air.SendToGA[1]+'</td><td><a class="detailInv" data-details="not_approve_by_ga" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="m1">'+data.msg.manual_off_air.ApproveByGA[0].TOTAL+'</a></td><td>'+data.msg.manual_off_air.ApproveByGA[1]+'</td><td><a class="detailInv" data-details="not_send_to_clients" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="m1">'+data.msg.manual_off_air.Delivery[0].TOTAL+'</a></td><td>'+data.msg.manual_off_air.Delivery[1]+'</td><td><a class="detailInv" data-details="not_received_by_clients" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="m1">'+data.msg.manual_off_air.Received[0].TOTAL+'</a></td><td>'+data.msg.manual_off_air.Received[1]+'</td><td>'+data.msg.manual_off_air.Returned[0].TOTAL+'</td><td>'+data.msg.manual_off_air.Returned[1]+'</td></tr>')
					$('#reportCont').append('<tr><td>Manual On Air Invoices</td><td>'+data.msg.manual_on_air.EntryByBilling[0].TOTAL+'</td><td>'+data.msg.manual_on_air.EntryByBilling[1]+'</td><td><a class="detailInv"  data-details="not_send_to_ga" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="m0">'+data.msg.manual_on_air.SendToGA[0].TOTAL+'</a></td><td>'+data.msg.manual_on_air.SendToGA[1]+'</td><td><a class="detailInv"  data-details="not_approve_by_ga" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="m0">'+data.msg.manual_on_air.ApproveByGA[0].TOTAL+'</a></td><td>'+data.msg.manual_on_air.ApproveByGA[1]+'</td><td><a class="detailInv" data-details="not_send_to_clients" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="m0">'+data.msg.manual_on_air.Delivery[0].TOTAL+'</a></td><td>'+data.msg.manual_on_air.Delivery[1]+'</td><td><a class="detailInv" data-details="not_received_by_clients" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="m0">'+data.msg.manual_on_air.Received[0].TOTAL+'</a></td><td>'+data.msg.manual_on_air.Received[1]+'</td><td>'+data.msg.manual_on_air.Returned[0].TOTAL+'</td><td>'+data.msg.manual_on_air.Returned[1]+'</td></tr>')
					$('#reportCont').append('<tr><td>BMS Invoices</td><td>'+data.msg.bms_invoice.EntryByBilling[0].TOTAL+'</td><td>'+data.msg.bms_invoice.EntryByBilling[1]+'</td><td><a class="detailInv"  data-details="not_send_to_ga" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="b">'+data.msg.bms_invoice.SendToGA[0].TOTAL+'</a></td><td>'+data.msg.bms_invoice.SendToGA[1]+'</td><td><a class="detailInv"  data-details="not_approve_by_ga" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="b">'+data.msg.bms_invoice.ApproveByGA[0].TOTAL+'</a></td><td>'+data.msg.bms_invoice.ApproveByGA[1]+'</td><td><a class="detailInv" data-details="not_send_to_clients" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="b">'+data.msg.bms_invoice.Delivery[0].TOTAL+'</a></td><td>'+data.msg.bms_invoice.Delivery[1]+'</td><td><a class="detailInv" data-details="not_received_by_clients" data-year="'+filterYear+'" data-month="'+filterMonth+'" data-type="b">'+data.msg.bms_invoice.Received[0].TOTAL+'</a></td><td>'+data.msg.bms_invoice.Received[1]+'</td><td>'+data.msg.bms_invoice.Returned[0].TOTAL+'</td><td>'+data.msg.bms_invoice.Returned[1]+'</td></tr>')
				}
			}
		});

		var t = $('#reportTbl').DataTable({
			'dom'		: 't',
			'ordering'	: false,
			'destroy'	: true,
		});
	}

	$('.btn-filter').on('click', function(event) {
		reportTbl( $('#filterMonth').val(), $('#filterYear').val() );
	});

	$('#reportTbl').on('click', '.detailInv', function(event) {
		event.preventDefault();

		var detailsInv = $(this).data('details');
		var InvType = $(this).data('type');
		var PeriodYear = $(this).data('year');
		var PeriodMonth = $(this).data('month');

		$.ajax({
			url : base_url + 'report/details_invoice',
			type : 'POST',
			dataType : 'JSON',
			data : { 'detailsInv' : detailsInv, 'InvType' : InvType, 'PeriodYear' : PeriodYear, 'PeriodMonth' : PeriodMonth },
			success : function (data) {
				if (data.type == 'done') {
					$('#detailTbl').DataTable().destroy()

					$('#detailTblBody').html('');
					for (var i = 0; i < data.msg.length; i++) {
						$('#detailTblBody').append('<tr><td>'+(i+1)+'</td><td>'+data.msg[i].InvNo+'</td><td>'+data.msg[i].PONo+'</td><td>'+data.msg[i].InvStsName+'</td></tr>');
					}

					$('#detailTbl').DataTable({
						'dom'		: 'Bflrtip',
						'ordering'	: false,
						'destroy'	: true,
						'buttons'	: [
						'excel'
						]
					});
					$('#titleLabel').text(data.title);
					$('#default-modal').modal('show');
				}else{
					Swal.fire('Failed!', data.msg, 'error');
				}
			}
		});
	});


});