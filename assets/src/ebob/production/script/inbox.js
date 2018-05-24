$(document).ready(function(){

	var counterDeal = false;
	$('#resolutionBox').keydown(updateCount);
	$('#resolutionBox').keyup(updateCount);

	checkIfCrankFunction();

	$('#crankCustomer').click(function(){
		if($(this).html() == "Add to Crank List"){
			crankCustomerFunction("add");
			$(this).html("Remove from Crank List");
		}else if($(this).html() == "Remove from Crank List"){
			crankCustomerFunction("remove");
			$(this).html("Add to Crank List");
		}
	});

	getComplainsData("pending");

	$('form').keypress(function(e){
		if ( e.which == 13 )
		{
			$(this).next().focus();
			return false;
		}
	});

	$("#searchComplain").on('keyup', function (e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			getSearchedComplain($('#searchComplain').val());
		}
	});

	$('.navbar-nav li form .form-group button').click(function(){
		getSearchedComplain($('#searchComplain').val());
	});

	$(document).on('click', '.userComplain', function (e) {
		createCookie("commentDetail", $(this).attr("id"), 1);
		location.reload();
	});	

	$(document).on('click', '#goBackButton', function (e) {
		eraseCookie("commentDetail");
		location.reload();
	});	

	$('#resolvedComplains').click(function(){
		$('.nav-pills li').removeClass('active');
		getComplainsData("resolved");
		$('#resolvedTab').addClass('active');
	});

	$('#pendingComplains').click(function(){
		$('.nav-pills li').removeClass('active');
		getComplainsData("pending");
		$('#pendingTab').addClass('active');
	});

	$('#counterDeal').click(function(){
		if($(this).html() == "COUNTER DEAL"){
			$(this).html("CANCEL DEAL");
			$(this).css('background-color','red');
			$('#rewardPointsDiv').fadeIn();
			counterDeal = true;
		}
		else{
			$(this).html("COUNTER DEAL");
			$(this).css('background-color','#815082');
			$('#rewardPointsDiv').fadeOut();
			counterDeal = false;
		}
	});

	$('#submitResolution').click(function(){
		if($('#resolutionBox').val() != ""){
			if(counterDeal){
				submitResolutionFunction($('#rewardPoints').val(), $('#discountPrice').val(), $('#productId').val(), 1);
			} else{
				submitResolutionFunction(0,0,0,0);
			}
		}else{
			swal(
				'Missing Field',
				'Please provide resolution in resolution box',
				'error'
				);
			return;
		}
	});

});

function checkIfCrankFunction(){
	$.ajax({
		type: 'POST',
		data: { userEmail: $('#hiddenEmail').val() },
		url: './ajax_scripts/checkIfCrank.php',
		success: function(data){
			if (data == "Crank") {
				$('#crankCustomer').html('Remove from Crank List');
				$('#crankCustomerDiv').css('display', '');
			}else if (data == "Less Complains") {
				$('#crankCustomer').html('Add to Crank List');
			}else if (data == "Not Cranked") {
				$('#crankCustomer').html('Add to Crank List');
				$('#crankCustomerDiv').css('display', '');
			}
		}
	});
}

function crankCustomerFunction(crank){
	$.ajax({
		type: 'POST',
		data: { userEmail: $('#hiddenEmail').val(), crankOp: crank },
		url: './ajax_scripts/crankCustomers.php',
		success: function(data){
			if(data == "Added"){
				swal({
					title: 'Cranked',
					type: 'success',
					text: 'This user is added to crank customers list successfully',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Ok'
				});
			}else if(data == "Removed"){
				swal({
					title: 'Un-Cranked',
					type: 'success',
					text: 'This user is removed from crank list successfully',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Ok'
				});
			}else{
				document.write(data);
				return;
			}
		}
	});
}

function submitResolutionFunction(rewardPoints, discountPrice, productId, isDeal){
	$.ajax({
		type:'POST',
		data: { resolutionComments: $('#resolutionBox').val(), complainId: getCookie("commentDetail"), reward: rewardPoints,
		discount: discountPrice, product: productId, deal: isDeal},
		url: "./ajax_scripts/submitComplainResolutionInbox.php",
		success: function(data) {
			if(data == ""){
				swal({
					title: 'Resolved',
					type: 'success',
					text: 'This complain has been resolved successfully!',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Ok'
				}).then(function () {
					setTimeout(function(){
						location.reload();
					},250);
				})
			}
			else{
				if(data == "Already resolved"){
					swal({
						title: 'Error',
						type: 'error',
						text: 'Complaint has already been resolved',
						showCancelButton: false,
						confirmButtonColor: '#ff0000',
						confirmButtonText: 'Ok'
					}).then(function () {
						setTimeout(function(){
							location.reload();
						},250);
					})
				}else{
					swal(
						'Error...',
						data,
						'error'
						)
				}
				return;
			}
		},
		error:function(jqXHR,textStatus,errorThrown ){
			alert('Exception:'+errorThrown );
		}
	});
}

function getComplainsData(status){
	showLoader();
	$.ajax({
		url: 'ajax_scripts/getPendingResolvedComplains.php',
		type: 'POST',
		data: { complainStatus: status },
		success: function(data){
			var data = JSON.parse(data);
			$('.pendingComplainsUl').empty();
			for (var i = 0; i < data.length; i++) {
				$('.pendingComplainsUl').append('<li class="list-group-item inverse userComplain" style="cursor: pointer;" id="'+data[i]["complainId"]+'"><a class="email-user"><img src="assets/img/user-14.jpg" alt="" /></a><div class="email-info"><span class="email-time">'+data[i]["time"]+'</span><h5 class="email-title"><a>'+data[i]["user"]+'</a></h5><p class="email-desc">'+data[i]["comments"]+'</p> </div> </li>');
			}
			hideLoader();
		}
	});
}

function updateCount() {
	var cs = $(this).val().length;
	$('#maxLength').text(500 - cs);
}

function eraseCookie(name) {
	createCookie(name, "", -1);
}

function getSearchedComplain(complainId){
	showLoader();
	var ajaxData = { id: complainId };

	if (complainId == "") {
		ajaxData = { id: complainId, complainStatus: "pending" };
	}

	$.ajax({
		type: 'POST',
		data: ajaxData,
		url: './ajax_scripts/getComplainBySearch.php',
		success: function(data){
			var data = JSON.parse(data);
			if (data.length > 0) {
				$('.pendingComplainsUl').empty();
				for (var i = 0; i < data.length; i++) {
					$('.pendingComplainsUl').append('<li class="list-group-item inverse userComplain" style="cursor: pointer;" id="'+data[i]["complainId"]+'"><a class="email-user"><img src="assets/img/user-14.jpg" alt="" /></a><div class="email-info"><span class="email-time">'+data[i]["time"]+'</span><h5 class="email-title"><a>'+data[i]["user"]+'</a></h5><p class="email-desc">'+data[i]["comments"]+'</p> </div> </li>');
				}
			}
			hideLoader();
		}
	});
}

function createCookie(name, value, days) {
	var expires;

	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		expires = "; expires=" + date.toGMTString();
	} else {
		expires = "";
	}
	document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function getCookie(name) {
	var dc = document.cookie;
	var prefix = name + "=";
	var begin = dc.indexOf("; " + prefix);
	if (begin == -1) {
		begin = dc.indexOf(prefix);
		if (begin != 0) return null;
	}
	else
	{
		begin += 2;
		var end = document.cookie.indexOf(";", begin);
		if (end == -1) {
			end = dc.length;
		}
	}
    // because unescape has been deprecated, replaced with decodeURI
    //return unescape(dc.substring(begin + prefix.length, end));
    return decodeURI(dc.substring(begin + prefix.length, end));
} 

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