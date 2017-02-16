<?php if(!class_exists('raintpl')){exit;}?><?php if( $timeout ){ ?>
<script>
    $(function(){
        setTimeout(function(){
            $('#showPopreg').trigger('click');
            $.post('/incoming.php?act=addPopupNumber', {}, function (re) {
                console.log(re);
            });
        }, <?php echo $timeout;?>)
    })
</script>
<a href="#popreg" class="fancybox" id="showPopreg" style="display:none;">Open</a>
<div id="popreg" style="display: none">
    <div style="text-align: center">
        <?php if( $linkVms ){ ?>
        <p>Đăng ký English360 để học không giới hạn tiếng Anh giao tiếp: Học tiếng Anh qua bài hát, phim, radio, học tiếng Anh với người nổi tiếng,
            video các tình huống giao tiếp thông dụng. Dịch vụ không mất phí 3G, miễn phí 1 ngày dùng thử.
            </p>
        <p style="margin-top: 10px"><a class="ht_1" href="<?php echo $linkVms;?>">Đăng ký</a></p>
        <?php }else{ ?>
        <p>Đăng ký English360 để học không giới hạn tiếng Anh giao tiếp: Học tiếng Anh qua bài hát, phim, radio, học tiếng Anh với người nổi tiếng,
            video các tình huống giao tiếp thông dụng. Dịch vụ không mất phí 3G, miễn phí 1 ngày dùng thử.
            Phí DV: 2.000đ/ngày (gia hạn hàng ngày)</p>
        <p style="margin-top: 10px"><a class="ht_1" href="<?php echo getSmsLink(9317,'DK E'); ?>">Đăng ký</a></p>
        <?php } ?>
    </div>
</div>
<?php } ?>


