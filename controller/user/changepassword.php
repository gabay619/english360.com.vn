<?php
$usercl = $dbmg->user;
include '/checkLogin.php';

$tpl->assign("pagefile", "user/changepassword");
include "controller/hmc/index.php";
?>