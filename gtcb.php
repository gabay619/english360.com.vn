<?php
include "config/init.php";
include "config/connect.php";
include "controller/gtcb/index.php";
//include "loadsite.php";
## Non Edit
include "controller/home/sidebar.php";
$tpl->assign("SESSION",$_SESSION);
$tpl->draw("index");
?>