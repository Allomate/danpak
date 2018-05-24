$(document).ready(function(){

	var preferences = [];
	var totalUnitsAdded = 1;
	var itemDetails = new Object();
	var mainSubCategoriesIds = $('#mainCatIdsCombined').val().split(",").filter(String);
	var mainSubCategoriesNames = $('#mainCatNamesCombined').val().split(",").filter(String);
	var unitTypeIds = $('#unitTypeIdsCombined').val().split(",").filter(String);
	var unitTypeNames = $('#unitTypeNameCombined').val().split(",").filter(String);
	var mainCatDDId = null;
	var unitsToDisable = [];
	var totalDistinctUnitTypesAddable = unitTypeIds.length;
	var invalidSku = false;

	$('select[name="pre_defined_item"]').change(function(){
		var thisRef = $(this);
		unitsToDisable = [];
		if ($(this).val() == '0') {
			$('#skuandnameDiv').fadeIn('fast');
		}else{
			$('#skuandnameDiv').fadeOut('fast');
			$.ajax({
				type: 'POST',
				url: $('input[name="unitsDefinedForSku"]').val(),
				data: { itemId: $('select[name="pre_defined_item"]').val() },
				success: function(response){
					var response = JSON.parse(response);
					unitsToDisable = response[0].unit_id.split(",");
					for (var i = 0; i < totalUnitsAdded; i++) {
						$('select[name="unit_id_'+i+'"] option').removeAttr('disabled');
						$('select[name="unit_id_'+i+'"] option').each(function(){
							if(jQuery.inArray($(this).val(), unitsToDisable) !== -1){
								$(this).attr('disabled', 'disabled');
								if ($(this).text().indexOf("Already Added") < 0)
									$(this).text($(this).text()+" - Already Added");
							}else{
								$(this).removeAttr('disabled');
								$(this).text($(this).text().replace(' - Already Added',''));
							}
						});
					}

					totalDistinctUnitTypesAddable = unitTypeIds.length - unitsToDisable.length;
					$('.unitIdsDd').val(0);
				}
			})
		}
	});

	for (var i = 0; i < totalUnitsAdded; i++) {
		$('select[name="unit_id_'+i+'"] option').removeAttr('disabled');
		$('select[name="unit_id_'+i+'"] option').each(function(){
			if(jQuery.inArray($(this).val(), unitsToDisable) !== -1){
				$(this).attr('disabled', 'disabled');
			}
		});
	}

	$('#addAnotherVariantButton').click(function(){
		$('#moreVariants').append('<hr><div><div class="row" style="margin-bottom: 20px"><button id="removeThisPackaging" class="form-control" style="float: right; width: 20%">Remove</button></div><div class="row"><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Variants*</label><select class="form-control unitIdsDd" name="unit_id_'+totalUnitsAdded+'" data-style="form-control btn-default btn-outline"></select></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Product Quantity*</label><input type="text" name="item_quantity_'+totalUnitsAdded+'" class="form-control" placeholder=""></div></div></div><div class="row"><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Child</label><select class="form-control childItems" name="child_item_'+totalUnitsAdded+'" data-style="form-control btn-default btn-outline"></select></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Child Quantity</label><input type="text" name="child_item_quantity_'+totalUnitsAdded+'" class="form-control" placeholder=""></div></div></div><div class="row"><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Cost Price*</label><input type="text" name="item_warehouse_price_'+totalUnitsAdded+'" class="form-control" placeholder="Rs:0.00"></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Trade Price*</label><input type="text" name="item_trade_price_'+totalUnitsAdded+'" class="form-control" placeholder="Rs:0.00"></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Retail Price*</label><input type="text" name="item_retail_price_'+totalUnitsAdded+'" class="form-control" placeholder="Rs:0.00"></div></div></div><div class="row"><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Product Barcode*</label><input type="text" name="item_barcode_'+totalUnitsAdded+'" class="form-control" placeholder=""></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Expiry Date</label><input type="text" id="firstName" class="form-control" placeholder=""></div></div></div><div class="row"><div class="col-md-12"><div class="form-group"><label class="control-label mb-10">Description</label><textarea name="item_description_'+totalUnitsAdded+'" class="form-control" rows="5"></textarea></div></div></div></div>');

		$('select[name="unit_id_'+totalUnitsAdded+'"]').append('<option value="0">No type selected</option>');
		for (var i = 0; i < unitTypeIds.length; i++) {
			if(jQuery.inArray(unitTypeIds[i], unitsToDisable) !== -1){
				$('select[name="unit_id_'+totalUnitsAdded+'"]').append('<option value="'+unitTypeIds[i]+'" disabled="disabled">'+unitTypeNames[i]+'</option>');
			}else{
				$('select[name="unit_id_'+totalUnitsAdded+'"]').append('<option value="'+unitTypeIds[i]+'">'+unitTypeNames[i]+'</option>');
			}
		}
		$('select[name="child_item_'+totalUnitsAdded+'"]').append('<option value="0">No type selected</option>');
		for (var i = 0; i < unitTypeIds.length; i++) {
			if(jQuery.inArray(unitTypeIds[i], unitsToDisable) !== -1){
				$('select[name="child_item_'+totalUnitsAdded+'"]').append('<option value="'+unitTypeIds[i]+'" disabled="disabled">'+unitTypeNames[i]+'</option>');
			}else{
				$('select[name="child_item_'+totalUnitsAdded+'"]').append('<option value="'+unitTypeIds[i]+'">'+unitTypeNames[i]+'</option>');
			}
		}

		totalUnitsAdded++;
		if (totalUnitsAdded >= totalDistinctUnitTypesAddable) {
			// $('#addAnotherVariantButton').hide();
		}
		
	});

	$(document).on('click', '#removeThisPackaging', function(){
		$(this).parent().parent().remove();
	});

	$(document).on('change', '#mainCategoryDd_0', function(){
		$.ajax({
			type: 'POST',
			url: $('input[name="subCatDataForAjax"]').val(),
			data: { main_category: $(this).val() },
			success: function(response){
				var response = JSON.parse(response);
				$('select[name="sub_category_id_0"]').empty();
				for (var i = 0; i < response.length; i++) {
					$('select[name="sub_category_id_0"]').append('<option value="'+response[i]['sub_category_id']+'">'+response[i]['sub_category_name']+'</option>');
				}
			}
		})
	});

	$.ajax({
		type: 'POST',
		url: $('input[name="subCatDataForAjax"]').val(),
		data: { main_category: $('#mainCategoryDd_0').val() },
		success: function(response){
			var response = JSON.parse(response);
			$('select[name="sub_category_id_0"]').empty();
			for (var i = 0; i < response.length; i++) {
				$('select[name="sub_category_id_0"]').append('<option value="'+response[i]['sub_category_id']+'">'+response[i]['sub_category_name']+'</option>');
			}
		}
	})

	$("input[name='item_sku']").on('input',function(e){
		var itemSku = $(this).val();
		if (itemSku) {
			$.ajax({
				type: 'POST',
				url: $('input[name="skuDataRuntimeForAjax"]').val(),
				data: { sku: itemSku },
				success: function(response){
					if (response && response != 'null') {
						invalidSku = true;
						$('#skuExistError').fadeIn();
					}else{
						invalidSku = false;
						$('#skuExistError').hide();
					}
				}
			});
		}
	});

	$('#addInventoryButton').click(function(){
		var unitTypesAddedInSameItem = [];
		var barcodesAddedInSameItem = [];
		var sameBarcodesAdded = false;
		var sameUnitTypesAdded = false;

		if (!$('select[name="sub_category_id_0"]').val()) {
			swal('Missing Information', 'Please select a category', 'error');
			return;
		}

		if ($('select[name="pre_defined_item"]').length) {
			if ($('select[name="pre_defined_item"]').val() == "0") {
				if (!$('input[name="item_sku"]').val()) {
					swal('Missing Information', 'Please add item sku', 'error');
					return;
				}

				if (!$('input[name="item_name"]').val()) {
					swal('Missing Information', 'Please add item name', 'error');
					return;
				}


				if (invalidSku) {
					swal('Missing Information', 'This sku already exists', 'error');
					return;
				}
			}
		}else{
			if (!$('input[name="item_sku"]').val()) {
				swal('Missing Information', 'Please add item sku', 'error');
				return;
			}

			if (!$('input[name="item_name"]').val()) {
				swal('Missing Information', 'Please add item name', 'error');
				return;
			}


			if (invalidSku) {
				swal('Missing Information', 'This sku already exists', 'error');
				return;
			}
		}

		for (var i = 0; i < totalUnitsAdded; i++) {

			if($('select[name="unit_id_'+i+'"]').length){
				if ($('select[name="unit_id_'+i+'"]').val() == "0") {
					swal('Missing Information', 'You need to provide inventory variants for all the items', 'error');
					return;
				}
			}

			if($('input[name="item_barcode_'+i+'"]').length){
				if ($('input[name="item_barcode_'+i+'"]').val() == "") {
					swal('Missing Information', 'You need to provide barcodes for all the items', 'error');
					return;
				}
			}

			if($('input[name="item_quantity_'+i+'"]').length){
				if ($('input[name="item_quantity_'+i+'"]').val() == "") {
					swal('Missing Information', 'You need to provide quantity for all the items', 'error');
					return;
				}
			}

			if($('input[name="item_warehouse_price_'+i+'"]').length){
				if ($('input[name="item_warehouse_price_'+i+'"]').val() == "") {
					swal('Missing Information', 'You need to provide cost price for all the items', 'error');
					return;
				}
			}

			if($('input[name="item_trade_price_'+i+'"]').length){
				if ($('input[name="item_trade_price_'+i+'"]').val() == "") {
					swal('Missing Information', 'You need to provide trade price for all the items', 'error');
					return;
				}
			}

			if($('input[name="item_retail_price_'+i+'"]').length){
				if ($('input[name="item_retail_price_'+i+'"]').val() == "") {
					swal('Missing Information', 'You need to provide retail price for all the items', 'error');
					return;
				}
			}

			if($('select[name="child_item_'+i+'"]').length){
				if ($('select[name="child_item_'+i+'"]').val() != "0") {
					if (!$('input[name="child_item_quantity_'+i+'"]').val() || $('input[name="child_item_quantity_'+i+'"]').val() == "0") {
						swal('Missing Information', 'You need to provide quantity for all the child items selected', 'error');
						return;
					}
				}
			}

			if($('select[name="child_item_quantity_'+i+'"]').length){
				if ($('select[name="child_item_quantity_'+i+'"]').val() && $('select[name="child_item_quantity_'+i+'"]').val() != "0") {
					if ($('select[name="child_item_'+i+'"]').val() == "0") {
						swal('Missing Information', 'You need to provide quantity for all the child item variants', 'error');
						return;
					}
				}
			}

			if(jQuery.inArray($('input[name="item_barcode_'+i+'"]').val(), barcodesAddedInSameItem) !== -1){
				swal('Invalid Information', 'You can\'t add same barcodes for multiple items', 'error');
				sameBarcodesAdded = true;
				return;
			}

			if(jQuery.inArray($('select[name="unit_id_'+i+'"]').val(), unitTypesAddedInSameItem) !== -1){
				swal('Invalid Information', 'You can\'t add same Unit types for multiple items', 'error');
				sameUnitTypesAdded = true;
				return;
			}
			if ($('select[name="unit_id_'+i+'"]').length) {
				unitTypesAddedInSameItem.push($('select[name="unit_id_'+i+'"]').val());
			}
			if ($('input[name="item_barcode_'+i+'"]').length) {
				barcodesAddedInSameItem.push($('input[name="item_barcode_'+i+'"]').val());
			}
		}

		if (sameBarcodesAdded || sameUnitTypesAdded) {
			return;
		}

		$(this).attr('disabled','disabled');
		$('input[name="totalInventoryAdded"]').val(totalUnitsAdded);
		$('#addInventoryForm').submit();
	});

});