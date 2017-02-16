<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include "config/init.php";
include "config/connect.php";
include "controller/home/index.php";
## Non Edit
include "controller/home/sidebar.php";
$tpl->assign("SESSION",$_SESSION);
$tpl->draw("index");

?>