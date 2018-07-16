$(document).ready(function() {

    var selectedKpiCriteria = "monthly";
    var selectedMonthOrCriteria = "";
    var totalKpis = 0;
    var totalWeightage = 0;
    var kpiTypesAlreadyAdded = [];

    $(document).on('click', '.deactivateSingularKpi', function() {
        var kpiId = $(this).attr('id');

        swal({
            title: 'Are you sure?',
            showCancelButton: true,
            confirmButtonText: 'Yes, Deactivate It',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        type: "GET",
                        url: "/Kpi/DeActivateSingularKpi/" + kpiId,
                        success: function(response) {
                            if (response == "success") {
                                swal('KPI Deactivated', 'Kpi has been deactivated successfully', 'success');
                            } else {
                                swal('Failed', 'Failed to deactivate the kpi', 'error');
                            }
                            $('#myModal').modal('hide');
                        }
                    });
                })
            },
            allowOutsideClick: false
        })
    });

    $(document).on('click', '.activateSingularKpi', function() {
        var kpiId = $(this).attr('id');

        swal({
            title: 'Are you sure?',
            showCancelButton: true,
            confirmButtonText: 'Yes, Activate It',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        type: "GET",
                        url: "/Kpi/ActivateSingularKpi/" + kpiId,
                        success: function(response) {
                            if (response == "success") {
                                swal('KPI Activated', 'Kpi has been activated successfully', 'success');
                            } else {
                                swal('Failed', 'Failed to activate the kpi', 'error');
                            }
                            $('#myModal').modal('hide');
                        }
                    });
                })
            },
            allowOutsideClick: false
        })
    });

    $(document).on('click', '.deleteKpi', function() {
        var kpiId = $(this).attr('id');
        var thisRef = $(this);

        swal({
            title: 'Are you sure?',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete It',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        type: "GET",
                        url: "/Kpi/DeleteThisKpi/" + kpiId,
                        success: function(response) {
                            if (response == "success") {
                                swal('KPI Deleted', 'Kpi has been deleted successfully', 'success');
                            } else {
                                swal('Failed', 'Failed to delete the kpi', 'error');
                            }
                            thisRef.parent().parent().remove();
                        }
                    });
                })
            },
            allowOutsideClick: false
        })
    });

    $(document).on('click', '.viewEmpKpis', function() {
        var un = $(this).parent().find('#empUn').val();
        $.ajax({
            type: "GET",
            url: "/Kpi/GetDetailedKpis/" + un,
            success: function(response) {
                var response = JSON.parse(response);
                console.log(response);
                return;
                $('.kpisTable tbody').empty();
                for (var counter = 0; counter < response.length; counter++) {
                    $('.kpisTable tbody').append('<tr> <td>' + response[counter]["kpi_type"] + '</td><td>' + response[counter]["criteria"] + '</td><td>' + response[counter]["criteria_parameter"] + '</td><td>' + (response[counter]["item_name"] ? response[counter]["item_name"] : "NA") + '</td><td>' + (response[counter]["unit_name"] ? response[counter]["unit_name"] : "NA") + '</td><td>' + response[counter]["target"] + '</td><td>' + response[counter]["eligibility"] + '</td><td>' + response[counter]["weightage"] + '%</td><td>' + response[counter]["incentive"] + '</td><td>' + numberWithCommas(Math.round(response[counter]["progress"])) + (response[counter]["progress"] ? " (" + (parseInt(response[counter]["progress"]) / parseInt(response[counter]["target"])) * 100 + "%)" : " (0%)") + '</td><td><a class="deleteKpi" id="' + response[counter]["id"] + '"><i class="fa fa-close"></i></a>' + (response[counter]["active"] == "1" ? '<a class="view-report deactivateSingularKpi" id="' + response[counter]["id"] + '" style="display: none">De-Active</a>' : '<a id="' + response[counter]["id"] + '" class="view-report activateSingularKpi" style="display: none">Active</a>') + '</td> </tr>');
                }
                $('#datable_2_filter').remove();
                $('#myModal').modal('show');
            }
        });
    });

    //Check if page has error redirect and contain all previous data
    if ($('input[name="totalKpis"]').val()) {
        totalKpis = $('input[name="totalKpis"]').val();
        for (var i = 0; i < totalKpis; i++) {
            kpiTypesAlreadyAdded.push({ "criteria": $('input[name="criteria_' + i + '"]').val(), "month_or_quarter": $('input[name="for_month_or_criteria_' + i + '"]').val(), "kpi_type": $('input[name="for_kpi_type_' + i + '"]').val() });
            if ($('select[name="productDD_' + i + '"]').length) {
                var thisRef = $(this);
                $.ajax({
                    type: 'GET',
                    async: false,
                    url: '/Kpi/GetProductsForKpi',
                    success: function(response) {
                        var response = JSON.parse(response);
                        $('select[name="productDD_' + i + '"]').empty();
                        for (var j = 0; j < response.length; j++) {
                            $('select[name="productDD_' + i + '"]').append('<option value="' + response[j].item_id + '">' + response[j].item_name + '</option>');
                        }
                        $('select[name="productDD_' + i + '"]').val($('input[name="selected_product_' + i + '"]').val());
                        $.ajax({
                            type: 'POST',
                            async: false,
                            url: '/Kpi/GetUnitsForThisProduct',
                            data: { 'item_id': $('select[name="productDD_' + i + '"]').val() },
                            success: function(response) {
                                var response = JSON.parse(response);
                                $('select[name="unitDD_' + i + '"]').empty();
                                for (var k = 0; k < response.length; k++) {
                                    $('select[name="unitDD_' + i + '"]').append('<option value="' + response[k].pref_id + '">' + response[k].unit_name + '</option>');
                                }
                                $('select[name="unitDD_' + i + '"]').val($('input[name="selected_unit_' + i + '"]').val());
                            }
                        });
                    }
                });
            } else if (!$('select[name="productDD_' + i + '"]').length && $('select[name="unitDD_' + i + '"]').length) {
                $.ajax({
                    type: 'GET',
                    async: false,
                    url: '/Kpi/GetUnitsForKpi',
                    success: function(response) {
                        var response = JSON.parse(response);
                        $('select[name="unitDD_' + i + '"]').empty();
                        for (var j = 0; j < response.length; j++) {
                            $('select[name="unitDD_' + i + '"]').append('<option value="' + response[j].unit_id + '">' + response[j].unit_name + '</option>');
                        }
                        $('select[name="unitDD_' + i + '"]').val($('input[name="selected_unit_' + i + '"]').val());
                        if (totalKpis == 0) {
                            $('#progressBar').fadeIn('fast');
                            $('#kpiDynamicDiv').fadeIn('fast');
                        }
                        $('#kpiDynamicDiv').fadeIn('fast');
                        $('.modal').modal('hide');
                    }
                });
            }
        }

        $('.weightage').each(function() {
            totalWeightage = parseInt($(this).val()) + totalWeightage;
        });

        $('#progressBar').fadeIn('fast');
        $('.progress-bar').css('width', totalWeightage + '%');
        $('.progress-bar').html(totalWeightage + '%');
    }

    $(document).on('input', '.weightage', function(e) {
        totalWeightage = 0;
        if (!$.isNumeric($(this).val())) {
            if (!$(this).val()) {
                $(this).val("1");
            } else {
                $(this).val($.trim($(this).val()).slice(0, -1));
            }
            e.preventDefault();
            return;
        }
        if (!$(this).val() || parseInt($(this).val()) <= 0) {
            $(this).val("1");
        }
        if (parseInt($(this).val()) > 100) {
            $(this).val("100");
        }
        $('.weightage').each(function() {
            totalWeightage = parseInt($(this).val()) + totalWeightage;
        });
        $('.progress-bar').css('width', totalWeightage + '%');
        $('.progress-bar').html(totalWeightage + '%');
    });

    $(document).on('input', '.empTargets', function(e) {
        if (!$.isNumeric($(this).val())) {
            if (!$(this).val()) {
                $(this).val("1");
            } else {
                $(this).val($.trim($(this).val()).slice(0, -1));
            }
            e.preventDefault();
            return;
        }
        if (!$(this).val() || parseInt($(this).val()) <= 0) {
            $(this).val("1");
        }
    });

    $(document).on('input', '.empIncentives', function(e) {
        if (!$.isNumeric($(this).val())) {
            if (!$(this).val()) {
                $(this).val("1");
            } else {
                $(this).val($.trim($(this).val()).slice(0, -1));
            }
            e.preventDefault();
            return;
        }
        if (!$(this).val() || parseInt($(this).val()) <= 0) {
            $(this).val("1");
        }
    });

    $(document).on('input', '.empEligibility', function(e) {
        if (!$.isNumeric($(this).val())) {
            if (!$(this).val()) {
                $(this).val("1");
            } else {
                $(this).val($.trim($(this).val()).slice(0, -1));
            }
            e.preventDefault();
            return;
        }
        if (!$(this).val() || parseInt($(this).val()) <= 0) {
            $(this).val("1");
        }
    });

    $('#submitKpi').click(function() {
        var impure = false;
        if (!kpiTypesAlreadyAdded.length) {
            swal('Missing Kpi', 'Please add KPIs for this employee', 'error');
            return;
        }
        if (parseInt($('.progress-bar').html().split("%")[0]) !== 100) {
            swal('Weightage Invalid', 'Please evaluate KPIs and commulate them to a total of 100%', 'error');
            return;
        }

        $('.empTargets').each(function() {
            if (!$(this).val()) {
                impure = true;
                swal('Target Missing', 'Please provide all the target fields for employee', 'error');
                return;
            }
        });

        if (!impure) {
            $('.empEligibility').each(function() {
                if (!$(this).val()) {
                    impure = true;
                    swal('Eligibility Missing', 'Please provide all the eligibility fields for employee', 'error');
                    return;
                }
            });
        }

        if (!impure) {
            $('.empIncentives').each(function() {
                if (!$(this).val()) {
                    impure = true;
                    swal('Incentive Missing', 'Please provide all the incentive fields for employee', 'error');
                    return;
                }
            });
        }

        if (impure)
            return;

        $('input[name="evaluation_from_employees"]').val(($('#evaluateUsingEmployees').is(":checked") ? "1" : "0"));
        $('input[name="totalKpis"]').val(totalKpis);
        $('#addKpiForm').submit();
    });

    $('#createKpiForThisCriteria').click(function() {
        var selectedKpiType = $("input[name='kpi_type']:checked").val();
        if (selectedKpiCriteria == "monthly") {
            selectedMonthOrCriteria = $('select[name="monthDD"]').val();
        } else {
            selectedMonthOrCriteria = $('select[name="quarterDD"]').val();
        }
        var replicatedKpi = false;
        if (kpiTypesAlreadyAdded.length > 0) {
            $.each(kpiTypesAlreadyAdded, function(index, value) {
                if (selectedKpiCriteria == value["criteria"]) {
                    if (selectedMonthOrCriteria == value["month_or_quarter"]) {
                        if (selectedKpiType == value["kpi_type"]) {
                            swal('Duplicate', 'You have already added KPI for similar preferences against this employee', 'warning');
                            replicatedKpi = true;
                        }
                    }
                }
            });
        }
        if (replicatedKpi) {
            return;
        }

        if (selectedKpiType == "product") {
            if (totalKpis !== 0) {
                $('#kpiDynamicDiv').append('<br><br><br>');
            }
            $('#kpiDynamicDiv').append('<h5>Product Wise (' + selectedMonthOrCriteria + ') </h5><br><div class="row"><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Product</label><select class="form-control productDD" id="' + totalKpis + '" name="productDD_' + totalKpis + '" data-style="form-control btn-default btn-outline"><option>Select product</option></select></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Unit</label><select class="form-control unitDD" data-style="form-control btn-default btn-outline" id="' + totalKpis + '" name="unitDD_' + totalKpis + '"><option>Select unit</option></select></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Target</label><input type="text" name="target_' + totalKpis + '" class="form-control empTargets" value="1" placeholder=""></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Eligibility</label><input type="text" name="eligibility_' + totalKpis + '" class="form-control empEligibility" value="1"></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Weightage (%)</label><input type="text" name="weightage_' + totalKpis + '" class="form-control weightage" value="1" placeholder=""></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Incentive</label><input type="text" name="incentive_' + totalKpis + '" class="form-control empIncentives" value="1"></div></div><br><input type="text" name="for_month_or_criteria_' + totalKpis + '" value="' + selectedMonthOrCriteria + '" hidden /><input type="text" name="criteria_' + totalKpis + '" value="' + selectedKpiCriteria + '" hidden /><input type="text" name="for_kpi_type_' + totalKpis + '" value="' + selectedKpiType + '" hidden />');

            $.ajax({
                type: 'GET',
                url: '/Kpi/GetProductsForKpi',
                success: function(response) {
                    var response = JSON.parse(response);
                    $('select[name="productDD_' + totalKpis + '"]').empty();
                    for (var i = 0; i < response.length; i++) {
                        $('select[name="productDD_' + totalKpis + '"]').append('<option value="' + response[i].item_id + '">' + response[i].item_name + '</option>');
                    }
                    $.ajax({
                        type: 'POST',
                        url: '/Kpi/GetUnitsForThisProduct',
                        data: { 'item_id': $('select[name="productDD_' + totalKpis + '"]').val() },
                        success: function(response) {
                            var response = JSON.parse(response);
                            $('select[name="unitDD_' + totalKpis + '"]').empty();
                            for (var i = 0; i < response.length; i++) {
                                $('select[name="unitDD_' + totalKpis + '"]').append('<option value="' + response[i].pref_id + '">' + response[i].unit_name + '</option>');
                            }
                            if (totalKpis == 0) {
                                $('#progressBar').fadeIn('fast');
                                $('#kpiDynamicDiv').fadeIn('fast');
                            }
                            $('#kpiDynamicDiv').fadeIn('fast');
                            $('.modal').modal('hide');
                            totalKpis++;
                        }
                    });
                }
            });
        } else if (selectedKpiType == "quantity") {
            if (totalKpis !== 0) {
                $('#kpiDynamicDiv').append('<br><br><br>');
            }
            $('#kpiDynamicDiv').append('<h5>Quantity Wise (' + selectedMonthOrCriteria + ') </h5><br><div class="row"><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Unit</label><select class="form-control unitDD" id="' + totalKpis + '" name="unitDD_' + totalKpis + '" data-style="form-control btn-default btn-outline"><option>Select unit</option></select></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Target</label><input type="text" name="target_' + totalKpis + '" class="form-control empTargets" value="1" placeholder=""></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Eligibility</label><input type="text" name="eligibility_' + totalKpis + '" class="form-control empEligibility" value="1"></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Weightage (%)</label><input type="text" name="weightage_' + totalKpis + '" class="form-control weightage" value="1" placeholder=""></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Incentive</label><input type="text" name="incentive_' + totalKpis + '" class="form-control empIncentives" value="1"></div></div><br><input type="text" name="for_month_or_criteria_' + totalKpis + '" value="' + selectedMonthOrCriteria + '" hidden /><input type="text" name="criteria_' + totalKpis + '" value="' + selectedKpiCriteria + '" hidden /><input type="text" name="for_kpi_type_' + totalKpis + '" value="' + selectedKpiType + '" hidden />');

            $.ajax({
                type: 'GET',
                url: '/Kpi/GetUnitsForKpi',
                success: function(response) {
                    var response = JSON.parse(response);
                    $('select[name="unitDD_' + totalKpis + '"]').empty();
                    for (var i = 0; i < response.length; i++) {
                        $('select[name="unitDD_' + totalKpis + '"]').append('<option value="' + response[i].unit_id + '">' + response[i].unit_name + '</option>');
                    }
                    if (totalKpis == 0) {
                        $('#progressBar').fadeIn('fast');
                        $('#kpiDynamicDiv').fadeIn('fast');
                    }
                    $('#kpiDynamicDiv').fadeIn('fast');
                    $('.modal').modal('hide');
                    totalKpis++;

                }
            });
        } else {
            if (totalKpis !== 0) {
                $('#kpiDynamicDiv').append('<br><br><br>');
            }
            $('#kpiDynamicDiv').append('<h5>Revenue Wise (' + selectedMonthOrCriteria + ') </h5><br><div class="row"><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Target</label><input type="text" name="target_' + totalKpis + '" class="form-control empTargets" value="1" placeholder=""></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Eligibility</label><input type="text" name="eligibility_' + totalKpis + '" class="form-control empEligibility" value="1"></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Weightage (%)</label><input type="text" name="weightage_' + totalKpis + '" class="form-control weightage" value="1" placeholder=""></div></div><div class="col-md-6"><div class="form-group"><label class="control-label mb-10">Incentive</label><input type="text" name="incentive_' + totalKpis + '" class="form-control empIncentives" value="1"></div></div><br><input type="text" name="for_month_or_criteria_' + totalKpis + '" value="' + selectedMonthOrCriteria + '" hidden /><input type="text" name="criteria_' + totalKpis + '" value="' + selectedKpiCriteria + '" hidden /><input type="text" name="for_kpi_type_' + totalKpis + '" value="' + selectedKpiType + '" hidden />');
            $('.modal').modal('hide');
            if (totalKpis == 0) {
                $('#progressBar').fadeIn('fast');
                $('#kpiDynamicDiv').fadeIn('fast');
            }
            $('#kpiDynamicDiv').fadeIn('fast');
            $('.modal').modal('hide');
            totalKpis++;
        }
        kpiTypesAlreadyAdded.push({ "criteria": selectedKpiCriteria, "month_or_quarter": selectedMonthOrCriteria, "kpi_type": selectedKpiType });
        totalWeightage++;
        $('.progress-bar').css('width', totalWeightage + '%');
        $('.progress-bar').html(totalWeightage + '%');
    });

    $(document).on('change', '.productDD', function() {
        var thisRef = $(this);
        var itemId = $(this).val();

        $.ajax({
            type: 'POST',
            url: '/Kpi/GetUnitsForThisProduct',
            data: { 'item_id': itemId },
            success: function(response) {
                var response = JSON.parse(response);
                thisRef.parent().parent().parent().find('.unitDD').empty();
                for (var i = 0; i < response.length; i++) {
                    thisRef.parent().parent().parent().find('.unitDD').append('<option value="' + response[i].pref_id + '">' + response[i].unit_name + '</option>');
                }
                if (totalKpis == 0) {
                    $('#progressBar').fadeIn('fast');
                    $('#kpiDynamicDiv').fadeIn('fast');
                }
                $('#kpiDynamicDiv').fadeIn('fast');
                $('.modal').modal('hide');

            }
        });
    });

    $('.add-kpi').click(function() {
        if (selectedKpiCriteria == "monthly") {
            if ($('select[name="monthDD"]').val() == "0") {
                swal('Select month', 'Please select a month to add kpi', 'error');
                return;
            }
        } else {
            if ($('select[name="quarterDD"]').val() == "0") {
                swal('Select month', 'Please select a month to add kpi', 'error');
                return;
            }
        }
        $('.modal').modal('show');
    });

    $(document).on('click', '.radioSelector', function(e) {
        var thisRef = $(this);
        if ($(this).val() == "monthly") {
            $('select[name="quarterDD"]').attr('disabled', 'disabled');
            $('select[name="monthDD"]').removeAttr('disabled');
            selectedKpiCriteria = "monthly";
        } else {
            $('select[name="monthDD"]').attr('disabled', 'disabled');
            $('select[name="quarterDD"]').removeAttr('disabled');
            selectedKpiCriteria = "quarterly";
        }
    });

});

const numberWithCommas = (x) => {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}