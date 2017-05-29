<?php if(!class_exists('raintpl')){exit;}?><div class="item_cate cate_hmc" style="overflow: hidden">
    <div class="content_item mgt10">
        <ul>
            <li class="hmc_li hmc_li_1">
                <a class="hmc_a1" href="/hmcaudio.php"> <i class="icon_baihat"></i> <span>Bài hát</span> </a>
                <div class="list_hmc list_hmc_1">
                    <div class="list_2">
                        <?php $counter1=-1; if( isset($listsong) && is_array($listsong) && sizeof($listsong) ) foreach( $listsong as $key1 => $value1 ){ $counter1++; ?>
                        <?php $link=$this->var['link']=makelink::makehmcaudio($value1["_id"],$value1["name"]);?>
                        <div><a title="" href="<?php echo $link;?>"><?php echo $value1["name"];?></a></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="btn_xemthem btn_xemthem_hmc">
                    <a class="btn_1" href="/hmcaudio.php" title="">Xem thêm</a>
                </div>
            </li>
            <li class="hmc_li hmc_li_2">
                <a class="hmc_a2" href="/category.php?catid=1450861603"> <i class="icon_phim"></i> <span>Phim</span> </a>
                <div class="list_hmc list_hmc_2">
                    <div class="list_2">
                    <?php $counter1=-1; if( isset($listfilm) && is_array($listfilm) && sizeof($listfilm) ) foreach( $listfilm as $key1 => $value1 ){ $counter1++; ?>
                    <?php $link=$this->var['link']=makelink::makethuvien('1450861603',$value1["_id"],$value1["name"]);?>
                    <div><a title="" href="<?php echo $link;?>"><?php echo $value1["name"];?></a></div>
                    <?php } ?>
                    </div>
                </div>
                <div class="btn_xemthem btn_xemthem_hmc">
                    <a class="btn_1" href="/category.php?catid=1450861603" title="">Xem thêm</a>
                </div>
            </li>
            <li class="hmc_li hmc_li_3">
                <a class="hmc_a3" href="/hmcgame.php"> <i class="icon_trochoi"></i> <span>Trò chơi</span> </a>
                <div class="list_hmc list_hmc_3">
                    <div class="list_2">
                    <?php $counter1=-1; if( isset($listgame) && is_array($listgame) && sizeof($listgame) ) foreach( $listgame as $key1 => $value1 ){ $counter1++; ?>
                <div><a title="" href="/hmcgame.php?catid=<?php echo $value1["_id"];?>&d=e"><?php echo $value1["name"];?></a></div>
                      <?php } ?>
                     </div>
            </div>
                <div class="btn_xemthem btn_xemthem_hmc">
                    <a class="btn_1" href="/hmcgame.php" title="">Xem thêm</a>
                </div>
            </li>
        </ul>
    </div>
</div>
<link rel="stylesheet" href="/assets/lib/fancybox2/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="/assets/lib/fancybox2/jquery.fancybox.pack.js?v=2.1.5"></script>
<script>
    $(".fancybox").fancybox({
        autoSize: true,
        beforeLoad : function() {
//                this.width = 800;
//                this.height = 450;
        }
    });
</script>
<?php if( $popup ){ ?>
<a href="#pop" class="fancybox" style="display:none;">Open</a>

<div id="pop" style="display:none;">
    <?php echo $popup["content"];?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
//        var now = Date.now();
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
        var popup_count = getCookie("popup_<?php echo $popup["_id"];?>");
        var popup_time = getCookie("popup_time_<?php echo $popup["_id"];?>");
        popup_time = popup_time == "" ? 0 : popup_time;
        timeout = <?php echo $popup["timeout"];?>;
        if((now - popup_time)/1000 < <?php echo $popup["distance_time"];?>){
            timeout = timeout + <?php echo $popup["distance_time"];?> - (now - popup_time)/1000;
        }

        console.log(timeout);
        if(popup_count == "")
            popup_count = 0;
        if(popup_count < <?php echo $popup["count_on_day"];?>){
            setTimeout(function () {
                showPopup();
                setCookie("popup_<?php echo $popup["_id"];?>", parseInt(popup_count)+1, 1);
                setCookie("popup_time_<?php echo $popup["_id"];?>", now , 1);
    //            setCookie("popup_timeout_<?php echo $popup["id"];?>", "" , 1);
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
<?php } ?>

<?php if( $show ){ ?>
<a href="#event-welcome" class="fancybox" id="showWelcome" style="display:none;">Open</a>
<div id="event-welcome" style="display: none">
    <?php if( $show=='welcome' ){ ?>
    <h2 style="text-align: center">CHÚC MỪNG!</h2>
    <div style="text-align: center">
        <p>Bạn đã nhận được học bổng của English360, khóa học hoàn toàn miễn phí trong 15 ngày.</p>
        <p>Chúc bạn có khoảng thời gian học tập thú vị cùng English360.</p>
    </div>
    <?php }else{ ?>
    <h2 style="text-align: center">THÔNG BÁO</h2>
    <div style="text-align: center">
        <p>Khóa học bổng của English360 đã kết thúc. Bạn hãy tiếp tục đăng ký để nhận được các ưu đãi sau:</p>
        <p>- Được tham gia tất cả các bài học của English360</p>
        <p>- Được miễn phí 1 ngày học tiếp theo</p>
        <p>Soạn tin DK E gửi 9317 để đăng ký.</p>
    </div>
    <?php } ?>
</div>
<script>
    $(function(){
        $('#showWelcome').trigger('click');
    })
</script>
<?php } ?>

<?php if( $banner ){ ?>
<div class="fix-banner" style="width: 100%; position: fixed; bottom: 0; left: 0; z-index: 10 ">
    <?php echo $banner["content"];?>
</div>
<?php } ?>


<?php if( $showAdsPop ){ ?>
<script>
    var clickOnCancel = false;

    $(function () {
//        alert(<?php echo $timeoutPopAds;?>);
//        $('#showPopAdsreg')
        setTimeout(function () {
            $('#showPopAdsreg').fancybox({
            <?php if( $activePopAds ){ ?>
                closeClick: true,
                afterClose: function() {
                    if(!clickOnCancel){
                        regPackageAds();
                    }
                },
            <?php }else{ ?>
            afterClose: function() {
                cancelPackageAds();
            },
            <?php } ?>
            afterShow: function () {
                setTimeout(function(){
                    $.fancybox.close()
                }, <?php echo $timeoutPopAds;?>)
            },
            closeBtn: false
            }).trigger('click');
        },<?php echo $waittimePopAds;?>);

//        setTimeout(function(){
//            $.fancybox.close()
//        }, {timeoutPopAds})
    })




    function cancelPackageAds() {
        clickOnCancel = true;
        $.post('/incoming.php?act=cancelPackageAds',{

        }, function (re) {

        })
        $.fancybox.close();
    }
</script>
<a href="#popAdsreg" class="fancybox" id="showPopAdsreg" style="display:none;">Open</a>
<div id="popAdsreg" style="display: none">
    <div style="text-align: center">
        <p><?php echo $contentPopAds;?></p>
        <p style="margin-top: 10px">
            <a class="ht_1" href="javascript:cancelPackageAds()">Từ chối</a>
            <a class="ht_1" href="javascript:regPackageAds()" >Đồng ý</a>
        </p>
        <?php if( $pricePopAds ){ ?>
        <p><?php echo $pricePopAds;?></p>
        <?php } ?>
    </div>
</div>
<?php } ?>
<?php if( $adsPopContinue ){ ?>
<script>
    regPackageAds();
</script>
<?php } ?>
<script>
    function regPackageAds(){
        $.fancybox.close();
        $.post('/incoming.php?act=regPackageAds',{

        }, function (re) {

        })
    }
</script>
<?php if( $showEvent ){ ?>
<a href="#popEvent" class="fancybox" id="showPopEvent" style="display:none;">Open</a>
<?php if( $hasPhone ){ ?>
<div id="popEvent" style="display: none">
    <div style="text-align: center; position: relative">
        <p><img src="<?php echo $event["bgWap"];?>" alt=""></p>
        <p style="position: absolute; margin: 0 auto; top: 60%; left: 0; right: 0">
            <a class="ht_1" href="javascript:regEvent('<?php echo $event["_id"];?>')">Đồng ý</a>
        </p>
    </div>
</div>
<?php }else{ ?>
<div id="popEvent" style="display: none">
    <div style="text-align: center; position: relative">
        <p><img src="<?php echo $event["bgWap"];?>" alt=""></p>
        <p style="position: absolute; margin: 0 auto; top: 68%; left: 0; right: 0">
            <input type="text" width="50%" placeholder="Nhập email" class="input1" id="emailEvent" style="margin-bottom: 5px"><br>
            <a class="ht_1" href="javascript:regEvent('<?php echo $event["_id"];?>')">Đồng ý</a>
        </p>
    </div>
</div>
<?php } ?>
<a href="#successEvent" class="fancybox" id="showSuccessEvent" style="display:none;">Open</a>
<div id="successEvent" style="display: none">
    <div style="text-align: center;">
        <p>Bạn đang được English360 miễn phí <?php echo $event["free_day"];?> ngày không giới hạn các khoá học tiếng Anh giao tiếp.</p>
        <!--<p>Tài khoản miễn phí đã được gửi về số điện thoại của bạn.</p>-->
    </div>
</div>
<script>
    <?php if( $registedEvent ){ ?>
    $('#showSuccessEvent').trigger('click');
    setTimeout(function () {
        $.post('/incoming.php?act=removeEvent', {
            
        }, function (re) {
            
        })
        $.fancybox.close();
    }, 3000)
    <?php }else{ ?>
    setTimeout(function () {
        $('#showPopEvent').trigger('click');

    }, <?php echo $event["timeout_popup"]*1000;?>)
    <?php } ?>


    function regEvent(id) {
        <?php if( $hasPhone ){ ?>
        email = '';
        <?php }else{ ?>
        email = $('#emailEvent').val();
        if(email == ''){
            alert('Địa chỉ email không được bỏ trống.');
            return false;
        }
        <?php } ?>
        $.post('/incoming.php?act=regEvent', {
            id:id, email: email
        }, function (re) {
            if(re.success){
                $.fancybox.close();
                $('#successEvent div').html(re.mss);
                $('#showSuccessEvent').trigger('click');
            }else{
                alert(re.mss);
                return false;
            }
        })
    }
</script>
<?php } ?>
<?php if( $showExpiredEvent ){ ?>
<a href="#expiredEvent" class="fancybox" id="showExpiredEvent" style="display:none;">Open</a>
<div id="expiredEvent" style="display: none">
    <div style="text-align: center;">
        <p>Thời gian sử dụng miễn phí đã kết thúc.</p>
        <?php if( $SESSION["uinfo"]["phone"] ){ ?>
        <p>Bấm vào <a style="color: blue; text-decoration: underline; font-weight: bold" href="/regispack.php">ĐÂY</a> để đăng ký và sử dụng dịch vụ.</p>
       <?php }else{ ?>
        <p>Soạn DK E gửi 9317 để tiếp tục sử dụng (Chỉ áp dụng cho thuê bao MobiFone)</p>
        <?php } ?>
    </div>
</div>
<script>
    $('#showExpiredEvent').trigger('click');
</script>
<?php } ?>