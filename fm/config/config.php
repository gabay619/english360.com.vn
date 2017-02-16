<?php
if(isset($_POST[session_name()])) session_id($_POST[session_name()]);
session_start();
include("functionsupport.php");
$checklogin = true;
$uinfoadmin = $_SESSION['uinfoadmin'];
$rootfolder = "uploads/file/".md5($uinfoadmin)."/";
$startbyuserfolder = true;
$fileallow = "jpg,gif,png,jpeg,avi,mp4,flv,mp3,apk,ipa,java";

$filetypes = array(
    'media'=>array("mp3", "wav", "ogg", "mp4", "flv","webm"),
    'image' => array("jpg", "gif", "png", "jpeg"),
    'text' => array("txt", "html", "php", "js", "config","css", "srt"),
    'app' => array("apk", "java", "ipa")
    );
$siteUrl =  "http" . (($_SERVER['SERVER_PORT']==443) ? "s://" : "://") . $_SERVER['HTTP_HOST']."/fm/" ;
?>