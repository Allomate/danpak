$(document).ready(function(){
	
	$(document).on('click', '.viewCatalogueContents', function(e){
		var catalogueId = $(this).attr('id');
		$.ajax({
			url: $('#baseUrlField').val(),
			type: 'POST',
			data: { test: "123" },
			success: function(response){
				document.write(response);
			}
		});
	});
	
});