$(document).ready(function() {

    $('#scheme_type').change(function() {
        if ($(this).val() == "1") {
            $('#discountOnTpContent').hide();
            $('#giftItemContent').hide();
            $('#schemeContent').fadeIn('fast');
        } else if ($(this).val() == "2") {
            $('#schemeContent').hide();
            $('#giftItemContent').hide();
            $('#discountOnTpContent').fadeIn('fast');
        } else {
            $('#schemeContent').hide();
            $('#giftItemContent').fadeIn('fast');
            $('#discountOnTpContent').hide();
        }
    });

    $('#addCampaignBtn').click(function() {
        var checkboxValidator = false;
        $('input[type="checkbox"]').each(function() {
            if ($(this).attr('checked')) {
                checkboxValidator = true;
                return;
            }
        });

        if (!checkboxValidator) {
            swal('Missing Information', 'Please provide Area, Region or Territory to proceed', 'warning');
            return;
        }

        if ($('#scheme_type').val() == "1") {
            if (!$('#scheme_image').val()) {
                swal('Missing Information', 'Please provide scheme image also', 'warning');
                return;
            }
        } else if ($('#scheme_type').val() == "2") {
            if (!$('#scheme_image_disc_tp').val()) {
                swal('Missing Information', 'Please provide scheme image also', 'warning');
                return;
            }
        } else {
            if (!$('#scheme_image_gift').val()) {
                swal('Missing Information', 'Please provide scheme image also', 'warning');
                return;
            }
        }
        $(this).attr('disabled', 'disabled');
        $('#addCampaignFOrm').submit();
    });

    $(document).on('click', '.viewDetail', function() {
        var campaignId = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: $('input[name="urlForCampaignDetails"]').val(),
            data: { campaign_id: campaignId },
            success: function(response) {
                var response = JSON.parse(response);
                if (response.scheme_type == "1") {
                    $('.viewCampaignDetailsTable tbody').empty();
                    $('.viewCampaignDetailsTable tbody').append('<tr><td>' + response.data["item_name"] + '</td><td>' + numberWithCommas(response.data["minimum_quantity_for_eligibility"]) + '</td><td>' + numberWithCommas(response.data["quantity_for_free_item"]) + '</td><td>' + numberWithCommas(response.data["scheme_amount"]) + '</td>');
                    $('.dataTables_info').hide();
                    $('.dataTables_paginate').hide();
                    $('#DataTables_Table_1_filter').hide();
                    $('.dataTables_length').hide();
                    $('#discountOnTpDetailsModalBody').hide();
                    $('#giftCampaignDetailsModalBody').hide();
                    $('#schemeOfferDetailsModalBody').fadeIn();
                    $('#myModal').modal('show');
                } else if (response.scheme_type == "2") {
                    $('#schemeOfferDetailsModalBody').hide();
                    $('#giftCampaignDetailsModalBody').hide();
                    $('#discountOnTpDetailsModalBody').fadeIn();
                    $('#myModal').modal('show');
                    response.data['packaging_price_each_discounted'] = parseInt(response.data["packaging_price_each"]) - (parseInt(response.data['containing_quantity']) * parseInt(response.data['discount_on_tp_pkr']));
                    response.data["discounted_from_each_packaging"] = (parseInt(response.data['containing_quantity']) * parseInt(response.data['discount_on_tp_pkr']));
                    response.data["savings_on_scheme"] = (parseInt(response.data['containing_quantity']) * parseInt(response.data['discount_on_tp_pkr'])) * response.data['minimum_quantity_for_eligibility'];
                    $('#packaging').text(response.data["packaging"]);
                    $('#contains').text(response.data["containing_quantity"] + " " + response.data["containing_item"] + " (Rs. " + numberWithCommas(response.data["containing_item_price_each"]) + " Each)");
                    $('#minimum_quantity_for_eligibility').text(response.data["minimum_quantity_for_eligibility"] + " " + response.data["packaging"]);
                    $('#actual_bill').text('Rs. ' + numberWithCommas(response.data["packaging_price_total"]));
                    $('#scheme_offer_on_tp').text('Rs. ' + numberWithCommas(response.data["discount_on_tp_pkr"]));
                    $('#price_of_each_packaging').text('Rs. ' + numberWithCommas(response.data["packaging_price_each_discounted"]));
                    $('#savings_each_cartan').text('Rs. ' + numberWithCommas(response.data["discounted_from_each_packaging"]));
                    $('#savings_on_scheme').text('Rs. ' + numberWithCommas(response.data["savings_on_scheme"]));
                    $('#actual_bill_quantity_package').text(response.data["minimum_quantity_for_eligibility"] + " " + response.data["packaging"]);
                    $('#each_packaging_price').text(response.data["unit_short_name"]);
                } else {
                    $('#schemeOfferDetailsModalBody').hide();
                    $('#giftCampaignDetailsModalBody').fadeIn();
                    $('#discountOnTpDetailsModalBody').hide();
                    $('#myModal').modal('show');
                    $('#minimum_quantity_for_eligibility_gift').text(response.data["minimum_quantity_for_eligibility"] + " " + response.data["packaging"]);
                    $('#actual_bill_gift').text('Rs. ' + numberWithCommas(response.data["packaging_price_total"]));
                    $('#actual_bill_quantity_package_gift').text(response.data["minimum_quantity_for_eligibility"] + " " + response.data["packaging"]);
                    $('#gift_price').text('Rs. ' + numberWithCommas(response.data["offered_gift_price"]));
                    $('#each_packaging_price_gift').text(response.data["unit_short_name"]);
                    $('#price_of_each_packaging_gift').text('Rs. ' + (response.data["packaging_price_total"] - response.data["offered_gift_price"]) / response.data["minimum_quantity_for_eligibility"]);
                }
            }
        })
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
            confirmButtonText: 'Yes, Deactivate it!'
        }).then((result) => {
            if (result.value) {
                window.location.href = thisRef.attr('href');
            }
        })
    });

    $('input[name="quantity_for_free_item"]').on('input', function() {
        $('#validQuantityErr').hide();

        if ($('input[name="minimum_quantity_for_eligibility"]').val() == "") {
            $('#validQuantityErr').text("Please provide minimum eligibility quantity first");
            $('#validQuantityErr').fadeIn();
            $('input[name="quantity_for_free_item"]').val('');
            $('input[name="minimum_quantity_for_eligibility"]').focus();
            $('input[name="scheme_amount"]').val("");
            return;
        }

        if ($('input[name="quantity_for_free_item"]').val() == "") {
            $('#validQuantityErr').text("Please provide given free quantity for scheme amount to calculate");
            $('#validQuantityErr').fadeIn();
            $('input[name="quantity_for_free_item"]').val('');
            $('input[name="scheme_amount"]').val("");
            return;
        }

        $.ajax({
            type: 'POST',
            url: $('#urlForItemTradePrice').val(),
            data: { pref_id: $('select[name="item_given_free_pref_id"]').val() },
            success: function(response) {
                var result = JSON.parse(response) / (parseInt($('input[name="quantity_for_free_item"]').val()) + parseInt($('input[name="minimum_quantity_for_eligibility"]').val()));
                $('input[name="scheme_amount"]').val(Math.round(result));
            }
        });
    });

    $('#region').click(function() {
        if ($(this).attr('checked')) {
            $(this).attr('checked', false);
            return;
        }
        $('#territory').attr('checked', false);
        $('#area').attr('checked', false);
        $(this).attr('checked', true);
        $('input[name="bulk_assignment"]').val("region");
    });

    $('#area').click(function() {
        if ($(this).attr('checked')) {
            $(this).attr('checked', false);
            return;
        }
        $('#territory').attr('checked', false);
        $('#region').attr('checked', false);
        $(this).attr('checked', true);
        $('input[name="bulk_assignment"]').val("area");
    });

    $('#territory').click(function() {
        if ($(this).attr('checked')) {
            $(this).attr('checked', false);
            return;
        }
        $('#region').attr('checked', false);
        $('#area').attr('checked', false);
        $(this).attr('checked', true);
        $('input[name="bulk_assignment"]').val("territory");
    });

    const numberWithCommas = (x) => {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

});