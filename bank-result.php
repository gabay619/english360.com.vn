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
$aff_txncl = $dbmg->aff_txn;
$accountcl = $dbmg->account;
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
    //Tinh tien aff
    if(isset($user['aff']['uid'])){
        $aff = $usercl->findOne(array('_id'=>$user['aff']['uid']));
        $aff_rate = Constant::AFF_RATE_BANK;
        $aff_discount = $aff_rate*$txn['amount'];
        //Luu log aff
        $aff_txncl->insert(array(
            '_id' => strval(time()),
            'datecreate' => time(),
            'txn_id' => $txn['_id'],
            'uid' => $aff['_id'],
            'ref_id' => $user['_id'],
            'method' => Constant::BANK_METHOD_NAME,
            'discount' => $aff_discount,
            'rate' => $aff_rate,
            'amount' => $txn['amount']
        ));
        //Cong tien cho pub
        $account = $accountcl->findOne(array('uid'=>$aff['_id']));
        if(!$account){
            $account = array(
                '_id' => strval(time()),
                'uid' => $aff['_id'],
                'balance' => 0
            );
            $accountcl->insert($account);
        }
        $setAcc = array('balance'=>$account['balance']+$aff_discount);
        $accountcl->update(array('_id'=>$account['_id']), array('$set'=>$setAcc));
    }

    //Neu la thanh toan truc tiep-> dang ky goi
    if(isset($txn['pkg_id'])){
        $package = $packagecl->findOne(array('_id'=>$txn['pkg_id']));
        $time = $package['time']*86400;
        if(isset($user['pkg_expired']) && $user['pkg_expired']>time()){
            //Cong don
            $time = $user['pkg_expired'] + $time;
        }else{
            $time = time() + $time;
        }
        $usercl->update(array('_id'=>$txn['uid']), array('$set'=>array('pkg_id'=>$txn['pkg_id'],'pkg_expired'=>$time)));
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
