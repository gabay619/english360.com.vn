<?php
include "config/init.php";
include "config/connect.php";

$usercl = $dbmg->user;
$token = $_GET['token'];
try{
    $decode = base64_decode($token);
    $dataArr = explode('+', $decode);
    $email = $dataArr[0];
    $time = $dataArr[1];
}catch (Exception $e){
    $_SESSION['flash_mss'] = 'Thao tác không hợp lệ.';
    header('Location: thong-bao.html');exit;
}
if(time() - $time > 600){
    $_SESSION['flash_mss'] = 'Thao tác không hợp lệ.';
    header('Location: thong-bao.html');exit;
}

$user = $usercl->findOne(array(
    'email' => $email,
    'status' => Constant::STATUS_DISABLE
));
if(!$user){
    $_SESSION['flash_mss'] = 'Thao tác không hợp lệ.';
    header('Location: thong-bao.html');exit;
}
$content = '<p>Xin chào,</p>'.
    '<p>Để xác thực email cho tài khoản English360, bạn vui lòng click vào đường link bên dưới:</p>'.
    '<p><a href="'.Common::getVerifyEmailUrl($user['_id'],$user['email']).'">'.Common::getVerifyEmailUrl($user['_id'],$user['email']).'</a></p>'.
    '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>';
$mail = new \helpers\Mail($user['email'],'Xác nhận tài khoản English360.com.vn',$content);
if(!$mail->send()){
    $_SESSION['flash_mss'] = 'Thao tác không hợp lệ.';
    header('Location: thong-bao.html');exit;
}
$_SESSION['flash_mss'] = 'Vui lòng kiểm tra email và kích hoạt tài khoản.';
header('Location: thong-bao.html');exit;