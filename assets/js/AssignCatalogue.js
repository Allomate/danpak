$(document).ready(function(){
	
	$('.date').datepicker({
		format: "yyyy-mm-dd",
		startDate: '+0d'
	});

	$('#assignCatalogueButton').click(function(){
		if ($('#employeeIdDropdown').val() < 0) {
			swal('Missing Information', 'Please select an employee', 'error');
			return;
		}

		if ($('#catalogueIdDropdown').val() < 0) {
			swal('Missing Information', 'Please select a catalogue', 'error');
			return;
		}
		
		$(this).attr('disabled', 'disabled');
		$('#backFromCataloguesAssignmentButton').attr('disabled', 'disabled');
		$('#assignCatalogueForm').submit();
	});

	$('#updateAssignmentButton').click(function(){
		$(this).attr('disabled', 'disabled');
		$('#backFromCataloguesAssignmentButton').attr('disabled', 'disabled');
		$('#updateCatalogueAssignmentForm').submit();
	});
	
});