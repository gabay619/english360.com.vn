<?php
include "config/init.php";
include "config/connect.php";
include "controller/luyennguam/luyentap3.php";
## Non Edit
include "controller/home/sidebar.php";
$tpl->assign("SESSION",$_SESSION);
$tpl->draw("index");
?>