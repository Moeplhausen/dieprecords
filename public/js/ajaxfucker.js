$(document).ready(function() {
    $('#submission-table').dynatable();
    $('.decisionbtnfucker').click(function () {
        var proof_id = $(this).val();
        var element=$(this);

        $.ajax({
            type: 'POST',
            url: '/decidesubmission',
            data: {id:proof_id,answ:$(this).hasClass("approve-submission")|0},
            success: function (data) {
                element.closest("tr").remove();
                $('#alertsContainer').append("<div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"+data['msg']+"<strong></div>")
            }
        });
    })


});