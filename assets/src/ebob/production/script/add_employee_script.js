$(document).ready(function(){

	$('#empUsername').keydown(checkExistingUn);
	$('#empUsername').keyup(checkExistingUn);
	var unExists = false;

	$('#addEmployeeButton').click(function(e){
		if(unExists){
			swal({
				title: 'Username already exist',
				type: 'error',
				showCancelButton: false,
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ok'
			});
			e.preventDefault(e);
		}
	});

	var options = $("#departmentsDD option");
	options.detach().sort(function(a,b) {
		var at = $(a).text();
		var bt = $(b).text();
		return (at > bt)?1:((at < bt)?-1:0);
	});
	options.appendTo("#departmentsDD");

	var options = $("#empRole option");
	options.detach().sort(function(a,b) {
		var at = $(a).text();
		var bt = $(b).text();
		return (at > bt)?1:((at < bt)?-1:0);
	});
	options.appendTo("#empRole");

	showLoader();
	$.ajax({
		type:'POST',
		data: { companyId: $('#companyDD').val() },
		url: "ajax_scripts/getFranchisesForCompany.php",
		success: function(data) {
			var data = JSON.parse(data);
			$('#franchiseDD').empty();
			if(data["id"].length){
				for (var i = 0; i < data["id"].length; i++) {
					$('#franchiseDD').append($('<option>', {
						value: data["id"][i],
						text: data["name"][i]
					}));
				}

				if($("#empRole").val() == "2")
					$('#franchiseDD').attr("disabled", "true");

				var options = $("#franchiseDD option");
				options.detach().sort(function(a,b) {
					var at = $(a).text();
					var bt = $(b).text();
					return (at > bt)?1:((at < bt)?-1:0);
				});
				options.appendTo("#franchiseDD");
				if(!$('#submitForm').length){
					$('#formSubmitDiv').append("<input type='submit' class='btn btn-info' id='submitForm' style='float: right'>");
				}
			}else{
				swal({
					title: 'Missing Information',
					type: 'warning',
					text: 'This company do not have any franchise',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Ok'
				});
				$('#formSubmitDiv').empty();
			}
			hideLoader();
		},
		error:function(jqXHR,textStatus,errorThrown ){
			alert('Exception:'+errorThrown );
		}
	}); 

	$('#empRole').change(function(){
		if($(this).val() != "2")
			$('#franchiseDD').removeAttr("disabled");
		else
			$('#franchiseDD').attr("disabled", "true");
	});

	$("#companyDD").change(function(){
		var companyId = $(this).val();
		$('#page-loader').removeClass();
		debugger;
		if(!$('#page-loader').hasClass('fade')){
			$('#page-loader').addClass('fade');
		}
		$('#page-loader').addClass('in');
		$.ajax({
			type:'POST',
			data: { companyId: companyId },
			url: "ajax_scripts/getFranchisesForCompany.php",
			success: function(data) {
				var data = JSON.parse(data);
				$('#franchiseDD').empty();
				if(data["id"].length){
					for (var i = 0; i < data["id"].length; i++) {
						$('#franchiseDD').append($('<option>', {
							value: data["id"][i],
							text: data["name"][i]
						}));
					}
					if(!$('#submitForm').length){
						$('#formSubmitDiv').append("<input type='submit' class='btn btn-info' id='submitForm' style='float: right'>");
					}
				}else{
					swal({
						title: 'Missing Information',
						type: 'warning',
						text: 'This company do not have any franchise',
						showCancelButton: false,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Ok'
					});
					$('#formSubmitDiv').empty();
				}
				hideLoader();
			},
			error:function(jqXHR,textStatus,errorThrown ){
				alert('Exception:'+errorThrown );
			}
		}); 
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
						url: "ajax_scripts/parseCsvFormattedFile-employeeBulkUpload.php",
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
										$('#failedUploadsTbody').append("<tr><td>" + response[i]["employee_username"] + "</td><td>" + response[i]["error"] + "</td></tr>");
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

	function checkExistingUn() {
		if($('#empUsername').val() != ""){
			$.ajax({
				type:'POST',
				data: { username: $('#empUsername').val() },
				url: "ajax_scripts/checkExistingUsername.php",
				success: function(data) {
					if(data == "Exist"){
						unExists = true;
						if($('.has-feedback').hasClass('has-success')){
							$('.has-feedback').removeClass('has-success');
							$('.has-feedback').addClass('has-error');
						}
						$('#usernameWarning').empty();
						$('#usernameWarning').append('<span class="fa fa-times form-control-feedback"></span>');
					}else{
						unExists = false;
						if($('.has-feedback').hasClass('has-error')){
							$('.has-feedback').removeClass('has-error');
							$('.has-feedback').addClass('has-success');
						}
						$('#usernameWarning').empty();
						$('#usernameWarning').append('<span class="fa fa-check form-control-feedback"></span>');
					}
				}
			});
		}else{
			unExists = false;
			$('#usernameWarning').empty();
		}
	}

	function showLoader(){
		$('#page-loader').removeClass();
		$('#page-loader').addClass('fade');
		$('#page-loader').addClass('in');
	}

	function hideLoader(){
		$('#page-loader').removeClass();
		if(!$('#page-loader').hasClass('fade')){
			$('#page-loader').addClass('fade');
		}
	}

});