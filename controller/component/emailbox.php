<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$usercl = $dbmg->user;
$showEmailbox = true;
$regemail = '';
$regLession = array();
if(isset($_SESSION['uinfo'])){
    $checkUser = $usercl->findOne(array('_id'=>$_SESSION['uinfo']['_id']));
    $regLession = isset($checkUser['reg_lession']) ? $checkUser['reg_lession'] : array();
    if(!is_array($regLession) || count($regLession) == 0){
        $regemail = $_SESSION['uinfo']['email'];
    }else{
        $showEmailbox = false;
    }
}else{
    $regemail = $_SESSION['email_reg_lession'];
}

$allType = Common::getAllLessionType();
//print_r($allType);
$tpl->assign("regemail", "$regemail");
$tpl->assign("allType", $allType);
$tpl->assign("showEmailbox", "$showEmailbox");
$tpl->assign("checked", $regLession);
$tpl->assign("emailbox", "component/emailbox");

