var totalListItems = 0;
$(document).ready(function(){

	var target = $('.targetsPanel');

	$('#criteria').change(function(){
		if ($(this).val() == "quarterly") {
			$('#crtieriaDefinition').html('<select class="form-control" id="definition" style="width: 30%; display: inline;"><option value="q1">Q1</option><option value="q2">Q2</option><option value="q3">Q3</option><option value="q4">Q4</option></select>');
		}else if ($(this).val() == "monthly") {
			$('#crtieriaDefinition').html('<select class="form-control" id="definition" style="width: 30%; display: inline;"><option value="jan">JAN</option><option value="feb">FEB</option><option value="mar">MAR</option><option value="apr">APR</option><option value="may">MAY</option><option value="jun">JUN</option><option value="jul">JUL</option><option value="aug">AUG</option><option value="sep">SEP</option><option value="oct">OCT</option><option value="nov">NOV</option><option value="dec">DEC</option></select>');
		}else if ($(this).val() == "annually") {
			$('#crtieriaDefinition').html('<select class="form-control" id="definition" style="width: 30%; display: inline;"><option value="'+(new Date()).getFullYear()+'">'+(new Date()).getFullYear()+'</option></select>');
		}else if ($(this).val() == "daily") {
			$('#crtieriaDefinition').html('<select class="form-control" id="definition" style="width: 30%; display: inline;"><option value="monday">MONDAY</option><option value="tuesday">TUESDAY</option><option value="wednesday">WEDNESDAY</option><option value="thursday">THURSDAY</option><option value="friday">FRIDAY</option><option value="saturday">SATURDAY</option><option value="sunday">SUNDAY</option></select>');
		}
	});

	$('#criteriaUpdateDD').change(function(){
		$(this).css('width', '70%' );
		if ($(this).val() == "quarterly") {
			$('#crtieriaDefinitionUpdateDiv').html('<select class="form-control" id="definitionUpdateDD" style="display: inline;"><option value="q1">Q1</option><option value="q2">Q2</option><option value="q3">Q3</option><option value="q4">Q4</option></select>');
		}else if ($(this).val() == "monthly") {
			$('#crtieriaDefinitionUpdateDiv').html('<select class="form-control" id="definitionUpdateDD" style="display: inline;"><option value="jan">JAN</option><option value="feb">FEB</option><option value="mar">MAR</option><option value="apr">APR</option><option value="may">MAY</option><option value="jun">JUN</option><option value="jul">JUL</option><option value="aug">AUG</option><option value="sep">SEP</option><option value="oct">OCT</option><option value="nov">NOV</option><option value="dec">DEC</option></select>');
		}else if ($(this).val() == "annually") {
			$('#crtieriaDefinitionUpdateDiv').html('<select class="form-control" id="definitionUpdateDD" style="display: inline;"><option value="'+(new Date()).getFullYear()+'">'+(new Date()).getFullYear()+'</option></select>');
		}else if ($(this).val() == "daily") {
			$('#crtieriaDefinitionUpdateDiv').html('<select class="form-control" id="definitionUpdateDD" style="display: inline;"><option value="monday">MONDAY</option><option value="tuesday">TUESDAY</option><option value="wednesday">WEDNESDAY</option><option value="thursday">THURSDAY</option><option value="friday">FRIDAY</option><option value="saturday">SATURDAY</option><option value="sunday">SUNDAY</option></select>');
		}
	});

	showLoader(target);
	fetchEmpTargets(target);

	$('#addNewTargetBtn').click(function(){
		$('#targetsDynamic ul').append('<li><div class="row"><div class="col-md-10 targetSpanParent"><span id="targetSpan'+totalListItems+'" style="display: none"></span> <div class="row"><div class="col-md-11"><input class="form-control targetsInput" id="updateTargetsInput'+totalListItems+'"  style=""/></div><div class="col-md-1"><input type="number" class="form-control percentagesInput" id="updatePercentagesInput'+totalListItems+'"/></div></div></div></div></li>')
	});

	$(document).on('click', '.deleteTargetsBtn', function(e) {
		var ref = $(this).parent().parent().parent();
		ref.fadeOut();
		setTimeout(function(){
			ref.remove();
		}, 500);
	});

	$('#findTargetsBtn').click(function(){
		fetchEmpTargets(target);
	});

	$('#updateTargetsBtn').click(function(){

		$('.deleteTargetsBtn').map(function() {
			$(this).show();
		}).get();

		if ($(this).find("#updateTargetsText").text() == "Update Targets") {
			$(this).find("#updateTargetsText").text("Commit Changes")
			$('span#criteriaSpan').hide();
			$('span#quarterSpan').hide();
			$('span#targetSale').hide();
			$('.targetSpanParent span').hide();
			$('#cancelCommitBtn').show();
			$('#addNewTargetBtn').show()
			$('#criteriaUpdateDD').fadeIn();
			$('#crtieriaDefinitionUpdateDiv').fadeIn();
			$('#targetSaleInput').fadeIn();
			$('.targetSpanParent input').fadeIn();
			$('#criteriaUpdateDD').val($('#criteria').val());
			if ($('#criteriaUpdateDD').val() == "quarterly") {
				$('#crtieriaDefinitionUpdateDiv').html('<select class="form-control" id="definitionUpdateDD" style="display: inline;"><option value="q1">Q1</option><option value="q2">Q2</option><option value="q3">Q3</option><option value="q4">Q4</option></select>');
			}else if ($('#criteriaUpdateDD').val() == "monthly") {
				$('#crtieriaDefinitionUpdateDiv').html('<select class="form-control" id="definitionUpdateDD" style="display: inline;"><option value="jan">JAN</option><option value="feb">FEB</option><option value="mar">MAR</option><option value="apr">APR</option><option value="may">MAY</option><option value="jun">JUN</option><option value="jul">JUL</option><option value="aug">AUG</option><option value="sep">SEP</option><option value="oct">OCT</option><option value="nov">NOV</option><option value="dec">DEC</option></select>');
			}else if ($('#criteriaUpdateDD').val() == "annually") {
				$('#crtieriaDefinitionUpdateDiv').html('<select class="form-control" id="definitionUpdateDD" style="display: inline;"><option value="'+(new Date()).getFullYear()+'">'+(new Date()).getFullYear()+'</option></select>');
			}else if ($('#criteriaUpdateDD').val() == "daily") {
				$('#crtieriaDefinitionUpdateDiv').html('<select class="form-control" id="definitionUpdateDD" style="display: inline;"><option value="monday">MONDAY</option><option value="tuesday">TUESDAY</option><option value="wednesday">WEDNESDAY</option><option value="thursday">THURSDAY</option><option value="friday">FRIDAY</option><option value="saturday">SATURDAY</option><option value="sunday">SUNDAY</option></select>');
			}
			$('#definitionUpdateDD').val($('#definition').val());
		}else{

			var calcPercentage = 0;
			var percentages = $('.targetSpanParent .percentagesInput').map(function() {
				calcPercentage += parseInt(this.value);
				return $.trim(this.value);
			}).get().clean("");

			if (calcPercentage != 100) {
				swal('Percentage Not Balanced', 'Please divide the targets in the total of 100%', 'error');
				return;
			}

			$('#updateTargetsBtn').removeClass('btn-success');
			$('#updateTargetsText').hide();
			$('.updateTargetsSpinner').fadeIn();
			$('button').attr('disabled', true);

			$(this).find("#updateTargetsText").text("Update Targets");

			var targets = $('.targetSpanParent .targetsInput').map(function() {
				return $.trim(this.value);
			}).get().clean("");

			var ajaxData = {
				id: $('#rowId').val(),
				criteria : $('#criteriaUpdateDD').val(),
				definition: $('#definitionUpdateDD').val(),
				target_sale: $('#targetSaleInput').val(),
				targets: targets.join('<>'),
				percentages: percentages.join('<>')
			}

			ajaxer('updateEmployeeTargets.php', ajaxData, function(response){
				if (response == "Updated") {
					fetchEmpTargets(target);
					$('span#criteriaSpan').fadeIn();
					$('span#quarterSpan').fadeIn();
					$('span#targetSale').fadeIn();
					$('.targetSpanParent span').fadeIn();
					$('#cancelCommitBtn').hide();
					$('#addNewTargetBtn').hide();
					$('#criteriaUpdateDD').hide();
					$('#crtieriaDefinitionUpdateDiv').hide();
					$('#targetSaleInput').hide();
					$('.targetSpanParent input').hide();
				}else{
					document.write(response);
					swal('Failed', 'Unable to update employee targets', 'error');
				}
				$('#updateTargetsBtn').addClass('btn-success');
				$('#updateTargetsText').fadeIn();
				$('.updateTargetsSpinner').hide();
				$('button').attr('disabled', false);
				return;
			});
		}
	});

$('#cancelCommitBtn').click(function(){
	$(this).hide();
	$('#addNewTargetBtn').hide();	
	$('#updateTargetsBtn').find("#updateTargetsText").text("Update Targets");
	$('span#criteriaSpan').fadeIn();
	$('span#quarterSpan').fadeIn();
	$('span#targetSale').fadeIn();
	$('.targetSpanParent span').fadeIn();
	$('#criteriaUpdateDD').hide();
	$('#crtieriaDefinitionUpdateDiv').hide();
	$('#targetSaleInput').hide();
	$('.targetSpanParent input').hide();
	$('.deleteTargetsBtn').map(function() {
		$(this).hide();
	}).get();
	fetchEmpTargets(target);
});
});

function showLoader(target){
	var targetLoader = target;
	var targetBody = $(targetLoader).find('.panel-body');
	var spinnerHtml = '<div class="panel-loader"><span class="spinner-small"></span></div>';
	$(targetLoader).addClass('panel-loading');
	$(targetBody).prepend(spinnerHtml);
}

function fetchEmpTargets(target){

	var criteriaDefinition = '';

	$.each($("#definition option:selected"), function(){
		criteriaDefinition = $(this).val()
	});

	var ajaxData = {
		employee: $('#employeeId').val(),
		criteria: $('#criteria').val(),
		definition: criteriaDefinition
	}

	ajaxer('getEmployeeTargets.php', ajaxData, function(response){
		var response = JSON.parse(response);

		if (response.length == 0) {
			$('.employeeTargetDetails').css('display', 'none');
			$('.noDataFound').fadeIn();
			$('#updateTargetsBtn').hide();
			hideLoader(target);
			return;
		}else{
			$('.employeeTargetDetails').css('display', '');
			$('.noDataFound').hide();
			$('#updateTargetsBtn').show();
		}
		var targets = response.targets.split("<>");
		var percentages = response.percentage.split("<>");
		$('#targetsDynamic ul').empty();
		for (var i = 0; i < targets.length; i++) {
			$('#targetsDynamic ul').append('<li><div class="row"><div class="col-md-10 targetSpanParent"><div class="row"><div class="col-md-9"><span id="targetSpan'+i+'" style="width: 50%">'+targets[i]+'</span></div><div class="col-md-3" style="text-align: center"><strong><span style="margin-left: 5%">'+percentages[i]+'%</span></strong></div></div><div class="row"><div class="col-md-11"><input class="form-control targetsInput" id="updateTargetsInput'+i+'" value="'+targets[i]+'" style="display: none;"/></div><div class="col-md-1"><input type="number" class="form-control percentagesInput" id="updatePercentagesInput'+i+'" value="'+percentages[i]+'" style="display: none;"/></div></div></div><div class="col-md-2"><button class="btn btn-sm btn-danger deleteTargetsBtn" id="'+i+'" style="margin-left: 5px">Delete</button></div></div></li>');
			$('.deleteTargetsBtn').hide();
			totalListItems++;
		}

		$('#rowId').val(response.id);
		$('#criteriaSpan').text($("#criteria option:selected").text());
		$('#quarterSpan').text($("#definition option:selected").text());
		$('#targetSale').text(response.sale);
		$('#targetSaleInput').val(response.sale);
		hideLoader(target);
		return;
	});

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

Array.prototype.clean = function(deleteValue) {
	for (var i = 0; i < this.length; i++) {
		if (this[i] == deleteValue) {         
			this.splice(i, 1);
			i--;
		}
	}
	return this;
};