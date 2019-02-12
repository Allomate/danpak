$(document).ready(function() {

    var zones = [];

    $("#zones").on('keyup', function(e) {
        if (e.keyCode == 13) {
            if ($(this).val()) {
                $('#zoneLists').append('<a class="list-group-item list-group-item-action zoneItem">' + $(this).val() + '</a>');
                zones.push($(this).val());
                $(this).val("");
            }
        }
    });

    if ($('#updateTerritoryForm').length) {
        $('#territoryZones').val().split("<>").forEach(element => {
            if (element) {
                $('#zoneLists').append('<a class="list-group-item list-group-item-action zoneItem">' + element + '</a>');
                zones.push(element);
            }
        });
    }

    $(document).on('click', '.zoneItem', function() {
        zones.splice(zones.indexOf($(this).text()), 1);
        $(this).remove();
    });

    $('#addRegionButton').click(function() {
        if ($('#employeeIdDD').val() == "0" || !$('#employeeIdDD').val()) {
            alert('Please select a valid POC');
            return;
        }
        $(this).attr('disabled', 'disabled');
        $('#backFromRegionsButton').attr('disabled', 'disabled');
        $('#addRegionForm').submit();
    });

    $('#updateRegionButton').click(function() {
        if ($('#employeeIdDD').val() == "0" || !$('#employeeIdDD').val()) {
            alert('Please select a valid POC');
            return;
        }
        $(this).attr('disabled', 'disabled');
        $('#backFromRegionsButton').attr('disabled', 'disabled');
        $('#updateRegionForm').submit();
    });

    $('#addAreaButton').click(function() {
        if ($('#regionIdDD').val() == "0" || !$('#regionIdDD').val()) {
            alert('Please select a valid region');
            return;
        }
        $(this).attr('disabled', 'disabled');
        $('#backFromAreasButton').attr('disabled', 'disabled');
        $('#addAreaForm').submit();
    });

    $('#updateAreaButton').click(function() {
        if ($('#regionIdDD').val() == "0" || !$('#regionIdDD').val()) {
            alert('Please select a valid region');
            return;
        }
        $(this).attr('disabled', 'disabled');
        $('#backFromAreasButton').attr('disabled', 'disabled');
        $('#updateAreaForm').submit();
    });

    $('#addTerritoryButton').click(function() {
        if ($('#areaIdDD').val() == "0" || !$('#areaIdDD').val()) {
            alert('Please select a valid area');
            return;
        }
        if (!zones.length) {
            alert('Please add a zone');
            return;
        }
        $(this).attr('disabled', 'disabled');
        $('#backFromTerritoryButton').attr('disabled', 'disabled');
        $('#addTerritoryForm').append('<input type="text" name="zones" value="' + zones.join('<>') + '" hidden/>');
        $('#addTerritoryForm').submit();
    });

    $('#updateTerritoryButton').click(function() {
        if ($('#areaIdDD').val() == "0" || !$('#areaIdDD').val()) {
            alert('Please select a valid area');
            return;
        }
        if (!zones.length) {
            alert('Please add a zone');
            return;
        }
        $(this).attr('disabled', 'disabled');
        $('#backFromTerritoryButton').attr('disabled', 'disabled');
        $('#updateTerritoryForm').append('<input type="text" name="zones" value="' + zones.join('<>') + '" hidden/>');
        $('#updateTerritoryForm').submit();
    });

});