$(document).ready(function() {
    var retailersAddedForAssignment = [];
    var url = window.location.href;

    if (url.indexOf("UpdateRetailersAssignments") >= 0) {
        $('#retailersForAssignments').val().split(",").forEach(function(item) {
            retailersAddedForAssignment.push(item);
        });
    }

    var table = $('.table').DataTable();

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

    if ($('select[name="asmOrRsm"]').length) {
        $.ajax({
            type: "POST",
            data: { manager_id: $('select[name="asmOrRsm"]').val() },
            url: "/Retailers/GetReportingTsoAndOb",
            success: function(response) {
                var response = JSON.parse(response);
                $('select[name="orderBooker"]').empty();
                if (!response.ob.length) {
                    $('select[name="orderBooker"]').append('<option value="0" disabled selected>No Order booker</option>');
                } else {
                    for (var i = 0; i < response.ob.length; i++) {
                        $('select[name="orderBooker"]').append('<option value="' + response.ob[i].employee_id + '">' + response.ob[i].employee_username + '</option>');
                    }
                }

                $('select[name="tso"]').empty();
                if (!response.ob.length) {
                    $('select[name="tso"]').append('<option value="0" disabled selected>No TSO</option>');
                } else {
                    for (var i = 0; i < response.tso.length; i++) {
                        $('select[name="tso"]').append('<option value="' + response.tso[i].employee_id + '">' + response.tso[i].employee_username + '</option>');
                    }
                }
            }
        });

        $('select[name="asmOrRsm"]').change(function() {
            $.ajax({
                type: "POST",
                data: { manager_id: $('select[name="asmOrRsm"]').val() },
                url: "/Retailers/GetReportingTsoAndOb",
                success: function(response) {
                    var response = JSON.parse(response);
                    $('select[name="orderBooker"]').empty();
                    if (!response.ob.length) {
                        $('select[name="orderBooker"]').append('<option value="0" disabled selected>No Order booker</option>');
                    } else {
                        for (var i = 0; i < response.ob.length; i++) {
                            $('select[name="orderBooker"]').append('<option value="' + response.ob[i].employee_id + '">' + response.ob[i].employee_username + '</option>');
                        }
                    }

                    $('select[name="tso"]').empty();
                    if (!response.ob.length) {
                        $('select[name="tso"]').append('<option value="0" disabled selected>No TSO</option>');
                    } else {
                        for (var i = 0; i < response.tso.length; i++) {
                            $('select[name="tso"]').append('<option value="' + response.tso[i].employee_id + '">' + response.tso[i].employee_username + '</option>');
                        }
                    }
                }
            });
        });

        var addedEmployees = [];

        $('#addTso').click(function() {
            if ($('select[name="tso"] :selected').val() === "0") {
                alert("No TSO found");
                return;
            }

            if (jQuery.inArray($('select[name="tso"]').val(), addedEmployees) !== -1) {
                alert('Already added');
                return;
            }
            addedEmployees.push($('select[name="tso"]').val());
            $('#addedEmployees').append('<li style="display: inline-block; width: 300px !important;"><span style="box-shadow: 0 2px 8px 0 #e5d6d6; padding: 10px; width: 75%; margin-bottom: 10px; display: inline-block;">' + $('select[name="tso"] :selected').text() + '</span> <span id="' + $('select[name="tso"] :selected').val() + ' (T.S.O)" class="removeAddedEmployee" style="width: 20%; height: 42px; display: inline-block;padding-top: 8px;padding-bottom: 8px;text-align: center;background: red;color: white;font-weight: bold;box-shadow: 0 2px 8px 0 #e5d6d6;">x</span> </li>');
        });

        $('#addOb').click(function() {
            if ($('select[name="orderBooker"] :selected').val() === "0") {
                alert("No OB found");
                return;
            }

            if (jQuery.inArray($('select[name="orderBooker"]').val(), addedEmployees) !== -1) {
                alert('Already added');
                return;
            }
            addedEmployees.push($('select[name="orderBooker"]').val());
            $('#addedEmployees').append('<li style="display: inline-block; width: 300px !important;"><span style="box-shadow: 0 2px 8px 0 #e5d6d6; padding: 10px; width: 75%; margin-bottom: 10px; display: inline-block;">' + $('select[name="orderBooker"] :selected').text() + '</span> <span id="' + $('select[name="orderBooker"] :selected').val() + ' (O.B)" class="removeAddedEmployee" style="width: 20%; height: 42px; display: inline-block;padding-top: 8px;padding-bottom: 8px;text-align: center;background: red;color: white;font-weight: bold;box-shadow: 0 2px 8px 0 #e5d6d6;">x</span> </li>');
        });

    }

    $('#addRetailersAssignmentsButton').click(function() {
        if (!$('#territoryRadio').is(':checked')) {
            if (!retailersAddedForAssignment.length) {
                alert('Please add distributors');
                return;
            }
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
        if (!$('#territoryRadio').is(':checked')) {
            if (!retailersAddedForAssignment.length) {
                alert('Please add distributors');
                return;
            }
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

        table.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var data = this.data();
            var rowRequired = $(this.node());
            var columnRequired = rowRequired.find('td:eq(4)');
            var retIdSearch = columnRequired.find('input[type="number"]').val();
            if (retIdSearch == retailerId) {
                rowRequired.find('td:eq(4) a.addRetailerForAssignment').css('background-color', '#001e35');
                rowRequired.find('td:eq(4) a.addRetailerForAssignment').text('Add');
            }
        });
    });

    $(document).on('click', '.addRetailerForAssignment', function() {
        var retailerId = $(this).parent().find('input[type="number"]').val();
        if (jQuery.inArray(retailerId, retailersAddedForAssignment) !== -1) {
            alert('You\'ve already added this retailer');
            return;
        }
        var thisRef = $(this);
        var retailerName = $.trim($(this).parent().parent().find('td:eq(0)').text());
        $('#addedAssignmentsList').append('<li style="margin-top: 10px"><div><input type="text" value="' + retailerName + '" class="form-control" style="width: 70%; display: inline; height: 50px" disabled="disabled"><a type="button" class="btn btn-cancel removeAddedAssignment" id="' + retailerId + '">Remove</a></div></li>');
        retailersAddedForAssignment.push(retailerId);
        $('#retailersForAssignments').val(retailersAddedForAssignment.join(","));
        $(this).css('background-color', 'green');
        thisRef.text("Added");
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