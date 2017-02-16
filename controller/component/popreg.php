<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 08/07/2016
 * Time: 10:58 AM
 */
$configcl = $dbmg->config;
$timeout = 0;
$linkVms = '';
if(!isset($_SESSION['uinfo']) || Network::getUserInfo($_SESSION['uinfo']['phone'],'E',$_SESSION['uinfo']['_id'])!=1){
    $config = $configcl->findOne(array('name' => Constant::CONFIG_POPUP_REG));
    if($config){
        $_SESSION['number_popreg'] = isset($_SESSION['number_popreg']) ? $_SESSION['number_popreg'] : 0;
//        echo $_SESSION['number_popreg'];
        if($_SESSION['number_popreg'] < $config['value']['number']){
//            $_SESSION['number_popreg']++;
            $timeout = $config['value']['timeout']*1000;
            if(Network::is3g() && Network::is3gmobifone() && Network::OPEN_REG){
                $link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&WAP');
                $linkVms = Network::genLinkConfirmVms("E",$link_callback);
            }
        }
    }
}

$tpl->assign("timeout",$timeout);
$tpl->assign("linkVms",$linkVms);