$(document).ready(function(){

	$('.table').DataTable();
	var select = document.getElementById('employees_list');
	if (select) {
		multi( select );
	}

	var empAdded = [];

	if ($('input[name="employee_id"]').val()) {
		empAdded = $('input[name="employee_id"]').val().split(',');
		$('#employeesListDiv .non-selected-wrapper a').each(function(){
			var dataValue = $(this).attr('data-value');
			if(jQuery.inArray(dataValue, empAdded) !== -1){
				$(this).addClass('selected');
				$('#employeesListDiv .selected-wrapper').append('<a tabindex="0" class="item selected" role="button" data-value="'+$(this).attr('data-value')+'" multi-index="'+$(this).attr('multi-index')+'">'+$(this).text()+'</a>');        
			}
		});
	}

	$('#addMessageButton').click(function(){
		if (!$('select[name="group_id"]').val() || parseInt($('select[name="group_id"]').val()) <= 0) {
			if (!$('select[name="individual_id"]').val() || parseInt($('select[name="individual_id"]').val()) <= 0) {
				alert('Please select at least one group or individual');
				return;
			}
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromAddMessage').attr('disabled', 'disabled');
		$('#addMessageForm').submit();
	});

	$('#updateMessageButton').click(function(){
		if (!$('select[name="group_id"]').val() || parseInt($('select[name="group_id"]').val()) <= 0) {
			if (!$('select[name="individual_id"]').val() || parseInt($('select[name="individual_id"]').val()) <= 0) {
				alert('Please select at least one group or individual');
				return;
			}
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromAddMessage').attr('disabled', 'disabled');
		$('#updateMessageForm').submit();
	});

	$('#addGroupButton').click(function(){
		empAdded = [];
		$('#employeesListDiv .selected-wrapper a').each(function(){
			empAdded.push($(this).attr('data-value'));
		});
		if (!empAdded.length) {
			alert('Please add an employee first');
			return;
		}
		if (!$('input[name="group_name"]').val()) {
			alert('Please enter a valid group name');
			return
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromAddGroups').attr('disabled', 'disabled');
		$('input[name="employee_id"]').val(empAdded.join(","));
		$('#addGroupForm').submit();
	});

	$('#updateGroupBtn').click(function(){
		empAdded = [];
		$('#employeesListDiv .selected-wrapper a').each(function(){
			empAdded.push($(this).attr('data-value'));
		});
		if (!empAdded.length) {
			alert('Please add an employee first');
			return;
		}
		if (!$('input[name="group_name"]').val()) {
			alert('Please enter a valid group name');
			return
		}
		$(this).attr('disabled', 'disabled');
		$('#backFromUpdateGroup').attr('disabled', 'disabled');
		$('input[name="employee_id"]').val(empAdded.join(","));
		$('#updateGroupForm').submit();
	});

});