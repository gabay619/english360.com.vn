<?php
foreach (glob(__DIR__.'/helpers/*.php') as $filename)
{
    include $filename;
}
include "config/init.php";
include "config/connect.php";
include "controller/famous/index.php";
## Non Edit
include "controller/home/sidebar.php";
$tpl->assign("SESSION",$_SESSION);
$tpl->draw("index");
?>