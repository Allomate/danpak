$(document).ready(function() {
    $('.inventoryTable').DataTable();
    $('.dataTables_wrapper').hide();
    var itemsAddedInOrderExpansion = [];
    var stockItemsInOrderExpansion = [];

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

    $('.stockOrderTable tbody tr').each(function() {
        stockItemsInOrderExpansion.push($(this).find('input[name="item_id_existing"]').val());
    });

    if ($('select[name="item_id"]').length) {
        $.ajax({
            type: 'POST',
            url: $('#getItemsForSku').val(),
            data: { itemId: $('select[name="item_id"]').val() },
            success: function(response) {
                var response = JSON.parse(response);
                $('select[name="pref_id"]').empty();
                for (var i = 0; i < response.length; i++) {
                    $('select[name="pref_id"]').append('<option value="' + response[i]["pref_id"] + '">' + response[i]["unit_name"] + '</option>');
                }
            }
        });

        $('select[name="item_id"]').change(function() {
            $.ajax({
                type: 'POST',
                url: $('#getItemsForSku').val(),
                data: { itemId: $('select[name="item_id"]').val() },
                success: function(response) {
                    var response = JSON.parse(response);
                    $('select[name="pref_id"]').empty();
                    for (var i = 0; i < response.length; i++) {
                        $('select[name="pref_id"]').append('<option value="' + response[i]["pref_id"] + '">' + response[i]["unit_name"] + '</option>');
                    }
                }
            });
        });

        $('select[name="employee_id"]').change(function() {
            $.ajax({
                type: 'POST',
                url: '/Orders/GetRetailersForEmployeeAjax',
                data: { employee_id: $('select[name="employee_id"]').val() },
                success: function(response) {
                    var response = JSON.parse(response);
                    $('select[name="distributor_id"]').empty();
                    if (!response.length) {
                        $('select[name="distributor_id"]').append('<option>No Retailers/Distributors Assigned</option>');
                        return;
                    }
                    for (var i = 0; i < response.length; i++) {
                        $('select[name="distributor_id"]').append('<option value="' + response[i]["retailer_id"] + '">' + response[i]["retailer_name"] + '</option>');
                    }
                }
            });
        });

        $.ajax({
            type: 'POST',
            url: '/Orders/GetRetailersForEmployeeAjax',
            data: { employee_id: $('select[name="employee_id"]').val() },
            success: function(response) {
                var response = JSON.parse(response);
                $('select[name="distributor_id"]').empty();
                if (!response.length) {
                    $('select[name="distributor_id"]').append('<option value="null">No Retailers/Distributors Assigned</option>');
                    return;
                }
                for (var i = 0; i < response.length; i++) {
                    $('select[name="distributor_id"]').append('<option value="' + response[i]["retailer_id"] + '">' + response[i]["retailer_name"] + '</option>');
                }
            }
        });

        $('#totalCartDiv table tbody').empty();

        $(document).on('click', '#removeFromCart', function() {
            $(this).parent().parent().remove();
        });

        $(document).on('click', '#addCampaignBtn', function() {

            if (!$('input[name="custom_order_data"]').val() || !$('input[id="campaign_quantity"]').val()) {
                alert('Please provide date & campaign quantity');
            } else if (isNaN($('select[name="distributor_id"] :selected').val())) {
                alert('No retailer/distributor selected');
            } else {
                if ($('select[name="campaign_id"]').val()) {
                    var discount = 0;
                    if ($('input[name="discount"]').val() && $('input[name="discount"]').val() !== "0") {
                        discount = $('input[name="discount"]').val();
                    }
                    $.ajax({
                        type: 'POST',
                        url: '/Orders/GetDistDiscountForCampaign',
                        data: { campaign_id: $('select[name="campaign_id"]').val(), quantity: $('input[id="campaign_quantity"]').val(), dist_id: $('select[name="distributor_id"]').val(), discount: discount },
                        success: function(response) {
                            var response = JSON.parse(response);
                            var actualBill = parseFloat(response.campaign_price);
                            var itemDiscount = 0;

                            if ($('input[name="discount"]').val() && $('input[name="discount"]').val() !== "0") {
                                itemDiscount = parseFloat($('input[name="discount"]').val());
                                actualBill = actualBill - (actualBill * (itemDiscount / 100));
                            }

                            $('#totalCartDiv').css('width', '');
                            $('#totalCartDiv').fadeIn();
                            $('#totalCartDiv table tbody').append('<tr><td>' + $('input[name="custom_order_data"]').val() + '</td><td>' + $('select[name="employee_id"] option:selected').text() + '</td><td>' + $('select[name="campaign_id"] option:selected').text() + '</td><td>NA</td><td>' + $('select[name="distributor_id"] option:selected').text() + '</td><td>' + $('input[id="campaign_quantity"]').val() + '</td><td>' + itemDiscount + '%</td><td>' + response.distributor_discount + '%</td></td><td>' + Math.round(actualBill) + '</td><td><a id="removeFromCart"><i class="fa fa-close"></i></a><input id="campIdHidden" value="' + $('select[name="campaign_id"]').val() + '" hidden/></a><input id="retIdHidden" value="' + $('select[name="distributor_id"]').val() + '" hidden/></td></tr>');
                        }
                    });
                } else {
                    alert('There is no campaign selected');
                }
            }
        });

        $(document).on('click', '#addToCartBtn', function() {

            if (isNaN($('select[name="distributor_id"] :selected').val())) {
                alert('No retailer/distributor selected');
                return;
            }

            if (!$('input[name="custom_order_data"]').val() || !$('input[name="quantity"]').val()) {
                alert('Please provide date & quantity');
                return;
            }
            $.ajax({
                type: 'POST',
                url: '/Orders/GetDistDiscountForItem',
                data: { pref_id: $('select[name="pref_id"]').val(), dist_id: $('select[name="distributor_id"]').val() },
                success: function(response) {
                    var response = JSON.parse(response);
                    var actualBill = parseFloat($('input[name="quantity"]').val()) * parseFloat(response.trade_price_after_discount);
                    var itemDiscount = 0;
                    if ($('input[name="discount"]').val() && $('input[name="discount"]').val() !== "0") {
                        itemDiscount = parseFloat($('input[name="discount"]').val());
                        actualBill = actualBill - (actualBill * (itemDiscount / 100));
                    }
                    $('#totalCartDiv').css('width', '');
                    $('#totalCartDiv').fadeIn();
                    $('#totalCartDiv table tbody').append('<tr><td>' + $('input[name="custom_order_data"]').val() + '</td><td>' + $('select[name="employee_id"] option:selected').text() + '</td><td>' + $('select[name="item_id"] option:selected').text() + '</td><td>' + $('select[name="pref_id"] option:selected').text() + '</td><td>' + $('select[name="distributor_id"] option:selected').text() + '</td><td>' + $('input[name="quantity"]').val() + '</td><td>' + itemDiscount + '%</td><td>' + response.distributor_discount + '%</td></td><td>' + Math.round(actualBill) + '</td><td><a id="removeFromCart"><i class="fa fa-close"></i></a><input id="prefIdHidden" value="' + $('select[name="pref_id"]').val() + '" hidden/></a><input id="retIdHidden" value="' + $('select[name="distributor_id"]').val() + '" hidden/></td></tr>');
                }
            });
        });
    }

    $('#expandOrderButton').click(function() {
        if (!itemsAddedInOrderExpansion.length) {
            alert('Please add items for expansion');
            return;
        }
        $(this).attr('disabled', 'disabled');
        $('#backFromOrdersBtn').attr('disabled', 'disabled');
        $('#expandOrderForm').submit();
    });

    $('#createOrderBtn').click(function() {
        if (!$('#totalCartDiv table tbody tr').length) {
            alert('Please add items to cart');
            return;
        }
        $(this).attr('disabled', 'disabled');
        var result = [];
        $('#totalCartDiv table tbody tr').each(function() {
            if ($(this).find('td:eq(9)').find('#prefIdHidden').length) {
                var retailer_id = $('select[name="distributor_id"]').val();
                var employee_id = $('select[name="employee_id"]').val();
                var item_quantity_booker = $(this).find('td:eq(5)').text();
                var booker_discount = $(this).find('td:eq(6)').text().split("%")[0];
                var pref_id = $(this).find('td:eq(9)').find('#prefIdHidden').val();
                result.push({ retailer_id: retailer_id, employee_id: employee_id, pref_id: pref_id, item_quantity_booker: item_quantity_booker, booker_discount: booker_discount, order_data: $('input[name="custom_order_data"]').val() });
            }
        });

        $('#totalCartDiv table tbody tr').each(function() {
            if ($(this).find('td:eq(9)').find('#campIdHidden').length) {
                var retailer_id = $('select[name="distributor_id"]').val();
                var employee_id = $('select[name="employee_id"]').val();
                var item_quantity_booker = $(this).find('td:eq(5)').text();
                var booker_discount = $(this).find('td:eq(6)').text().split("%")[0];
                var campaign_id = $(this).find('td:eq(9)').find('#campIdHidden').val();
                result.push({ retailer_id: retailer_id, employee_id: employee_id, campaign_id: campaign_id, item_quantity_booker: item_quantity_booker, booker_discount: booker_discount, order_data: $('input[name="custom_order_data"]').val() });
            }
        });

        $('input[name="finalResult"]').val(JSON.stringify(result));
        $('#createOrderForm').submit();
    });

    $(document).on('click', '.deleteImagesSpanTag', function() {
        var itemId = $(this).attr('id');
        if ($('input[name="items_deleted"]').val() == '') {
            $('input[name="items_deleted"]').val(itemId);
        } else {
            $('input[name="items_deleted"]').val($('input[name="items_deleted"]').val() + ',' + itemId);
        }
        $(this).parent().parent().remove();
        if (!$('#dynamicItemImagesToDeleteDiv').find('article').length) {
            $('#dynamicItemImagesToDeleteDiv').remove();
        }
    });

    $(document).on('click', '.deleteOrderExpansionInventory', function() {
        var itemIdToRemove = $(this).attr('id');
        var quantitiesAdded = $('input[name="item_quantities_expansion"]').val().split(",");
        var itemsAdded = $('input[name="item_ids_expansion"]').val().split(",");
        var bookerDiscounts = $('input[name="booker_discounts_expansion"]').val().split(",");

        if (jQuery.inArray(itemIdToRemove, itemsAdded) !== -1) {
            quantitiesAdded.splice(jQuery.inArray(itemIdToRemove, itemsAdded), 1);
            bookerDiscounts.splice(jQuery.inArray(itemIdToRemove, itemsAdded), 1);
            itemsAdded.splice(jQuery.inArray(itemIdToRemove, itemsAdded), 1);
            itemsAddedInOrderExpansion.splice(jQuery.inArray(itemIdToRemove, itemsAddedInOrderExpansion), 1);
        }

        $('input[name="item_quantities_expansion"]').val(quantitiesAdded.join(","));
        $('input[name="item_ids_expansion"]').val(itemsAdded.join(","));
        $('input[name="booker_discounts_expansion"]').val(bookerDiscounts.join(","));

        $(this).parent().parent().remove();
    });

    $('input[name="item_quantity"]').on('input', function() {
        var maxQuantAvailable = $(this).parent().parent().find('td:eq(5)').text();
        if (parseInt($(this).val()) > parseInt(maxQuantAvailable)) {
            $(this).val(maxQuantAvailable);
        }
        if (parseInt($(this).val()) <= 0) {
            $(this).val('1');
        }
    });

    $('input[name="item_quantity_booker_existing"]').on('input', function() {
        var maxQuantAvailable = $(this).parent().parent().find('td:eq(5)').text();
        var stockedQuantityForThisItemBeforeChange = $(this).parent().parent().find('input[name="item_quantity_booker_existing_stocked"]').val();
        maxQuantAvailable = maxQuantAvailable - parseInt(stockedQuantityForThisItemBeforeChange);
        if (parseInt($(this).val()) > parseInt(maxQuantAvailable)) {
            $(this).val(maxQuantAvailable);
        }
        if (parseInt($(this).val()) <= 0) {
            $(this).val('1');
        }
    });

    $(document).on('click', '.addQuantityBtn', function() {
        var quantity = $(this).parent().parent().find('input[name="item_quantity"]').val();
        if (!quantity || parseInt(quantity) <= 0) {
            alert('Please enter valid quantity');
            return;
        }

        var item_id = $(this).attr('id');
        if (jQuery.inArray(item_id, stockItemsInOrderExpansion) !== -1) {
            alert('This item is already in stock order. You can update the stock order anytime');
            return;
        }
        var bookerDiscount = $(this).parent().parent().find('input[name="booker_discount"]').val();
        var name = $(this).parent().parent().find('td:eq(1)').text() + " (" + $(this).parent().parent().find('td:eq(2)').text() + ")";

        if (jQuery.inArray(item_id, itemsAddedInOrderExpansion) !== -1) {
            alert('This item is already added. Please remove it and add again if you want to update its quantity');
            return;
        }

        if (!$('#dynamicInventoryExpansionDiv div').length) {
            $('#dynamicInventoryExpansionDiv').fadeIn();
        }

        $('#dynamicInventoryExpansionDiv').append('<div class="col-md-2" style="padding: 0px;"><div class="form-group" style="padding: 20px!important"><span style="font-weight: bold; display: block; background: #fff; padding: 10px; margin-bottom: 10px;">' + name + '</span><span class="deleteOrderExpansionInventory" style="width: 100%" id="' + item_id + '">DELETE</span></div></div>');

        // $('#dynamicInventoryExpansionDiv').append('<div class="form-group"><article style="display: inline-block; width: 120px; margin-right: 10px"><header style="border: 1px solid black; border-top-right-radius: 2em; border-top-left-radius: 0.5em"><span style="    font-weight: bold; height: auto; min-height: 100px; display: block; margin: 0 auto; text-align: center; padding-top: 30%; vertical-align: middle;">' + name + '</span></header><content><span class="deleteOrderExpansionInventory" id="' + item_id + '">DELETE</span></content></article></div>');
        if ($('input[name="item_ids_expansion"]').val()) {
            $('input[name="item_quantities_expansion"]').val($('input[name="item_quantities_expansion"]').val() + "," + quantity)
            $('input[name="booker_discounts_expansion"]').val($('input[name="booker_discounts_expansion"]').val() + "," + bookerDiscount)
            $('input[name="item_ids_expansion"]').val($('input[name="item_ids_expansion"]').val() + "," + item_id)
        } else {
            $('input[name="item_ids_expansion"]').val(item_id);
            $('input[name="item_quantities_expansion"]').val(quantity);
            $('input[name="booker_discounts_expansion"]').val(bookerDiscount);
        }
        itemsAddedInOrderExpansion.push(item_id);
    });

    $(document).on('click', '.removeItemFromStockOrderBtn', function() {
        var itemId = $(this).attr('id');
        if ($('input[name="items_deleted"]').val()) {
            $('input[name="items_deleted"]').val($('input[name="items_deleted"]').val() + "," + itemId);
        } else {
            $('input[name="items_deleted"]').val(itemId);
        }
        $(this).parent().parent().remove();
    });

    $('.updateStockQuantityBtn').click(function() {
        $(this).attr('disabled', 'disabled');
        $('#backFromOrdersBtn').attr('disabled', 'disabled');
        $('input[name="existing_items"]').val("");
        $('input[name="existing_quantities"]').val("");
        $('.stockOrderTable tbody tr').each(function() {
            if ($('input[name="existing_items"]').val()) {
                $('input[name="existing_items"]').val($('input[name="existing_items"]').val() + "," + $(this).find('input[name="item_id_existing"]').val())
                $('input[name="existing_quantities"]').val($('input[name="existing_quantities"]').val() + "," + $(this).find('input[name="item_quantity_booker_existing"]').val())
            } else {
                $('input[name="existing_quantities"]').val($(this).find('input[name="item_quantity_booker_existing"]').val())
                $('input[name="existing_items"]').val($(this).find('input[name="item_id_existing"]').val())
            }
        });
        $('#updateOrderForm').submit();
    });

});