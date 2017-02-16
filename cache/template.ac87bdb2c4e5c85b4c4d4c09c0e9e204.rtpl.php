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
    <script src="/template/wap/asset/js/jquery-1.10.1.min.js"></script>
</head>

<body>
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
    <script>
//        $(function(){
//            $( "#dialog-trans" ).dialog({
//                autoOpen: false,
//                modal:true,
//                closeOnEscape: true,
//                draggable: false,
//                width:450,
//                create: function() {
//                    $(this).css("maxHeight", 600);
//                }
//            });
//        });
    </script>
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
        <a class="tk_box_link" href="login.php" title="">Đăng nhập</a>
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
        <p>Copyright © 2014 by IQVN </p>
        <p>All rights reserved</p>
        <p><a href="/version.php?v=web" style="text-decoration: underline">Chuyển sang phiên bản WEB</a></p>
    </div>
    <audio style="display: none;width: 0;height: 0;" id="mainaudio" controls></audio>
</div>
</div>
<a id='backTop'>Back To Top</a>
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
<!--<script src="../src/jquery.backTop.min.js"></script>-->
<script>
    $(function(){
        countNotify();
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

</script>

<script>
    $(document).ready(function() {
        $('.btn_tratu').click(function() {
            $('.m_tsl_box').slideToggle("fast");
            $(".show_tratu").html('');
            $('#txtTratu').focus();
            $('#txtTratu').val('');
        });
    });
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

</body>
</html>
