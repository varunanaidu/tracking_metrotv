$(function () {
	$('#user').select2();

	$('#user').on('click', function() {
		alert('clicked');
	});

	$('#user').on('change', function () {

		var user = $(this).val();
		if ( user == "" ){
			$("#content-uac").html ( "" );
			return false;
		}

		var data = {"key" :user};
		$.ajax({
			url : base_url + "uac/setup",
			type : "POST",
			dataType : "JSON",
			data : data,
			beforeSend : function(){$("#content-uac").html ( "" );},
			success : function(data){
				if ( data.type === "done" ){
					$("#content-uac").html ( data.msg );
				}
				else{
					Swal.fire ( "Failed!", data.msg, "error" );
				}
			},
			error : function(){
				Swal.fire ( "Failed!", "Error occurred, Please refresh your browser.", "error" );
			}
		});
	});


	
	$("#default-form").ajaxForm({
		dataType: "json",
		url : base_url + 'uac/save',
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

	var t = $("#userTbl").DataTable({
		"processing" : true,
		"language": {
			"processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": base_url + "uac/view_list",
			"type": "POST"
		},
		"searchDelay" : 750,
		"columnDefs"	: [{
			"targets"	: [0],
			"orderable"	: false
		}]
	});
	
});