<?php if(!class_exists('raintpl')){exit;}?><div class="my_sidebar" id="scrollbar_sidebar">
    <div class="list_sb sidebar">
        <ul>
            <?php if( !isset($SESSION["uinfo"]) ){ ?>
            <li> <a href="login.php" class="btn btnlogin_sb"><i class="icon_logo"></i>
                <div class="clearfix"></div>
                <span>Tài khoản</span></a>
            </li>
            <?php }else{ ?>
            <li>
                <a href="/userprofile.php" class="btn btnlogin_sb"><i class="icon_logo"></i>
                    <div class="clearfix"></div>
                    <span>Xin chào, <?php echo getFullDisplayName($SESSION["uinfo"]); ?> </span>
                </a>

            <?php } ?>

            <li><a href="index.php"><i class="icon-home"></i>Trang chủ</a></li>
            <li><a href="/category.php?catid=1450844989"><i class="icon-noitieng"></i>Người nổi tiếng</a></li>
            <li><a href="gtcb.php"><i class="icon-giaotiep"></i>Giao tiếp cơ bản</a></li>
            <li><a href="/category.php?catid=1450861603"><i class="icon-phim"></i>Phim</a></li>
            <li><a href="/hmcaudio.php"><i class="icon-nhac"></i>Bài hát</a></li>
            <li><a href="/hmcgame.php"><i class="icon-trochoi"></i>Trò chơi</a></li>
            <li><a href="/category.php?catid=1427183162"><i class="icon-hocvideo"></i>Video</a></li>
            <li><a href="/category.php?catid=1427344702"><i class="icon-hocaudio"></i>Radio</a></li>
            <li><a href="/category.php?catid=1427183137"><i class="icon-hocthanhngu"></i>Thành ngữ</a></li>
            <li><a href="/category.php?catid=1428995217"><i class="icon-hangngay"></i>Tiếng Anh hàng ngày</a></li>
            <li><a href="/category.php?catid=1425608584"><i class="icon-tudien"></i>Từ điển</a></li>
            <li><a href="/luyennguam.php"><i class="icon-nguam"></i>Ngữ âm</a></li>
            <li><a href="/category.php?catid=1427344743"><i class="icon-kinhnghiem"></i>Kinh nghiệm</a></li>
            <li><a href="/hoidap.php"><i class="icon-hmc"></i>Hỏi đáp</a></li>
            <li><a href="/page.php?slug=gioi-thieu"><i class="icon-gioithieu"></i>Giới thiệu dịch vụ</a></li>
            <li><a href="https://itunes.apple.com/us/app/english360/id1128662378" target="_blank"><i class="icon-gioithieu"></i>Tải app iOS</a></li>
            <li><a href="http://english360.vn/uploads/app/English360_309.apk" target="_blank"><i class="icon-gioithieu"></i>Tải app Android</a></li>
            <li><a href="/page.php?slug=dieu-khoan"><i class="icon-dieukhoan"></i>Điều khoản sử dụng </a></li>
            <!--<?php if( isset($SESSION["uinfo"]) ){ ?>-->
            <!--<li><a href="/logout.php">Thoát </a></li>-->
            <!--<?php } ?>-->
        </ul>
    </div>
</div>