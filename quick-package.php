<?php
include "config/init.php";
include "config/connect.php";
include "controller/user/quick-package.php";
## Non Edit
include "controller/home/sidebar.php";
$tpl->assign("SESSION",$_SESSION);
$tpl->draw("index");
?>