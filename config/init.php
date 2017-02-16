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
    //detect 3g
    if(Network::is3g() && Network::is3gmobifone()){
        $phone = Network::is3g();
        include "connect.php";
        if(!isset($_SESSION['uinfo']) || $_SESSION['uinfo']['phone'] != $phone){
            $usercl = $dbmg->user;
            $user = $usercl->findOne(array('phone' => $phone));
            if(!$user){
                $password = Common::generateRandomPassword();
                $newUser = array(
                        '_id' => strval(time()),
                        'phone' => $phone,
                        'un_password' => $password,
                        'password' => Common::encryptpassword($password),
                        'datecreate' => time(),
                        'status' => Constant::STATUS_ENABLE,
                        'fullname'=>'',
                        'email'=> '',
                        'cmnd'=> '',
                        'cmnd_ngaycap'=>'',
                        'cmnd_noicap'=>'',
                        'birthday'=>'',
                        'priavatar'=>'',
                        'thong_bao' => array(
                            'noti' => "1",
                            'sms' => "1",
                            'email' => "1",
                        )
                );
                $usercl->insert($newUser);
            }
            $o = (array) $usercl->findOne(array('phone'=>$phone));
            $_SESSION['uinfo'] = $o;
        }
        //log
        $logCl = $dbmg->log;
        $date = date('d/m/Y');
        $logTime = $logCl->findOne(array('date'=>$date));
        if($logTime){
            $logCl->update(array('date'=>$date), array('$set'=>array('total'=>$logTime['total']+1)));

        }else{
            $newLog = array(
                    'date' => $date,
                    'chanel' => 'wap',
                    'total' => 1
            );
            $logCl->insert($newLog);
        }
        //log3g
        $log3gCl = $dbmg->log3g;
        $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
        $newLog3g = array(
                '_id' => strval(time()),
                'phone' => $phone,
                'ip' => Network::ip(),
                'chanel' => 'WAP',
                'useragent' => $useragent,
                'status' => Constant::STATUS_ENABLE,
                'datecreate' => time()
        );
        $log3gCl->insert($newLog3g);
    }elseif(Network::is3g() && !Network::is3gmobifone()){
        $log3gCl = $dbmg->log3g;
        $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
        $newLog3g = array(
                '_id' => strval(time()),
                'phone' => $phone,
                'ip' => Network::ip(),
                'chanel' => 'WAP',
                'useragent' => $useragent,
                'status' => Constant::STATUS_DISABLE,
                'datecreate' => time()
        );
        $log3gCl->insert($newLog3g);
    }
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