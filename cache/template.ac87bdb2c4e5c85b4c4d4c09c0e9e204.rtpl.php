<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!--<meta name="MobileOptimized" content="100" />-->
    <!--<meta http-equiv="x-ua-compatible" content="IE=edge" />-->
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="/assets/web/images/favicon.png" type="image/x-icon"/>
    <!--<meta name="MobileOptimized" conte?v=nt="320">-->
    <!--<meta name="apple-mobile-web-app-capable" content="yes">-->
    <!--<meta name="<apple-to></apple-to>uch-fullscreen" content="yes">-->
    <title>English360</title>
    <link href="/template/wap/asset/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/template/wap/asset/css/idangerous.swiper.css">
    <link rel="stylesheet" href="/assets/web/css/font-awesome.css">
    <link rel="stylesheet" href="/template/wap/asset/css/help.css">
    <link rel="stylesheet" href="/template/wap/asset/css/27012016.css">
    <link href="/template/wap/asset/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="/template/wap/asset/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="/template/wap/asset/css/backTop.css" rel="stylesheet" type="text/css" />
    <link href="/template/wap/asset/css/featherlight.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/assets/lib/jwplayer-7.4.2/jwplayer.js"></script>
    <script type="text/javascript" src="/assets/lib/jwplayer-7.4.2/polyfills.base64.js"></script>
    <script type="text/javascript" src="/assets/lib/jwplayer-7.4.2/polyfills.promise.js"></script>
    <script type="text/javascript">jwplayer.key="sP/q5QP+35gezFLCM/h47ykgSjaKjE0jUjCEfQ==";</script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/blockUI.js"></script>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
</head>

<body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-101046121-1', 'auto');
    ga('send', 'pageview');

</script>
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1539737363001576',
            xfbml      : true,
            version    : 'v2.7'
        });
    };

    //    (function(d, s, id) {
    //        var js, fjs = d.getElementsByTagName(s)[0];
    //        if (d.getElementById(id)) return;
    //        js = d.createElement(s); js.id = id;
    //        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4&appId=1539737363001576";
    //        fjs.parentNode.insertBefore(js, fjs);
    //    }(document, 'script', 'facebook-jssdk'));

    FB.api('/me/likes?fields=id', function(response) {
        console.log(response);
        var our_page_id = '986816931397636';
        var user_is_fan = false;
        var likes_count = response.data.length;
        for(i = 0; i < likes_count; i++) {
            if(response.data[i].id === our_page_id) {
                user_is_fan = true;
                break;
            }
        }
        console.log(user_is_fan)
    });
</script>
<div class="wrapper">
<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("component/sidebar") . ( substr("component/sidebar",-1,1) != "/" ? "/" : "" ) . basename("component/sidebar") );?>
<div class="carea">
    <!-- tra từ -->
    <script language="JavaScript" type="text/javascript" src="/assets/lib/jquery-ui/jquery-ui.min.js"></script>
    <link href="/assets/lib/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="/template/wap/asset/js/vdict.ls.js"></script>
    <div id="dialog-trans" title="Tra từ">
        <div id="content_result"></div>
    </div>
<div class="header">
    <ul>
        <li class="left sidebar"><a id="sib_btn" href="javascript:void(0)" title=""></a></li>
        <li> <a href="/"><i class="icon_home_header"></i></a> </li>
        <li><a href="/" class="logo_mbf">MobiFone</a></li>
        <li>
            <div class="m_tsl"> <a href="javascript:;">
                <div class="m_tsl_bt btn_tratu"></div>
            </a> </div>
        </li>
        <li> <a class="btn_search"></a> </li>
    </ul>
    <div class="bg_noel_1"></div>
</div>
<div class="search_type" id="ulglobal2">
    <div class="search_type_box">
        <input type="text" id="keyword" placeholder="Tìm kiếm" name="keyword">
        <!--<a href="" class="btn_search_2"><img src="/template/wap/asset/images/header_icon_search.png" /></a>-->
        <button type="submit" onclick="searchData()">OK</button>
        <button class="btn_close_search"><img src="/template/wap/asset/images/btn_close_search.png"/></button>
    </div>
</div>



    <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("component/tratu") . ( substr("component/tratu",-1,1) != "/" ? "/" : "" ) . basename("component/tratu") );?>

    <?php if( !isset($SESSION["uinfo"]) ){ ?>
    <div class="tk_box">
        <a class="tk_box_link" href="/register.php" title="">Đăng ký</a>
        <a class="tk_box_link" href="/login.php" title="">Đăng nhập</a>
    </div>
    <?php }else{ ?>
    <div class="tk_box">
        <a class="tk_box_link_hi" href="/userprofile.php" title="">Xin chào, <?php echo getFullDisplayName($SESSION["uinfo"]); ?></a>
    </div>

    <?php } ?>
    <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("".$pagefile."") . ( substr("".$pagefile."",-1,1) != "/" ? "/" : "" ) . basename("".$pagefile."") );?>
    <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("component/hocmachoi") . ( substr("component/hocmachoi",-1,1) != "/" ? "/" : "" ) . basename("component/hocmachoi") );?>

        <div class="clearfix"></div>
    </div>

<div class="footer">
    <div class="footer_info">
        <div class="logo"></div>
        <p>Cơ quan chủ quản: Công ty TNHH Truyền thông IQ Việt Nam</p>
        <p>Địa chỉ: Tầng 2 tòa nhà Dinhle, 123B Trần Đăng Ninh, Dịch Vọng, Cầu Giấy, Hà Nội</p>
        <p>Email: cskh@english360.com.vn CSKH: (024) 32474175</p>
        <p>Quản lý nội dung: Bà Lê Thị Lan Anh</p>
        <p><a href="/version.php?v=web" style="text-decoration: underline">Chuyển sang phiên bản WEB</a></p>
    </div>
    <audio style="display: none;width: 0;height: 0;" id="mainaudio" controls></audio>
</div>
</div>
<a id='backTop'>Back To Top</a>
<audio style="display: none; width: 0;height: 0;" id="mainaudio" controls></audio>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
<script src="/template/wap/asset/js/jquery.backTop.min.js"></script>
<script>
    $(document).ready( function() {
        $('#backTop').backTop({
            'position' : 1600,
            'speed' : 500,
            'color' : 'red',
        });
    });
</script>
<!-- JS -->
<script src="/template/wap/asset/js/idangerous.swiper-2.1.min.js"></script>
<script src="/template/wap/asset/js/funcs.js"></script>
<script src="/template/wap/asset/js/giaitri.ui.js"></script>
<script src="/template/wap/asset/js/tytabs.jquery.min.js"></script>
<script src="/template/wap/asset/js/featherlight.min.js"></script>
<script src='https://code.responsivevoice.org/responsivevoice.js'></script>

<!--<script src="../src/jquery.backTop.min.js"></script>-->
<script>
    $(function(){
        countNotify();
        checkCash();
        checkPackage();
    })

    function countNotify(){
        $.post('incoming.php?act=count_notify', {}, function(res){
            if(res.status==200){
                var htmlx = '<span class="count_notification">'+res.count+'</span>'
                $('.tk_box_link_hi').append(htmlx);
                var htmlx2 = '<span class="count_notification" style="float: none; display: inline-block">'+res.count+'</span>'
                $('.your-notify').append(htmlx2);
            }

        })
    }

    function checkCash() {
        $.post('incoming.php?act=check_cash', {}, function(res){
            if(res.status==200){
                $('.check_cash').html(res.info);
            }

        })
    }

    function checkPackage() {
        $.post('incoming.php?act=check_package', {}, function(res){
            if(res.status==200){
                $('.check_package').html(res.info);
            }
        })
    }

</script>

<script>
    $(document).ready(function() {
        $('.btn_tratu').click(function() {
            $('.m_tsl_box').slideToggle("fast");
            $(".show_tratu").html('');
            $('#txtTratu').focus();
            $('#txtTratu').val('');
        });

        $('.Loa').click(function(e){
            var src = $(this).attr('alt');
            $('#mainaudio').attr('src',src);
            $('#mainaudio')[0].play();
        })

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
</script>
<script>

    var mySwiper = new Swiper('.swiper-container',{
        pagination: '.pagination',
        loop:true,
        calculateHeight: true,
        autoplay: 5000,
        grabCursor: true,
        paginationClickable: true
    })


    $(function(){
        $('#keyword').keyup(function(e){
            if(e.keyCode == 13){
                searchData();
            }
        });
        $( ".showTab" ).click(function() {
            $('.tabItem').hide();
            $('.showTab').attr('style','');
            $(this).attr('style','border: 1px solid red;');
            $($(this).attr('data-target')).toggle();
        });
    });
    function toggleSearchInput() {
        $("#ulglobal2").toggle();
    }
    function searchData(){
        var keyword = $('#keyword').val();
        if(keyword != ''){
            window.location = 'search.php?keyword='+keyword;
        }
    }


</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/577dfd36dd7fc0d375f2409c/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
<style>
    .voice{
        text-decoration: underline;
        font-weight: bold;
        color: #146eb4;
    }
    .text-success{
        color: #24C179
    }
    .text-danger{
        color: #FE5252
    }
    .btnMicro{
        width: 25px;
    }
    .popover{
        position: absolute;
        bottom: -36px;
        left: 0;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 0 5px;
        color: #FE5252;
        z-index: 10;
    }
</style>
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
</script>.php
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
