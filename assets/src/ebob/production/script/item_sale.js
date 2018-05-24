$(document).ready(function(){

	var target = $('.itemDetailsPanel');
	var targetSale = $('.itemSalePanel');
	var totalItemsInReceipt = [];
	var itemId = 0;
	var itemNameForReceipt = '';
	var stockQuantity = 0;
	var itemDiscount = 0;
	var saleIdForViewModal = 0;
	var itemsExcluder = false;

	$('#itemBarcodeFetch').val("11223410");

	$('#addItemsForm').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) { 
			e.preventDefault();
			return false;
		}
	});

	$('#newCustomerModalButton').click(function(){
		if ($('#customerName').val() == "" || $('#customerPhone').val() == "" || 
			$("input[name='gender']:checked").val() == "" || $("input[name='gender']:checked").val() == undefined) {
			swal('Missing Details', 'Please fill all the details marked with *', 'warning');
		return;
	}

	$('#newCustomerModalButton').removeClass('btn-success');
	$('.newCustomerModalSpinner').fadeIn();
	$('#newCustomerModalText').hide();
	$('button').attr('disabled', true);
	$('input').attr('disabled', true);

	var ajaxData = {
		customerName: $('#customerName').val(),
		customerPhone: $('#customerPhone').val(),
		customerGender: $("input[name='gender']:checked").val(),
		customerEmail: $('#customerEmail').val()
	};

	ajaxer('nonRegisteredCustomerDetailsOnSale.php', ajaxData, function(response){
		var response = JSON.parse(response);
		if (response.status == "Success") {
			swal('Successfully Registered', 'This phone number is successfully registered to ' + $('#customerName').val(), 'success');
			$('#customerName').val('');
			$('#customerPhone').val('');
			$('#customerEmail').val('');
			$("input[name='gender']:checked").val('Male');
			$('#myModal').modal('hide');
		}else if(response.status == "Exist"){
			swal('Already Registered', 'This phone number is already registered to ' + response.name, 'warning');
		}else{
			document.write(response);
			swal('Failed', 'Unable to register customer at the moment', 'error');
		}
		$('#newCustomerModalButton').addClass('btn-success');
		$('.newCustomerModalSpinner').hide();
		$('#newCustomerModalText').fadeIn();
		$('button').attr('disabled', false);
		$('input').attr('disabled', false);
		return;
	});
});

	$('#addNewBtn').click(function(){
		$('#myModal').modal('show');
	});

	$("#quantitySold").on('keyup', function (e) {
		if (e.keyCode == 13) {

			$("#quantitySold").blur();

			if ($('#quantitySold').val() == '') {
				swal('Missing Information', 'Please provide the quantity', 'warning');
				return;
			}

			if ($('#quantitySold').val() > stockQuantity){
				swal('Out of stock', 'Quantity is more than we have in stock', 'warning');
				return;
			}

			if(getIndexByAttribute(totalItemsInReceipt, "id", itemId) < 0 || 
				getIndexByAttribute(totalItemsInReceipt, "id", itemId) != null){
				var originQuant = parseInt(totalItemsInReceipt[getIndexByAttribute(totalItemsInReceipt, "id", itemId)]["quantitySold"]);
			var newQuant = parseInt($(this).val());
			if ((originQuant + newQuant) > stockQuantity) {
				swal('Out of stock', 'We do not have enough items in stock', 'error');
				return;
			}
			totalItemsInReceipt[getIndexByAttribute(totalItemsInReceipt, "id", itemId)]["quantitySold"] = originQuant + newQuant;
			totalItemsInReceipt[getIndexByAttribute(totalItemsInReceipt, "id", itemId)]["finalPrice"] = parseInt(totalItemsInReceipt[getIndexByAttribute(totalItemsInReceipt, "id", itemId)]["quantitySold"])*parseInt(totalItemsInReceipt[getIndexByAttribute(totalItemsInReceipt, "id", itemId)]["itemSell"]);
		}else{
			debugger;
			var itemPriceSold = $('#itemSell').text().split(" ");
			var itemDiscountDetail = itemPriceSold[2];
			totalItemsInReceipt.push({
				id: itemId,
				barcode: $('#itemBarcode').text(),
				quantitySold: $(this).val(),
				itemName: itemNameForReceipt,
				itemSell: itemPriceSold[0],
				discount: itemPriceSold[2],
				finalPrice: parseInt($('#itemSell').text())*parseInt($(this).val())
			});
		}

		$('#receiptItemsList').empty();
		for (var i = 0; i < totalItemsInReceipt.length; i++) {
			$('#receiptItemsList').append('<li><span style="background-color: #e2e2d9; padding: 10px 15px 10px 15px; width: auto">'+totalItemsInReceipt[i]["itemName"]+' ('+totalItemsInReceipt[i]["quantitySold"]+')<span style="padding-left: 10px; font-weight: bold; color: red; cursor: pointer; padding-right: 0px; padding-bottom: 0px; padding-top: 0px" class="removeItem" id="'+totalItemsInReceipt[i]["id"]+'">x</span></span></li>')
		}

		$('#createSaleButton').show();
		$('#paymentMethodDiv').fadeIn();
		$('#selectEmpDivatSale').fadeIn();
		$('.confirmSaleBody table').fadeIn();
		$('.confirmSaleBody table tbody').empty();
		$('.confirmSaleBody table tfoot').empty();
		var totalPrice = 0;
		for (var i = 0; i < totalItemsInReceipt.length; i++) {
			$('.confirmSaleBody table tbody').append('<tr><td>'+totalItemsInReceipt[i]["itemName"]+'</td><td>'+totalItemsInReceipt[i]["quantitySold"]+'</td><td>'+totalItemsInReceipt[i]["itemSell"]+'</td><td>'+totalItemsInReceipt[i]["discount"]+'</td><td>'+(parseInt(totalItemsInReceipt[i]["itemSell"])*parseInt(totalItemsInReceipt[i]["quantitySold"]))+'</td></tr>')
			totalPrice += (parseInt(totalItemsInReceipt[i]["itemSell"])*parseInt(totalItemsInReceipt[i]["quantitySold"]));
		}
		$('.confirmSaleBody table tfoot').append('<tr style="text-align: center"><th colspan="4">Total</th><th>'+totalPrice+'</th></tr>');

		$('#quantitySold').val('');
	}
});

	$(document).on('click', '.removeItem', function(){
		totalItemsInReceipt.splice(getIndexByAttribute(totalItemsInReceipt, "id", $(this).attr('id')),1);
		$(this).parent().parent().remove();

		if (totalItemsInReceipt.length <= 0) {
			$('#createSaleButton').hide();
			$('#selectEmpDivatSale').hide();
			$('#paymentMethodDiv').hide();
			$('.confirmSaleBody table').hide();
			return;
		}

		$('#createSaleButton').show();
		$('#paymentMethodDiv').fadeIn();
		$('#selectEmpDivatSale').fadeIn();
		$('.confirmSaleBody table').fadeIn();
		$('.confirmSaleBody table tbody').empty();
		$('.confirmSaleBody table tfoot').empty();
		var totalPrice = 0;
		for (var i = 0; i < totalItemsInReceipt.length; i++) {
			$('.confirmSaleBody table tbody').append('<tr><td>'+totalItemsInReceipt[i]["itemName"]+'</td><td>'+totalItemsInReceipt[i]["quantitySold"]+'</td><td>'+totalItemsInReceipt[i]["itemSell"]+'</td><td>'+(parseInt(totalItemsInReceipt[i]["itemSell"])*parseInt(totalItemsInReceipt[i]["quantitySold"]))+'</td></tr>')
			totalPrice += (parseInt(totalItemsInReceipt[i]["itemSell"])*parseInt(totalItemsInReceipt[i]["quantitySold"]));
		}
		$('.confirmSaleBody table tfoot').append('<tr style="text-align: center"><th colspan="3">Total</th><th>'+totalPrice+'</th></tr>');

	});

	$(document).on('click', '.selectMultipleBarcodes', function(){
		showLoader(target);
		var item_barcode = $(this).attr('id');
		var ajaxData = { barcode: item_barcode };

		ajaxer('getItemDetailsToBeSold.php', ajaxData, function(response){
			var response = JSON.parse(response);

			if (response.length <= 0) {
				hideLoader(target);
				return;
			}

			itemId = response.id;
			itemDiscount = response.discount_available;
			itemNameForReceipt  = response.name;
			$('#itemName').text(response.name);
			$('#itemBrand').text(response.brand);
			$('#itemColor').text(response.color);
			$('#itemSize').text(response.size);
			$('#itemBarcode').text(item_barcode);
			$('#itemQuantityInStock').text(response.quantity);
			if (response.discount_active == "1") {
				
				$('#itemSell').text(response.sale + " - " + response.discount_available + "% off");
			}else{
				$('#itemSell').text(response.sale);
			}
			$('#itemExpiry').text(response.expiry);
			$('#itemImage').attr("src", response.image);
			$('#itemCategory').text(response.product_category);
			$('#itemDescription').text(response.description);
			stockQuantity = response.quantity;
			hideLoader(target);
			$('#addItemsFormDiv').fadeIn();
			$('#showMultipleItemsTable').hide();
		});
	});

	$("#itemNameFetch").on('keyup', function (e) {
		if (e.keyCode == 13) {
			var itemname = $(this).val();
			var ajaxData = { itemname: itemname };
			showLoader();
			ajaxer('getItemsToBeSoldByName.php', ajaxData, function(response){
				var response = JSON.parse(response);

				if (response.length <= 0) {
					hideLoader(target);
					return;
				}

				if (response.length == 1) {
					itemId = response[0].id;
					itemDiscount = response[0].discount_available;
					itemNameForReceipt  = response[0].name;
					$('#itemName').text(response[0].name);
					$('#itemBrand').text(response[0].brand);
					$('#itemColor').text(response[0].color);
					$('#itemSize').text(response[0].size);
					$('#itemBarcode').text(response[0].barcode);
					$('#itemQuantityInStock').text(response[0].quantity);
					$('#itemSell').text(response[0].sale);
					$('#itemExpiry').text(response[0].expiry);
					$('#itemImage').attr("src", response[0].image);
					$('#itemCategory').text(response.product_category);
					$('#itemDescription').text(response.description);
					stockQuantity = response[0].quantity;
					$('#addItemsFormDiv').fadeIn();
					$('#showMultipleItemsTable').hide();
				}else{
					$('#showMultipleItemsTable table tbody').empty();
					for (var i = 0; i < response.length; i++) {
						$('#showMultipleItemsTable table tbody').append('<tr><td>'+response[i].barcode+'</td><td>'+response[i].name+'</td><td>'+response[i].sale+'</td><td><button class="btn btn-primary selectMultipleBarcodes" id='+response[i].barcode+'>Select</button></td></tr>');
					}
					$('#addItemsFormDiv').hide();
					$('#showMultipleItemsTable').fadeIn();
				}
				
				hideLoader(target);
				return;		
			});
		}
	});

	$("#itemBarcodeFetch").on('keyup', function (e) {
		if (e.keyCode == 13) {
			showLoader(target);
			var item_barcode = $(this).val();
			var ajaxData = { barcode: item_barcode };

			ajaxer('getItemDetailsToBeSold.php', ajaxData, function(response){
				var response = JSON.parse(response);
				
				if (response.length <= 0) {
					hideLoader(target);
					return;
				}

				itemId = response.id;
				itemDiscount = response.discount_available;
				itemNameForReceipt  = response.name;
				$('#itemName').text(response.name);
				$('#itemBrand').text(response.brand);
				$('#itemColor').text(response.color);
				$('#itemSize').text(response.size);
				$('#itemBarcode').text(item_barcode);
				$('#itemQuantityInStock').text(response.quantity);
				if (response.discount_active == "1") {
					$('#itemSell').text(response.sale + " - " + response.discount_available + "% off");
				}else{
					$('#itemSell').text(response.sale);
				}
				$('#itemExpiry').text(response.expiry);
				$('#itemImage').attr("src", response.image);
				$('#itemCategory').text(response.product_category);
				$('#itemDescription').text(response.description);
				stockQuantity = response.quantity;
				hideLoader(target);
				$('#addItemsFormDiv').fadeIn();
				$('#showMultipleItemsTable').hide();
			});
		}
	});

	$('#updateSaleViewModalButton').click(function(){
		if ($('#updateSaleViewModalText').text() == "Update") {
			$('#updateQuantityDiv').fadeIn();
			$('#updateSaleViewModalText').text("Commit");
			return;
		}

		if (parseInt($('#itemQuantityUpdateSaleViewModal').val()) <= 0) {
			swal('Invalid Quantity', 'Please enter valid number of items', 'error');
			return;
		}

		if (parseInt($('#itemQuantityUpdateSaleViewModal').val()) > parseInt($('#itemQuantitySaleViewModal').text())) {
			swal('Invalid Quantity', 'Please enter valid number of items to remove', 'error');
			return;
		}

		$(this).attr('disabled', true);

		var ajaxData = { saleId: saleIdForViewModal, existingQuan: $('#itemQuantitySaleViewModal').text(),
		quantity: $('#itemQuantityUpdateSaleViewModal').val(), 
		finalPrice: parseInt($('#itemPriceEachSaleViewModal').text())*parseInt($('#itemQuantityUpdateSaleViewModal').val()) };
		ajaxer('updateSaleData.php', ajaxData, function(response){
			if (response == "Updated") {
				$('#saleModal').modal('hide');
				swal('Updated', 'Your sale has been updated', 'success');
				saleTokenFetcher(targetSale);
			}else if(response == "Out of stock"){
				swal('Out of stock', 'You do not have enough stock for this item', 'warning');
			}else{
				swal('Failed', 'Unable to update at the moment', 'error');
			}

			$(this).attr('disabled', false);
			return;
		});
	});

	$(document).on('click', '.reverseSale', function(){
		showLoaderSale(targetSale);
		$('#updateSaleViewModalText').text('Update');
		if (!$('#updateSaleViewModalButton').hasClass('btn-info')) {
			$('#updateSaleViewModalButton').addClass('btn-info');
			$('.updateSaleViewModalSpinner').hide();
			$('#updateSaleViewModalText').show();
			$('button').attr('disabled', false);
		}
		
		$('#itemQuantitySaleViewModal').fadeIn();
		$('#updateQuantityDiv').hide();
		var saleId = $(this).attr('id');
		saleIdForViewModal = saleId;
		ajaxer('fetchSaleUsingIdForReverse.php', { saleId: saleId }, function(response){
			var response = JSON.parse(response);
			$('.sale-modal-title').text(response.item_name);
			$('#itemQuantitySaleViewModal').text(response.item_quantity);
			$('#itemQuantityUpdateSaleViewModal').val(response.item_quantity);
			$('#itemPriceEachSaleViewModal').text(response.item_price_each);
			$('#itemFinalPriceSaleViewModal').text(response.item_final_price);
			$('#saleModal').modal('show');
			$('#switcher').empty();
			$('#switcher').append('<label class="switch" id="switchLabel" style="margin-left: 10px; margin-right: 10px"><input type="checkbox"><span class="slider round"></span></label>');
			itemsExcluder = false;
			hideLoaderSale(targetSale);
		});
	});

	$("#saleTokenFetch").on('keyup', function (e) {
		if (e.keyCode == 13) {
			saleTokenFetcher(targetSale);
		}
	});

	$('#fetchSale').click(function(){
		var empId = $('#employeeIdFetch').val();
		alert(empId);
	});

	$(document).on('click', '#createSaleButton', function(e) {

		$(this).removeClass('btn-success');
		$('.createSaleSpinner').fadeIn();
		$('#createSaleText').hide();
		$('button').attr('disabled', true);

		var ajaxData = { 
			cart: JSON.stringify(totalItemsInReceipt), 
			sold_by: $('#employeeId').val(),
			customerPhone: $('#phoneNumber').val(),
			payment_method: $('input[name="payment_method"]:checked').val()
		}

		ajaxer('createSale.php', ajaxData, function(response){
			var response = JSON.parse(response);

			if (response.status == "Success") {
				swal({
					title: 'Item Sold',
					type: 'success',
					text: 'Sale token is: ' + response.token,
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Ok'
				}).then(function () {
					location.reload();
				})
			}else {
				swal('Failed', 'Items are unable to be sold or recorded', 'error');
			}
			$(this).addClass('btn-success');
			$('.createSaleSpinner').hide();
			$('#createSaleText').fadeIn();
			$('button').attr('disabled', false);
			return;
		});
	});

	$('#confirmNumberButton').click(function(){
		$('#confirmNumberButton').removeClass('btn-success');
		$('.confirmNumberSpinner').fadeIn();
		$('#confirmNumberText').hide();
		var ajaxData = { customerNumber: $('#phoneNumber').val() };
		ajaxer('confirmCustomerNumber.php', ajaxData, function(response){
			if (response != "Failed") {
				swal('Confirmed', 'This number belongs to <strong>' + response + '</strong>', 'success');
			}else{
				swal('Failed', 'Unable to confirm this number', 'error');
			}
			$('#confirmNumberButton').addClass('btn-success');
			$('.confirmNumberSpinner').hide();
			$('#confirmNumberText').fadeIn();
		});
	});

});

function getIndexByAttribute(list, attr, val){
	var result = null;
	$.each(list, function(index, item){
		if(item[attr].toString() == val.toString()){
			result = index;
           return false;     // breaks the $.each() loop
       }
   });
	return result;
}

function saleTokenFetcher(targetSale){
	showLoaderSale(targetSale);
	var saleToken = $('#saleTokenFetch').val();
	ajaxer('fetchSaleDetails.php', { token: saleToken, fetchType: "token" }, function(response){
		var response = JSON.parse(response);
		var finalPriceSale = 0;
		$('#saleReceipt').fadeIn();
		$('#saleReceipt table tbody').empty();
		for (var i = 0; i < response.length; i++) {
			$('#saleReceipt table tbody').append('<tr><td>'+response[i].barcode+'</td><td>'+response[i].item_name+'</td><td>'+response[i].item_quantity+'</td><td>'+response[i].item_final_price+'</td><td><button class="btn btn-warning reverseSale" id="'+response[i].sale_id+'">Reverse</td></td></tr>');
			finalPriceSale += parseInt(response[i].item_final_price);
		}
		$('#totalPriceSale').text(finalPriceSale);
		hideLoaderSale(targetSale);
	});
}

function showLoader(target){
	var targetLoader = target;
	var targetBody = $(targetLoader).find('.panel-body');
	var spinnerHtml = '<div class="panel-loader"><span class="spinner-small"></span></div>';
	$(targetLoader).addClass('panel-loading');
	$(targetBody).prepend(spinnerHtml);
}

function hideLoader(target){
	if (target) {
		$(target).removeClass('panel-loading');
		$(target).find('.panel-loader').remove();
	}
}

function showLoaderSale(target){
	var targetLoader = target;
	var targetBody = $(targetLoader).find('.panel-body');
	var spinnerHtml = '<div class="panel-loader"><span class="spinner-small"></span></div>';
	$(targetLoader).addClass('panel-loading');
	$(targetBody).prepend(spinnerHtml);
}

function hideLoaderSale(target){
	if (target) {
		$(target).removeClass('panel-loading');
		$(target).find('.panel-loader').remove();
	}
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