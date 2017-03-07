<div class="row">
    <div class="col-xs-8">
        <img id="captcha" class="" src="{{$captcha}}" alt='captcha' style="height: 34px;width: 100%"/>
    </div>
    <div class="col-xs-4">
        <button class="btn btn-default" id="captcha-refresh" type="button"><i class="glyphicon glyphicon-refresh"></i></button>
    </div>
</div>
<script>
    $(function(){
        $("#captcha-refresh").click(function(){
            $.ajax({
                type: "GET",
                url: "/captcha",
                success:function(captcha)
                {
                    $("#captcha").attr("src",captcha);
                }
            });
        });
    });
</script>