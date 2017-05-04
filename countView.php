<?php

//$checkis3g = Network::is3g();
//echo $checkis3g;
//if(!isset($_SESSION['CountView'])){
//    $_SESSION['CountView'] = 1;
//}else{
//    $_SESSION['CountView']++;
//}
//$countView = $_SESSION['CountView'];
//if($countView > Constant::MAX_CONTENT_FREE){
//    if(!isset($_SESSION['uinfo'])){
//        header("Location: /login.php");exit();
//    }
//    else{
//        $user = $usercl->findOne(array('_id'=>$_SESSION['uinfo']['_id']));
//        if($user['ssid'] != session_id()){
//            unset($_SESSION['uinfo']);
//            $_SESSION['flash_mss'] = 'Tài khoản của bạn được đăng nhập từ nơi khác.';
//            header("Location: /login.php");exit();
//        }
//        $result = Common::isRegPackage($_SESSION['uinfo']['_id']);
//        if(!$result){
//                $_SESSION['flash_mss'] = 'Bạn đã sử dụng hết 10 nội dung miễn phí.';
//                header("Location: /regispack.php");exit();
//        }
//    }
//}
//Lưu log
$historylogCl = $dbmg->history_log;
$newHistoryLog = array(
    '_id' => strval(time().rand(10,99)),
    'datecreate' => time(),
    'action' => $type,
    'chanel' => HistoryLog::CHANEL_WAP,
    'ip' => Network::ip(),
    'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
    'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
    'status' => Constant::STATUS_ENABLE,
    'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
    'price' => 0,
    'ref' => isset($_GET['ref']) ? $_GET['ref'] : ''
);
if(!isset($_SESSION['notsave_log']))
    $historylogCl->insert($newHistoryLog);
?>