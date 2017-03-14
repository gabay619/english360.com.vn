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
$redirect = isset($_GET['redirect']) && !empty($_GET['redirect']) ? $_GET['redirect'] : Constant::BASE_URL;
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
    'ip' => Network::ip(),
    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
    'get' => $_GET
));
//Luư cookie
$cookie_value = Common::encodeAffCookie($uid.'&'.$sub_id);
setcookie(Constant::AFF_COOKIE_NAME, $cookie_value, time()+ Constant::AFF_COOKIE_EXPIRED, '/');
//print_r($_COOKIE);die;
header('Location: '.$redirect);exit;