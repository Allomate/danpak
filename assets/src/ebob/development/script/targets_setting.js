$(document).ready(function(){
	
	var target = $('.targetsPanel');

	var totalTargets = 1;
	$('#targetsSettingPanelBody').append('<div class="row"><div class="form-group"><label class="col-md-1 control-label targetLabel" id="'+totalTargets+'" style="line-height: 40px;">Target # ' + totalTargets + ':</label><div class="col-md-8" style="padding: 0px"><textarea class="form-control" rows="2" cols="20" id="target'+totalTargets+'" ></textarea></div><div class="col-md-1"><input type="number" class="form-control" id="targetsPercentage" style="height: 45px" /></div><div class="col-md-2" style="line-height: 34px;"><button class="btn btn-danger removeTarget" id="'+totalTargets+'">Remove</button></div></div></div><br>');
	totalTargets++;

	$(document).on('click', '.addTargets', function(e) {
		$('#targetsSettingPanelBody').append('<div class="row"><div class="form-group"><label class="col-md-1 control-label targetLabel" id="'+totalTargets+'" style="line-height: 40px;">Target # ' + totalTargets + ':</label><div class="col-md-8" style="padding: 0px"><textarea class="form-control" rows="2" cols="20" id="target'+totalTargets+'" ></textarea></div><div class="col-md-1"><input type="number" class="form-control" id="targetsPercentage" style="height: 45px" /></div><div class="col-md-2" style="line-height: 34px;"><button class="btn btn-danger removeTarget" id="'+totalTargets+'">Remove</button></div></div></div><br>');
		totalTargets++;
	});

	$('#criteria').change(function(){
		if ($(this).val() == "quarterly") {
			$(this).css('width', '50%');
			$('#crtieriaDefinition').html('<select class="form-control" id="definition" style="width: 48%; display: inline;"><option value="q1">Q1</option><option value="q2">Q2</option><option value="q3">Q3</option><option value="q4">Q4</option></select>');
		}else if ($(this).val() == "monthly") {
			$(this).css('width', '50%');
			$('#crtieriaDefinition').html('<select class="form-control" id="definition" style="width: 48%; display: inline;"><option value="jan">JAN</option><option value="feb">FEB</option><option value="mar">MAR</option><option value="apr">APR</option><option value="may">MAY</option><option value="jun">JUN</option><option value="jul">JUL</option><option value="aug">AUG</option><option value="sep">SEP</option><option value="oct">OCT</option><option value="nov">NOV</option><option value="dec">DEC</option></select>');
		}else if ($(this).val() == "annually") {
			$(this).css('width', '50%');
			$('#crtieriaDefinition').html('<select class="form-control" id="definition" style="width: 48%; display: inline;"><option value="'+(new Date()).getFullYear()+'">'+(new Date()).getFullYear()+'</option></select>');
		}else if ($(this).val() == "daily") {
			$(this).css('width', '50%');
			$('#crtieriaDefinition').html('<select class="form-control" id="definition" style="width: 48%; display: inline;"><option value="monday">MONDAY</option><option value="tuesday">TUESDAY</option><option value="wednesday">WEDNESDAY</option><option value="thursday">THURSDAY</option><option value="friday">FRIDAY</option><option value="saturday">SATURDAY</option><option value="sunday">SUNDAY</option></select>');
		}
	});

	$('#submitTargetsButton').click(function(){
		var criteriaDefinition = '';
		$.each($("#definition option:selected"), function(){
			criteriaDefinition = $(this).val()
		});
		var targets = $('textarea').map(function() {
			return $.trim(this.value);
		}).get().clean("");

		var calcPercentage = 0;
		var percentage = $('input#targetsPercentage').map(function() {
			calcPercentage += parseInt(this.value);
			return $.trim(this.value);
		}).get().clean("");

		if (calcPercentage != 100) {
			swal('Percentage Not Balanced', 'Please divide the targets in the total of 100%', 'error');
			return;
		}

		var ajaxData = {
			targets : targets.join("<>"),
			percentage: percentage.join("<>"), 
			criteria: $('#criteria').val(),
			employee_id : $('#employeeId').val(),
			target_sale : $('#targetSale').val(),
			criteria_definition: criteriaDefinition
		}
		
		$('#submitTargetsButton').removeClass('btn-success');
		$('.submitTargetsSpinner').fadeIn();
		$('#submitTargetsText').hide();
		$('button').attr('disabled', true);
		
		ajaxer('setEmployeeTargets.php', ajaxData, function(response){
			if (response == "Success") {
				$('#submitTargetsButton').addClass('btn-success');
				$('.submitTargetsSpinner').hide();
				$('#submitTargetsText').fadeIn();
				$('button').attr('disabled', false);	
				swal('Targets Submitted', 'Targets have been submitted', 'success');
			}else{
				document.write(response);
				swal('Failed', 'Something went wrong while uploading the targets', 'error');
			}
			return;
		});

	});

	$(document).on('click', '.removeTarget', function(e) {
		if ($('.targetLabel').length <= 1) {
			swal('Sorry', 'Unable to delete this target as it is the only one', 'error');
			return;
		}
		showLoader(target);
		$(this).parent().parent().parent().remove();
		var targets = $('textarea').map(function() {
			return $.trim(this.value);
		}).get();

		var percentage = $('input#targetsPercentage').map(function() {
			return $.trim(this.value);
		}).get();

		$('#targetsSettingPanelBody').empty();
		totalTargets = 1;
		for (var i = 0; i < targets.length; i++) {
			$('#targetsSettingPanelBody').append('<div class="row"><div class="form-group"><label class="col-md-1 control-label targetLabel" id="'+totalTargets+'" style="line-height: 40px;">Target # ' + totalTargets + ':</label><div class="col-md-8" style="padding: 0px"><textarea class="form-control" rows="2" cols="20" id="target'+totalTargets+'" >'+targets[i]+'</textarea></div><div class="col-md-1"><input type="number" class="form-control" id="targetsPercentage" value="'+percentage[i]+'" style="height: 45px" /></div><div class="col-md-2" style="line-height: 34px;"><button class="btn btn-danger removeTarget" id="'+totalTargets+'">Remove</button></div></div></div><br>');
			totalTargets++;
		}
		hideLoader(target);
	});

});

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

Array.prototype.clean = function(deleteValue) {
	for (var i = 0; i < this.length; i++) {
		if (this[i] == deleteValue) {         
			this.splice(i, 1);
			i--;
		}
	}
	return this;
};