<?php
$usercl = $dbmg->user;
$key = $_GET['key'];
try{
    $decode = base64_decode($key);
    $dataArr = explode('+', $decode);
    $phone = $dataArr[0];
    $password = $dataArr[1];
    $user = $usercl->findOne(array('phone'=>$phone),array('phone','password','thong_bao'));
    if(!$user)
        throw new Exception('User không tồn tại.');
    if($password != $user['password'])
        throw new Exception('Mật khẩu không đúng.');
    $thongbao = array_merge($user['thong_bao'], array('email'=>Constant::STATUS_DISABLE));
    $usercl->update(array('phone'=>$phone),array('$set'=>array('thong_bao'=>$thongbao)));
}catch (Exception $e){
    $_SESSION['flash_mss'] = 'Thao tác không hợp lệ.';
}
$_SESSION['flash_mss'] = 'Bạn đã hủy nhận thông báo qua email.';
header('Location: thong-bao.php');exit;

