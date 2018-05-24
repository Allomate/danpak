$(document).ready(function(){

	var subInventData = null;
						debugger;
	$.ajax({
		url: $('input[name="subInventData"]').val(),
		success: function(response){
			subInventData = JSON.parse(response);
			for (var i = 0; i < subInventData.length; i++) {
				$('select[name="item_name_item_inside"]').append('<option value="'+subInventData[i].item_id+'">'+subInventData[i].item_name+'</option>');
				$('select[name="item_name_inside_this_item"]').append('<option value="'+subInventData[i].item_id+'">'+subInventData[i].item_name+'</option>');
			}

			var itemIdSelectedItemInside = parseInt($('select[name="item_name_item_inside"]').val());
			var itemIdSelectedInsideThisItem = parseInt($('select[name="item_name_inside_this_item"]').val());

			if ($('input[name="currentController"]').val() == 'UpdateSubInventory' || $('input[name="currentController"]').val() == 'UpdateSubInventoryOps') {
				$.ajax({
					url: $('input[name="thisSubInventData"]').val(),
					success: function(response){
						debugger;
						var response = JSON.parse(response);
						var insideThisItemId = response['inside_this_item'].split("-")[0];
						var insideThisItemUnitIt = response['inside_this_item'].split("-")[1];
						var itemInsideItemId = response['item_inside'].split("-")[0];
						var itemInsideUnitId = response['item_inside'].split("-")[1];
						$('select[name="item_name_item_inside"]').val(itemInsideItemId);
						$('select[name="item_name_inside_this_item"]').val(insideThisItemId);

						itemIdSelectedItemInside = itemInsideItemId;
						itemIdSelectedInsideThisItem = insideThisItemId;

						$.each( subInventData, function( index, value ){
							if (value.item_id == itemIdSelectedItemInside) {
								var unitData = value.units_data.split(",");
								for (var i = 0; i < unitData.length; i++) {
									var unitName = unitData[i].split("(")[0];
									var unitId = unitData[i].split("(")[1].split(")")[0];
									if (unitId == itemInsideUnitId) {
										$('select[name="unit_id_item_inside"]').append('<option value="'+unitId+'" selected="selected">'+unitName+'</option>');
									}else{
										$('select[name="unit_id_item_inside"]').append('<option value="'+unitId+'">'+unitName+'</option>');
									}
								}
							}
							if (value.item_id == itemIdSelectedInsideThisItem) {
								var unitData = value.units_data.split(",");
								for (var i = 0; i < unitData.length; i++) {
									var unitName = unitData[i].split("(")[0];
									var unitId = unitData[i].split("(")[1].split(")")[0];
									if (unitId == insideThisItemUnitIt) {
										$('select[name="unit_id_inside_this_item"]').append('<option value="'+unitId+'" selected="selected">'+unitName+'</option>');
									}else{
										$('select[name="unit_id_inside_this_item"]').append('<option value="'+unitId+'">'+unitName+'</option>');
									}
								}
							}
						});
						$('input[name="quantity"]').val(response["quantity"]);
					}
				})
			}else{
				$.each( subInventData, function( index, value ){
					if (value.item_id == itemIdSelectedItemInside) {
						var unitData = value.units_data.split(",");
						for (var i = 0; i < unitData.length; i++) {
							var unitName = unitData[i].split("(")[0];
							var unitId = unitData[i].split("(")[1].split(")")[0];
							$('select[name="unit_id_item_inside"]').append('<option value="'+unitId+'">'+unitName+'</option>');
						}
					}
					if (value.item_id == itemIdSelectedInsideThisItem) {
						var unitData = value.units_data.split(",");
						for (var i = 0; i < unitData.length; i++) {
							var unitName = unitData[i].split("(")[0];
							var unitId = unitData[i].split("(")[1].split(")")[0];
							$('select[name="unit_id_inside_this_item"]').append('<option value="'+unitId+'">'+unitName+'</option>');
						}
					}
				});
			}

		}
	});

	$('select[name="item_name_item_inside"]').change(function(){
		var itemIdSelected = parseInt($(this).val());
		$('select[name="unit_id_item_inside"]').empty()
		$.each( subInventData, function( index, value ){
			if (value.item_id == itemIdSelected) {
				var unitData = value.units_data.split(",");
				for (var i = 0; i < unitData.length; i++) {
					var unitName = unitData[i].split("(")[0];
					var unitId = unitData[i].split("(")[1].split(")")[0];
					$('select[name="unit_id_item_inside"]').append('<option value="'+unitId+'">'+unitName+'</option>');
				}
			}
		});
	});

	$('select[name="item_name_inside_this_item"]').change(function(){
		var itemIdSelected = parseInt($(this).val());
		$('select[name="unit_id_inside_this_item"]').empty()
		$.each( subInventData, function( index, value ){
			if (value.item_id == itemIdSelected) {
				var unitData = value.units_data.split(",");
				for (var i = 0; i < unitData.length; i++) {
					var unitName = unitData[i].split("(")[0];
					var unitId = unitData[i].split("(")[1].split(")")[0];
					$('select[name="unit_id_inside_this_item"]').append('<option value="'+unitId+'">'+unitName+'</option>');
				}
			}
		});
	});

	$('#convertQuantityBtn').click(function(){
		$(this).attr('disabled', 'disabled');
		$('#backFromConversionButton').attr('disabled', 'disabled');
		$('#convertQuantityForm').submit();
	});

	$('input[name="convert_parent_quantity"]').on('input', function() {
		var maxParentQuantity = parseInt($('input[name="convert_parent_quantity"]').attr('max'));
		var convertParentQuantity = parseInt($(this).val());
		if ($(this).val() > maxParentQuantity) {
			$(this).val(maxParentQuantity);
			convertParentQuantity = maxParentQuantity;
		}
		if ($(this).val() <= 0) {
			$(this).val("1");
			convertParentQuantity = 1;
		}
		$('#quantityAddingToChild').text(convertParentQuantity*parseInt($('input[name="each_parent_contains_quantity"]').val()));
		$('input[name="quantityAddingToChild"]').val(convertParentQuantity*parseInt($('input[name="each_parent_contains_quantity"]').val()));
		$('#quantityRemainingForParent').text(maxParentQuantity-convertParentQuantity);
		$('input[name="quantityRemainingForParent"]').val(maxParentQuantity-convertParentQuantity);
	});

	$('#addSubInventoryButton').click(function(){
		$(this).attr('disabled', 'disabled');
		$('#backFromSubInventoryButton').attr('disabled', 'disabled');
		$('#addSubInventForm').submit();
	});

	$('#updateSubInventoryButton').click(function(){
		$(this).attr('disabled', 'disabled');
		$('#backFromSubInventoryButton').attr('disabled', 'disabled');
		$('#updateSubInventForm').submit();
	});

});