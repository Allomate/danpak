$(document).ready(function() {
    var retailersAddedForAssignment = [];
    var url = window.location.href;

    if (url.indexOf("UpdateRetailersAssignments") >= 0) {
        $('#retailersForAssignments').val().split(",").forEach(function(item) {
            retailersAddedForAssignment.push(item);
        });
    }

    $('.table').DataTable();
    $('.dataTables_wrapper').hide();
    setTimeout(function() {
        $('select[name="DataTables_Table_0_length"]').css({
            'font-size': '10pt',
            'margin': '0px 10px 0px 10px'
        });
        $('select[name="DataTables_Table_0_length"]').parent().parent().parent().parent().width('100%');
        $('select[name="DataTables_Table_0_length"]').parent().parent().css('float', 'left');
        $('.dataTables_filter').css('float', 'right');
        $('.table').parent().parent().width('100%');
        $('.dataTables_paginate').parent().parent().width('100%');
        $('#loaderImg').hide();
        $('.table').fadeIn();
        $('.dataTables_wrapper').fadeIn();
    }, 300);

    $('#addRetailersAssignmentsButton').click(function() {
        if (!retailersAddedForAssignment.length) {
            alert('Please add distributors');
            return;
        }
        $(this).attr('disabled', 'disabled');
        $('#backFromRetailersAssignmentsButton').attr('disabled', 'disabled');
        $('#addRetailerAssignmentForm').submit();
    });

    $('#addRetailerTypeButton').click(function() {
        $(this).attr('disabled', 'disabled');
        $('#backFromRetailersTypeButton').attr('disabled', 'disabled');
        $('#addRetailerTypeForm').submit();
    });

    $('#updateRetailerTypeButton').click(function() {
        $(this).attr('disabled', 'disabled');
        $('#backFromRetailersTypeButton').attr('disabled', 'disabled');
        $('#updateRetailerTypeForm').submit();
    });

    $('#updateRetailersAssignmentsButton').click(function() {
        if (!retailersAddedForAssignment.length) {
            alert('Please add distributors');
            return;
        }
        $(this).attr('disabled', 'disabled');
        $('#backFromUpdateRetailersAssignmentsButton').attr('disabled', 'disabled');
        $('#updateRetailerAssignmentForm').submit();
    });

    $(document).on('click', '.removeAddedAssignment', function() {
        var retailerId = $(this).attr('id');
        retailersAddedForAssignment = jQuery.grep(retailersAddedForAssignment, function(value) {
            return value != retailerId;
        });
        $(this).parent().parent().remove();
        $('#retailersForAssignments').val(retailersAddedForAssignment.join(","));
    });

    $(document).on('click', '.addRetailerForAssignment', function() {
        var retailerId = $(this).parent().find('input[type="number"]').val();
        if (jQuery.inArray(retailerId, retailersAddedForAssignment) !== -1) {
            alert('You\'ve already added this retailer');
            return;
        }
        var retailerName = $.trim($(this).parent().parent().find('td:eq(0)').text());
        $('#addedAssignmentsList').append('<li style="margin-top: 10px"><div><input type="text" value="' + retailerName + '" class="form-control" style="width: 70%; display: inline; height: 50px" disabled="disabled"><a type="button" class="btn btn-cancel removeAddedAssignment" id="' + retailerId + '">Remove</a></div></li>');
        retailersAddedForAssignment.push(retailerId);
        $('#retailersForAssignments').val(retailersAddedForAssignment.join(","));
    });

    $('#addRetailerButton').click(function() {
        $(this).attr('disabled', 'disabled');
        $('#backFromRetailersButton').attr('disabled', 'disabled');
        $('#addRetailerForm').submit();
    });

    $('#updateRetailerButton').click(function() {
        $(this).attr('disabled', 'disabled');
        $('#backFromRetailersButton').attr('disabled', 'disabled');
        $('#updateRetailerForm').submit();
    });

});