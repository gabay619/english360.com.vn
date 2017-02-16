<?php
foreach (glob(__DIR__.'/../helpers/*.php') as $filename)
{
    include $filename;
}
include("../config/config.php");
include("inc/permission.php");
if(!acceptpermiss("loginsystem")) { header("Location: login.php"); die; }
//if(!isset($_SESSION['uinfo'])) { header("Location: login.php"); die; }
include("../config/connect.php");
$act= $_GET['act'];
$tact= $_GET['tact'];
$md = getpermissionbykey("key",$act);
if(!isacceptpermission(array($md['key']))) die("You are not authorize this permission");
$page = $md["controller"];
include("component/template.php");
?>