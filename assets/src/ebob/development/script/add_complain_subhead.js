$(document).ready(function(){
	$('#subHeadLevel2Div').css('display', 'none');
	$('#subHeadLevel3Div').css('display', 'none');
	document.getElementById("level").value = "1";

	$(document).on('change',"#subHeadLevel1 #complainSubHeadLevel1",function(){
		if($('#subHeadLevels').val() == "3"){
			$('body').addClass('loading');
			debugger;
			$.ajax({
				type:'POST',
				data: { complainHead: $('#complainHead').val(), complainHeadLevel1: $('#complainSubHeadLevel1').val() ,
				level: $('#subHeadLevels').val() },
				url: "ajax_scripts/getComplainSubHeads.php",
				success: function(data) {
					debugger;
					var data = JSON.parse(data);
					if(data.length == 0){
						$('body').removeClass('loading');
						alert("Sorry! This complain sub-head doesn't contain any further subheads");
						return;
					}
					$('#subHeadLevel2').empty();
					$('#subHeadLevel2').append("<select class='form-control' name='complainSubHeadLevel2' id='complainSubHeadLevel2'></select>");
					for (var i = 0; i < data.length; i++) {
						$('#complainSubHeadLevel2').append($('<option>', {
							value: data[i]["id"],
							text: data[i]["subhead"]
						}));
					}
					$('body').removeClass('loading');
				}
			});
		}
	});

	$('#complainHead').change(function(){
		if($('#subHeadLevels').val() == "2"){
			$('body').addClass('loading');
			$.ajax({
				type:'POST',
				data: { complainHead: $('#complainHead').val(), level: $('#subHeadLevels').val() },
				url: "ajax_scripts/getComplainSubHeads.php",
				success: function(data) {
					var data = JSON.parse(data);
					if(data.length == 0){
						alert("Sorry! This complain sub-head doesn't contain any further subheads");
						return;
					}
					$('#subHeadLevel1').empty();
					$('#subHeadLevel1').append("<select class='form-control' name='complainSubHeadLevel1' id='complainSubHeadLevel1'></select>");
					for (var i = 0; i < data.length; i++) {
						$('#complainSubHeadLevel1').append($('<option>', {
							value: data[i]["id"],
							text: data[i]["subhead"]
						}));
					}
					$('body').removeClass('loading');
				}
			});
		}else if($('#subHeadLevels').val() == "3"){
			$('body').addClass('loading');
			$.ajax({
				type:'POST',
				data: { complainHead: $('#complainHead').val(), level: "2" },
				url: "ajax_scripts/getComplainSubHeads.php",
				success: function(data) {
					var data = JSON.parse(data);
					debugger;
					if(data.length == 0){
						alert("Sorry! This complain sub-head doesn't contain any further subheads");
						$('#subHeadLevels').val("1");
						return;
					}

					$('#subHeadLevel2Div').css('display', '');
					$('#subHeadLevel3Div').css('display', '');
					document.getElementById("level").value = "3";

					$('#subHeadLevel1').empty();
					$('#subHeadLevel1').append("<select class='form-control' name='complainSubHeadLevel1' id='complainSubHeadLevel1'></select>");
					for (var i = 0; i < data.length; i++) {
						$('#complainSubHeadLevel1').append($('<option>', {
							value: data[i]["id"],
							text: data[i]["subhead"]
						}));
					}

					$.ajax({
						type:'POST',
						data: { complainHead: $('#complainHead').val(), complainHeadLevel1: $('#complainSubHeadLevel1').val() ,
						level: $('#subHeadLevels').val() },
						url: "ajax_scripts/getComplainSubHeads.php",
						success: function(data) {
							debugger;
							var data = JSON.parse(data);
							$('#subHeadLevel2').empty();
							$('#subHeadLevel2').append("<select class='form-control' name='complainSubHeadLevel2' id='complainSubHeadLevel2'></select>");
							for (var i = 0; i < data.length; i++) {
								$('#complainSubHeadLevel2').append($('<option>', {
									value: data[i]["id"],
									text: data[i]["subhead"]
								}));
							}
							$('body').removeClass('loading');
						}
					});

				}
			});
		}
	});

	$('#subHeadLevels').change(function(){
		var subHeadLevel = parseInt($('#subHeadLevels').val());
		$('body').addClass('loading');
		if($('#subHeadLevels').val() == "2"){
			$.ajax({
				type:'POST',
				data: { complainHead: $('#complainHead').val(), level: $('#subHeadLevels').val() },
				url: "ajax_scripts/getComplainSubHeads.php",
				success: function(data) {
					var data = JSON.parse(data);
					if(data.length == 0){
						alert("Sorry! This complain head doesn't contain any subhead");
						$('#subHeadLevels').val(subHeadLevel-1);
						$('body').removeClass('loading');
						return;
					}

					$('#subHeadLevel2Div').css('display', '');
					$('#subHeadLevel3Div').css('display', 'none');
					document.getElementById("level").value = "2";
					$('#subHeadLevel1').empty();
					$('#subHeadLevel1').append("<select class='form-control' name='complainSubHeadLevel1' id='complainSubHeadLevel1'></select>");
					for (var i = 0; i < data.length; i++) {
						$('#complainSubHeadLevel1').append($('<option>', {
							value: data[i]["id"],
							text: data[i]["subhead"]
						}));
					}

					$('#subHeadLevel2').empty();
					$('#subHeadLevel2').append("<input type='text' class='form-control' name='complainSubHeadLevel2' placeholder='Complain Sub-Head Level 2 Name'>");

					$('body').removeClass('loading');
				}
			});
		}else if($('#subHeadLevels').val() == "3"){
			$.ajax({
				type:'POST',
				data: { complainHead: $('#complainHead').val(), level: "2" },
				url: "ajax_scripts/getComplainSubHeads.php",
				success: function(data) {
					var data = JSON.parse(data);

					if(data.length == 0){
						alert("Sorry! This complain sub-head doesn't contain any further subheads");
						$('#subHeadLevels').val(subHeadLevel-2);
						$('body').removeClass('loading');
						return;
					}

					$('#subHeadLevel2Div').css('display', '');
					$('#subHeadLevel3Div').css('display', '');
					document.getElementById("level").value = "3";

					$('#subHeadLevel1').empty();
					$('#subHeadLevel1').append("<select class='form-control' name='complainSubHeadLevel1' id='complainSubHeadLevel1'></select>");
					for (var i = 0; i < data.length; i++) {
						$('#complainSubHeadLevel1').append($('<option>', {
							value: data[i]["id"],
							text: data[i]["subhead"]
						}));
					}

					$.ajax({
						type:'POST',
						data: { complainHead: $('#complainHead').val(), complainHeadLevel1: $('#complainSubHeadLevel1').val() ,
						level: $('#subHeadLevels').val() },
						url: "ajax_scripts/getComplainSubHeads.php",
						success: function(data) {
							var data = JSON.parse(data);
							$('#subHeadLevel2').empty();
							$('#subHeadLevel2').append("<select class='form-control' name='complainSubHeadLevel2' id='complainSubHeadLevel2'></select>");
							for (var i = 0; i < data.length; i++) {
								$('#complainSubHeadLevel2').append($('<option>', {
									value: data[i]["id"],
									text: data[i]["subhead"]
								}));
							}
							$('body').removeClass('loading');
						}
					});

				}
			});
		}else{
			$('#subHeadLevel2Div').css('display', 'none');
			$('#subHeadLevel3Div').css('display', 'none');
			document.getElementById("level").value = "1";
			$('#subHeadLevel1').empty();
			$('#subHeadLevel1').append("<input type='text' class='form-control' name='complainSubHeadLevel1' placeholder='Complain Sub-Head Level 1 Name'>");
			$('body').removeClass('loading');
		}
	});

});
