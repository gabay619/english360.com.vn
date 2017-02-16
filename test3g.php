<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include "config/init.php";
include "config/connect.php";
//$adsLogCl = $dbmg->ads_log;
//$log = $adsLogCl->findOne();
$link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&WAP');
$linkVms = Network::genNewLinkConfirmVms("E",$link_callback);
echo '<a href="'.$linkVms.'">CLICK</a>'

?>