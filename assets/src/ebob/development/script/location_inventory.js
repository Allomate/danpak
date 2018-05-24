$(document).ready(function(){
	$('#pendingInventoryTable').DataTable();
	$('#inventoryTable').DataTable();
	$('#requestToLocationInventoryTable').DataTable();
	$('#pendingInventoryTable_filter').parent().css('text-align', 'right');
	$('#pendingInventoryTable_filter').css('display', 'inline-block');
	$('#pendingInventoryTable_filter').parent().append('<button class="btn btn-success" style="margin-left: 22px" id="acceptAllInventoryBtn"><img src="assets/raw/view-details-loader.gif" class="acceptAllSpinner"><span id="acceptAllText">Accept All</span></button>');
	fetchAcquiredInventory(null);
	fetchPendingInventory(null);
	fetchLocationInventoryRequests(null);

	$(document).on('click', '.deleteInventButton', function(e) {
		var ajaxData = {'id': $(this).attr('id')};
		swal({
			title: 'Are you sure?',
			showCancelButton: true,
			confirmButtonText: 'Yes',
			showLoaderOnConfirm: true,
			preConfirm: function () {
				return new Promise(function (resolve, reject) {
					ajaxer('deleteThisLocationInventItem.php', ajaxData, function(response){
						if (response == "Deleted") {
							swal('Deleted', 'Product has been successfully deleted', 'success');
							fetchAcquiredInventory(null);
						}else{
							swal('Failed', 'Unable to delete this product at the moment', 'error');
						}
						return;
					});
				})
			},
			allowOutsideClick: false
		})
	});
	
	$(document).on('click', '#requestSentFromLocationButton', function(e) {
		var col = $(this).parent().parent().children().index($(this).parent());
		var row = $(this).parent().parent().parent().children().index($(this).parent().parent());

		var quantityRequired = $('#requestToLocationInventoryTable tbody tr:eq('+row+') td:eq(4)').text();
		var locationStock = $('#requestToLocationInventoryTable tbody tr:eq('+row+') td:eq(10)').text();

		if (quantityRequired > locationStock) {
			swal('Out of stock', 'Sorry but this item is not present in this quantity at the location', 'error');
			return;
		}

		if(window.confirm("Are you sure na?")){
			var targetBtnComponent = $(this).parent().find('#requestSentFromLocationButton');
			var targetBtnComponent = $(this).parent().find('#requestSentFromLocationButton');
			var targetTdComponent = $(this).parent();
			targetBtnComponent.find('.requestSentSpinner').fadeIn();
			targetBtnComponent.find('#requestSentText').hide();
			targetBtnComponent.removeClass('btn-info');
			$('button').attr('disabled', true);

			var ajaxData = {
				"barcode": $('#requestToLocationInventoryTable tbody tr:eq('+row+') td:eq(0)').text(),
				"requested_from_franchise": $('#requestToLocationInventoryTable tbody tr:eq('+row+') td:eq(6)').text()
			}

			ajaxer('requestSentBackFromLocationToLocation.php', ajaxData, function(response){
				if (response == "Success") {
					targetBtnComponent.addClass('btn-warning');
					targetBtnComponent.find('.requestSentSpinner').hide();
					targetBtnComponent.find('#requestSentText').text('Sent');
					targetBtnComponent.find('#requestSentText').fadeIn();

					setTimeout(function(){
						targetTdComponent.empty();
						targetTdComponent.append('<span style="text-align: center; font-weight: bold">No action needed</span>');
						$('button').attr('disabled', false);
						getAllRequests(null);
					}, 3000);
				}else if (response == "Already-Updated") {
					targetBtnComponent.addClass('btn-danger');
					targetBtnComponent.find('.requestSentSpinner').hide();
					targetBtnComponent.find('#requestSentText').text('Failed');
					targetBtnComponent.find('#requestSentText').fadeIn();
					setTimeout(function(){
						targetBtnComponent.find('#requestSentText').text('Send Item');
						targetBtnComponent.removeClass('btn-danger');
						targetBtnComponent.addClass('btn-info');
						$('button').attr('disabled', false);
					}, 3000);
					swal('Failed', 'Item is already sent. Unable to send again', 'warning');
				}else{
					targetBtnComponent.addClass('btn-danger');
					targetBtnComponent.find('.requestSentSpinner').hide();
					targetBtnComponent.find('#requestSentText').text('Failed');
					targetBtnComponent.find('#requestSentText').fadeIn();
					setTimeout(function(){
						targetBtnComponent.find('#requestSentText').text('Send Item');
						targetBtnComponent.removeClass('btn-danger');
						targetBtnComponent.addClass('btn-info');
						$('button').attr('disabled', false);
					}, 3000);
					swal('Failed', 'Something went wrong while updating the request', 'error');
				}
			});
		}
		return;
	});

	$(document).on('click', '.reqInventButton', function(e) {
		var col = $(this).parent().parent().children().index($(this).parent());
		var row = $(this).parent().parent().parent().children().index($(this).parent().parent());

		$('#inventoryTable tbody tr:eq(' + row + ') td:eq(' + col + ') .requestInventSpinner').fadeIn();
		$('#inventoryTable tbody tr:eq(' + row + ') td:eq(' + col + ') #reqInventText').hide();
		$('#inventoryTable tbody tr:eq(' + row + ') td:eq(' + col + ') .reqInventButton').attr('disabled', true);

		var ajaxData = {
			"id": $(this).attr('id')
		}

		ajaxer('getItemData-locationData.php', ajaxData, function(response){
			var response = JSON.parse(response);
			$('#itemName').text(response.name);
			$('#itemBrand').text(response.brand);
			$('#itemSize').text(response.size);
			$('#itemColor').text(response.color);
			$('#itemQuantity').text(response.quantity);
			$('#itemPurchase').text(response.purchased);
			$('#itemSell').text(response.sale);
			$('#itemExp').text(response.expiry);
			$('#itemBarcode').text(response.barcode);
			$('#inventoryTable tbody tr:eq(' + row + ') td:eq(' + col + ') .requestInventSpinner').hide();
			$('#inventoryTable tbody tr:eq(' + row + ') td:eq(' + col + ') #reqInventText').fadeIn();
			$('#inventoryTable tbody tr:eq(' + row + ') td:eq(' + col + ') .reqInventButton').removeAttr('disabled');			
			$('#requestInventModal').modal('show');
			$('.modal-title').text($('#inventoryTable tbody tr:eq('+row+') td:eq(0)').text());
		});
	});

	$(document).on('click', '#acceptAllInventoryBtn', function(e) {
		var rowCount = $('#pendingInventoryTbody tr').length;
		$('.acceptAllSpinner').fadeIn();
		$('#acceptAllText').hide();
		$('#acceptAllInventoryBtn').removeClass('btn btn-success');
		$('button').attr('disabled', true);

		var barcodes = [];
		for (var i = 0; i < rowCount; i++) {
			if ($('#pendingInventoryTable tbody tr:eq('+i+') td:eq(0)').text() != "No data available in table") {
				barcodes.push($('#pendingInventoryTable tbody tr:eq('+i+') td:eq(0)').text());
			}
		}

		$('button').attr('disabled', true);
		var ajaxData = {
			"barcode": barcodes.join(",")
		}

		ajaxer('acceptInventory.php', ajaxData, function(response){
			$('button').attr('disabled', false);
			$('.acceptAllSpinner').hide();
			$('#acceptAllText').fadeIn();
			$('#acceptAllInventoryBtn').addClass('btn btn-success');
			if (JSON.parse(response).length == 0) {
				$('#pendingInventoryTable tbody tr').remove();
				fetchAcquiredInventory(null);
			}else{
				swal('Failed', 'Unable to accept this item', 'error');
			}
		});
	});

	$(document).on('click', '.acceptInventoryButton', function(e) {
		var col = $(this).parent().parent().children().index($(this).parent());
		var row = $(this).parent().parent().parent().children().index($(this).parent().parent());

		$('#pendingInventoryTable tbody tr:eq(' + row + ') td:eq(' + col + ') .acceptInventorySpinner').fadeIn();
		$('#pendingInventoryTable tbody tr:eq(' + row + ') td:eq(' + col + ') #acceptInventoryText').hide();
		$('#pendingInventoryTable tbody tr:eq(' + row + ') td:eq(' + col + ') .acceptInventoryButton').attr('disabled', true);
		$('button').attr('disabled', true);

		var ajaxData = {
			"barcode": $('#pendingInventoryTable tbody tr:eq('+row+') td:eq(0)').text()
		}

		ajaxer('acceptInventory.php', ajaxData, function(response){
			if (JSON.parse(response).length == 0) {
				$('button').attr('disabled', false);
				$('#pendingInventoryTable tbody tr:eq('+row+')').fadeOut();
				fetchAcquiredInventory(null);
			}else{
				swal('Failed', 'Dispatch has been failed due to some reason', 'error');
			}
		});
	});

	$('input[name=showFranchise]').click(function(){
		if ($('input[name=showFranchise]').prop('checked')) {
			$('#franchiseId').removeAttr('disabled');
			$('#franchiseLabel').css('color', 'black')
		}else{
			$('#franchiseId').attr('disabled', true);
			$('#franchiseLabel').css('color', 'gray')
		}
	});

	$('#requestForInventory').click(function(){

		var ajaxUrl = null;
		var ajaxData = null;
		if($("input[name=showFranchise]").is(':checked')){
			ajaxUrl = 'createRequestForInventoryLocation.php';
			ajaxData = {
				'barcode': $('.modal-title').text(), 
				'required': $('#reqQuantityInput').val(), 
				'color': $('#itemColor').text(), 
				'size': $('#itemSize').text(), 
				'name': $('#itemName').text(), 
				'toFranchise': $('#franchiseId').val()
			};
		}else{
			ajaxUrl = 'createRequestForInventory.php';
			ajaxData = {
				'barcode': $('.modal-title').text(), 
				'required': $('#reqQuantityInput').val(), 
				'color': $('#itemColor').text(), 
				'size': $('#itemSize').text(), 
				'name': $('#itemName').text()
			};
		}

		if ($('#reqQuantityInput').val() == '' || $('#reqQuantityInput').val() < '0') {
			alert('Please enter valid quantity to request');
			return;
		}
		$('#reqBtnText').hide();
		$('.requestSpinner').fadeIn();
		$(this).attr('disabled', true);
		$('.closeModal').hide();

		ajaxer(ajaxUrl, ajaxData, function(response){
			if (response == "Success") {
				$('#reqBtnText').fadeIn();
				$('.requestSpinner').hide();
				$('#requestForInventory').removeClass('btn btn-info');
				$('#requestForInventory').addClass('btn btn-success');
				$('#reqBtnText').text('Request Sent');
				setTimeout(function(){
					$('#requestInventModal').modal('hide');
					setTimeout(function(){
						location.reload();
					},200);
				},1000);
			}else{
				document.write(response);
			}
		});
	});

	$(document).on('click', '[data-click=panel-reload-inventory]', function(e) {
		e.preventDefault();
		var target = $(this).closest('.panel');
		if (!$(target).hasClass('panel-loading')) {
			var targetBody = $(target).find('.panel-body');
			var spinnerHtml = '<div class="panel-loader"><span class="spinner-small"></span></div>';
			$(target).addClass('panel-loading');
			$(targetBody).prepend(spinnerHtml);
			if ($(this).attr('id') == "locationInventory") {
				fetchAcquiredInventory(target);
			}else if($(this).attr('id') == "requestInventToLocation"){
				fetchLocationInventoryRequests(target);
			}else{
				fetchPendingInventory(target);
			}
		}
	});
});

function fetchAcquiredInventory(target){
	var ajaxData = { "location": "true" };
	ajaxer('getAllInventory.php', ajaxData, function(response){
		var data = JSON.parse(response);
		$("#inventoryTable").find('tbody').empty();
		for (var i = 0; i < data.length; i++) {
			$('#inventoryTbody').append('<tr><td>'+data[i]["barcode"]+'</td><td>'+data[i]["name"]+'</td><td>'+data[i]["color"]+'</td><td>'+data[i]["size"]+'</td><td>'+data[i]["quantity"]+'</td><td>'+data[i]["createdOn"]+'</td><td id="requestInventTd"><button class="btn btn-info reqInventButton" id="'+data[i]["id"]+'" style="font-size: 12px;"><img src="assets/raw/view-details-loader.gif" class="requestInventSpinner"><span id="reqInventText">Request Inventory</span></button>&nbsp;&nbsp;&nbsp; <button class="btn btn-danger deleteInventButton" id="'+data[i]["id"]+'" style="font-size: 12px;"><img src="assets/raw/view-details-loader.gif" class="deleteInventSpinner"><span id="deleteInventText">DELETE</span></button></td></tr>');
		}
		if (target) {
			$(target).removeClass('panel-loading');
			$(target).find('.panel-loader').remove();
		}
	});
}

function fetchLocationInventoryRequests(target){
	var ajaxData = null;
	ajaxer('getLocationInventoryRequests.php', ajaxData, function(response){
		var data = JSON.parse(response);
		$("#requestToLocationInventoryTable").find('tbody').empty();
		for (var i = 0; i < data.length; i++) {
			if (data[i]["recieved"] == "0")
				data[i]["recieved"] = "No";
			else
				data[i]["recieved"] = "Yes";
			
			if (data[i]["sent"] == "0"){
				data[i]["sent"] = "No";
				$('#requestToLocationInventoryTable').append('<tr><td id="barcodeTd">'+data[i]["barcode"]+'</td><td>'+data[i]["name"]+'</td><td>'+data[i]["color"]+'</td><td>'+data[i]["size"]+'</td><td id="quantityReq">'+data[i]["quantity"]+'</td><td>'+data[i]["to_franchise"]+'</td><td>'+data[i]["from_franchise"]+'</td><td>'+data[i]["createdOn"] + ' ' + data[i]["time"] +'</td><td>'+data[i]["sent"]+'</td><td>'+data[i]["recieved"]+'</td><td id="warehouseStock">'+data[i]["warehouseStock"]+'</td><td class="sentInventoryBtnTd"><button type="button" id="requestSentFromLocationButton" class="btn btn-info"><img src="assets/raw/view-details-loader.gif" class="requestSentSpinner" style="height: 15px;"><span id="requestSentText">Send Item</span></button></td></tr>');
			}
			else{
				data[i]["sent"] = "Yes";
				$('#requestToLocationInventoryTable').append('<tr><td id="barcodeTd">'+data[i]["barcode"]+'</td><td>'+data[i]["name"]+'</td><td>'+data[i]["color"]+'</td><td>'+data[i]["size"]+'</td><td>'+data[i]["quantity"]+'</td><td>'+data[i]["to_franchise"]+'</td><td>'+data[i]["from_franchise"]+'</td><td>'+data[i]["createdOn"] + ' ' + data[i]["time"] +'</td><td>'+data[i]["sent"]+'</td><td>'+data[i]["recieved"]+'</td><td>'+data[i]["warehouseStock"]+'</td><td class="sentInventorySpanTd"><span style="text-align: center; font-weight: bold">No action needed</span></td></tr>');
			}
		}

		if (target) {
			$(target).removeClass('panel-loading');
			$(target).find('.panel-loader').remove();
		}
	});
}

function fetchPendingInventory(target){
	var ajaxData = { "location": "true" };
	ajaxer('getPendingInventory.php', ajaxData, function(response){
		var data = JSON.parse(response);
		$("#pendingInventoryTable").find('tbody').empty();
		for (var i = 0; i < data.length; i++) {
			$('#pendingInventoryTbody').append('<tr><td>'+data[i]["barcode"]+'</td><td>'+data[i]["name"]+'</td><td>'+data[i]["color"]+'</td><td>'+data[i]["size"]+'</td><td>'+data[i]["quantity"]+'</td><td>'+data[i]["createdOn"]+'</td><td id="acceptInventTd"><button class="btn btn-info acceptInventoryButton" id="'+data[i]["id"]+'" style="font-size: 12px;"><img src="assets/raw/view-details-loader.gif" class="acceptInventorySpinner"><span id="acceptInventoryText">Accept Inventory</span></button></td></tr>');
		}

		if (target) {
			$(target).removeClass('panel-loading');
			$(target).find('.panel-loader').remove();
		}
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