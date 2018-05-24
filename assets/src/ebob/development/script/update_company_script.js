$(document).ready(function(){

	$('#companyNameInput').val($("#companyId option:selected").text());
	$('#companyName').text($("#companyId option:selected").text());
	$('#companyIdInput').val($("#companyId").val());
	showLoader();
	$.ajax({
		type: 'POST',
		url: 'ajax_scripts/getFranchisesForCompany.php',
		data: { companyId: $('#companyId').val() },
		success: function(data){
			var data = JSON.parse(data);
			$('#locationId').empty();
			for (var i = 0; i < data["id"].length; i++) {
				$("#locationId").append("<option value='"+data["id"][i]+"'>"+data["name"][i]+"</option>");
			}

			$.ajax({
				type: 'POST',
				url: 'ajax_scripts/getFranchisesDetails.php',
				data: { locationId: $('#locationId').val() },
				success: function(data){
					var data = JSON.parse(data);
					$("#locationName").text(data["name"][0]);
					$("#locationCity").text(data["city"][0]);
					$("#locationAddress").text(data["address"][0]);
					$('#locationNameInput').val(data["name"][0]);
					$('#locationCityInput').val(data["city"][0]);
					$('#locationAddressInput').val(data["address"][0]);
					$('#locationIdInput').val(data["id"][0]);

					$('#locationRegion').text(data["regions"][0]);
					if(data["areas"][0] == null)
						$('#locationArea').text("Un-Assigned");
					else
						$('#locationArea').text(data["areas"][0]);

					$('#locationRegionDD').val(data["regionId"]);
					$('#locationAreaDD').val(data["areaId"]);

				}
			});
			hideLoader();
		}
	});

	$('button#updateLocation').click(function(){
		if($(this).html() == "Save"){
			$('#updateFranchiseForm').submit();
		}else{
			$(this).html("Save");
			$('#locationNameInput').css('display', '');
			$('#locationCityInput').css('display', '');
			$('#locationAddressInput').css('display', '');
			$('#locationInput').css('display', '');
			$('#locationRegionDD').css('display', '');
			$('#locationAreaDD').css('display', '');
			$('#locationName').css('display', 'none');
			$('#locationCity').css('display', 'none');
			$('#locationRegion').css('display', 'none');
			$('#locationArea').css('display', 'none');
			$('#locationAddress').css('display', 'none');
			$('#cancelLocationButton').css('display', '');
		}
	});

	$('button#cancelLocationButton').click(function(){
		$("#updateLocation").html("Update");
		$('#locationNameInput').css('display', 'none');
		$('#locationCityInput').css('display', 'none');
		$('#locationAddressInput').css('display', 'none');
		$('#locationRegionDD').css('display', 'none');
		$('#locationAreaDD').css('display', 'none');
		$('#locationName').css('display', '');
		$('#locationCity').css('display', '');
		$('#locationRegion').css('display', '');
		$('#locationArea').css('display', '');
		$('#locationAddress').css('display', '');
		$('#cancelLocationButton').css('display', 'none');
	});

	$('button#updateCompany').click(function(){
		if($(this).html() == "Save"){
			$('#updateCompanyForm').submit();
		}else{
			$(this).html("Save");
			$('#companyNameInput').css('display', '');
			$('#companyName').css('display', 'none');
			$(this).css('width', '70%');
			setTimeout(function(){
				$('#cancelButton').css('display', '');
			}, 200);
		}
	});

	$('button#cancelButton').click(function(){
		$(this).css('display', 'none');
		$('#companyNameInput').css('display', 'none');
		$('#companyName').css('display', '');
		$("button#updateCompany").html("Update");
		$("button#updateCompany").css('width', '100%');
	});

	$('#companyId').change(function(){
		$('#companyNameInput').val($("#companyId option:selected").text());
		$('#companyName').text($("#companyId option:selected").text());
		$('#companyIdInput').val($("#companyId").val());

		showLoader();
		$.ajax({
			type: 'POST',
			url: 'ajax_scripts/getFranchisesForCompany.php',
			data: { companyId: $('#companyId').val() },
			success: function(data){
				var data = JSON.parse(data);
				$('#locationId').empty();
				for (var i = 0; i < data["id"].length; i++) {
					$("#locationId").append("<option value='"+data["id"][i]+"'>"+data["name"][i]+"</option>");
				}

				$.ajax({
					type: 'POST',
					url: 'ajax_scripts/getFranchisesDetails.php',
					data: { locationId: $('#locationId').val() },
					success: function(data){
						var data = JSON.parse(data);
						$("#locationName").text(data["name"][0]);
						$("#locationCity").text(data["city"][0]);
						$("#locationAddress").text(data["address"][0]);
						$('#locationNameInput').val(data["name"][0]);
						$('#locationCityInput').val(data["city"][0]);
						$('#locationAddressInput').val(data["address"][0]);
						$('#locationIdInput').val(data["id"][0]);

						$('#locationRegion').text(data["regions"][0]);
						if(data["areas"][0] == null)
							$('#locationArea').text("Un-Assigned");
						else
							$('#locationArea').text(data["areas"][0]);

						$('#locationRegionDD').val(data["regionId"]);
						$('#locationAreaDD').val(data["areaId"]);
					}
				});
				hideLoader();
			}
		});
	});

	$('#locationId').change(function(){
		showLoader();
		$.ajax({
			type: 'POST',
			url: 'ajax_scripts/getFranchisesDetails.php',
			data: { locationId: $('#locationId').val() },
			success: function(data){
				var data = JSON.parse(data);
				$("#locationName").text(data["name"][0]);
				$("#locationCity").text(data["city"][0]);
				$("#locationAddress").text(data["address"][0]);
				$('#locationNameInput').val(data["name"][0]);
				$('#locationCityInput').val(data["city"][0]);
				$('#locationAddressInput').val(data["address"][0]);
				$('#locationIdInput').val(data["id"][0]);

				$('#locationRegion').text(data["regions"][0]);
				if(data["areas"][0] == null)
					$('#locationArea').text("Un-Assigned");
				else
					$('#locationArea').text(data["areas"][0]);

				$('#locationRegionDD').val(data["regionId"]);
				$('#locationAreaDD').val(data["areaId"]);
				hideLoader();
			}
		});
	});

	function showLoader(){
		$('#page-loader').removeClass();
		$('#page-loader').addClass('fade');
		$('#page-loader').addClass('in');
	}

	function hideLoader(){
		$('#page-loader').removeClass();
		if(!$('#page-loader').hasClass('fade')){
			$('#page-loader').addClass('fade');
		}
	}

});