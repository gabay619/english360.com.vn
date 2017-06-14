<?php
ob_start();
session_start();
include "config/init.php";
include "config/connect.php";
$historycl = $dbmg->history_log;
$newHistoryLog = array(
        '_id' => strval(time().rand(10,99)),
        'datecreate' => time(),
        'action' => HistoryLog::LOG_DANG_XUAT,
        'chanel' => HistoryLog::CHANEL_WAP,
        'ip' => Network::ip(),
        'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
        'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
        'status' => Constant::STATUS_ENABLE,
        'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
        'price'=>0,
        'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""

);
if(!isset($_SESSION['notsave_log']))
    $historycl->insert($newHistoryLog);
unset($_SESSION['uinfo']);
//session_destroy();
header("Location: index.php");
?>