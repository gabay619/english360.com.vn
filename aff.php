<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 06/03/2017
 * Time: 10:15 AM
 */
$onWap = 1;
include "config/init.php";
include "config/connect.php";
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '/';
if(empty($_GET['uid'])){
    header('Location: '.$redirect);exit;
}
$uid = $_GET['uid'];
$sub_id = isset($_GET['sub_id']) ? $_GET['sub_id'] : '';
$clickcl = $dbmg->aff_click;
$newclick = $clickcl->insert(array(
    '_id' => strval(time()),
    'datecreate' => time(),
    'uid' => $uid,
    'sub_id' => $sub_id,
    'redirect' => $redirect,
    'ip' => Network::ip()
));
//Luư cookie
$cookie_value = Common::encodeAffCookie($uid.'&'.$sub_id);
setcookie(Constant::AFF_COOKIE_NAME, $cookie_value, Constant::AFF_COOKIE_EXPIRED);
header('Location: '.$redirect);exit;