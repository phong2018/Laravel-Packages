<div class='w-full overflow-hidden'>
    <div class='{{$classLabel}} float-left' >
         Captcha
         <span class='text-red-500'>*</span>
    </div>
    <div class="{{$classInput}} float-right" >
        <table class='w-full'>
            <td>
                <input id="captcha" type="text" class="form-control
                @if($errors->has('captcha'))
                border-red-500
                @endif
                " placeholder="Enter Captcha" name="captcha">
            </td>
            <td>
                <div class="captcha">
                    <span>{!! captcha_img() !!}</span>
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-danger" class="refresh-captcha" id="refresh-captcha">
                    &#x21bb;
                </button>
            </td>
        </table>
         
        
        
    </div>
</div>

<script type="text/javascript">
    $('#refresh-captcha').click(function () { 
        $.ajax({
            type: 'GET',
            url: 'refresh-captcha',
            success: function (data) { 
                $(".captcha span").html(data.captcha);
            }
        });
    });

</script>