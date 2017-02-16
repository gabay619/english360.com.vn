<?php
$usercl = $dbmg->user;
$eucl = $dbmg->event_user;
$eventcl = $dbmg->event;
include '/checkLogin.php';
if(Network::getUserInfo($_SESSION['uinfo']['phone'],'E',$_SESSION['uinfo']['_id']) != 1){
    header('Location: /regispack.php');
}
$isFreeUser = Common::isFreeUser($_SESSION['uinfo']['phone']);
$tpl->assign("isFreeUser", "$isFreeUser");
$isHssvUser = Common::isHssvUser($_SESSION['uinfo']['_id']);
$tpl->assign("isHssvUser", "$isHssvUser");
$eventUser = $eucl->findOne(array('uid'=>$_SESSION['uinfo']['_id']));
$event = false;
if($eventUser){
    $event = $eventcl->findOne(array('_id'=>$eventUser['eid']));
    if($event){
        $startEvent = date('d/m/Y', $eventUser['datecreate']);
        $endEvent = date('d/m/Y', $eventUser['datecreate']+$event['free_day']*24*60*60);
        $tpl->assign("startEvent", $startEvent);
        $tpl->assign("endEvent", $endEvent);
    }
}
$tpl->assign("event", $event);
$tpl->assign("pagefile", "user/regispacked");

include "controller/hmc/index.php";

?>