<?php
$notifycl = $dbmg->notify;
$usercl = $dbmg->user;
include '/checkLogin.php';

//$ui = $_SESSION['uinfo'];
//$uid = $ui['_id'];

//$authKey = $dbmg->auth_key;
//$ui = $_SESSION['uinfo']['phone'];
//$sentKey = (array)$authKey->findOne(array('phone'=>$ui));
//$mess = "Ma xac thuc cua ban la : ".$sentKey['key'];
//$sent_auth_key = Network::sentMT($ui, 'INVALID', $mess);
//print_r($sent_auth_key);

$result = Network::getUserInfo($_SESSION['uinfo']['phone'],'E',$_SESSION['uinfo']['_id']);
$is3g = Network::is3g() && Network::is3gmobifone();
$tpl->assign("result",$result);
$tpl->assign("is3g",$is3g);
$tpl->assign("pagefile", "user/profile");
include "controller/hmc/index.php";
?>