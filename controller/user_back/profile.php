<?php
$notifycl = $dbmg->notify;
$usercl = $dbmg->user;
$ui = $_SESSION['uinfo'];
$uid = $ui['_id'];
$tpl->assign("pagefile", "user/profile");
?>