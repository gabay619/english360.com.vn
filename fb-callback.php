<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20/02/2017
 * Time: 9:49 AM
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
//session_start();
//$onWap =1;
include "config/init.php";
include "config/connect.php";

$usercl = $dbmg->user;

$fb = new Facebook\Facebook([
    'app_id' => Constant::FACEBOOK_APP_ID, // Replace {app-id} with your app id
    'app_secret' => Constant::FACEBOOK_APP_KEY,
    'default_graph_version' => 'v2.2',
]);

$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (! isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
}

// Logged in
//echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//echo '<pre>';
//print_r($tokenMetadata);
//echo '</pre>';
// Lấy thông tin
$fb_uid = $tokenMetadata->getUserId();
$_SESSION['fb_access_token'] = (string) $accessToken;
$fb->setDefaultAccessToken($_SESSION['fb_access_token']);
$response = $fb->get('/me?locale=en_US&fields=name,email,picture');
$userNode = $response->getGraphUser();
//echo $userNode->getField('id');
//var_dump(
//    $userNode->getField('email'), $userNode['email']
//);
$fb_email = $userNode->getField('email');
$fb_name = $userNode->getField('name');
$checkUser = $usercl->findOne(array('fbid'=>$fb_uid));
if(!$checkUser){
//    $img = 'http://graph.facebook.com/'.$fb_uid.'/picture?type=large';
//    $avatar = 'uploads/avatar/'.$fb_uid.'.jpg';
//    copy($img, $avatar);
    $uid = strval(time());
    $email = $usercl->findOne(array('email'=>$fb_email)) ? '' : $fb_email;
//    $password = Common::generateRandomPassword();
    $o = array(
        '_id' => $uid,
//        'username'=> $username,
        'displayname' => $fb_name,
        'fullname' => $fb_name,
        'fbid' => $fb_uid,
//        'un_password'=>$password,
//        'password' => Common::encryptpassword($password),
        'datecreate' => time(),
        'status'=>Constant::STATUS_ENABLE,
        'email'=>$email,
        'priavatar'=>'',
        'cmd'=>'',
        'cmnd_noicap'=>'',
        'cmnd_ngaycap'=>'',
        'birthday'=>'',
        'thong_bao' => array(
            'noti' => "1",
            'email' => "1",
        )
    );
    $usercl->insert($o);
}else
    $o = $checkUser;
$_SESSION['uinfo'] = $o;
header('Location: index.php');exit;

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('1539737363001576'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
    }

    echo '<h3>Long-lived</h3>';
    var_dump($accessToken->getValue());
}


echo '<img src="//graph.facebook.com/'.$tokenMetadata->getUserId().'/picture?type=large">';
//$fb->setDefaultAccessToken($_SESSION['fb_access_token']);
//$response = $fb->get('/me?locale=en_US&fields=name,email,picture');
//$userNode = $response->getGraphUser();
//echo $userNode->getField('id');
//var_dump(
//    $userNode->getField('email'), $userNode['email']
//);
// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');