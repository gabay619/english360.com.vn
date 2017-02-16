<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28/12/2016
 * Time: 9:21 AM
 */
session_start();
//print_r($_SESSION);die;
$onWap = 1;

//include "config/init.php";
foreach (glob(__DIR__.'/helpers/*.php') as $filename)
{
    include $filename;
}
include "config/connect.php";
//$usercl = $dbmg->user;
//$user = $usercl->findOne(array('email'=>'congchinh.619@gmail.com'));
//print_r($user);die;
$eventcl = $dbmg->event;
$eucl = $dbmg->event_user;
$adscl = $dbmg->ads;
$usercl = $dbmg->user;
$_GET['time'] = time();
$_GET['phone'] =  Network::is3g() ? Network::is3g() : '';
$_GET['ip'] = Network::ip();
$adscl->insert($_GET);
$event_id = $_GET['eid'];
$link = isset($_GET['link']) ? $_GET['link'] : '/';
$event = $eventcl->findOne(array('_id'=>$event_id));
if(!$event){
    header('Location: '.$link); exit;
}
$start = $event['start'];
$end = $event['end'];
$now = time();
if($start > $now || $end < $now || $event['status'] != Constant::STATUS_ENABLE){
    header('Location: '.$link); exit;
}
if(Network::is3g() && Network::is3gmobifone()){
    $phone = Network::is3g();
//    include "connect.php";
    if(!isset($_SESSION['uinfo']) || $_SESSION['uinfo']['phone'] != $phone){
//        $usercl = $dbmg->user;
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
//    $logCl = $dbmg->log;
//    $date = date('d/m/Y');
//    $logTime = $logCl->findOne(array('date'=>$date));
//    if($logTime){
//        $logCl->update(array('date'=>$date), array('$set'=>array('total'=>$logTime['total']+1)));
//
//    }else{
//        $newLog = array(
//            'date' => $date,
//            'chanel' => 'wap',
//            'total' => 1
//        );
//        $logCl->insert($newLog);
//    }
//    //log3g
//    $log3gCl = $dbmg->log3g;
//    $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
//    $newLog3g = array(
//        '_id' => strval(time()),
//        'phone' => $phone,
//        'ip' => Network::ip(),
//        'chanel' => 'WAP',
//        'useragent' => $useragent,
//        'status' => Constant::STATUS_ENABLE,
//        'datecreate' => time()
//    );
//    $log3gCl->insert($newLog3g);

    if(Network::getUserInfo($phone) == 1){
        header('Location: '.$link); exit;
    }
//    echo $_SESSION['uinfo']['_id'].'-'.$event_id;die;
    $userEvent = $eucl->findOne(array('uid'=>$_SESSION['uinfo']['_id'], 'eid'=>$event_id));
//    var_dump($userEvent);die;
    if(!$userEvent){
        $user = $usercl->findOne(array('_id'=>$_SESSION['uinfo']['_id']));
        $eucl->insert(array(
            '_id' => strval(time()),
            'datecreate' => time(),
            'uid' => $_SESSION['uinfo']['_id'],
            'eid' => $event_id
        ));
        $start = time();
        $end = $start + $event['free_day']*24*60*60;
        $mtcontent = str_replace(array('{phone}','{pass}','{start}','{end}'), array($_SESSION['uinfo']['phone'], $_SESSION['uinfo']['un_password'],date('d/m/Y',$start), date('d/m/Y',$end)), $event['contentMT']);
        Network::sentMT($_SESSION['uinfo']['phone'], 'DKKM', $mtcontent);
//        header('Location: '.$link); exit;
    }
}


//if(isset($_SESSION['uinfo'])){
//    if(Network::getUserInfo($_SESSION['uinfo']['phone']) == 1){
//        header('Location: '.$link); exit;
//    }
//    $userEvent = $eucl->findOne(array('uid'=>$_SESSION['uinfo']['_id'], 'eid'=>$event_id));
//    if(!$userEvent){
//        $user = $usercl->findOne(array('_id'=>$_SESSION['uinfo']['_id']));
//        $eucl->insert(array(
//            '_id' => strval(time()),
//            'datecreate' => time(),
//            'uid' => $_SESSION['uinfo']['_id'],
//            'eid' => $eventId
//        ));
//        $start = time();
//        $end = $start + $event['free_day']*24*60*60;
//        $mtcontent = str_replace(array('{phone}','{pass}','{start}','{end}'), array($user['phone'], $user['un_password'],date('d/m/Y',$start), date('d/m/Y',$end)), $event['contentMT']);
//        Network::sentMT($_SESSION['uinfo']['phone'], 'DKKM', $mtcontent);
////        header('Location: '.$link); exit;
//    }
//}
//echo 1;exit;
$_SESSION['event_id'] = $event_id;
//echo $_SESSION['event_id'];die;
header('Location: '.$link); exit;
