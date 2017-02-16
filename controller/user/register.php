<?php
$usercl = $dbmg->user;
$mes = array('mss' => "", "class" => "none");
$token = new Csrf(true, true, false);
$tpl->assign("csrf_name", $token->get_token_name());
$tpl->assign("csrf_value", $token->get_token_value());
$phone = $_POST['phone'];
$userinfo = (object)$usercl->findOne(array('phone' => $phone));
if ($userinfo->_id){
    $mes = array('mss' => 'Tài khoản đã tồn tại');
}else{
    if(isMobifoneNumber($phone)==true){
        $timeNow = time();
        $unpassword = Common::generateRandomPassword();
        $password = encryptpassword($unpassword);

        //    $password = strval(mt_rand(1000,9999));
        //$activeKey = strval(mt_rand(10000, 99999));
        $username = $_POST['phone'];
        $newAccount = array('_id' => strval($timeNow), 'phone' => $phone, 'password' => $password, 'un_password'=> $unpassword, 'datecreate' => $timeNow, 'sendsmscount' => "0", 'datecountsms' => $timeNow,'status'=>"1");
        $newAccount['displayname'] = $_POST['phone'];
        $userinfo = (object)$usercl->insert($newAccount);
        $_SESSION['activephone'] = $phone;

        $mgconn->close();
        header("Location: login.php");
    }else{
        $mes1 = array('mss' => "Vui lòng nhập số điện thoại của Mobifone", "class" => "none");

    }
}

$tpl->assign("alert", $mes);

$tpl->assign("pagefile", "user/register");
include "controller/hmc/index.php";
?>