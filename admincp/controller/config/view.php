<?php
$title = "Cấu hình";
?>
    <title><?php echo $title ?></title>
    <h5 class="text-center"><?php echo $title ?></h5>
    <div class="clearfix"></div>
<?php include "component/message.php"; ?>
    <div>
<?php if(acceptpermiss("config_bl")) { ?>
        <p><a href="<?php echo cpagerparm("tact,status") ?>tact=config_bl">Cấu hình Blacklist</a></p>
    <?php }
if(acceptpermiss("config_1t")) { ?>
        <p><a href="<?php echo cpagerparm("tact,status") ?>tact=config_1t">Cấu hình 1 chạm</a></p>
    <?php }
if(acceptpermiss("config_1t5")) { ?>
    <p><a href="<?php echo cpagerparm("tact,status") ?>tact=config_1t5">Cấu hình 1.5 chạm</a></p>
<?php }
if(acceptpermiss("config_3g")) {
    ?>
        <p><a href="<?php echo cpagerparm("tact,status") ?>tact=config_3g">Xem log 3G</a></p>
    <?php }
    if(acceptpermiss("config_ads")) {
    ?>
        <p><a href="<?php echo cpagerparm("tact,status") ?>tact=config_ads">Xem log quảng cáo</a></p>
    <?php } ?>
    </div>
<?php include("component/paging.php") ?>