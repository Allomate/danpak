$(document).ready(function(){
	
	fetchInventory(null);

	$(document).on('click', '[data-click=panel-reload-inventory]', function(e) {
		e.preventDefault();
		var target = $(this).closest('.panel');
		if (!$(target).hasClass('panel-loading')) {
			var targetBody = $(target).find('.panel-body');
			var spinnerHtml = '<div class="panel-loader"><span class="spinner-small"></span></div>';
			$(target).addClass('panel-loading');
			$(targetBody).prepend(spinnerHtml);
			if ($(this).attr('id') == "inventoryList") {
				fetchInventory(target);
			}else{
				$(target).removeClass('panel-loading');
				$(target).find('.panel-loader').remove();
			}
		}
	});
});

function fetchInventory(target){
	var ajaxData = { "location": "false" }
	ajaxer('getAllInventory.php', ajaxData, function(response){
		var data = JSON.parse(response);
		$('#inventoryTbody').empty();
		
		for (var i = 0; i < data.length; i++) {
 			$('#inventoryTbody').append('<tr><td>'+data[i]["barcode"]+'</td><td>'+data[i]["name"]+'</td><td>'+data[i]["color"]+'</td><td>'+data[i]["size"]+'</td><td>'+data[i]["quantity"]+'</td><td>'+data[i]["createdOn"]+'</td></tr>');
		}

		if (target) {
			$(target).removeClass('panel-loading');
			$(target).find('.panel-loader').remove();
		}

		$('#inventoryTable').DataTable();
	});
}

function ajaxer( url, data, handleData ){
	$.ajax({
		type: 'POST',
		url: 'ajax_scripts/' + url,
		data: data,
		success: function(response){
			handleData(response);
		}
	});
}