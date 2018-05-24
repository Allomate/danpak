$(document).ready(function() {

    $.ajax({
        type: 'POST',
        url: $('#getAccRightsUrlAjax').val(),
        success: function(response) {
            var response = JSON.parse(response);
            delete response["id"];
            delete response["admin_id"];
            $('.side-nav li li').each(function() {
                if ($(this).find('a').attr("href") != "javascript:void(0);") {
                    var url = decodeURIComponent($(this).find('a').attr("href")).split("/");
                    var lastSegment = url.pop() || url.pop();
                    if (response[lastSegment] !== "1") {
                        $(this).find('a').hide();
                    }
                }
            });

            $('.side-nav li').each(function() {
                if ($(this).find('ul').attr('id')) {
                    var anyVisibleItemInThisList = false;
                    $(this).find('ul li').each(function() {
                        if ($(this).find('a').css("display") !== "none") {
                            anyVisibleItemInThisList = true;
                        }
                    });
                    if (!anyVisibleItemInThisList) {
                        console.log($(this).find('ul').parent().hide());
                    }
                }
            });
        }
    });

});