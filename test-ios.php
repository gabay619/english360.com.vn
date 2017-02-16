<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    {include="component/sidebar"}
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



        {include="component/tratu"}

        {if condition="!isset($SESSION.uinfo)"}
        <div class="tk_box">
            <a class="tk_box_link" href="/register.php" title="">Đăng ký</a>
            <a class="tk_box_link" href="login.php" title="">Đăng nhập</a>
        </div>
        {else}
        <div class="tk_box">
            <a class="tk_box_link_hi" href="/userprofile.php" title="">Xinchào, {function="getFullDisplayName($SESSION.uinfo)"}</a>

        </div>

        {/if}
        <div class="main">
            <!--<input type="hidden" id="medialink" value="{$obj.medialink}">-->
            <!--<input type="hidden" id="avatar" value="{$obj.avatar}">-->
            <div class="content_cate p5">
                <div class="item_cate">
                    <div class="title_cate">
                        <a href=""><i class="icon-noitieng"></i>{$catname.name}</a>
                        <span class="btn_more_cate"><label></label><label></label><label></label></span>
                        <div class="content_more_cate" style="display: none">
                            <div class="content_more_cate_box">
                                <span class="square_dot"></span>
                                <div class="list_more_cate">
                                    {loop="listcat"}
                                    {$link=makelink::makecat($value._id,$value.type,$value.namenoneutf)}
                                    <a class="active" href="{$link}">{$value.name}</a>
                                    {/loop}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content_item2">
                        <div id="myElement">Loading the player...</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="item_cate">
                    <div class="title_cate">
                        <a href=""><i class="icon-noitieng"></i>Bình luận</a>
                    </div>
                    {include="$commentFile"}
                    <div class="clearfix"></div>
                </div>
                <div class="item_cate">
                    <!-- Tabs -->
                    <div id="tabsholder">
                        <ul class="tabs tabs-style">
                            <li id="tab1">Bài học liên quan</li>
                            <li id="tab2">Bài học mới nhất</li>
                        </ul>
                        <div class="contents marginbot">
                            <div id="content1" class="tabscontent">
                                <ul class="list_1">
                                    {loop="ref"}
                                    {$link=makelink::makethuvien($obj._id,$value._id,$value.name)}
                                    <li> <a href="{$link}"> <span class="thumb_img"><img alt="" src="{$value.avatar}"></span> <span class="title_list">{$value.name}</span> <span class="caption_view">{$value.datecreate}</span> </a> </li>
                                    {/loop}
                                </ul>
                            </div>
                            <div id="content2" class="tabscontent">
                                <ul class="list_1">
                                    {loop="new"}
                                    {$link=makelink::makethuvien($obj._id,$value._id,$value.name)}
                                    <li> <a href="{$link}"> <span class="thumb_img"><img alt="" src="{$value.avatar}"></span> <span class="title_list">{$value.name}</span> <span class="caption_view">{$value.datecreate}</span> </a> </li>
                                    {/loop}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /Tabs -->
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
        <script type="text/javascript">
            jwplayer("myElement").setup({
                playlist: [{
                    file: "http://suckhoe1.vn/fm/uploads/file/e00cf25ad42683b3df678c61f42c6bda/Video/1466070755_nhan_biet_nhung_dau_hieu_som_cua_benh_tu_ky.mp4",
                    image: "/uploads/10-05-2016/1462874845.jpg",
                    tracks: [{
                        file: "/uploads/sub2.vtt",
                        label: "English",
                        kind: "captions",
                        "default": true
                    },
//                        {
//                        file: "/uploads/10-05-2016/1462874168.srt",
//                        kind: "captions",
//                        label: "Tiếng Việt"
//                    }
                    ]
                }],
                width: "100%",
                aspectratio: "16:9",
            });
        </script>
    <script>
        $('.Loa').click(function(e){
            var src = $(this).attr('alt');
            $('#mainaudio').attr('src',src);
            $('#mainaudio')[0].play();
        })
        // Load comment
        var pagenow = 1;
        //    getComment();
        function savearticle(exid) {
            $.post('/incoming.php', {
                act: 'saveexam', id: exid, type: '{$catname.type}',return_url: window.location.href
            }, function (re) {
                if (re.status == 200)
                    alert('Lưu bài học thành công.');
                else if(re.status == 505){
                    alert('Bạn cần đăng nhập để sử dụng chức năng này.');
                    window.location.href = '/login.php';
                }
                else if(re.status == 400){
                    alert('Bạn cần đăng ký gói cước để sử dụng chức năng này.');
                    window.location.href = '/regispack.php';
                }
            });
        }

    </script>
        {include="component/hocmachoi"}

        <div class="clearfix"></div>
    </div>

    <div class="footer">
        <div class="footer_info">
            <div class="logo"></div>
            <p>Copyright © 2014 by IQVN </p>
            <p>All rights reserved</p>
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
        $.post('incoming.php?act=count_notify', {

            id :1
        }, function(res){
            if(res.status==200){
                var htmlx = '<span class="count_notification">'+res.count+'</span>'
                $('.tk_box_link_hi').append(htmlx);
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
