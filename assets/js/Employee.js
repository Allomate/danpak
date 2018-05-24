$(document).ready(function(){
	$('#addEmployeeButton').click(function(){
		if (!$('#territoryDD').val() || $('#territoryDD').val() == "0") {
			alert('Please select a territory first');
			return;
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromEmployeeButton').attr('disabled', 'disabled');
		$('#addEmployeeForm').submit();
	});

	$(document).on('click', '.dropify-clear', function(){
		$('input[name="picture_deleted"]').val('deleted');
	});

	$('#updateEmployeeButton').click(function(){
		if (!$('#territoryDD').val() || $('#territoryDD').val() == "0") {
			alert('Please select a territory first');
			return;
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromEmployeeButton').attr('disabled', 'disabled');
		$('#updateEmployeeForm').submit();
	});
});