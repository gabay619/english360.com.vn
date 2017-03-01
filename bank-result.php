<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 24/02/2017
 * Time: 8:56 AM
 */
include "config/init.php";
include "config/connect.php";
require_once 'sdk/1pay/OnePayBank.php';

//echo 1;die;
$usercl = $dbmg->user;
$logcl = $dbmg->log_txn_bank;
$txncl = $dbmg->txn_bank;
$packagecl = $dbmg->package;
$mpc = new OnePayBank();
$log = $_GET;
$log['_id'] = strval(time());
$logcl->insert($log);
if(!isset($log['order_id'])){
    $_SESSION['flash_mss'] = 'Giao dịch thất bại.';
    header('Location: thong-bao.php');exit;
}

$rs = $mpc->exeResult($log);

//Xử lý kết quả trả về
$txn = $txncl->findOne(array('_id'=>$rs['id']));
$setTxn = array(
    'response_code' => $rs['code']
);

if($rs['code'] == Constant::TXN_BANK_SUCCESS){
    $setTxn['card_name'] = $rs['card_name'];
    $setTxn['card_type'] = $rs['card_type'];
    $txncl->update(array('_id'=>$rs['id']), array('$set'=>$setTxn));
    $user = $usercl->findOne(array('_id'=>$txn['uid']));
    //Neu la thanh toan truc tiep-> dang ky goi
    if(isset($txn['pkg_id'])){
        $package = $packagecl->findOne(array('_id'=>$txn['pkg_id']));
        $time = $package['time']*86400;
        if(isset($user['pkg_expired']) && $user['pkg_expired']>time()){
            //Cong don
            $time = $user['pkg_expired'] + $time;
        }
        $usercl->update(array('_id'=>$txn['uid']), array('$set'=>array('pkg_id'=>$txn['pkg_id'],'pkg_expired'=>$time+time())));
        $_SESSION['flash_mss'] = 'Thanh toán khóa học thành công. Số dư tài khoản hiện tại: '.number_format($user['balance']).'đ';
        header('Location: thong-bao.html');exit;
    }
    //Cap nhat so du
    $balance = isset($user['balance']) ? $user['balance'] : 0;
    $balance = $balance + $txn['amount'] * Constant::BANK_TO_CASH;
    $usercl->update(array('_id'=>$txn['uid']), array('$set'=>array('balance'=>$balance)));
    $_SESSION['flash_mss'] = 'Giao dịch thành công.';
    header('Location: thong-bao.html');exit;
}else{
    $txncl->update(array('_id'=>$rs['id']), array('$set'=>$setTxn));
    $_SESSION['flash_mss'] = Common::getTxnBankMss($rs['code']);
    header('Location: thong-bao.html');exit;
}
