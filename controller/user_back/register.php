<?php
$usercl = $dbmg->user;
$mes = array('mss' => "", "class" => "none");
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
        $newAccount = array('_id' => strval($timeNow), 'phone' => $phone, 'password' => $password, 'un_password'=> $unpassword, 'datecreate' => $timeNow, 'sendsmscount' => "0", 'datecountsms' => $timeNow,'stautus'=>"1");
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
?>