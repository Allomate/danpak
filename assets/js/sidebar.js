$(document).ready(function() {

    $(document).on('click', '#deactivatedProducts', function(e) {
        e.preventDefault();
        setCookie('deactivated_products_list', 'true', 1);
        window.location.href = "/Inventory/ListInventory";
        window.location.href = $(this).attr('href');
    });

    $(document).on('click', '#activatedProducts', function(e) {
        e.preventDefault();
        setCookie('deactivated_products_list', 'true', -1);
        window.location.href = $(this).attr('href');
    });

    $.ajax({
        type: 'POST',
        url: $('#getAccRightsUrlAjax').val(),
        success: function(response) {
            if (response && response !== "null") {
                var response = JSON.parse(response);
                delete response["id"];
                delete response["admin_id"];
                $('.side-nav li li').each(function() {
                    if ($(this).find('a').attr("href") != "javascript:void(0);") {
                        var url = decodeURIComponent($(this).find('a').attr("href")).split("/");
                        var lastSegment;
                        if (url[4] == "ListRetailers") {
                            lastSegment = "ListRetailers";
                        } else {
                            lastSegment = url.pop() || url.pop();
                        }
                        if (response[lastSegment] !== "1") {
                            $(this).find('a').parent().remove();
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
                            $(this).find('ul').parent().remove();
                        }
                    } else {
                        if ($(this).find('a').attr("href") != "javascript:void(0);") {
                            var url = decodeURIComponent($(this).find('a').attr("href")).split("/");
                            var lastSegment;
                            if (url[4] == "ListRetailers") {
                                lastSegment = "ListRetailers";
                            } else {
                                lastSegment = url.pop() || url.pop();
                            }
                            if (response[lastSegment] !== "1") {
                                $(this).find('a').parent().remove();
                            }
                        }
                    }
                });
            } else {
                window.location = "/Login/SignOut";
            }

            $('.side-nav').show();
        }
    });

    $.ajax({
        type: 'POST',
        url: $('#getUserProfile').val(),
        success: function(response) {
            $('.user-auth-img').attr('src', $('.user-auth-img').attr('src') + response);
        }
    });

});

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}