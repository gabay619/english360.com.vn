<?php
//$usercl = $dbmg->user;
//$authKey = $dbmg->auth_key;
//$ui = $_SESSION['uinfo']['phone'];
//$sentKey = (array)$authKey->findOne(array('phone'=>$ui));
//if(!$sentKey){
//    $newKey = array(
//        'phone' => $ui,
//        'key' => rand(100000, 999999),
//        'time' => time()
//    );
//    $authKey->insert($newKey);
//}
//Gui SMS
//Network::sentMT($phone, 'INVALID', 'message');
//result 0  = thành công

//Đăng ký gói cước

//$re = Network::registedpack($_SESSION['uinfo']['phone']);

//result 0 = thành công

//Hủy gói
//Network::cancelpack($phone);
//result 0 = thành công

//Kiểm tra có đang đk gói ko
//$result = Network::getUserInfo($_SESSION['uinfo']['phone']);

//result 1 = đang sử dụng gói

//$tpl->assign("obj", $sentKey);
include '/checkLogin.php';

$is3g = Network::is3g();
$linkVms = '';
if($is3g && Network::is3gmobifone() && Network::OPEN_REG){
    $link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&WAP');
    $linkVms = Network::genLinkConfirmVms("E",$link_callback);
}
$act = isset($_GET['act']) ? $_GET['act'] : '';
$confirm = $act == 'confirm';
$isLogin = isset($_SESSION['uinfo']);
$flash_mss = isset($_SESSION['flash_mss']) ? $_SESSION['flash_mss'] : '';
$tpl->assign("flash_mss", $flash_mss);
unset($_SESSION['flash_mss']);

$tpl->assign("confirm", "$confirm");
$tpl->assign("isLogin", $isLogin);
$tpl->assign("linkVms", "$linkVms");
$tpl->assign("is3g", "$is3g");
$tpl->assign("pagefile", "user/regispack");
include "controller/hmc/index.php";
?>