<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20/02/2017
 * Time: 9:49 AM
 */
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/sdk/Facebook/autoload.php';
$fb = new Facebook\Facebook([
    'app_id' => '1539737363001576', // Replace {app-id} with your app id
    'app_secret' => '4e2fd0ebbaacbaca83e713c966d1969d',
    'default_graph_version' => 'v2.2',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://english360.com.vn/fb-callback.html', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';