$(document).ready(function(){
	App.init();
	Dashboard.init();
	$('.nav li').removeClass('active');
	$('#warehouseLi').addClass('active');
	$('#itemsLi').addClass('active');
	$('#addItems').addClass('active');

	var ajaxDefData = {'catId': $('#mainCategoryDD').val(), 'catType': 'sub'};
	fetchCategories(ajaxDefData);

	$('#mainCategoryDD').change(function(){
		var ajaxData = {
			'catId': $(this).val(),
			'catType': 'sub'
		};
		fetchCategories(ajaxData);
	});

	$('#subCatDD').change(function(){
		var ajaxData = {
			'catId': $(this).val(),
			'catType': 'sub'
		};
		fetchSubCategories(ajaxData);
	});

	$('#submitForm').click(function(e){
		e.preventDefault();
		if ($("input[name='itemName']").val() == '' || $("input[name='itemQuantity']").val() == '' || $("input[name='itemBarcode']").val() == '') {
			alert('Please provide Name, Quantity and Barcode as essentials. Thanks');
			return;
		}

		$('button').attr('disabled', true);
		$(this).removeClass('btn-success');
		$('#submitBtnText').hide();
		$('.spinnerButton').fadeIn();
		$('#addItemsForm').ajaxSubmit({
			type: "POST",
			url: "ajax_scripts/add_item_details.php",
			data: $('#addItemsForm').serialize(),
			cache: false,
			success: function (response) {
				$('button').attr('disabled', false);
				$('#submitForm').addClass('btn-success');
				$('#submitBtnText').fadeIn();
				$('.spinnerButton').hide();
				if (response == "Barcode already exists") {
					swal('Failed', 'This barcode already exists', 'warning');
				}else if(response == "Violations"){
					swal('Failed', 'One more violation and your license will be cancelled', 'warning');
				}else if (response == "Success") {
					swal({
						title: 'Added',
						type: 'success',
						text: 'The product is added successfully',
						showCancelButton: false,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Ok'
					}).then(function () {
						setTimeout(function(){
							location.reload();
						},250);
					})
				}else{
					document.write(response);
				}
				return;
			}
		});

	});

	$('#itemExpInput').datepicker({
		format: 'yyyy-mm-dd'
	});

	$('#uploadBulkButton').click(function(){
		if ($("#csvSheet").val() == '') {
			return;
		}
		swal({
			title: 'Are you sure?',
			showCancelButton: true,
			confirmButtonText: 'Yes',
			showLoaderOnConfirm: true,
			preConfirm: function () {
				return new Promise(function (resolve, reject) {
					$('#csvUploadingForm').ajaxSubmit({
						type: "POST",
						url: "ajax_scripts/parseCsvFormattedFile.php",
						data: $('#csvUploadingForm').serialize(),
						cache: false,
						success: function (response) {
							if (response == "filetype") {
								swal('Failed', 'Unable to upload this filetype. Allowed types are: .csv', 'error');
							}else{
								var response = JSON.parse(response);
								if (response.length > 0) {
									$('#failedUploadsTbody').empty();
									for (var i = 0; i < response.length; i++) {
										$('#failedUploadsTbody').append("<tr><td>" + response[i]["barcode"] + "</td><td>" + response[i]["error"] + "</td></tr>");
									}
									$('#failedUploadsDiv').fadeIn();
									$('#failedUploadsTable').fadeIn();
									swal('Failed', 'Unable to upload all the records', 'warning');
								}else{
									$('#failedUploadsDiv').fadeOut();
									$('#failedUploadsTable').fadeOut();
									swal('Upload Complete', 'All the items are uploaded successfully', 'success');
								}
							}
							return;
						}
					});
				})
			},
			allowOutsideClick: false
		})
	});
});

function fetchCategories(ajaxData){
	$('body').addClass('loading');
	ajaxer('getCategories.php', ajaxData, function(response){
		var data = JSON.parse(response);
		$('#subCatDD').empty();
		for (var i = 0; i < data.length; i++) {
			$('#subCatDD').append('<option value="'+data[i]["id"]+'">'+data[i]["name"]+'</option>');	
		}
		$('#subCategoryDiv').css('display', '');

		var ajaxNewData = { 'catId': $('#subCatDD').val(), 'catType': 'product' };
		ajaxer('getCategories.php', ajaxNewData, function(response){
			var dataNew = JSON.parse(response);
			$('#prodCategoryDD').empty();
			for (var i = 0; i < dataNew.length; i++) {
				$('#prodCategoryDD').append('<option value="'+dataNew[i]["id"]+'">'+dataNew[i]["name"]+'</option>');	
			}
			$('#prodCategoryDiv').css('display', '');
		});
		$('body').removeClass('loading');
	});
}

function fetchSubCategories(ajaxData){
	$('body').addClass('loading');
	ajaxer('getCategories.php', ajaxData, function(response){
		var ajaxNewData = { 'catId': $('#subCatDD').val(), 'catType': 'product' };
		ajaxer('getCategories.php', ajaxNewData, function(response){
			var dataNew = JSON.parse(response);
			$('#prodCategoryDD').empty();
			for (var i = 0; i < dataNew.length; i++) {
				$('#prodCategoryDD').append('<option value="'+dataNew[i]["id"]+'">'+dataNew[i]["name"]+'</option>');	
			}
			$('#prodCategoryDiv').css('display', '');
		});
		$('body').removeClass('loading');
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