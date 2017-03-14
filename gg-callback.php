<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14/03/2017
 * Time: 11:13 AM
 */
session_start();
include "config/init.php";
include "config/connect.php";

$usercl = $dbmg->user;
$client = new Google_Client();
$client->setClientId(Constant::GOOGLE_APP_ID);
$client->setClientSecret(Constant::GOOGLE_APP_SECRET);
$client->setDeveloperKey(Constant::GOOLE_APP_KEY);

$client->setIncludeGrantedScopes(true);   // incremental auth
$client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);
$client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
$client->setRedirectUri('http://'.$_SERVER['HTTP_HOST'].'/gg-callback.php');
if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['gg_access_token'] = $client->getAccessToken();
//    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
//    exit;
//    print_r( $_SESSION['gg_access_token']);die;

}
//if we have access_token continue, or else get login URL for user
if (isset($_SESSION['gg_access_token']) && $_SESSION['gg_access_token']) {
    $client->setAccessToken($_SESSION['gg_access_token']);
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));exit;
}
try{
    $service = new Google_Service_Oauth2($client);
    $uinfo = $service->userinfo->get();
    $gg_email = $uinfo->email;
    $gg_name = $uinfo->name;
    $gg_id = $uinfo->id;
}catch (Exception $e){
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));exit;
}

if(empty($gg_email)){
    $_SESSION['flass_mss'] = 'English360 không nhận được địa chỉ email Google của bạn.';
    header('Location: /thong-bao.html');exit;
}
$checkEmail = $usercl->findOne(array(
    'email' => $gg_email,
    'ggid' => array('$ne'=>$gg_id)
));
if($checkEmail){
    if(isset($checkEmail['ggid']) && !empty($checkEmail['ggid'])){
        $_SESSION['flass_mss'] = 'Email đã được sử dụng';
        header('Location: /thong-bao.html');exit;
    }
    //Nếu có user đk cùng mail trước đó thì gộp làm 1
    $updateUser = array(
        'ggid' => $gg_id,
        'ssid' => session_id()
    );
    if(empty($checkEmail['displayname'])) $updateUser['displayname'] = $gg_name;
    if(empty($checkEmail['fullname'])) $updateUser['fullname'] = $gg_name;
    $usercl->update(array('_id'=>$checkEmail['_id']), array('$set'=>$updateUser));
    $o = $usercl->findOne(array('_id'=>$checkEmail['_id']));
    $_SESSION['uinfo'] = $o;
    header('Location: index.php');exit;
}
$checkUser = $usercl->findOne(array('ggid'=>$gg_id));
if(!$checkUser){
    $uid = strval(time());
    $email = $gg_email;
    $o = array(
        '_id' => $uid,
        'displayname' => $gg_name,
        'fullname' => $gg_name,
        'ggid' => $gg_id,
        'datecreate' => time(),
        'status'=>Constant::STATUS_ENABLE,
        'email'=>$email,
        'priavatar'=>'',
        'cmd'=>'',
        'cmnd_noicap'=>'',
        'cmnd_ngaycap'=>'',
        'birthday'=>'',
        'ssid' => session_id(),
        'thong_bao' => array(
            'noti' => "1",
            'email' => "1",
        )
    );
    //if aff
    if(isset($_COOKIE[Constant::AFF_COOKIE_NAME])){
        $cookie_value = Common::decodeAffCookie($_COOKIE[Constant::AFF_COOKIE_NAME]);
        $cookieArr = explode('&',$cookie_value);
        $o['aff'] = array(
            'uid' => $cookieArr[0],
            'sub_id' => isset($cookieArr[1]) ? $cookieArr[1] : '',
            'datecreate' => time()
        );
    }
    $usercl->insert($o);
}else{
    $usercl->update(array('_id'=>$checkUser['_id']), array('$set'=>array('ssid'=>session_id())));
    $o = $checkUser;
}
$_SESSION['uinfo'] = $o;
//$_SESSION['uinfo']['ssid'] = session_id();
header('Location: index.php');exit;