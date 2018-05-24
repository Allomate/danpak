$(document).ready(function() {

    var totalChoices = 1;
    var resultData = "";

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

    $(document).on('click', '.addMore', function() {
        $('#dynamic_adding_choices').append('<div class="row"><div class="col-md-10"><div class="form-group"><input type="text" name="multiple_choices_' + totalChoices + '" class="form-control" placeholder="Multiple choice answers" /></div></div><div class="col-md-2"><div class="row"><div class="col-md-6" style="padding: 2px"><div class="form-group"><button class="btn btn-primary addMore" type="button" style="width: 100%">Add More</button></div></div><div class="col-md-6" style="padding: 2px"><div class="form-group"><button class="btn btn-danger removeThis" type="button" style="width: 100%">Remove</button></div></div></div></div></div>');
        totalChoices++;
    });

    $(document).on('click', '.removeThis', function() {
        $(this).parent().parent().parent().parent().parent().remove();
    });

    $(document).on('click', '.viewResponses', function() {
        var questId = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: $('#getQuestResponseUrlAjax').val(),
            data: { questionnaireId: questId },
            success: function(response) {
                var response = JSON.parse(response);
                $('.responseModalBody').empty();
                $('.responseModalBody').html('<table class="table responsesTable"><thead><tr><th>S.No</th><th>Question</th><th>Answer</th><th>Comments</th><th>Employee</th></tr></thead><tbody></tbody><tfoot><tr><th>S.No</th><th>Question</th><th>Answer</th><th>Comments</th><th>Employee</th></tr></tfoot></table>');
                var sno = 1;
                for (var i = 0; i < response.length; i++) {
                    $('.responsesTable tbody').append('<tr><td>' + sno + '</td><td>' + response[i]["question"] + '</td><td>' + response[i]["answer"] + '</td><td>' + response[i]["comments"] + '</td><td>' + response[i]["employee"] + '</td></tr>');
                    sno++;
                }
                $('.responsesTable').dataTable();
                $('#responsesModal').modal('show');
            }
        });
    });

    $(document).on('click', '.viewChoices', function() {
        var questId = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: $('#getChoicesUrlAjax').val(),
            data: { questionnaireId: questId },
            success: function(response) {
                var response = JSON.parse(response);
                var choices = response["multiple_choices"].split("<$>");
                console.log(choices);
                $('.choicesTable tbody').empty();
                var sno = 1;
                for (var i = 0; i < choices.length; i++) {
                    $('.choicesTable tbody').append('<tr><td>' + sno + '</td><td>' + choices[i] + '</td></tr>');
                    sno++;
                }
                $('.dataTables_length').remove();
                $('.dataTables_filter').remove();
                $('.dataTables_info').remove();
                $('.dataTables_paginate').remove();
                $('#myModal').modal('show');
            }
        });
    });

    $('#createQuestionnaireButton').click(function() {
        if (!$('select[name="group_id"]').val() || parseInt($('select[name="group_id"]').val()) <= 0) {
            if (!$('select[name="individual_id"]').val() || parseInt($('select[name="individual_id"]').val()) <= 0) {
                alert('Please select at least one group or individual');
                return;
            }
        }

        if (!$('input[name="question"]').val()) {
            alert('Please provide a question');
            return;
        }

        $(this).attr('disabled', 'disabled');
        $('#backFromCreateQuestionnaireMessage').attr('disabled', 'disabled');
        var failedResult = false;
        for (var i = 0; i < totalChoices; i++) {
            if ($('input[name="multiple_choices_' + i + '"]').length) {
                if (!$('input[name="multiple_choices_' + i + '"]').val()) {
                    failedResult = true;
                }
                if (!$('input[name="result_data"]').val()) {
                    $('input[name="result_data"]').val($('input[name="multiple_choices_' + i + '"]').val());
                } else {
                    $('input[name="result_data"]').val($('input[name="result_data"]').val() + '<$>' + $('input[name="multiple_choices_' + i + '"]').val());
                }
            }
        }
        if (failedResult) {
            $('input[name="result_data"]').val("");
            $(this).removeAttr('disabled');
            $('#backFromCreateQuestionnaireMessage').removeAttr('disabled');
            alert('Kindly provide choices in all the fields or remove the unneccessary fields');
            return;
        }
        $('#dynamic_adding_choices').remove();
        $('#addQuestionnaireForm').submit();
    });

    if ($('#updateQuestionnaireForm').length) {

        totalChoices = $('input[name="multiple_choices"]').val().split("<$>");

        for (var i = 0; i < totalChoices.length; i++) {
            if (i == 0) {
                $('#dynamic_adding_choices').html('<div class="row"><div class="col-md-10"><div class="form-group"><input type="text" name="multiple_choices_' + i + '" class="form-control" placeholder="Multiple choice answers" value="' + totalChoices[i] + '" /></div></div><div class="col-md-2"><div class="row"><div class="col-md-6" style="padding: 2px"><div class="form-group"><button class="btn btn-primary addMore" type="button" style="width: 100%">Add More</button></div></div></div></div></div>');
            } else {
                $('#dynamic_adding_choices').append('<div class="row"><div class="col-md-10"><div class="form-group"><input type="text" name="multiple_choices_' + i + '" class="form-control" placeholder="Multiple choice answers" value="' + totalChoices[i] + '" /></div></div><div class="col-md-2"><div class="row"><div class="col-md-6" style="padding: 2px"><div class="form-group"><button class="btn btn-primary addMore" type="button" style="width: 100%">Add More</button></div></div><div class="col-md-6" style="padding: 2px"><div class="form-group"><button class="btn btn-danger removeThis" type="button" style="width: 100%">Remove</button></div></div></div></div></div>');
            }
        }
        totalChoices = totalChoices.length;

        $('#updateQuestionnaireButton').click(function() {
            if (!$('select[name="group_id"]').val() || parseInt($('select[name="group_id"]').val()) <= 0) {
                if (!$('select[name="individual_id"]').val() || parseInt($('select[name="individual_id"]').val()) <= 0) {
                    alert('Please select at least one group or individual');
                    return;
                }
            }

            if (!$('input[name="question"]').val()) {
                alert('Please provide a question');
                return;
            }

            $(this).attr('disabled', 'disabled');
            $('#backFromCreateQuestionnaireMessage').attr('disabled', 'disabled');
            var failedResult = false;
            $('input[name="multiple_choices"]').val("");
            for (var i = 0; i < totalChoices; i++) {
                if ($('input[name="multiple_choices_' + i + '"]').length) {
                    if (!$('input[name="multiple_choices_' + i + '"]').val()) {
                        failedResult = true;
                    }
                    if (!$('input[name="multiple_choices"]').val()) {
                        $('input[name="multiple_choices"]').val($('input[name="multiple_choices_' + i + '"]').val());
                    } else {
                        $('input[name="multiple_choices"]').val($('input[name="multiple_choices"]').val() + '<$>' + $('input[name="multiple_choices_' + i + '"]').val());
                    }
                }
            }
            if (failedResult) {
                $('input[name="multiple_choices"]').val("");
                $(this).removeAttr('disabled');
                $('#backFromCreateQuestionnaireMessage').removeAttr('disabled');
                alert('Kindly provide choices in all the fields or remove the unneccessary fields');
                return;
            }
            $('#dynamic_adding_choices').remove();
            $('#updateQuestionnaireForm').submit();
        });

    }

});