$(document).ready(function () {
    var submissiontables = ['#submission-table-desktop', '#submission-table-mobile'];
    submissiontables.forEach(function (tableid) {
        $(tableid).dynatable({
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
    });

    function updateTableContents() {
        $('[data-toggle="tooltip"]').tooltip();
        $(".button-x-corner").unbind('click');
        $('.button-x-corner').click(function () {
            console.log("click");
            $(this).attr('disabled','true');
            var proof_id = $(this).attr('submission');
            var score=$(this).attr('submission');
            var name=$(this).attr('submittername');

            $.ajax({
                type: 'POST',
                url: DECIDESUBMISSIONURL,
                data: {id: proof_id, answ: 0, score: score,name:name,decided:0},
                success: function (data, textStatus, xhr) {
                    //console.log(data);
                    console.log(xhr);
                    if (xhr.status == '200') {
                        $('#alertsContainer').append("<div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" + data['msg'] + "<strong></div>")
                    }
                    else {
                        $('#alertsContainer').append("<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" + data['msg'] + "<strong></div>")
                    }
                }
            });
        })


    }


    function decideSubmission() {
        $(".decisionbtnfucker").unbind('click');
        $('.decisionbtnfucker').click(function () {
            var proof_id = $(this).val();
            var element = $(this);
            var inputs=(element.closest("tr").find('input'));
            var name = inputs[0].value
            var scorenumber = inputs[1].value;

            element.closest("tr").find('input,button').attr('disabled','true');

            $.ajax({
                type: 'POST',
                url: DECIDESUBMISSIONURL,
                data: {id: proof_id, answ: $(this).hasClass("approve-submission") | 0, score: scorenumber,name:name,decided:1},
                success: function (data, textStatus, xhr) {
                    //console.log(data);
                    console.log(xhr);
                    if (xhr.status == '200') {
                        element.closest("tr").remove();
                        $('#alertsContainer').append("<div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" + data['msg'] + "<strong></div>")
                    }
                    else {
                        $('#alertsContainer').append("<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" + data['msg'] + "<strong></div>")
                    }
                }
            });
        })
    }

    decideSubmission()


});