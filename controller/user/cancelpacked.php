<?php
$usercl = $dbmg->user;
include '/checkLogin.php';
$token = new Csrf(true, true, false);
$tpl->assign("csrf_name", $token->get_token_name());
$tpl->assign("csrf_value", $token->get_token_value());
$isRegispack = Network::getUserInfo($_SESSION['uinfo']['phone'],'E',$_SESSION['uinfo']['_id']) == 1;
$tpl->assign("isRegispack", "$isRegispack");
$tpl->assign("pagefile", "user/cancelpacked");
include "controller/hmc/index.php";
?>