$(document).ready(function(){
	
	window.onbeforeunload = function() {
		return "Data will be lost if you leave the page, are you sure?";
	};

	fetchInventory(null);

	$(document).on('click', '#removeInventAdded', function(e) {
		var row = ($(this).parent().parent().parent().children().index($(this).parent().parent()));
		$('#addedInventoryTable tr:eq('+row+')').remove();
		$('#totalInventAdded').text($('#addedInventoryTable tr').length);
		if ($('#addedInventoryTable tr').length <= 0) {
			$('#addedInventoryTable').append('<h5 id="emptyInventoryTitle">No items added to the inventory</h5>');
		}
	});

	$('#dispatchItemsButton').click(function(){
		$("button").attr("disabled", true);
		if ($('#addedInventoryTable tr').length <= 0) {
			alert('Please add items to inventory first');
			$("button").attr("disabled", false);
			return;
		}

		$('#dispatchItemsText').hide();
		$('.dispatchItemsSpinner').fadeIn();
		$('button').attr('disabled', true);
		var barcodes = "";
		var quantities = "";

		$("#addedInventoryTable tr").each(function(){
			if(barcodes != ""){
				barcodes += "," + $(this).find("td:first").text();
				quantities += "," + $(this).find("td:eq(2)").text();
			}
			else{
				barcodes = $(this).find("td:first").text();
				quantities = $(this).find("td:eq(2)").text();
			}
		});

		var ajaxData = { "barcode": barcodes, "quantity": quantities, "franchise": $('#franchises').val() };
		ajaxer( 'dispatch_inventory.php', ajaxData, function(response){
			$('button').attr('disabled', false);
			if (response != "One more 	violation and your liscene will be cancelled") {
				if (JSON.parse(response).length == 0) {
					swal('Dispatched', 'All the items provided have been dispatched', 'success');
					$('#addedInventoryTable tr').remove();
					$('#addedInventoryTable').append('<h5 id="emptyInventoryTitle">No items added to the inventory</h5>');
					fetchInventory(null);
				}else{
					swal('Failed', 'Dispatch has been failed due to some reason', 'error');
				}
			}else{
				swal('Failed', 'One more violation and your liscene will be cancelled', 'error');
			}
			$('#dispatchItemsText').fadeIn();
			$('.dispatchItemsSpinner').hide();
			$("button").attr("disabled", false);
			return;
		});
	});

	$(document).on('click', '.addInventoryBtn', function(e) {
		var row = ($(this).parent().parent().parent().children().index($(this).parent().parent()) + 1);
		
		var barcode = $('#inventoryTable tr:eq('+row+') td:eq(0)').text();
		var item = $('#inventoryTable tr:eq('+row+') td:eq(1)').text();
		var quantity = parseInt($('#inventoryTable tr:eq('+row+') td:eq(5) input').val());
		var totalItemQuantity = parseInt($('#inventoryTable tr:eq('+row+') td:eq(4)').text());
		var id = $(this).attr('id');

		if (!quantity || quantity == '' || quantity <= 0) {
			alert('Please enter valid quantity');
			return;
		}

		$('#inventoryTable tr:eq('+row+') td:eq(5) input').val('');
		if (quantity > totalItemQuantity) {
			alert('You don\'t have enough quantity');
			return;
		}

		if ( $('#tempInventTr-'+id).length){

			var existingQuant = parseInt($('#tempInventTr-'+id).find('#tempInventQuantity').text());
			
			if (existingQuant+quantity > totalItemQuantity) {
				alert('You don\'t have enough quantity');
				return;a
			}

			$('#tempInventTr-'+id).find('#tempInventQuantity').text((existingQuant + quantity));
			return;
		}

		if ($('#emptyInventoryTitle').length) {
			$('#emptyInventoryTitle').remove();
		}
		$('#addedInventoryTable').append('<tr id="tempInventTr-'+id+'"><td>'+barcode+'</td><td>'+item+'</td><td id="tempInventQuantity">'+quantity+'</td><td><img src="assets/raw/remove-bin.png" id="removeInventAdded" style="width: auto; height: 20px; cursor: pointer;"></td></tr>');

		$('#totalInventAdded').text($('#addedInventoryTable tr').length);
	});

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
	var ajaxData = { "location" : "false" }
	ajaxer('getAllInventory.php', ajaxData, function(response){
		var data = JSON.parse(response);
		$('#inventoryTbody').empty();
		for (var i = 0; i < data.length; i++) {
			$('#inventoryTbody').append('<tr><td>'+data[i]["barcode"]+'</td><td>'+data[i]["name"]+'</td><td>'+data[i]["color"]+'</td><td>'+data[i]["size"]+'</td><td>'+data[i]["quantity"]+'</td><td style="width: 200px;"><input class="form-control" type="number" style="width: 50%;" min="1"/></td><td class="addBtnTd"><button class="btn btn-info addInventoryBtn" id="'+data[i]["id"]+'" style="font-size: 12px;"><span id="addInventoryText">Add</span></button></td></tr>');
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