<?php if(!class_exists('raintpl')){exit;}?><div class="main">
    <div class="content_cate p5">
        <div class="item_cate">
            <div class="center hello">Xin chào, <?php echo $SESSION["uinfo"]["phone"];?></div>
            <div class="content_items taikhoan">
                <?php if( $result==1 ){ ?>
                <a href="/regispacked.php"  class="ht">Thông tin gói cước</a>
                <?php }else{ ?>
                <a href="/regispack.php" class="ht">Đăng ký gói cước</a>
                <?php } ?>
                <a href="setup.php" class="ht">Cài đặt riêng tư</a>
                <a href="saveexam.php" class="ht">Bài học đã lưu</a>
                <a href="yourfaq.php" class="ht">Câu hỏi của bạn</a>
                <a href="notify.php" class="ht">Thông báo của bạn</a>
                <?php if( !$is3g ){ ?>
                <a href="logout.php" class="ht">Thoát</a>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

