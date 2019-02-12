$(document).ready(function() {

    $('#addAccessRightsButton').click(function() {

        if ($('select[name="admin_id"]').val() == "null" && $('select[name="distributor_id"]').val() == "null") {
            alert('Please select employee or distributor');
            return;
        }

        if ($('select[name="admin_id"]').val() != "null" && $('select[name="distributor_id"]').val() != "null") {
            alert('Please select employee or distributor but not both');
            return;
        }

        $(this).attr('disabled', 'disabled');
        $('#backFromNewAccRightsButton').attr('disabled', 'disabled');

        var selected = [];
        $('input[name="access_rights"]:not(:checked)').each(function() {
            selected.push($(this).attr('value') + '=0');
        });

        $('input[name="access_rights"]:checked').each(function() {
            selected.push($(this).attr('value') + '=1');
        });

        $('#permisData').val(selected.join(','));

        $('#addAccessRightsForm').submit();
    });

    $(document).on('click', '.deleteConfirmation', function(e) {
        var thisRef = $(this);
        e.preventDefault();
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.location.href = thisRef.attr('href');
            }
        })
    });

    $('#updateAccessRightsButton').click(function() {

        if ($('select[name="admin_id"]').val() == "null" && $('select[name="distributor_id"]').val() == "null") {
            alert('Please select employee or distributor');
            return;
        }

        if ($('select[name="admin_id"]').val() != "null" && $('select[name="distributor_id"]').val() != "null") {
            alert('Please select employee or distributor but not both');
            return;
        }

        $(this).attr('disabled', 'disabled');
        $('#backFromNewAccRightsButton').attr('disabled', 'disabled');

        var selected = [];
        $('input[name="access_rights"]:not(:checked)').each(function() {
            selected.push($(this).attr('value') + '=0');
        });

        $('input[name="access_rights"]:checked').each(function() {
            selected.push($(this).attr('value') + '=1');
        });

        $('#permisData').val(selected.join(','));

        $('#updateAccessRightsForm').submit();
    });

    if ($('#updateUrl').length) {
        debugger;
        $.ajax({
            type: 'POST',
            url: $('#updateUrl').val(),
            data: { id: $('#currentRecord').val() },
            success: function(response) {
                var response = JSON.parse(response);
                $.each(response, function(key, value) {
                    if (value == "1" || value == 1) {
                        if (key != 'id' && key != 'admin_id')
                            $('input[value="' + key + '"]').prop('checked', true);
                    }
                });
            }
        });
    }

});