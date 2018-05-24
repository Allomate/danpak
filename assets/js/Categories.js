$(document).ready(function(){

	$('#updateMainCatButton').click(function(){
		$(this).attr('disabled', 'disabled');
		$('#backFromUpdateMainCategories').attr('disabled', 'disabled');
		$('#updateMainCategoryForm').submit();
	});

	$('#addMainCatButton').click(function(){
		$(this).attr('disabled', 'disabled');
		$('#backFromAddMainCategories').attr('disabled', 'disabled');
		$('#addMainCategoryForm').submit();
	});

	$('#updateSubCatButton').click(function(){
		$(this).attr('disabled', 'disabled');
		$('#backFromUpdateSubCategories').attr('disabled', 'disabled');
		$('#updateSubCategoryForm').submit();
	});

	$('#addSubCatButton').click(function(){
		$(this).attr('disabled', 'disabled');
		$('#backFromAddSubCategories').attr('disabled', 'disabled');
		$('#addSubCategoryForm').submit();
	});

});