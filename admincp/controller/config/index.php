<?php
ob_start();
session_start();
if(!isset($_SESSION['admin_config']) || !$_SESSION['admin_config'] || !isset($_SESSION['admin_token']) || !$_SESSION['admin_token']){
    header("Location: login-lv2.php");
}
if($tact=='config_bl') include("bl.php");
elseif($tact=='bl_delete') include("bl_delete.php");
elseif($tact=='config_1t') include("onetouch.php");
elseif($tact=='config_1t5') include("onedotfivetouch.php");
elseif($tact=='onetouch_delete') include("onetouch_delete.php");
elseif($tact=='config_3g') include("log3g.php");
elseif($tact=='config_ads') include("ads.php");
else include("view.php");