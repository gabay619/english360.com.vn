<div class="footer">
{{--<div class="border_noel"></div>--}}
    <div class="w1170">
        @banner()
        <div class="left info_boss">
            <div class="logo_ib block">
                <a href=""><img src="/assets/web/images/logo_top.png" alt="english360.vn"></a>
            </div>
            <div class="app_link_footer block">
                <a href="https://itunes.apple.com/us/app/english360/id1128662378?ls=1&mt=8" target="_blank"><img src="/assets/web/images/iosstore.png" alt="english360.vn"></a>
                <a href="#"><img src="/assets/web/images/googlestore.png" alt="english360.vn"></a>
            </div>
            <div class="list_p_ib block">
                <p>Cơ quan chủ quản: Công ty TNHH Truyền thông IQ Việt Nam</p>
                <p>Địa chỉ: Tầng 2 tòa nhà Dinhle, 123B Trần Đăng Ninh, Dịch Vọng, Cầu Giấy, Hà Nội</p>
                {{--<p>Giấy phép MXH số 2332/GP-BTTTT do Bộ Thông tin và Truyền thông cấp ngày 15/11/2015/08/2014</p>--}}
                <p>Email: cskh@english360.com.vn CSKH: (024) 32474175</p>
                <p>Quản lý nội dung: Bà Lê Thị Lan Anh</p>
                <p class="sub_link">
                    {{--<a href="/trang/gioi-thieu.html">Giới thiệu</a>--}}
                    <a href="/trang/dieu-khoan.html">Điều khoản</a>
                    <a href="/version.php?v=wap">Chuyển sang phiên bản WAP</a>
                </p>
            </div>
        </div>
        <div class="right menu_bottom_ib">
            <a href="/nguoi-noi-tieng.html">Người nổi tiếng</a>
            <a href="/giao-tiep-co-ban.html">Giao tiếp cơ bản</a>
            <a href="/bai-hat.html">Bài hát</a>
            <a href="/video.html">Video</a>
            <a href="/radio.html">Radio</a>
            <a href="/phim.html">Phim</a>
            <a href="/tieng-anh-hang-ngay.html">Tiếng Anh hàng ngày</a>
            <a href="/thanh-ngu.html">Thành ngữ</a>
            <a href="/tu-dien.html">Từ điển</a>
        </div>
    </div>
</div>
<div class="clear"></div>

@right_tool()

<audio style="width: 0;height: 0;" id="mainaudio" controls></audio>
<script src="/assets/web/js/me.js" type="text/javascript"></script>


<!-- bxSlider Javascript file -->
<script src="/assets/web/js/jquery.bxslider.min.js"></script>
<script>
//    $('.Loa').click(function(e){
//        var src = $(this).attr('alt');
//        $('#mainaudio').attr('src',src);
//        $('#mainaudio')[0].play();
//    });
    var loa = $('.Loa');
    loa.each(function(){
        var src = $(this).attr('alt');
        html = '<a href="javascript:playAudio(\''+src+'\')"><i class="fa fa-fw"></i></a>';
        $(this).after(html);
        $(this).hide();
    });

    function checkPhrase(ph1,ph2){
        return ph1.toLowerCase().replace(/[^a-zA-Z1-9]/g, "") == ph2.toLowerCase().replace(/[^a-zA-Z1-9]/g, "");
    }

    function getMobileOperatingSystem() {
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;

        // Windows Phone must come first because its UA also contains "Android"
        if (/windows phone/i.test(userAgent)) {
            return "Windows Phone";
        }

        if (/android/i.test(userAgent)) {
            return "Android";
        }

        // iOS detection from: http://stackoverflow.com/a/9039885/177710
        if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
            return "iOS";
        }

        return "unknown";
    }

//End voice

    function playAudio(link){
        $('#mainaudio').attr('src',link);
        $('#mainaudio')[0].play();
    }

    function soundCorrect() {
        playAudio('/assets/sound/correct.mp3');
    }

    function soundInCorrect() {
        playAudio('/assets/sound/incorrect.mp3');
    }

    function soundCongratulation(){
        playAudio('/assets/sound/congratulation.mp3');
    }

    $(function(){
        $('.bxslider').bxSlider({
            auto:true,
            //duration:3000,
        });
        $('.bxslider2').bxSlider({
            auto:true,
            minSlides: 3,
            maxSlides: 4,
            slideWidth: 200
        });

        $('.slider1').bxSlider({
            slideWidth: 150,
            minSlides: 4,
            maxSlides: 5,
            slideMargin: 20,
            //auto:true,
            startSlides:1
        });

        //gửi mã xac thực
        $('.send-authKey-btn').click(function(){
            parent = $(this).parents('.content_dangkyTK');
            phone = parent.find('.txtPhone2').val();
            $.post('/user/send-pass', {
                phone: phone, _token: '{{csrf_token()}}'
            }, function(result){
                console.log(result);
                if(result.success){
                    parent.find('.authkeyInfo').show();
                    parent.find('.txtAuthKey').focus();
                    parent.find('.txtPhone2').prop('disabled', true);
                    parent.find('.send-authKey-mss').hide();
                }else{
                    parent.find('.registerAjaxMsg').html(result.message);
                    parent.find('.txtPhone2').focus();
                }
            }, 'json')
        });
        $('.txtPhone2').keyup(function(){
            parent = $(this).parents('.content_dangkyTK');
            parent.find('.registerAjaxMsg').html('');
        });
        //Đăng ký tài khoản
        $('.btn_register').click(function(){
            $(this).hide();
            parent = $(this).parents('.content_dangkyTK');
            email = parent.find('.txtEmail').val();
            password = parent.find('.txtPassword').val();
            password_confirmation = parent.find('.txtPasswordConfirmation').val();
            $.post('/user/register', {
                email:email, password: password, password_confirmation:password_confirmation, _token: '{{csrf_token()}}'
            }, function(result){
                if(result.success){
                    $.featherlight.close();
                    showMss(result.message);
                }else{
                    parent.find('.registerAjaxMsg').html(result.message);
//                    parent.find('.txtAuthKey').focus();
                }
                parent.find('.btn_register').show();
            }, 'json')
        });
        $('.txtAuthKey').keyup(function(){
            parent = $(this).parents('.content_dangkyTK');
            parent.find('.authkeyAjaxMsg').html('');
        });

        //Đăng ký tài khoản
        $('.btn_dangkyTK').click(function(){
            parent = $(this).parents('.content_dangkyTK');
            displayname = parent.find('.txtDisplayname').val();
            email = parent.find('.txtEmail').val();
            password = parent.find('.txtPassword').val();
            password_confirmation = parent.find('.txtPasswordConfirmation').val();
            $.post('/user/register', {
                displayname: displayname, email: email, password: password, password_confirmation: password_confirmation, _token: '{{csrf_token()}}'
            }, function(result){
                if(result.success){
                    location.reload();
                }else{
                    parent.find('.infoAjaxMsg').html(result.message);
                }
            }, 'json')
        });
        $('.registerInfo input').keyup(function(){
            parent = $(this).parents('.content_dangkyTK');
            parent.find('.infoAjaxMsg').html('');
        });


    })

    function showMss(mss){
        bootbox.alert(
                '<div style="font-size: 14px; text-align: center"><p>'+mss+'</p></div>'
                , function(){
                    $('.modal').modal('hide');
                });
        setTimeout(function(){
            $('.modal').modal('hide');
        }, 5000);
    }
</script>

<!-- Tao tai khoan moi lightbox -->
<script src="/assets/web/js/featherlight.min.js" type="text/javascript"></script>
<div class="lightbox" id="fl1">
    <!--<h2 class="heading_lightbox">Đăng ký tài khoản</h2>-->
    <div class="content_lightbox">
        <div class="content_dangkyTK">
            <p class="p_avatar center"><label class="icon_ava"><i class="fa fa-fw"></i></label></p>
            <p><span class="registerAjaxMsg" style="color:red;"></span></p>
            <p><input class="input_1 txtEmail" type="text" placeholder="Email" /></p>
            <p><input type="password" class="input_1 input_uf txtPassword"  placeholder="Nhập mật khẩu"/></p>
            <p><input type="password" class="input_1 input_uf txtPasswordConfirmation"  placeholder="Xác nhận mật khẩu"/></p>
            <p class="center"><a href="javascript:void(0);" class="btn_x btn_blue btn_register">Đăng ký</a></p>
            <p style="text-align: center">hoặc đăng ký bằng</p>
            <p class="center">
                <a href="/user/login?redirect=1" class="social-icon fb"></a>
                <a href="/gg-callback.html" class="social-icon gg"></a>
                {{--<a href="/user/login?redirect=1" class="btn_x btn_blue" style="background-color: rgb(64,93,155) !important;">Đăng ký bằng Facebook</a>--}}
            </p>
            {{--<p class="send-authKey-mss">Để xác thực số điện thoại trên là của bạn, vui lòng <strong><a href="javascript:void(0);" class="text-link-3 send-authKey-btn">Click vào đây</a></strong> để nhận mật khẩu mà chúng tôi gửi qua SMS.</p>--}}
            {{--<div class="authkeyInfo" style="display: none">--}}
                {{--<p><span style="color: green">Vui lòng nhập mật khẩu vào ô bên dưới</span></p>--}}
                {{--<p><span class="authkeyAjaxMsg" style="color:red;"></span></p>--}}
                {{--<p><input type="password" class="input_1 input_uf txtAuthKey"  placeholder="Nhập mật khẩu"/></p>--}}
                {{--<p class="center"><a href="javascript:void(0);" class="btn_x btn_blue btn_check_Auth">Đăng nhập</a></p>--}}
                {{--<p><a href="">Lấy lại mật khẩu--}}
                    {{--</a></p>--}}
            {{--</div>--}}
        </div>
    </div>
</div>
@chatbox()

<script src="/assets/lib/bootbox/bootbox.min.js"></script>
<script src="/assets/web/js/cookie.js"></script>
<script src="/assets/web/js/vdict.chinhnc.js"></script>
{{--<script language='javascript' src="/assets/web/js/vdict.chinhnc.js" charset="utf-8"></script>--}}
{{--<div style="height: 200px; width: 200px; position: fixed; right: 0; top: 200px; background: blue">--}}
    {{--<input type="text" id="txtTratu">--}}
    {{--<button onclick="tratu();">Search</button>--}}
{{--</div>--}}
{{--<script>--}}
    {{--function tratu(){--}}
        {{--word = $('#txtTratu').val();--}}
        {{--dict = 'av';--}}
        {{--lookup(word, dict);--}}
    {{--}--}}
{{--</script>--}}
<style>
    /*.modal-dialog{*/
        /*margin-top: 150px;*/
    /*}*/
    .modal-footer{
        text-align: center;
        margin-top: 0;
    }
    .modal-footer button{
        width: 20%;
    }
    .voice{
        text-decoration: underline;
        cursor: pointer;
        color: #428bca;
    }
</style>
@popup()
@event()
{{--@event_welcome()--}}
<!-- Google Code dành cho Thẻ tiếp thị lại -->
<!--------------------------------------------------
Không thể liên kết thẻ tiếp thị lại với thông tin nhận dạng cá nhân hay đặt thẻ tiếp thị lại trên các trang có liên quan đến danh mục nhạy cảm. Xem thêm thông tin và hướng dẫn về cách thiết lập thẻ trên: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
    var google_tag_params = {
        edu_pid: 'REPLACE_WITH_VALUE',
        edu_plocid: 'REPLACE_WITH_VALUE',
        edu_pagetype: 'REPLACE_WITH_VALUE',
        edu_totalvalue: 'REPLACE_WITH_VALUE',
    };
</script>
<script type="text/javascript">
    / <![CDATA[ /
    var google_conversion_id = 975534012;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    / ]]> /
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/975534012/?guid=ON&amp;script=0"/>
    </div>
</noscript>
</body>
</html>