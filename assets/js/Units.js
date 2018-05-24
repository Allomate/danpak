$(document).ready(function(){

	$('#updateUnitButton').click(function(){
		$(this).attr('disabled', 'disabled');
		$('#backFromAddUnitButton').attr('disabled', 'disabled');
		$('#updateUnitForm').submit();
	});

	$('#addUnitButton').click(function(){
		$(this).attr('disabled', 'disabled');
		$('#backFromAddUnitButton').attr('disabled', 'disabled');
		$('#addUnitForm').submit();
	});

});