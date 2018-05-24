$(document).ready(function(){
	
	var table = $('.table').DataTable();
	$('.dataTables_wrapper').hide();
	setTimeout(function(){
		$('select[name="DataTables_Table_0_length"]').css({
			'font-size' : '10pt',
			'margin' : '0px 10px 0px 10px'
		});
		$('select[name="DataTables_Table_0_length"]').prepend('<option value="5">5</option>');
		$('select[name="DataTables_Table_0_length"]').parent().parent().parent().parent().width('100%');
		$('select[name="DataTables_Table_0_length"]').parent().parent().css('float', 'left');
		$('.dataTables_filter').css('float', 'right');
		$('#DataTables_Table_0_wrapper').find('.row:eq(1)').width('100%');
		$('.dataTables_paginate').parent().parent().width('100%');
		$('#loaderImg').hide();
		$('.table').fadeIn();
		$('.dataTables_wrapper').fadeIn();
	}, 300);

	var catalogueDetails = [];
	var	indexStorage = [];

	$('#')

	// $('.date').datepicker({
	// 	format: "yyyy-mm-dd",
	// 	startDate: '+0d'
	// });

});