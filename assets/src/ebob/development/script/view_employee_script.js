$(document).ready(function(){

	var departmentsLists = new Array();
	fetchEmpDetails($('#empUsername').val());

	$('#updateOfficialDetails').click(function(){
		if($(this).html() == "Save"){
			var empDepts = "";
			var tempCounter = 0;
			
			$("#empDeptCheckboxes input[name='departments[]']:checked").each(function ()
			{
				if (tempCounter == 0)
					empDepts = $(this).val();
				else
					empDepts += "," + $(this).val();
				tempCounter++;
			});

			$.ajax({
				type: 'POST',
				url: 'ajax_scripts/updateEmpOfficialDetails.php',
				data: { empLocation: $('#empLocationInput').val(), empDepartments: empDepts,
				empUsername: $('#empUsername').val() },
				success: function(data){
					if(data == "Updated"){
						swal({
							title: 'Success',
							type: 'success',
							text: 'Employee official details updated successfully',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							confirmButtonText: 'Ok'
						});
						fetchEmpDetails($('#empUsername').val());
						toggleOfficialDetailsLayout(false);
					}
				}
			});
		}else{
			toggleOfficialDetailsLayout(true);
		}
	});

	$('#updateEmpDetails').click(function(){
		if($(this).html() == "Save"){
			$.ajax({
				type: 'POST',
				url: 'ajax_scripts/updateEmpProfileDetails.php',
				data: { empName: $('#empNameInput').val(), empAddress: $('#empAddressInput').val(), empCity: $('#empCityInput').val(), 
				empCountry: $('#empCountryInput').val(), empPhone: $('#empPhoneInput').val(), empUsername: $('#empUsername').val() },
				success: function(data){
					if(data == "Updated"){
						swal({
							title: 'Success',
							type: 'success',
							text: 'Employee profile details updated successfully',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							confirmButtonText: 'Ok'
						});
						fetchEmpDetails($('#empUsername').val());
						toggleProfileLayout(false);
					}
				}
			});
		}else{
			toggleProfileLayout(true);
		}
	});

	$('#cancelOfficialDetailsUpdate').click(function(e){
		toggleOfficialDetailsLayout(false);
	});

	$('#cancelEmpUpdate').click(function(e){
		toggleProfileLayout(false);
	});

	$('#empUsername').change(function(){
		fetchEmpDetails($('#empUsername').val());
	});

});

function fetchEmpDetails(newUserName){
	showLoader();
	$.ajax({
		type: 'POST',
		url: 'ajax_scripts/fetchEmpDetails.php',
		data: { username: newUserName },
		success: function(data){
			var data = JSON.parse(data);
			$('#empName').text(data["name"]);
			$('#empAddress').text(data["address"]);
			$('#empCity').text(data["city"]);
			$('#empCountry').text(data["country"]);
			$('#empPhone').text(data["phone"]);
			$('#empCompany').text(data["company"]);
			$('#empLocation').text(data["franchise"]);

			var deptIds = data["departments_id"].split(",");
			$('#empDeptCheckboxes input:checkbox').removeAttr('checked');

			for (var i = 0; i < deptIds.length; i++) {
				$('#empDeptCheckboxes input[type=checkbox][value='+deptIds[i]+']').prop('checked', true);
			}

			$('#empDept').text(data["departments"]);

			$('#empNameInput').val(data["name"]);
			$('#empAddressInput').val(data["address"]);
			$('#empCityInput').val(data["city"]);
			$('#empCountryInput').val(data["country"]);
			$('#empPhoneInput').val(data["phone"]);

			$('#empLocationInput').val(data["franchise"]);
			$('#empComplains').text("10");
			hideLoader();
		}
	});
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

function toggleProfileLayout(updateLayout){
	if(updateLayout){
		$('#updateEmpDetails').html("Save");
		$('#empNameInput').css('display', '');
		$('#empAddressInput').css('display', '');
		$('#empCityInput').css('display', '');
		$('#empCountryInput').css('display', '');
		$('#empPhoneInput').css('display', '');

		$('#empName').css('display', 'none');
		$('#empAddress').css('display', 'none');
		$('#empCity').css('display', 'none');
		$('#empCountry').css('display', 'none');
		$('#empPhone').css('display', 'none');
		$('#updateEmpDetails').css('width', '70%');
		setTimeout(function(){
			$('#cancelEmpUpdate').css('display', '');
		}, 200);
	}else{
		$('#empNameInput').css('display', 'none');
		$('#empAddressInput').css('display', 'none');
		$('#empCityInput').css('display', 'none');
		$('#empCountryInput').css('display', 'none');
		$('#empPhoneInput').css('display', 'none');

		$('#empName').css('display', '');
		$('#empAddress').css('display', '');
		$('#empCity').css('display', '');
		$('#empCountry').css('display', '');
		$('#empPhone').css('display', '');
		$('#cancelEmpUpdate').css('display', 'none');
		$('#updateEmpDetails').css('width', '100%');
		$('#updateEmpDetails').text('Update');
	}
}

function toggleOfficialDetailsLayout(updateLayout){
	if(updateLayout){
		$('#updateOfficialDetails').html("Save");
		$('#empLocationInput').css('display', '');
		$('#empDeptCheckboxes').css('display', '');
		
		$('#empLocation').css('display', 'none');
		$('#empDept').css('display', 'none');

		$('#updateOfficialDetails').css('width', '70%');
		setTimeout(function(){
			$('#cancelOfficialDetailsUpdate').css('display', '');
		}, 200);
	}else{
		$('#updateOfficialDetails').html("Update");
		$('#empLocationInput').css('display', 'none');
		$('#empDeptCheckboxes').css('display', 'none');
		
		$('#empLocation').css('display', '');
		$('#empDept').css('display', '');

		$('#cancelOfficialDetailsUpdate').css('display', 'none');
		$('#updateOfficialDetails').css('width', '100%');
	}
}