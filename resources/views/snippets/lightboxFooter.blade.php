<div id='footerscore{{$submission->id}}'>
<input type='number' class='form-control copyMe{{$submission->id}}' name='footerscoreinput'
       id='footerscoreinput{{$submission->id}}' value='{{$submission->score}}' required>
</div>
<script>
    $('#footerscoreinput{{$submission->id}}').val($('.listscore{{$submission->id}}').val())
    $('.copyMe{{$submission->id}}').change(function () {
        $('.copyMe{{$submission->id}}').val($(this).val());
    });
</script>