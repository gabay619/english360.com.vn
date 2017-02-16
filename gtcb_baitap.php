<?php
include "config/init.php";
include "config/connect.php";
include "controller/gtcb/gtcb_baitap.php";
## Non Edit
include "controller/home/sidebar.php";
$tpl->assign("SESSION",$_SESSION);
$tpl->draw("index");
?>