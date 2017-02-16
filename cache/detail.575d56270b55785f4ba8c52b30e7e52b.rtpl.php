<?php if(!class_exists('raintpl')){exit;}?><audio style="display: none; width: 0;height: 0;" id="mainaudio" controls></audio>
<div class="main">
<div class="content_cate p5">
<div class="item_cate">
    <div class="title_cate">
        <a href=""><i class="icon-noitieng"></i>Giao tiếp cơ bản</a>
        <span class="btn_more_cate"><label></label><label></label><label></label></span>
        <div class="content_more_cate"style="display:none" >
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
    </div>
    <div class="content_item">
        <div class="dentail_channel">
            <h3 class="title_style_1"><?php echo $obj["name"];?></h3>

            <div class="date_view"><label><?php echo $obj["datecreate"];?></label></div>
            <div class="social_view">
            </div>
            <div id="myElement">Loading the player...</div>
            <div class="four_function">
                <div class="item_four_function">
                    <a class="showTab" data-target="#eng">Tiếng Anh</a>
                    <a class="showTab" data-target="#vie">Tiếng Việt</a>
                    <a class="showTab" data-target="#tuvung">Từ vựng</a>
                    <a class="" href="javascript:void(0)" onclick="savearticle('<?php echo $obj["_id"];?>')">Lưu bài</a>
                    <div class="all_ct_display">
                        <div class="tabItem" style="display: none;" id="eng"><?php echo $obj["content"]["eng"];?></div>
                        <div class="tabItem" style="display: none;" id="vie"><?php echo $obj["content"]["vie"];?></div>
                        <div class="tabItem" style="display: none;" id="tuvung"><?php echo $obj["tuvung"];?></div>
                    </div>
                </div>
            </div>
            <div class="text_component">
                <?php echo $obj["contents"];?>
            </div>
            <div class="btn_gui_comment center"><a href="gtcb_baitap.php?id=<?php echo $obj["_id"];?>" class="btn_1">Luyện tập</a></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
    <div class="item_cate">
        <div class="title_cate">
            <a href=""><i class="icon-noitieng"></i>Bình luận</a>
        </div>
        <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("".$commentFile."") . ( substr("".$commentFile."",-1,1) != "/" ? "/" : "" ) . basename("".$commentFile."") );?>
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
                <?php $counter1=-1; if( isset($ref) && is_array($ref) && sizeof($ref) ) foreach( $ref as $key1 => $value1 ){ $counter1++; ?>
                <?php $link=$this->var['link']=makelink::makegtcb($value1["_id"],$value1["namenoneutf"]);?>
                    <li> <a href="<?php echo $link;?>"> <span class="thumb_img"><img alt="" src="<?php echo $value1["avatar"];?>"></span> <span class="title_list"><?php echo $value1["name"];?></span> <span class="caption_view"><?php echo $value1["datecreate"];?></span> </a> </li>
                <?php } ?>
                </ul>
            </div>
            <div id="content2" class="tabscontent">
                <ul class="list_1">
                    <?php $counter1=-1; if( isset($new) && is_array($new) && sizeof($new) ) foreach( $new as $key1 => $value1 ){ $counter1++; ?>
                    <?php $link=$this->var['link']=makelink::makegtcb($value1["_id"],$value1["namenoneutf"]);?>
                    <li> <a href="<?php echo $link;?>"> <span class="thumb_img"><img alt="" src="<?php echo $value1["avatar"];?>"></span> <span class="title_list"><?php echo $value1["name"];?></span> <span class="caption_view"><?php echo $value1["datecreate"];?></span> </a> </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Tabs -->
    <div class="clearfix"></div>
</div>
</div>
</div>
        <h1 id="test"></h1>
<script type="text/javascript">
    jwplayer("myElement").setup({
        file: '<?php echo $obj["medialink"];?>',
        image: '<?php echo $obj["avatar"];?>',
        width: "100%",
        aspectratio: "16:9",
        autostart: true,

//        skin: 'bekle',
//        tracks: [{
//            file: "/assets/test/subAnh.srt",
//            label: "English",
//            kind: "captions",
//            "default": true
//        },{
//            file: "/assets/test/subViet.srt",
//            kind: "captions",
//            label: "Tiếng Việt"
//        }],
        captions: {
            color: '#fff',
            //                fontSize: 20,
            backgroundOpacity: 50
        }
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
            act: 'saveexam', id: exid, type: 'giaotiepcoban', return_url: window.location.href
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
    function addlike(exid, obj) {
        $.post('/incoming.php', {act: 'addlike', id: exid}, function (re) {
            if (re.status == 200) $(obj).parent().remove();
            alert(re.mss);
        });
    }
</script>
<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("component/popreg") . ( substr("component/popreg",-1,1) != "/" ? "/" : "" ) . basename("component/popreg") );?>

