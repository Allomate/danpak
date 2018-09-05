$(document).ready(function() {

    $(document).on('change', '#mainCategoryDd', function() {
        $.ajax({
            type: 'POST',
            url: $('input[name="subCatDataForAjax"]').val(),
            data: { main_category: $(this).val() },
            success: function(response) {
                var response = JSON.parse(response);
                $('select[name="sub_category_id"]').empty();
                for (var i = 0; i < response.length; i++) {
                    $('select[name="sub_category_id"]').append('<option value="' + response[i]['sub_category_id'] + '">' + response[i]['sub_category_name'] + '</option>');
                }
            }
        })
    });

    // $.ajax({
    //     type: 'POST',
    //     url: $('input[name="subCatDataForAjax"]').val(),
    //     data: { main_category: $('#mainCategoryDd').val() },
    //     success: function(response) {
    //         var response = JSON.parse(response);
    //         $('select[name="sub_category_id"]').empty();
    //         for (var i = 0; i < response.length; i++) {
    //             $('select[name="sub_category_id"]').append('<option value="' + response[i]['sub_category_id'] + '">' + response[i]['sub_category_name'] + '</option>');
    //         }
    //         $('select[name="sub_category_id"]').val($('input[name="subCatSelected"]').val());
    //     }
    // })

    $('#updateInventoryButton').click(function() {
        $('#updateInventoryForm').submit();
    });

    var hostName = window.location.protocol + '//' + window.location.hostname;
    $(document).on('click', '.deleteImages', function() {
        if ($('input[name="images_deleted"]').val() == '') {
            $('input[name="images_deleted"]').val($(this).parent().parent().find('img').attr('src').replace(hostName, "."));
        } else {
            $('input[name="images_deleted"]').val($('input[name="images_deleted"]').val() + ',' + $(this).parent().parent().find('img').attr('src').replace(hostName, "."));
        }
        $(this).parent().parent().remove();
    });

});