<?php
include "config/init.php";
include "config/connect.php";
include "controller/user/active.php";
## Non Edit
include "controller/home/sidebar.php";
$tpl->assign("SESSION",$_SESSION);
$tpl->assign("pageinfo", array("title"=>"Kích hoạt tài khoản uClip.vn"));
$tpl->draw("index");
?>