$(document).ready(function() {
    var retailersAddedForAssignment = [];
    var usernameExist = false;
    var url = window.location.href;

    if (url.indexOf("UpdateRetailersAssignments") >= 0) {
        $('#retailersForAssignments').val().split(",").forEach(function(item) {
            retailersAddedForAssignment.push(item);
        });
    }

    $('#viewAssigns').click(function() {
        if (!retailersAddedForAssignment.length) {
            alert('Please assign retailers');
            return;
        }
        $('#myModal').modal('show');
    });

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

        $('input[name="distributor_username"]').on('input', function(e) {
            var newUsername = $(this).val();
            $.ajax({
                type: "POST",
                data: { username: newUsername },
                url: "/Retailers/CheckExistingUsername",
                success: function(response) {
                    if (response != "null") {
                        $('#usernameError').fadeIn();
                        usernameExist = true;
                    } else {
                        $('#usernameError').hide();
                        usernameExist = false;
                    }
                }
            });
        });

        $.ajax({
            type: "POST",
            data: { manager_id: $('select[name="asmOrRsm"]').val() },
            url: "/Retailers/GetReportingTso",
            success: function(response) {
                var response = JSON.parse(response);
                $('select[name="tso"]').empty();
                // $('select[name="orderBooker"]').empty();
                if (!response.length) {
                    $('select[name="tso"]').append('<option value="0" disabled selected>No TSO</option>');
                    // $('select[name="orderBooker"]').append('<option value="0" disabled selected>No OB</option>');
                } else {
                    for (var i = 0; i < response.length; i++) {
                        if (response[i].assignment_status == "na") {
                            $('select[name="tso"]').append('<option value="' + response[i].employee_id + '">' + response[i].employee_username + '</option>');
                        } else {
                            $('select[name="tso"]').append('<option value="" disabled>' + response[i].employee_username + ' (Assigned)</option>');
                        }
                    }
                    // if ($('select[name="tso"]').val() !== "" && $('select[name="tso"]').val()) {
                    //     $.ajax({
                    //         type: "POST",
                    //         data: { tso_id: $('select[name="tso"]').val() },
                    //         url: "/Retailers/GetReportingOb",
                    //         success: function(response) {
                    //             var response = JSON.parse(response);
                    //             if (!response.length) {
                    //                 $('select[name="orderBooker"]').append('<option value="0" disabled selected>No OB</option>');
                    //             } else {
                    //                 for (var i = 0; i < response.length; i++) {
                    //                     if (response[i].assignment_status == "na") {
                    //                         $('select[name="orderBooker"]').append('<option value="' + response[i].employee_id + '">' + response[i].employee_username + '</option>');
                    //                     } else {
                    //                         $('select[name="orderBooker"]').append('<option value="" disabled>' + response[i].employee_username + ' (Assigned)</option>');
                    //                     }
                    //                 }
                    //             }
                    //         }
                    //     });
                    // } else {
                    //     $('select[name="orderBooker"]').append('<option value="0" disabled selected>No OB</option>');
                    // }
                }
            }
        });

        $('select[name="tso"]').change(function() {
            $.ajax({
                type: "POST",
                data: { tso_id: $('select[name="tso"]').val() },
                url: "/Retailers/GetReportingOb",
                success: function(response) {
                    var response = JSON.parse(response);
                    $('select[name="orderBooker"]').empty();
                    if (!response.length) {
                        $('select[name="orderBooker"]').append('<option value="0" disabled selected>No O.B</option>');
                    } else {
                        for (var i = 0; i < response.length; i++) {
                            if (response[i].assignment_status == "na") {
                                $('select[name="orderBooker"]').append('<option value="' + response[i].employee_id + '">' + response[i].employee_username + '</option>');
                            } else {
                                $('select[name="orderBooker"]').append('<option value="" disabled>' + response[i].employee_username + ' (Assigned)</option>');
                            }
                        }
                    }
                }
            });
        });

        $('select[name="asmOrRsm"]').change(function() {
            $.ajax({
                type: "POST",
                data: { manager_id: $('select[name="asmOrRsm"]').val() },
                url: "/Retailers/GetReportingTso",
                success: function(response) {
                    var response = JSON.parse(response);
                    $('select[name="tso"]').empty();
                    // $('select[name="orderBooker"]').empty();
                    if (!response.length) {
                        $('select[name="tso"]').append('<option value="0" disabled selected>No TSO</option>');
                        // $('select[name="orderBooker"]').append('<option value="0" disabled selected>No OB</option>');
                    } else {
                        for (var i = 0; i < response.length; i++) {
                            if (response[i].assignment_status == "na") {
                                $('select[name="tso"]').append('<option value="' + response[i].employee_id + '">' + response[i].employee_username + '</option>');
                            } else {
                                $('select[name="tso"]').append('<option value="" disabled>' + response[i].employee_username + ' (Assigned)</option>');
                            }
                        }
                        // if ($('select[name="tso"]').val() !== "" && $('select[name="tso"]').val()) {
                        //     $.ajax({
                        //         type: "POST",
                        //         data: { tso_id: $('select[name="tso"]').val() },
                        //         url: "/Retailers/GetReportingOb",
                        //         success: function(response) {
                        //             var response = JSON.parse(response);
                        //             if (!response.length) {
                        //                 $('select[name="orderBooker"]').append('<option value="0" disabled selected>No OB</option>');
                        //             } else {
                        //                 for (var i = 0; i < response.length; i++) {
                        //                     if (response[i].assignment_status == "na") {
                        //                         $('select[name="orderBooker"]').append('<option value="' + response[i].employee_id + '">' + response[i].employee_username + '</option>');
                        //                     } else {
                        //                         $('select[name="orderBooker"]').append('<option value="" disabled>' + response[i].employee_username + ' (Assigned)</option>');
                        //                     }
                        //                 }
                        //             }
                        //         }
                        //     });
                        // } else {
                        //     $('select[name="orderBooker"]').append('<option value="0" disabled selected>No OB</option>');
                        // }
                    }
                }
            });
        });

        var addedEmployees = [];
        $('#addedEmployees li').each(function() {
            addedEmployees.push($(this).find('span.removeAddedEmployee').attr('id'));
        });

        $(document).on('click', '.removeAddedEmployee', function() {
            var removeItem = $(this).attr('id');
            addedEmployees = jQuery.grep(addedEmployees, function(value) {
                return value != removeItem;
            });
            $(this).parent().remove();
        });

        $('#addTso').click(function() {
            if ($('select[name="tso"] :selected').val() === "0") {
                alert("No TSO found");
                return;
            }

            if (!$('select[name="tso"] :selected').val() || $('select[name="tso"] :selected').val() == "") {
                alert("All TSO(s) are assigned");
                return;
            }

            if (jQuery.inArray($('select[name="tso"]').val(), addedEmployees) !== -1) {
                alert('Already added');
                return;
            }
            addedEmployees.push($('select[name="tso"]').val());
            $('#addedEmployees').append('<li style="cursor:pointer; display: inline-block; width: 300px !important;"><span style="box-shadow: 0 2px 8px 0 #e5d6d6; padding: 10px; width: 75%; margin-bottom: 10px; display: inline-block;">' + $('select[name="tso"] :selected').text() + ' (T.S.O)</span> <span id="' + $('select[name="tso"] :selected').val() + '" class="removeAddedEmployee" style="width: 20%; height: 42px; display: inline-block;padding-top: 8px;padding-bottom: 8px;text-align: center;background: red;color: white;font-weight: bold;box-shadow: 0 2px 8px 0 #e5d6d6;">x</span> </li>');
        });

        $('#addOb').click(function() {
            if ($('select[name="orderBooker"] :selected').val() === "0") {
                alert("No OB found");
                return;
            }

            if (!$('select[name="orderBooker"] :selected').val() || $('select[name="orderBooker"] :selected').val() == "") {
                alert("All OB(s) are assigned");
                return;
            }

            if (jQuery.inArray($('select[name="orderBooker"]').val(), addedEmployees) !== -1) {
                alert('Already added');
                return;
            }
            addedEmployees.push($('select[name="orderBooker"]').val());
            $('#addedEmployees').append('<li style="cursor:pointer; display: inline-block; width: 300px !important;"><span style="box-shadow: 0 2px 8px 0 #e5d6d6; padding: 10px; width: 75%; margin-bottom: 10px; display: inline-block;">' + $('select[name="orderBooker"] :selected').text() + '  (O.B)</span> <span id="' + $('select[name="orderBooker"] :selected').val() + '" class="removeAddedEmployee" style="width: 20%; height: 42px; display: inline-block;padding-top: 8px;padding-bottom: 8px;text-align: center;background: red;color: white;font-weight: bold;box-shadow: 0 2px 8px 0 #e5d6d6;">x</span> </li>');
        });

    }

    $('#addRetailersAssignmentsButton').click(function() {
        if (!$('#territoryRadio').is(':checked')) {
            if (!retailersAddedForAssignment.length) {
                alert('Please add retailers');
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
                alert('Please add retailers');
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
        $(this).parent().remove();
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

        $('#addedAssignmentsList').append('<li style="padding: 20px 10px; background: #fbf9f9; margin-bottom: 10px"><span style="width: 75%; display: inline-block;">' + retailerName + '</span><a style="width: 20%; display: inline-block; text-align: right; cursor: pointer" class="removeAddedAssignment" id="' + retailerId + '"><i class="fa fa-close"></i></a></li>');
        retailersAddedForAssignment.push(retailerId);
        $('#retailersForAssignments').val(retailersAddedForAssignment.join(","));
        $(this).css('background-color', 'green');
        thisRef.text("Added");
    });

    $('#addRetailerButton').click(function() {
        if (usernameExist) {
            alert("Username already exists");
            return;
        }
        if ($('input[name="distributor_username"]').val() == "" || $('input[name="distributor_password"]').val() == "" || $('input[name="retailer_city"]').val() == "" || $('textarea[name="retailer_address"]').val() == "") {
            alert('Please provide all the information with (*) label and assign employees');
            return;
        }
        $(this).attr('disabled', 'disabled');
        $('input[name="assignedEmployees"]').val(JSON.stringify(addedEmployees));
        $('#backFromRetailersButton').attr('disabled', 'disabled');
        $('#addRetailerForm').submit();
    });

    $('#updateRetailerButton').click(function() {
        if (usernameExist) {
            alert("Username already exists");
            return;
        }
        if ($('input[name="distributor_username"]').val() == "" || $('input[name="distributor_password"]').val() == "" || $('input[name="retailer_city"]').val() == "" || $('textarea[name="retailer_address"]').val() == "") {
            alert('Please provide all the information with (*) label and assign employees');
            return;
        }
        $(this).attr('disabled', 'disabled');
        $('input[name="assignedEmployees"]').val(JSON.stringify(addedEmployees));
        $('#backFromRetailersButton').attr('disabled', 'disabled');
        $('#updateRetailerForm').submit();
    });

});