$(document).ready(function(){
	$('.table').DataTable();
	$('.dataTables_wrapper').hide();
	setTimeout(function(){
		$('select[name="DataTables_Table_0_length"]').css({
			'font-size' : '10pt',
			'margin' : '0px 10px 0px 10px'
		});
		$('select[name="DataTables_Table_0_length"]').parent().parent().parent().parent().width('100%');
		$('select[name="DataTables_Table_0_length"]').parent().parent().css('float', 'left');
		$('.dataTables_filter').css('float', 'right');
		$('.table').parent().parent().width('100%');
		$('.dataTables_paginate').parent().parent().width('100%');
		$('.table').fadeIn();
		$('.dataTables_wrapper').fadeIn();
	}, 300);

	$('select[name="pre_defined_item"]').change(function(){
		if ($(this).val() == "0") {
			$('#itemSkuLabel').text('Item Sku*');
			$('#itemNameLabel').text('Item Name*');
		}else{
			$('#itemSkuLabel').text('Item Sku');
			$('#itemNameLabel').text('Item Name');
		}
	});

	$('#addItemButton').click(function(){
		if (parseInt($('select[name="pre_defined_item"]').val())) {
			if ($('input[name="item_name"]').val() || $('input[name="item_sku"]').val()) {
				alert('Please leave Item Name & Item Sku fields empty if you are selecting a pre-defined item');
				return;
			}
		}else{
			if (!$('input[name="item_name"]').val() || !$('input[name="item_sku"]').val()) {
				alert('Please provide Item Name and Item Sku');
				return;
			}
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromInventoryButton').attr('disabled', 'disabled');
		$('#addInventoryForm').submit();
	});

	$('#updateItemButton').click(function(){
		$(this).attr('disabled', 'disabled');
		$('#backFromInventoryButton').attr('disabled', 'disabled');
		$('#updateInventoryForm').submit();
	});

	$(document).on('click', '.deleteThumbSpanTag', function(){
		$('input[name="thumb_deleted"]').val($(this).parent().parent().find('header').find('img').attr('src'));
		$(this).parent().parent().parent().parent().fadeOut();
	});

	$(document).on('click', '.deleteImagesSpanTag', function(){
		if ($('input[name="images_deleted"]').val() == '') {
			$('input[name="images_deleted"]').val($(this).parent().parent().find('header').find('img').attr('src'));
		}else{
			$('input[name="images_deleted"]').val($('input[name="images_deleted"]').val()+','+$(this).parent().parent().find('header').find('img').attr('src'));
		}
		$(this).parent().parent().remove();
		if (!$('#dynamicItemImagesToDeleteDiv').find('article').length) {
			$('#dynamicItemImagesToDeleteDiv').remove();
		}
	});

});