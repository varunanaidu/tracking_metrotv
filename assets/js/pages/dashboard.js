$( function () {
	var barChart;

	ajax_chart( $('#filterMonth').val(), $('#filterYear').val() );

	function ajax_chart(filterMonth='',filterYear='') {

		$.ajax({
			url : base_url + 'site/find',
			type : 'POST',
			dataType : 'JSON',
			data : {
				'PeriodMonth'	: filterMonth,
				'PeriodYear'	: filterYear,
			},
			success : function (resp) {

				if (resp.type == 'done') {

					var label_chart = [];
					var data_manual_off_air = [];
					var data_manual_on_air = [];
					var data_bms = [];

					for (var i = 0; i < resp.data.length; i++) {
						label_chart.push(resp.data[i].InvStsName);
						data_manual_off_air.push(resp.data[i].manual_off_air);
						data_manual_on_air.push(resp.data[i].manual_on_air);
						data_bms.push(resp.data[i].bms);
					}
					
					var areaChartData = {
						labels  : label_chart,
						datasets: [
						{
							label               : 'Manual Off Air Invoices',
							backgroundColor     : 'rgba(60,141,188,0.9)',
							borderColor         : 'rgba(60,141,188,0.8)',
							pointRadius          : false,
							pointColor          : '#3b8bba',
							pointStrokeColor    : 'rgba(60,141,188,1)',
							pointHighlightFill  : '#fff',
							pointHighlightStroke: 'rgba(60,141,188,1)',
							data                : data_manual_off_air,
						},
						{
							label               : 'Manual On Air Invoices',
							backgroundColor     : 'rgba(210, 214, 222, 1)',
							borderColor         : 'rgba(210, 214, 222, 1)',
							pointRadius          : false,
							pointColor          : '#3b8bba',
							pointStrokeColor    : 'rgba(60,141,188,1)',
							pointHighlightFill  : '#fff',
							pointHighlightStroke: 'rgba(60,141,188,1)',
							data                : data_manual_on_air,
						},
						{
							label               : 'BMS Invoices',
							backgroundColor     : 'rgba(115, 118, 122, 1)',
							borderColor         : 'rgba(115, 118, 122, 1)',
							pointRadius          : false,
							pointColor          : '#3b8bba',
							pointStrokeColor    : 'rgba(60,141,188,1)',
							pointHighlightFill  : '#fff',
							pointHighlightStroke: 'rgba(60,141,188,1)',
							data                : data_bms,
						}
						]
					}

					var areaChartOptions = {
						maintainAspectRatio : false,
						responsive : true,
						legend: {
							display: false
						},
						scales: {
							xAxes: [{
								gridLines : {
									display : false,
								}
							}],
							yAxes: [{
								gridLines : {
									display : false,
								}
							}]
						}
					}

					var barChartCanvas = $('#invChart').get(0).getContext('2d')
					var barChartData = jQuery.extend(true, {}, areaChartData)
					var temp0 = areaChartData.datasets[0]
					var temp1 = areaChartData.datasets[1]
					barChartData.datasets[0] = temp0

					var barChartOptions = {
						responsive              : true,
						maintainAspectRatio     : false,
						datasetFill             : false
					}

					barChart = new Chart(barChartCanvas, {
						type: 'bar', 
						data: barChartData,
						options: barChartOptions
					})

				}


			}
		})

	}

	$('.btn-filter').on('click', function(event) {
		event.preventDefault();
		barChart.destroy();
		
		ajax_chart( $('#filterMonth').val(), $('#filterYear').val() );
	});
	

});