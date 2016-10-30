$(document).ready(function () {
    $('#submission-table').dynatable({
        readers: {
            'sortsubmissionscore': function (el, record) {
                return Number(el.innerHTML) || 0;
            }
        },
        features: {
            paginate: false,//decideSubmission() and pagination make issues.
            // Removing tables does not save in dynatable. We would need a more complicated data structure to support that


        },
    }).bind('dynatable:afterUpdate', function (e, dynatable) {
        decideSubmission()// we must run this again whenever the search function was used because it messes things up or we go to another page
    });


    function decideSubmission() {
        $('.decisionbtnfucker').click(function () {
            var proof_id = $(this).val();
            var element = $(this);
            var scorenumber = element.closest("tr").find('input').val();

            $.ajax({
                type: 'POST',
                url: '/decidesubmission',
                data: {id: proof_id, answ: $(this).hasClass("approve-submission") | 0, score: scorenumber},
                success: function (data,textStatus,xhr) {
                    //console.log(data);
                    console.log(xhr);
                    if (xhr.status=='200') {
                        element.closest("tr").remove();
                        $('#alertsContainer').append("<div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" + data['msg'] + "<strong></div>")
                    }
                    else{
                        $('#alertsContainer').append("<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" + data['msg'] + "<strong></div>")
                    }
                }
            });
        })
    }

    decideSubmission()


});