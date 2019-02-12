$(document).ready(function() {

    $('#addEmployeeButton').click(function() {
        $(this).attr('disabled', 'disabled');
        $('#backFromEmployeeButton').attr('disabled', 'disabled');
        $('#addEmployeeForm').submit();
    });

    $(document).on('click', '.dropify-clear', function() {
        $('input[name="picture_deleted"]').val('deleted');
    });

    $('#updateEmployeeButton').click(function() {
        $(this).attr('disabled', 'disabled');
        $('#backFromEmployeeButton').attr('disabled', 'disabled');
        $('#updateEmployeeForm').submit();
    });

});