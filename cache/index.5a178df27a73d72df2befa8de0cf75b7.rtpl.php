<?php if(!class_exists('raintpl')){exit;}?><div class="main">


<div class="swiper-container slide">
    <div class="swiper-wrapper">
        <?php $counter1=-1; if( isset($dataSlide) && is_array($dataSlide) && sizeof($dataSlide) ) foreach( $dataSlide as $key1 => $value1 ){ $counter1++; ?>
        <!--<?php $link=$this->var['link']=makelink::makenews($value1["_id"],$value1["name"]);?>-->
        <div class="swiper-slide">
            <a href="<?php echo $value1["url"];?>">
                <img src="<?php echo $value1["avatar"];?>#" alt="<?php echo $value1["name"];?>"/>
                <span class="caption">
                    <span class="title_s"><?php echo $value1["name"];?></span>
                </span>
            </a>
        </div>
        <?php } ?>
    </div>
    <div class="pagination"></div>
</div>
    <!--<div class="banner_noel">-->
        <!--<a href=""><img src="/template/wap/asset/images/banner_noel.png" alt=""></a>-->
    <!--</div>-->
<div class="content_cate p5">
    <div class="item_cate">
        <div class="title_cate">
            <a href="/category.php?catid=1450844989"><i class="icon-noitieng"></i>Người nổi tiếng</a>
            <?php if( count($listcatfamous) > 0 ){ ?>
            <span class="btn_more_cate"><label></label><label></label><label></label></span>
            <div class="content_more_cate" style="display: none">
                <div class="content_more_cate_box">
                    <span class="square_dot"></span>
                    <div class="list_more_cate">
                        <?php $counter1=-1; if( isset($listcatfamous) && is_array($listcatfamous) && sizeof($listcatfamous) ) foreach( $listcatfamous as $key1 => $value1 ){ $counter1++; ?>
                        <?php $link=$this->var['link']=makelink::makecat($value1["_id"],$value1["type"],$value1["namenoneutf"]);?>
                        <a class="active" href="<?php echo $link;?>"><?php echo $value1["name"];?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="content_item">
            <?php $link=$this->var['link']=makelink::makethuvien(1450844989,$objfamous["_id"],$objfamous["name"]);?>
            <a class="item_full" href="<?php echo $link;?>">
                <span class="thumb_img"><img src="<?php echo $objfamous["avatar"];?>" alt=""></span>
                <span class="caption"> <span class="title_s"><?php echo $objfamous["name"];?></span> </span>
            </a>
        </div>
        <div class="content_items">
            <?php $counter1=-1; if( isset($listfamous) && is_array($listfamous) && sizeof($listfamous) ) foreach( $listfamous as $key1 => $value1 ){ $counter1++; ?>
            <?php $link=$this->var['link']=makelink::makethuvien(1450844989,$value1["_id"],$value1["name"]);?>
            <ul class="list_1">
                <li> <a href="<?php echo $link;?>"> <span class="thumb_img"><img src="<?php echo $value1["avatar"];?>" alt=""></span> <span class="title_list"><?php echo $value1["name"];?></span> <span class="caption_view"><?php echo $value1["datecreate"];?></span> </a> </li>
            </ul>
            <?php } ?>
        </div>
        <div class="content_item">
            <div class="btn_xemthem">
                <a class="btn_1" href="/category.php?catid=1450844989" title="">Xem thêm</a>
            </div>
        </div>
    </div>
    <div class="item_cate">
        <div class="title_cate">
            <a href="/gtcb.php"><i class="icon-giaotiep"></i>Giao tiếp cơ bản</a>
            <?php if( count($listcatgtcb) > 0 ){ ?>
            <span class="btn_more_cate"><label></label><label></label><label></label></span>
            <div class="content_more_cate" style="display: none">
                <div class="content_more_cate_box">
                    <span class="square_dot"></span>
                    <div class="list_more_cate">
                        <?php $counter1=-1; if( isset($listcatgtcb) && is_array($listcatgtcb) && sizeof($listcatgtcb) ) foreach( $listcatgtcb as $key1 => $value1 ){ $counter1++; ?>
                        <?php $link=$this->var['link']=makelink::maketypegtcb($value1["_id"],$value1["namenoneutf"]);?>
                        <a class="active" href="<?php echo $link;?>"><?php echo $value1["name"];?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="content_item">
            <?php $link=$this->var['link']=makelink::makegtcb($objgtcb["_id"],$objgtcb["name"]);?>
            <a class="item_full" href="<?php echo $link;?>">
                <span class="thumb_img"><img src="<?php echo $objgtcb["avatar"];?>" alt=""></span>
                <span class="caption"> <span class="title_s"><?php echo $objgtcb["name"];?></span> </span>
            </a>
        </div>
        <div class="content_items">
            <?php $counter1=-1; if( isset($listgtcb) && is_array($listgtcb) && sizeof($listgtcb) ) foreach( $listgtcb as $key1 => $value1 ){ $counter1++; ?>
            <?php $link=$this->var['link']=makelink::makegtcb($value1["_id"],$value1["name"]);?>
            <ul class="list_1">
                <li> <a href="<?php echo $link;?>"> <span class="thumb_img"><label class="ic_playing"></label><img src="<?php echo $value1["avatar"];?>" alt=""></span> <span class="title_list"><?php echo $value1["name"];?></span> <span class="caption_view"> <?php echo $value1["datecreate"];?></span> </a> </li>
            </ul>
            <?php } ?>
        </div>
        <div class="content_item">
            <div class="btn_xemthem">
                <a class="btn_1" href="/gtcb.php" title="">Xem thêm</a>
            </div>
        </div>
    </div>
    <div class="item_cate">
        <div class="title_cate">
            <a href="/category.php?catid=1427183162"><i class="icon-hocvideo"></i>Video</a>
            <?php if( count($listcatvideo) > 0 ){ ?>
            <span class="btn_more_cate"><label></label><label></label><label></label></span>
            <div class="content_more_cate" style="display: none">
                <div class="content_more_cate_box">
                    <span class="square_dot"></span>
                    <div class="list_more_cate">
                        <?php $counter1=-1; if( isset($listcatvideo) && is_array($listcatvideo) && sizeof($listcatvideo) ) foreach( $listcatvideo as $key1 => $value1 ){ $counter1++; ?>
                        <!--<?php $link=$this->var['link']=makelink::maketypethuvien($value1["_id"],$value1["namenoneutf"]);?>-->
                        <?php $link=$this->var['link']=makelink::makecat($value1["_id"],$value1["type"],$value1["namenoneutf"]);?>
                        <a class="active" href="<?php echo $link;?>"><?php echo $value1["name"];?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="content_item">
            <?php $link=$this->var['link']=makelink::makethuvien(1427183162,$objvideo["_id"],$objvideo["name"]);?>
            <a class="item_full with_player" href="<?php echo $link;?>">
                <span class="thumb_img"><label class="ic_playing"></label><img src="<?php echo $objvideo["avatar"];?>" alt=""></span>
                <span class="caption"> <span class="title_s"><?php echo $objvideo["name"];?></span> </span>
            </a>
        </div>
        <div class="content_items">
            <?php $counter1=-1; if( isset($listvideo) && is_array($listvideo) && sizeof($listvideo) ) foreach( $listvideo as $key1 => $value1 ){ $counter1++; ?>
            <?php $link=$this->var['link']=makelink::makethuvien(1427183162,$value1["_id"],$value1["name"]);?>
            <ul class="list_1">
                <li> <a href="<?php echo $link;?>"> <span class="thumb_img"><label class="ic_playing"></label><img src="<?php echo $value1["avatar"];?>" alt=""></span> <span class="title_list"><?php echo $value1["name"];?></span> <span class="caption_view"> <?php echo $value1["datecreate"];?></span> </a> </li>
            </ul>
            <?php } ?>
        </div>
        <div class="content_item">
            <div class="btn_xemthem">
                <a class="btn_1" href="/category.php?catid=1427183162" title="">Xem thêm</a>
            </div>
        </div>
    </div>
    <div class="item_cate">
        <div class="title_cate"><a href="/category.php?catid=1427344702"><i class="icon-hocaudio"></i>Radio</a>
            <?php if( count($listcatradio) > 0 ){ ?>
            <span class="btn_more_cate"><label></label><label></label><label></label></span>
            <div class="content_more_cate" style="display: none">
                <div class="content_more_cate_box">
                    <span class="square_dot"></span>
                    <div class="list_more_cate">
                        <?php $counter1=-1; if( isset($listcatradio) && is_array($listcatradio) && sizeof($listcatradio) ) foreach( $listcatradio as $key1 => $value1 ){ $counter1++; ?>
                        <?php $link=$this->var['link']=makelink::makecat($value1["_id"],$value1["type"],$value1["namenoneutf"]);?>
                        <a class="active" href="<?php echo $link;?>"><?php echo $value1["name"];?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="content_item">
            <?php $link=$this->var['link']=makelink::makethuvien(1427344702,$objaudio["_id"],$objaudio["name"]);?>
            <a class="item_full" href="<?php echo $link;?>">
                <span class="thumb_img"><img src="<?php echo $objaudio["avatar"];?>" alt=""></span>
                <span class="caption"> <span class="title_s"><?php echo $objaudio["name"];?></span> </span>
            </a>
        </div>
        <div class="content_items">
            <?php $counter1=-1; if( isset($listaudio) && is_array($listaudio) && sizeof($listaudio) ) foreach( $listaudio as $key1 => $value1 ){ $counter1++; ?>
            <?php $link=$this->var['link']=makelink::makethuvien(1427344702,$value1["_id"],$value1["name"]);?>
            <ul class="list_1">
                <li> <a href="<?php echo $link;?>"> <span class="thumb_img"><img src="<?php echo $value1["avatar"];?>" alt=""></span> <span class="title_list"><?php echo $value1["name"];?></span> <span class="caption_view"><?php echo $value1["datecreate"];?></span> </a> </li>
            </ul>
            <?php } ?>
        </div>
        <div class="content_item">
            <div class="btn_xemthem">
                <a class="btn_1" href="/category.php?catid=1427344702" title="">Xem thêm</a>
            </div>
        </div>
    </div>
    <div class="item_cate">
        <div class="title_cate"><a href="/category.php?catid=1427183137"><i class="icon-hocthanhngu"></i>Thành ngữ</a>
            <?php if( count($listcatthanhngu) > 0 ){ ?>
            <span class="btn_more_cate"><label></label><label></label><label></label></span>
            <div class="content_more_cate" style="display: none">
                <div class="content_more_cate_box">
                    <span class="square_dot"></span>
                    <div class="list_more_cate">
                        <?php $counter1=-1; if( isset($listcatthanhngu) && is_array($listcatthanhngu) && sizeof($listcatthanhngu) ) foreach( $listcatthanhngu as $key1 => $value1 ){ $counter1++; ?>
                        <?php $link=$this->var['link']=makelink::makecat($value1["_id"],$value1["type"],$value1["namenoneutf"]);?>
                        <a class="active" href="<?php echo $link;?>"><?php echo $value1["name"];?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="content_item">
            <?php $link=$this->var['link']=makelink::makethuvien(1427183137,$objthanhngu["_id"],$objthanhngu["name"]);?>
            <a class="item_full" href="<?php echo $link;?>">
                <span class="thumb_img"><img src="<?php echo $objthanhngu["avatar"];?>" alt=""></span>
                <span class="caption"> <span class="title_s"><?php echo $objthanhngu["name"];?></span> </span>
            </a>
        </div>
        <div class="content_items">
            <?php $counter1=-1; if( isset($listtn) && is_array($listtn) && sizeof($listtn) ) foreach( $listtn as $key1 => $value1 ){ $counter1++; ?>
            <?php $link=$this->var['link']=makelink::makethuvien(1427183137,$value1["_id"],$value1["name"]);?>
            <ul class="list_1">
                <li> <a href="<?php echo $link;?>"> <span class="thumb_img"><img src="<?php echo $value1["avatar"];?>" alt=""></span> <span class="title_list"><?php echo $value1["name"];?></span> <span class="caption_view"><?php echo $value1["datecreate"];?></span> </a> </li>
            </ul>
            <?php } ?>
        </div>
        <div class="content_item">
            <div class="btn_xemthem">
                <a class="btn_1" href="/category.php?catid=1427183137" title="">Xem thêm</a>
            </div>
        </div>
    </div>
    <div class="item_cate">
        <div class="title_cate"><a href="/category.php?catid=1428995217"><i class="icon-hangngay"></i>Tiếng anh hàng ngày</a>
            <?php if( count($listcathangngay) > 0 ){ ?>
            <span class="btn_more_cate"><label></label><label></label><label></label></span>
            <div class="content_more_cate" style="display: none">
                <div class="content_more_cate_box">
                    <span class="square_dot"></span>
                    <div class="list_more_cate">
                        <?php $counter1=-1; if( isset($listcathangngay) && is_array($listcathangngay) && sizeof($listcathangngay) ) foreach( $listcathangngay as $key1 => $value1 ){ $counter1++; ?>
                        <?php $link=$this->var['link']=makelink::makecat($value1["_id"],$value1["type"],$value1["namenoneutf"]);?>
                        <a class="active" href="<?php echo $link;?>"><?php echo $value1["name"];?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="content_item">
            <?php $link=$this->var['link']=makelink::makethuvien(1428995217,$objhangngay["_id"],$objhangngay["name"]);?>
            <a class="item_full" href="<?php echo $link;?>">
                <span class="thumb_img"><img src="<?php echo $objhangngay["avatar"];?>" alt=""></span>
                <span class="caption"> <span class="title_s"><?php echo $objhangngay["name"];?></span> </span>
            </a>
        </div>
        <div class="content_items">
            <?php $counter1=-1; if( isset($listhangngay) && is_array($listhangngay) && sizeof($listhangngay) ) foreach( $listhangngay as $key1 => $value1 ){ $counter1++; ?>
            <?php $link=$this->var['link']=makelink::makethuvien(1428995217,$value1["_id"],$value1["name"]);?>
            <ul class="list_1">
                <li> <a href="<?php echo $link;?>"> <span class="thumb_img"><img src="<?php echo $value1["avatar"];?>" alt=""></span> <span class="title_list"><?php echo $value1["name"];?></span> <span class="caption_view"><?php echo $value1["datecreate"];?></span> </a> </li>
            </ul>
            <?php } ?>
        </div>
        <div class="content_item">
            <div class="btn_xemthem">
                <a class="btn_1" href="/category.php?catid=1428995217" title="">Xem thêm</a>
            </div>
        </div>
    </div>
    <div class="item_cate">
        <div class="title_cate"><a href="/category.php?catid=1427344743"><i class="icon-kinhnghiem"></i>Kinh nghiệm</a>
            <?php if( count($listcatkinhnghiem) > 0 ){ ?>
            <span class="btn_more_cate"><label></label><label></label><label></label></span>
            <div class="content_more_cate" style="display: none">
                <div class="content_more_cate_box">
                    <span class="square_dot"></span>
                    <div class="list_more_cate">
                        <?php $counter1=-1; if( isset($listcatkinhnghiem) && is_array($listcatkinhnghiem) && sizeof($listcatkinhnghiem) ) foreach( $listcatkinhnghiem as $key1 => $value1 ){ $counter1++; ?>
                        <?php $link=$this->var['link']=makelink::makecat($value1["_id"],$value1["type"],$value1["namenoneutf"]);?>
                        <a class="active" href="<?php echo $link;?>"><?php echo $value1["name"];?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="content_item">
            <?php $link=$this->var['link']=makelink::makethuvien(1427344743,$objkinhnghiem["_id"],$objkinhnghiem["name"]);?>
            <a class="item_full" href="<?php echo $link;?>">
                <span class="thumb_img"><img src="<?php echo $objkinhnghiem["avatar"];?>" alt=""></span>
                <span class="caption"> <span class="title_s"><?php echo $objkinhnghiem["name"];?></span> </span>
            </a>
        </div>
        <div class="content_items">
            <?php $counter1=-1; if( isset($listkinhnghiem) && is_array($listkinhnghiem) && sizeof($listkinhnghiem) ) foreach( $listkinhnghiem as $key1 => $value1 ){ $counter1++; ?>
            <?php $link=$this->var['link']=makelink::makethuvien(1427344743,$value1["_id"],$value1["name"]);?>
            <ul class="list_1">
                <li> <a href="<?php echo $link;?>"> <span class="thumb_img"><img src="<?php echo $value1["avatar"];?>" alt=""></span> <span class="title_list"><?php echo $value1["name"];?></span> <span class="caption_view"><?php echo $value1["datecreate"];?></span> </a> </li>
            </ul>
            <?php } ?>
        </div>
        <div class="content_item">
            <div class="btn_xemthem">
                <a class="btn_1" href="/category.php?catid=1427344743" title="">Xem thêm</a>
            </div>
        </div>
    </div>
</div>
</div>

<?php if( $showRegLessionPop ){ ?>
<a href="#regLession" class="fancybox" id="showPopregLession" style="display:none;">Open</a>
<div id="regLession" style="display: none">
    <div style="text-align: center" id="chkLession">
        <p>CHỌN CHUYÊN MỤC BẠN QUAN TÂM</p>
        <?php $counter1=-1; if( isset($allType) && is_array($allType) && sizeof($allType) ) foreach( $allType as $key1 => $value1 ){ $counter1++; ?>
        <label style="width: 50%;display: inline-block;float: left; text-align: left"><input type="checkbox" value="<?php echo $key1;?>" /> <?php echo $value1;?></label>
        <?php } ?>
        <label style="width: 50%;display: inline-block;float: left; text-align: left"><input type="checkbox" value="all" id="checkAllType" onclick="$('#chkLession input').not(this).prop('checked', this.checked);" /> Tất cả</label>
        <p style="margin-top: 10px; clear: both; text-align: center"><button class="ht_1" onclick="regLession()">Đăng ký</button></p>
    </div>
</div>
<script>
    $(function () {
        $('#showPopregLession').trigger('click');
    })
    function regLession() {
        select = [];
        $('#chkLession input').each(function(){
            if($(this).is(':checked')){
                if($(this).val() != 'all')
                    select[select.length] = $(this).val();
            }
        });
        $.post('incoming.php?act=reg-lession', {
            select:select
        }, function(result){
            alert(result.mss);
            $.fancybox.close();
        })
    }
</script>
<?php } ?>
