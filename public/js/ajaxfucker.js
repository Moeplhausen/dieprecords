$(document).ready(function() {
  //  $('#submission-table').dynatable();
    $('.decisionbtnfucker').click(function () {
        var proof_id = $(this).val();
        var element=$(this);
        console.log("click");

        $.ajax({
            type: 'POST',
            url: '/decidesubmission',
            data: {id:proof_id,answ:$(this).hasClass("approve-submission")|0},
            success: function (data) {
                console.log(data);
                console.log(element.closest("tr"));
                element.closest("tr").remove();
            }
        });
    })


});