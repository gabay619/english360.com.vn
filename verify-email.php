<?php
include "config/init.php";
include "config/connect.php";
//echo 1;die;
$usercl = $dbmg->user;
$key = $_GET['key'];
$email = $_GET['email'];
try{
    $decode = base64_decode($key);
    $dataArr = explode('+', $decode);
    $uid = $dataArr[0];
    $emailC = $dataArr[1];
    $time = $dataArr[2];
}catch (Exception $e){
    $_SESSION['flash_mss'] = 'Thao tác không hợp lệ.';
    header('Location: thong-bao.php');exit;
}

if($emailC != $email || time() - $time > 30*60){
    $_SESSION['flash_mss'] = 'Thao tác không hợp lệ.';
    header('Location: thong-bao.php');exit;
}
$usercl->update(array('email'=>$email), array('$set'=>array('email'=>'')));
$usercl->update(array('_id'=>$uid), array('$set'=>array('email'=>$email)));
$_SESSION['reg_lession_popup'] = true;
if(isset($_SESSION['uinfo']) && $_SESSION['uinfo']['_id'] == $uid){
    header('Location: reg-lession.php');exit;
}else{
    $_SESSION['email_reg_lession'] = $email;
    header('Location: index.php');exit;
}