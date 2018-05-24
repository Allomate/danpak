$(document).ready(function(){

	getAllRequests(null);

	$(document).on('click', '#clearAllRequestsRecords', function(e) {
		if(window.confirm("Are you sure?")){
			$('.clearAllRequestsSpinner').fadeIn();
			$('#clearAllRequestsText').hide();
			$('#clearAllRequestsRecords').removeClass('btn-danger');
			$('button').attr('disabled', true);
			var ajaxData = { records: "all" };
			ajaxer('removeRequestsHistory.php', ajaxData, function(response){
				if (response == "Deleted") {
					$('#clearAllRequestsText').text("Cleared");
					$('.clearAllRequestsSpinner').hide();
					$('#clearAllRequestsText').fadeIn();
					$('#clearAllRequestsRecords').addClass('btn-success');
					setTimeout(function(){
						$('#clearAllRequestsText').text("Clear All");
						$('#clearAllRequestsRecords').removeClass('btn-success');
						$('#clearAllRequestsRecords').addClass('btn-danger');
					}, 2000);
					getAllRequests(null);
				}else{
					$('#clearAllRequestsRecords').addClass('btn-danger');
					swal('Failed', 'Unable to clear records', 'error');
				}
				$('button').attr('disabled', false);
				return;
			});
		}
	});

	$(document).on('click', '#clearFilteredRequests', function(e) {
		if(window.confirm("Are you sure?")){
			$('.clearFilteredSpinner').fadeIn();
			$('#clearFilteredText').hide();
			$('#clearFilteredRequests').removeClass('btn-warning');
			$('button').attr('disabled', true);
			var ajaxData = { records: $('#filteredRecords').val() };
			ajaxer('removeRequestsHistory.php', ajaxData, function(response){
				if (response == "Deleted") {
					$('#clearFilteredText').text("Cleared");
					$('.clearFilteredSpinner').hide();
					$('#clearFilteredText').fadeIn();
					$('#clearFilteredRequests').addClass('btn-success');
					setTimeout(function(){
						$('#clearFilteredText').text("Clear Filtered");
						$('#clearFilteredRequests').removeClass('btn-success');
						$('#clearFilteredRequests').addClass('btn-warning');
					}, 2000);
					getAllRequests(null);
				}else{
					$('#clearFilteredRequests').addClass('btn-warning');
					swal('Failed', 'Unable to clear records', 'error');
				}
				$('button').attr('disabled', false);
				return;
			});
		}
	});

	$(document).on('click', '.sentInventoryBtnTd', function(e) {

		var quantityRequired = $(this).parent().find('td#quantityReq').text();
		var warehosueStock = $(this).parent().find('td#warehouseStock').text();

		if (quantityRequired > warehosueStock) {
			swal('Out of stock', 'Sorry but this item is not present in this quantity at the warehouse', 'error');
			return;
		}

		if(window.confirm("Are you sure?")){
			var targetBtnComponent = $(this).parent().find('#requestSentFromWarehouseButton');
			targetBtnComponent.find('.requestSentSpinner').fadeIn();
			targetBtnComponent.find('#requestSentText').hide();
			targetBtnComponent.removeClass('btn-info');
			$('button').attr('disabled', true);

			var ajaxData = { barcode: $(this).parent().find('#barcodeTd').text() };

			ajaxer('requestSentBack.php', ajaxData, function(response){
				if (response == "Success") {
					targetBtnComponent.addClass('btn-warning');
					targetBtnComponent.find('.requestSentSpinner').hide();
					targetBtnComponent.find('#requestSentText').text('Sent');
					targetBtnComponent.find('#requestSentText').fadeIn();
					setTimeout(function(){
						targetBtnComponent.find('#requestSentText').text('Send Item');
						targetBtnComponent.removeClass('btn-warning');
						targetBtnComponent.addClass('btn-info');
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

	$(document).on('click', '[data-click=panel-reload-inventory]', function(e) {
		e.preventDefault();
		var target = $(this).closest('.panel');
		if (!$(target).hasClass('panel-loading')) {
			var targetBody = $(target).find('.panel-body');
			var spinnerHtml = '<div class="panel-loader"><span class="spinner-small"></span></div>';
			$(target).addClass('panel-loading');
			$(targetBody).prepend(spinnerHtml);
			getAllRequests(target);
		}
	});
});

function getAllRequests(target){
	ajaxer('getInventoryRequests.php', null, function(response){
		var data = JSON.parse(response);
		$('#inventoryTbody').empty();
		for (var i = 0; i < data.length; i++) {
			if (data[i]["recieved"] == "0")
				data[i]["recieved"] = "No";
			else
				data[i]["recieved"] = "Yes";
			
			if (data[i]["sent"] == "0"){
				data[i]["sent"] = "No";
				$('#inventoryTbody').append('<tr><td id="barcodeTd">'+data[i]["barcode"]+'</td><td>'+data[i]["name"]+'</td><td>'+data[i]["color"]+'</td><td>'+data[i]["size"]+'</td><td id="quantityReq">'+data[i]["quantity"]+'</td><td>'+data[i]["franchise"]+'</td><td>'+data[i]["createdOn"] + ' ' + data[i]["time"] +'</td><td>'+data[i]["sent"]+'</td><td>'+data[i]["recieved"]+'</td><td id="warehouseStock">'+data[i]["warehouseStock"]+'</td><td class="sentInventoryBtnTd"><button type="button" id="requestSentFromWarehouseButton" class="btn btn-info"><img src="assets/raw/view-details-loader.gif" class="requestSentSpinner" style="height: 15px;"><span id="requestSentText">Send Item</span></button></td></tr>');
			}
			else{
				data[i]["sent"] = "Yes";
				$('#inventoryTbody').append('<tr><td id="barcodeTd">'+data[i]["barcode"]+'</td><td>'+data[i]["name"]+'</td><td>'+data[i]["color"]+'</td><td>'+data[i]["size"]+'</td><td>'+data[i]["quantity"]+'</td><td>'+data[i]["franchise"]+'</td><td>'+data[i]["createdOn"] + ' ' + data[i]["time"] +'</td><td>'+data[i]["sent"]+'</td><td>'+data[i]["recieved"]+'</td><td>'+data[i]["warehouseStock"]+'</td><td class="sentInventorySpanTd"><span style="text-align: center; font-weight: bold">No action needed</span></td></tr>');
			}
		}
		if (target) {
			$(target).removeClass('panel-loading');
			$(target).find('.panel-loader').remove();
		}
		$('#inventoryRequestsTable').DataTable();
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