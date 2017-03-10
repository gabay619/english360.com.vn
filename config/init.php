<?php
//echo __DIR__.'/../helpers';die;
//if($_SERVER['SERVER_NAME']=='english360.vn'){
//    echo 'WEBSITE Under Construction';die;
//}
foreach (glob(__DIR__.'/../helpers/*.php') as $filename)
{
    include $filename;
}
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../sdk/Facebook/autoload.php';
//$_SESSION['templogin'] = 1;
//print_r($_SESSION);die;
session_start();

$detech = new Mobile_Detect();
$detechMobile = $detech->isMobile() && !$detech->isTablet();
$version = isset($_SESSION['version']) ? $_SESSION['version'] : ($detechMobile ? 'wap' : 'web');
//var_dump($version);die;
if(($detechMobile && $version!='web') || $version == 'wap' || isset($onWap)) {
//    if($_SESSION['templogin'] != 1 && strpos($_SERVER['REQUEST_URI'], 'wapportal') === false){
//        header("Location: http://english360.vn/templogin.php");die;
//    }
    $_GET = array_merge($_GET, Common::array_strip_tags($_GET));
    include "config/config.php";
//    include "config/autoload.php";
    include "config/rain.tpl.class.php";
 
    $templatedir = $config['template']['mobile']['folder'];
    $sourcedir = $config['template']['mobile']['path'];
    raintpl::$tpl_dir = $sourcedir; // template directory
    raintpl::$cache_dir = $config['template']['mobile']['cache']; // cache directory
    raintpl::configure('path_replace', false);
    $tpl = new raintpl(); //include Rain TPL
    $tpl->assign("sourcedir", $sourcedir . "asset/");
    $tpl->assign("config", $config);
}else{
//    echo 'web';die;
    include "connect.php";
    require __DIR__.'/../website/public/index.php';die;
}
?>