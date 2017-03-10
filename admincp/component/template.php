<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/jquery-ui.min.css" rel="stylesheet">
    <link href="asset/lib/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet">
    <link href="asset/lib/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
    <link href="asset/lib/timepicker/jquery.timepicker.css" rel="stylesheet">
    <link href="/assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="asset/css/custom.css" rel="stylesheet">
    <script src="asset/js/jquery.min.js"></script>
    <script src="asset/js/jquery-ui.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/lib/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="asset/lib/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="asset/lib/typeahead/bootstrap3-typeahead.min.js"></script>
    <script src="asset/lib/timepicker/jquery.timepicker.js"></script>

</head>

<body>

<div class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">ADMIN</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
<!--                <li class="--><?php //echo $act=="home"?"active":"" ?><!--"><a href="?act=home">Home</a></li>-->
                <?php if(acceptpermiss("category")) { ?><li class="<?php echo $act=="category"?"active":"" ?>"><a href="?act=category">Danh mục</a></li><?php } ?>
                <li class="dropdown <?php echo in_array($act,array("gtcb","luyennguam","hmcaudio"))?"active":"" ?>">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Luyện tập <span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <?php if(acceptpermiss("gtcb")) { ?><li class="<?php echo $act=="gtcb"?"active":"" ?>"><a href="?act=gtcb">Giao tiếp cơ bản</a></li><?php } ?>
                        <?php if(acceptpermiss("hmcaudio")) { ?><li class="<?php echo $act=="hmcaudio"?"active":"" ?>"><a href="?act=hmcaudio">Bài hát tiếng Anh</a></li><?php } ?>
                        <?php if(acceptpermiss("luyennguam")) { ?><li class="<?php echo $act=="luyennguam"?"active":"" ?>"><a href="?act=luyennguam">Luyện ngữ âm</a></li><?php } ?>
                        <?php if(acceptpermiss("nguphap")) { ?><li class="<?php echo $act=="nguphap"?"active":"" ?>"><a href="?act=nguphap">Ngữ pháp</a></li><?php } ?>
                        <?php if(acceptpermiss("hmcgame")) { ?><li class="<?php echo $act=="hmcgame"?"active":"" ?>"><a href="?act=hmcgame">Trò chơi</a></li><?php } ?>
                    </ul>
                </li>
<!--                --><?php //if(acceptpermiss("news")) { ?><!--<li class="--><?php //echo $act=="news"?"active":"" ?><!--"><a href="?act=news">Tin tức</a></li>--><?php //} ?>
                <?php if(acceptpermiss("thuvien")) { ?><li class="<?php echo $act=="thuvien"?"active":"" ?>"><a href="?act=thuvien">Thư viện</a></li><?php } ?>
                <?php if(acceptpermiss("tudien")) { ?><li class="<?php echo $act=="tudien"?"active":"" ?>"><a href="?act=tudien">Từ điển</a></li><?php } ?>

                <li class="dropdown <?php echo in_array($act,array("user_manage","role_manage"))?"active":"" ?>">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">CSKH<span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <?php if(acceptpermiss("comment")) { ?><li class="<?php echo $act=="comment"?"active":"" ?>"><a href="?act=comment">Comment</a></li><?php } ?>
                        <?php if(acceptpermiss("report")) { ?><li class="<?php echo $act=="report"?"active":"" ?>"><a href="?act=report">Vi phạm</a></li><?php } ?>
                        <?php if(acceptpermiss("hoidap")) { ?><li class="<?php echo $act=="hoidap"?"active":"" ?>"><a href="?act=hoidap">Hỏi đáp</a></li><?php } ?>
                    </ul>
                </li>

<!--                --><?php //if(acceptpermiss("hmcaudio") || acceptpermiss("hmcvideo") || acceptpermiss("hmcgame")) { ?>
<!--                    <li class="dropdown --><?php //echo in_array($act,array("hmcaudio","hmcvideo","hmcgame"))?"active":"" ?><!--">-->
<!--                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">Học mà chơi <span class="caret"></span></a>-->
<!--                        <ul role="menu" class="dropdown-menu">-->
<!--                            --><?php //if(acceptpermiss("hmcaudio")) { ?><!--<li class="--><?php //echo $act=="hmcaudio"?"active":"" ?><!--"><a href="?act=hmcaudio">Học TA qua bài hát</a></li>--><?php //} ?>
<!--                            --><?php //if(acceptpermiss("hmcvideo")) { ?><!--<li class="--><?php //echo $act=="hmcvideo"?"active":"" ?><!--"><a href="?act=hmcvideo">Học TA qua video</a></li>--><?php //} ?>
<!--                            --><?php //if(acceptpermiss("hmcgame")) { ?><!--<li class="--><?php //echo $act=="hmcgame"?"active":"" ?><!--"><a href="?act=hmcgame">Học TA qua trò chơi</a></li>--><?php //} ?>
<!--                        </ul>-->
<!--                    </li>-->
<!--                --><?php //} ?>
<!--                --><?php //if(acceptpermiss("chat_view")) { ?><!--<li class="--><?php //echo $act=="chat"?"active":"" ?><!--"><a href="?act=chat">Chat</a></li>--><?php //} ?>

                <?php if(acceptpermiss("show_homecat")) { ?>
                <li class="dropdown <?php echo in_array($act,array("show_menu_wap","show_slideshow","show_homecat","show_newshome"))?"active":"" ?>">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Hiển thị <span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <?php if(acceptpermiss("show_slideshow")) { ?><li class="<?php echo $act=="show_slideshow"?"active":"" ?>"><a href="?act=show_slideshow">Slideshow</a></li><?php } ?>
                        <?php if(acceptpermiss("page")) { ?><li class="<?php echo $act=="page"?"active":"" ?>"><a href="?act=page">Trang</a></li><?php } ?>
                        <li class="<?php echo $act=="hot_lession"?"active":"" ?>"><a href="?act=hot_lession">Bài học nổi bật</a></li>
                    </ul>
                </li>
                <?php } ?>
                <li class="dropdown <?php echo in_array($act,array("event","import"))?"active":"" ?>">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Sự kiện <span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <?php if(acceptpermiss("event")) { ?><li class="<?php echo $act=="event"?"active":"" ?>"><a href="?act=event">Danh sách sự kiện</a></li><?php } ?>
                        <?php if(acceptpermiss("event")) { ?><li class="<?php echo $tact=="event1"?"active":"" ?>"><a href="?act=event&tact=event1">Miễn phí 30 ngày</a></li><?php } ?>
                        <?php if(acceptpermiss("import_hssv_view")) { ?><li class="<?php echo $act=="import"?"active":"" ?>"><a href="?act=import&tact=hssv_view">Đồng hành cùng HSSV</a></li><?php } ?>
                    </ul>
                </li>
                <?php if(acceptpermiss("email")) { ?><li class="<?php echo $act=="email"?"active":"" ?>"><a href="?act=email">Email</a></li><?php } ?>
                <?php if(acceptpermiss("sms")) { ?><li class="<?php echo $act=="sms"?"active":"" ?>"><a href="?act=sms">SMS</a></li><?php } ?>
                <?php if(acceptpermiss("txn")) { ?>
                <li class="dropdown <?php echo in_array($act,array("txn"))?"active":"" ?>">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Thanh toán <span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <li class="<?php echo $act=="package"?"active":"" ?>"><a href="?act=package">Cấu hình học phí</a></li>
                        <?php if(acceptpermiss("txn_card")) { ?><li class="<?php echo $tact=="txn_card"?"active":"" ?>"><a href="?act=txn&tact=txn_card">GD Thẻ cào</a></li><?php } ?>
                        <?php if(acceptpermiss("txn_bank")) { ?><li class="<?php echo $tact=="txn_bank"?"active":"" ?>"><a href="?act=txn&tact=txn_bank">GD Ngân hàng</a></li><?php } ?>
                        <?php if(acceptpermiss("txn_sms")) { ?><li class="<?php echo $tact=="txn_sms"?"active":"" ?>"><a href="?act=txn&tact=txn_sms">GD SMS</a></li><?php } ?>
                        <?php if(acceptpermiss("txn_otp")) { ?><li class="<?php echo $tact=="txn_otp"?"active":"" ?>"><a href="?act=txn&tact=txn_otp">GD OTP</a></li><?php } ?>
                        <?php if(acceptpermiss("txn_cash")) { ?><li class="<?php echo $tact=="txn_cash"?"active":"" ?>"><a href="?act=txn&tact=txn_cash">GD <?php echo Constant::CASH_NAME ?></a></li><?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if(acceptpermiss("aff")) { ?>
                    <li class="dropdown <?php echo in_array($act,array("aff"))?"active":"" ?>">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="?act=aff">Aff <span class="caret"></span></a>
                        <ul role="menu" class="dropdown-menu">
                            <?php if(acceptpermiss("aff_pub")) { ?><li class="<?php echo $act=="aff"&& empty($tact)?"active":"" ?>"><a href="?act=aff">Danh sách Publisher</a></li><?php } ?>
                            <?php if(acceptpermiss("aff_pub")) { ?><li class="<?php echo $act=="aff"&& $tact=='top'?"active":"" ?>"><a href="?act=aff&tact=top">Top Publisher</a></li><?php } ?>
                            <?php if(acceptpermiss("aff_withdraw")) { ?><li class="<?php echo $act=="aff"&& $tact=="withdraw"?"active":"" ?>"><a href="?act=aff&tact=withdraw">Lệnh rút tiền</a></li><?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <li class="dropdown <?php echo in_array($act,array("user_manage","role_manage"))?"active":"" ?>">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Hệ thống<span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <?php if(acceptpermiss("user_manage")) { ?><li class="<?php echo $act=="user_manage"?"active":"" ?>"><a href="?act=user_manage">Người dùng</a></li><?php } ?>
                        <?php if(acceptpermiss("role_manage")) { ?><li class="<?php echo $act=="role_manage"?"active":"" ?>"><a href="?act=role_manage">Nhóm quyền</a></li><?php } ?>
                        <?php if(acceptpermiss("log")) { ?><li class="<?php echo $act=="log"?"active":"" ?>"><a href="?act=log">Lịch sử sử dụng</a></li><?php } ?>
                        <?php if(acceptpermiss("config")) { ?><li class="<?php echo $act=="config"?"active":"" ?>"><a href="?act=config">Cấu hình</a></li><?php } ?>
                        <?php if(acceptpermiss("popup")) { ?><li class="<?php echo $act=="popup"?"active":"" ?>"><a href="?act=popup">Quản lý popup</a></li><?php } ?>
                        <?php if(acceptpermiss("banner")) { ?><li class="<?php echo $act=="banner"?"active":"" ?>"><a href="?act=banner">Quản lý banner</a></li><?php } ?>
                        <?php if(acceptpermiss("filemanager")) { ?><li class=""><a target="_blank" href="/fm/index.php">Quản lý File</a></li><?php } ?>
                        <li class=""><a href="logout.php">Thoát (<b><?php echo $_SESSION['uinfo']['username']?></b>)</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>

<div class="container">

    <div class="starter-template">
        <div class="row text-left">
        <?php include($page); ?>
        </div>
    </div>

</div><!-- /.container -->
<script>
    $('#checkall').click(function() {
        if($(this).is(':checked')) $('.checkitem').prop('checked', true);
        else $('.checkitem').prop('checked', false);
    });

    $(function(){
        $('.selectpicker').selectpicker();
        $( ".datepicker" ).datepicker({"dateFormat":"dd/mm/yy"});
        $('.timepicker').timepicker({
            'showDuration': true,
            'timeFormat': 'H:i'
        });
    })
</script>
</body>
</html>
