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


//$tpl->assign("confirm", "$confirm");
$link = isset($_GET['link']) ? html_entity_decode(urldecode($_GET['link'])) : '/';
$tpl->assign("link", "$link");
$tpl->assign("pagefile", "user/quick-package");
include "controller/hmc/index.php";
?>