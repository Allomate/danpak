$(document).ready(function(){

	$('.viewInboxComplain').click(function(){
		createCookie('commentDetail', $(this).attr('id'), 1);
		window.open('inbox.php', '_blank');
		return;
	});

	$(".changePictureBtn").click(function() {
		$('.updateProfileBtn').css('display', '');		
	});

	$(".updateProfileBtn").click(function() {
		swal({
			title: 'Are you sure?',
			showCancelButton: true,
			confirmButtonText: 'Yes',
			showLoaderOnConfirm: true,
			preConfirm: function () {
				return new Promise(function (resolve, reject) {
					$('#profImgUpload').ajaxSubmit({
						type: "POST",
						url: 'ajax_scripts/uploadProfilePicture.php',
						data: $('#profImgUpload').serialize(),
						cache: false,
						success: function (response) {
							var response = JSON.parse(response);
							if (response.status == "success") {
								swal('Updated', 'Profile picture has been updated', 'success');
								$('.profile-image img').attr('src', response.image);
							}else{
								swal('Failed', 'Unable to upload picture at the moment', 'error');
							}
							$('.updateProfileBtn').fadeOut();
							return;
						}
					});
				})
			},
			allowOutsideClick: false
		})
	});

});

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