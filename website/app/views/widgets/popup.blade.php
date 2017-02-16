<link rel="stylesheet" href="/assets/lib/fancybox2/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="/assets/lib/fancybox2/jquery.fancybox.pack.js?v=2.1.5"></script>
<a href="#pop" class="fancybox" style="display:none;">Open</a>

<div id="pop" style="display:none;">
    {{$popup->content}}
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox({
            autoSize: true,
            beforeLoad : function() {
//                this.width = 800;
//                this.height = 450;
            }
        });
        var now = Date.now();


        checkCookieForPopup();
    });

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
    }

    function checkCookieForPopup() {
        var now = Date.now();
        var popup_count = getCookie("popup_{{$popup->_id}}");
        var popup_time = getCookie("popup_time_{{$popup->_id}}");
        popup_time = popup_time == "" ? 0 : popup_time;
        timeout = {{$popup->timeout}};
        if((now - popup_time)/1000 < {{$popup->distance_time}}){
            timeout = timeout + {{$popup->distance_time}} - (now - popup_time)/1000;
        }

        console.log(timeout);
        if(popup_count == "")
            popup_count = 0;
        if(popup_count < {{$popup->count_on_day}}){
            setTimeout(function () {
                showPopup();
                setCookie("popup_{{$popup->_id}}", parseInt(popup_count)+1, 1);
                setCookie("popup_time_{{$popup->_id}}", now , 1);
{{--                setCookie("popup_timeout_{{$popup->_id}}", "" , 1);--}}
            }, timeout * 1000)
        }
        console.log((now - popup_time)/1000);
        console.log(popup_count);
    }

    function showPopup(){
        $(".fancybox").trigger('click');
        if($('#pop video').get(0))
            $('#pop video').get(0).play();
    }
</script>
