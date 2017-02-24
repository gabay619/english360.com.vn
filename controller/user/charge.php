<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 24/02/2017
 * Time: 9:38 AM
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
$notifycl = $dbmg->notify;
$usercl = $dbmg->user;
$type = isset($_GET['type']) ? $_GET['type'] : '';
switch ($type){
    case 'card':
        $card_type = array(''=>'--Chọn loại thẻ--')+Common::getCardType();
        $tpl->assign("card_type", $card_type);
        break;
    case 'bank':
        break;
    case 'sms':
        break;
    case 'api':
        break;
    default:
        break;
}

$tpl->assign("type", $type);
$tpl->assign("pagefile", "user/charge");
include "controller/hmc/index.php";