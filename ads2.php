<?php
include "config/init.php";
include "config/connect.php";

$adscl = $dbmg->ads;
$_GET['time'] = time();
$_GET['phone'] =  Network::is3g() ? Network::is3g() : '';
$adscl->insert($_GET);
$phone = Network::is3g();
$link_vms = '';
$linkRedirect = isset($_GET['link']) ? $_GET['link'] : 'index.php';
if($phone){
    $checkPackage = Network::getUserInfo($phone);
    if (Network::is3g() != '' && Network::is3gmobifone() == 1) {
        if ($checkPackage != 1) {
            $link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&WAP');
            $link_vms = Network::genLinkConfirmVms('E', $link_callback);
        }
    }
}

if(empty($link_vms)){
    header("Location: ".$linkRedirect);exit;
}else{
    die("<script>location.href = '".$link_vms."'</script>");
}
