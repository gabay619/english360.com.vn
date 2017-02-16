<?php
foreach (glob(__DIR__.'/../helpers/*.php') as $filename)
{
    include $filename;
}
include "../config/config.php";
include "../config/connect.php";
//if(Network::is3g() && Network::is3gmobifone()){
//    $phone = Network::is3g();
//    //log
//    $logCl = $dbmg->log;
//    $date = date('d/m/Y');
//    $logTime = $logCl->findOne(array('date'=>$date));
//    if($logTime){
//        $logCl->update(array('date'=>$date), array('$set'=>array('total'=>$logTime['total']+1)));
//
//    }else{
//        $newLog = array(
//                'date' => $date,
//                'chanel' => 'wap',
//                'total' => 1
//        );
//        $logCl->insert($newLog);
//    }
//    //log3g
//    $log3gCl = $dbmg->log3g;
//    $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
//    $newLog3g = array(
//            '_id' => strval(time()),
//            'phone' => $phone,
//            'ip' => Network::ip(),
//            'chanel' => 'APP',
//            'useragent' => $useragent,
//            'status' => Constant::STATUS_ENABLE,
//            'datecreate' => time()
//    );
//    $log3gCl->insert($newLog3g);
//}
header("Content-Type: application/json;charset=utf-8");
//echo json_encode(array('status'=>500, 'mss' => 'Dịch vụ đang bảo trì.')); exit;
include "changac.php";
include "chinhnc.php";

function _getDisplayAvatar($uid){
    global $dbmg;
    $userCl = $dbmg->user;
    $user = $userCl->findOne(array('_id' => $uid));
    return isset($user['priavatar']) && !empty($user['priavatar']) ? Common::getWebImageLink($user['priavatar']) : '';
}

function _getDisplayName($uid){
    global $dbmg;
    $userCl = $dbmg->user;
    $user = $userCl->findOne(array('_id' => $uid));
    if(!$user) return false;
    return isset($user['displayname']) && !empty($user['displayname']) && $user['displayname']!=$user['phone'] ? $user['displayname'] : Common::maskPhone($user['phone']);
}

function _getDisplayInfo($uid){
    global $dbmg;
    $userCl = $dbmg->user;
    $user = $userCl->findOne(array('_id' => $uid));
    if(!$user) return array('avatar' => '', 'displayname' => '');;
    $avatar = isset($user['priavatar']) && !empty($user['priavatar']) ? Common::getWebImageLink($user['priavatar']) : '';
    $displayname = isset($user['displayname']) && !empty($user['displayname']) && $user['displayname']!=$user['phone'] ? $user['displayname'] : Common::maskPhone($user['phone']);
    return array('avatar' => $avatar, 'displayname' => $displayname);
}

function _getParam($key, $default =''){
    return isset($_GET[$key]) && !empty($_GET[$key]) ? $_GET[$key] : $default;
}

function _checkLogin(){
    return isset($_SESSION['uinfo']);
}
$mgconn->close();
?>