$(document).ready(function() {
    $('#submission-table').dynatable();
    $('.decisionbtnfucker').click(function () {
        var proof_id = $(this).val();
        var element=$(this);
        var scorenumber=element.closest("tr").find('input').val();

        $.ajax({
            type: 'POST',
            url: '/decidesubmission',
            data: {id:proof_id,answ:$(this).hasClass("approve-submission")|0,score:scorenumber},
            success: function (data) {
                //console.log(data);
                element.closest("tr").remove();
                $('#alertsContainer').append("<div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"+data['msg']+"<strong></div>")
/*                $(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert-dismissible").alert('close');
                });*/
            }
        });
    })
});