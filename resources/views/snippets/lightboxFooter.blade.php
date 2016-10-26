<input type='number' class='form-control copyMe{{$submission->id}}' name='footerscore'
       id='footerscore{{$submission->id}}' value='{{$submission->score}}' required>
<script>
    $('#footerscore{{$submission->id}}').val($('.listscore{{$submission->id}}').val())
    $('.copyMe{{$submission->id}}').change(function () {
        $('.copyMe{{$submission->id}}').val($(this).val());
    });
</script>