$(document).ready(function(){

	$('#addRegionButton').click(function(){
		if ($('#employeeIdDD').val() == "0" || !$('#employeeIdDD').val()) {
			alert('Please select a valid POC');
			return;
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromRegionsButton').attr('disabled', 'disabled');
		$('#addRegionForm').submit();
	});

	$('#updateRegionButton').click(function(){
		if ($('#employeeIdDD').val() == "0" || !$('#employeeIdDD').val()) {
			alert('Please select a valid POC');
			return;
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromRegionsButton').attr('disabled', 'disabled');
		$('#updateRegionForm').submit();
	});

	$('#addAreaButton').click(function(){
		if ($('#regionIdDD').val() == "0" || !$('#regionIdDD').val()) {
			alert('Please select a valid region');
			return;
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromAreasButton').attr('disabled', 'disabled');
		$('#addAreaForm').submit();
	});

	$('#updateAreaButton').click(function(){
		if ($('#regionIdDD').val() == "0" || !$('#regionIdDD').val()) {
			alert('Please select a valid region');
			return;
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromAreasButton').attr('disabled', 'disabled');
		$('#updateAreaForm').submit();
	});

	$('#addTerritoryButton').click(function(){
		if ($('#areaIdDD').val() == "0" || !$('#areaIdDD').val()) {
			alert('Please select a valid area');
			return;
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromTerritoryButton').attr('disabled', 'disabled');
		$('#addTerritoryForm').submit();
	});

	$('#updateTerritoryButton').click(function(){
		if ($('#areaIdDD').val() == "0" || !$('#areaIdDD').val()) {
			alert('Please select a valid area');
			return;
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromTerritoryButton').attr('disabled', 'disabled');
		$('#updateTerritoryForm').submit();
	});

});