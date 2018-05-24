$(document).ready(function(){

	var target = $('.permissionsPanel');
	getPermissionsForEmployee(target);

	$('#empUsername').change(function(){
		$('input:checkbox').prop('checked', false);
		getPermissionsForEmployee(target);
	});

	$(document).on('click', '#updatePermissionsButton', function(e) {

		$('#updatePermissionsButton').removeClass('btn-success');
		$('.updatePermissionsSpinner').fadeIn();
		$('#updatePermissionsText').hide();
		$('button').attr('disabled', true);
		$('input').attr('disabled', true);

		var selected = [];
		$('input[name="access_rights"]:not(:checked)').each(function() {
			selected.push($(this).attr('value')+'=0');
		});

		$('input[name="access_rights"]:checked').each(function() {
			selected.push($(this).attr('value')+'=1');
		});

		var ajaxData = { permission_pages : selected.join(','), employee_id: $('#empUsername').val() };
		ajaxer('update_access_rights.php', ajaxData, function(response){
			if (response == "Updated") {
				swal('Updated', 'Permissions are given accordingly', 'success');
			}else{
				swal('Failed', 'Unable to give permissions at the moment', 'error');
			}

			$('#updatePermissionsButton').addClass('btn-success');
			$('.updatePermissionsSpinner').hide();
			$('#updatePermissionsText').fadeIn();
			$('button').attr('disabled', false);
			$('input').attr('disabled', false);
			return;
		});
	});
	
	$('#employee_main_checker').change(function() {
		if ($(this).is(':checked')) {
			$('input[value="add_employee"]').prop('checked', true);
			$('input[value="view_employee"]').prop('checked', true);
		}else{
			$('input[value="add_employee"]').prop('checked', false); 
			$('input[value="view_employee"]').prop('checked', false); 
		}
	});
	
	$('#pos_main_checker').change(function() {
		if ($(this).is(':checked')) {
			$('input[value="pos_setup"]').prop('checked', true);
			$('input[value="item_sale"]').prop('checked', true);
		}else{
			$('input[value="pos_setup"]').prop('checked', false); 
			$('input[value="item_sale"]').prop('checked', false); 
		}
	});
	
	$('#targets_main_checker').change(function() {
		if ($(this).is(':checked')) {
			$('input[value="add_targets"]').prop('checked', true);
			$('input[value="update_targets"]').prop('checked', true);
		}else{
			$('input[value="add_targets"]').prop('checked', false);
			$('input[value="update_targets"]').prop('checked', false);
		}
	});
	
	$('#inventory_main_checker').change(function() {
		if ($(this).is(':checked')) {
			$('input[value="warehouse_inventory"]').prop('checked', true);
			$('input[value="location_inventory"]').prop('checked', true);
			$('input[value="inventory_requests"]').prop('checked', true);
		}else{
			$('input[value="warehouse_inventory"]').prop('checked', false);
			$('input[value="location_inventory"]').prop('checked', false);
			$('input[value="inventory_requests"]').prop('checked', false);
		}
	});
	
	$('#warehouse_main_checker').change(function() {
		if ($(this).is(':checked')) {
			$('input[value="add_warehouse"]').prop('checked', true);
			$('input[value="dispatch_items"]').prop('checked', true);
			$('input[value="add_items"]').prop('checked', true);
			$('input[value="update_items"]').prop('checked', true);
		}else{
			$('input[value="add_warehouse"]').prop('checked', false);
			$('input[value="dispatch_items"]').prop('checked', false);
			$('input[value="add_items"]').prop('checked', false);
			$('input[value="update_items"]').prop('checked', false);
		}
	});

});

function getPermissionsForEmployee(target){
	showLoader(target);
	var ajaxData = { employee_id: $('#empUsername').val() };
	ajaxer('getPermissionsForEmployee.php', ajaxData, function(response){
		var response = JSON.parse(response);
		$.each(response, function(key, value){
			if (value) {
				if (key != 'id' && key != 'employee_id')
					$('input[value="'+key+'"]').prop('checked', true);
			}
		});
		hideLoader(target);
	});
}

function showLoader(target){
	var targetLoader = target;
	var targetBody = $(targetLoader).find('.panel-body');
	var spinnerHtml = '<div class="panel-loader"><span class="spinner-small"></span></div>';
	$(targetLoader).addClass('panel-loading');
	$(targetBody).prepend(spinnerHtml);
}

function hideLoader(target){
	if (target) {
		$(target).removeClass('panel-loading');
		$(target).find('.panel-loader').remove();
	}
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