<?php
//ini_set('display_errors', 'On');
//error_reporting(1);
ob_start();
$ssid = $_GET['ssid'];if(!isset($ssid)) $ssid = $_POST['ssid'];if(isset($ssid)) session_id($ssid);
session_start();
$timecache = 1;
$timememcache =5;
$config = array(
    "sitename"=>"english360.vn",
    "sitebaseurl"=>"",
    "defaultimage"=>"",
    "uploadfolder"=>"uploads",
    "sitemedia"=>array(
        "streamin_gurl"=>"http://english360.vn",
        "static_url"=>"http://english360.vn"
    ),
    "socialinfo"=>array(
        "facebook"=>array(
            "appid"=>"711518975610279"
        )
    ),
    "template"=>array(
        "mobile"=>array(
            "folder"=>"wap",
            "path"=>"template/wap/",
            "cache"=>"cache/"
        )
    )
);

include "function.php";
?>