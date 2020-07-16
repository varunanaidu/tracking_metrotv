$(function () {

	$('#find-form').on('submit', function(e) {
		e.preventDefault();

		if( !$('#inputInvoice').val() ){
			alert('Masukan keyword yang ingin dicari');
			return;
		};

		var data = $('#find-form').serialize();

		$.ajax({
			url : base_url + 'find/get_inv',
			type : 'POST',
			dataType : 'JSON',
			data : data,
			beforeSend : function () {
			$('#childContainer').css('display', 'none');	
			},
			success : function (data) {
				if (data.type == 'done' ) {
					$('#containerBox').removeAttr('style');
					$('#invTbl_cont').css({
						height: '300',
						overflow: 'scroll'
					});
					$('#invTbl').html('<div class="rowa headera"><div class="cella">Invoice (Click below to see details)</div></div>');
					for (var i = 0; i < data.msg.length; i++) {
						$('#invTbl').append('<div class="rowa" data-id="'+data.msg[i].InvID+'" ><div class="cella" data-title="Invoice" >'+data.msg[i].InvNo+'</div></div>')
					}
				}else{
					Swal.fire({
						title:'Failed!',
						type : 'error',
						html:data.msg
					});
				}
			}
		});
	});

	$('#invTbl').on('click', '.rowa', function(event) {
		var InvID = $(this).data('id');

		var data = {'inputInvoice' : InvID};

		$.ajax({
			url : base_url + 'find/search',
			type : 'POST',
			dataType : 'JSON',
			data : data,
			success : function (data) {
				if (data.type == 'done') {
					$('#childContainer').removeAttr('style');
					$('#detail_body').html('');
					$('#detail_body').append('<div class="cella" data-title="Invoice No">'+data.msg_2[0].InvNo+'</div><div class="cella" data-title="PO No">'+data.msg_2[0].PONo+'</div><div class="cella" data-title="Agency">'+data.msg_2[0].AgencyName+'</div><div class="cella" data-title="Advertiser">'+data.msg_2[0].AdvertiserName+'</div><div class="cella" data-title="AE">'+data.msg_2[0].AE_Name+'</div><div class="cella" data-title="Status Pengiriman">'+data.msg_2[0].InvStsName+'</div>')
					
					$('#resTbl').html('<div class="rowa headera"><div class="cella">Tanggal</div><div class="cella">Status</div><div class="cella">Keterangan</div></div>');
					for (var i = 0; i < data.msg.length; i++) {
						var keterangan;
						switch( data.msg[i].InvStsCode ){
							case '3A':
							keterangan = data.msg[i].ResiNoFromCourier;
							break;
							case '3B':
							keterangan = data.msg[i].ResiNoFromCourier;
							break;
							case '4A':
							keterangan = '<a style="color:black !important;" target="_blank" href="'+base_url+'assets/images/invoices/'+data.msg[i].ReceiptPathFilename+'">'+data.msg[i].ReceiptPathFilename+'</a>' ;
							break;
							case '5':
							keterangan = data.msg[i].ReasonReturned;
							break;
							default:
							keterangan = '';
						}
						$('#resTbl').append('<div class="rowa"><div class="cella" data-title="Tanggal">'+moment(data.msg[i].EntryBy_date).format('MM/DD/YYYY HH:mm:ss')+'</div><div class="cella" data-title="Status">'+data.msg[i].InvStsName+'</div><div class="cella" data-title="Keterangan">'+keterangan+'</div></div>')
					}
				}else{
					Swal.fire({
						title:'Failed!',
						type : 'error',
						html:data.msg
					});
				}
			}
		});
	});

	$('#backBtn').on('click', function() {
		window.location.href = base_url;
	});

	$('#signOutBtn').on('click', function() {
		window.location.href = base_url + 'site/signout';
	});
	
});