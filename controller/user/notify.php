<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$notifycl = $dbmg->notify;
$usercl = $dbmg->user;
$uid=$_SESSION['uinfo']['_id'];
include '/checkLogin.php';
$listNotify = iterator_to_array($notifycl->find(array("uid"=>$uid), array("_id","to","datecreate","mss","type","status"))->sort(array("_id"=>-1))->limit(20),false);
//print_r($listNotify);
$item = array();
foreach($listNotify as $k=>$aNotify){
        $postCl = Common::getClFromType($aNotify['to']['type']);
        $postCl = $dbmg->$postCl;
        $item[] = array(
                'id'=>$aNotify['_id'],
                'mss' => $aNotify['mss'],
                'url' => '/'.Common::getUrlFromType($aNotify['to']['type']).'?id='.$aNotify['to']['id'].'&type='.$aNotify['to']['type'],
                'datecreate' => date('h:s | d/m/Y ',$aNotify['datecreate']),
                'type'=>$aNotify['to']['type']
        );
}

$notifycl->update(array('uid' => $uid), array('$set'=>array('status'=>Constant::STATUS_DISABLE)), array('multiple'=>true));
//$_SESSION['count'] = 0;
//$tpl->assign("notify", $listNotify);
if(count($item)==0) $item = false;
$tpl->assign("item", $item);
$tpl->assign("pagefile", "user/notify");
include "controller/hmc/index.php";
?>