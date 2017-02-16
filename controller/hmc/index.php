<?php
//Hoc ma choi

$hmcaudiocl = $dbmg->hmcaudio;
$cateCl = $dbmg->category;
$thuvienCl = $dbmg->thuvien;
$popupCl = $dbmg->popup;
$bannerCl = $dbmg->banner;
$freecl = $dbmg->free_user;
$configcl = $dbmg->config;
$eventcl = $dbmg->event;
$eucl = $dbmg->event_user;
$condSong = $condFilm =  array(
        'status' => Constant::STATUS_ENABLE,
        '$or' => array(
                array('calendar' => array('$exists'=>false)),
                array('calendar' => array('$lte'=> time()))
        ),
        'free' => '1'
);
$listsong = iterator_to_array($hmcaudiocl->find($condSong)->sort(array("datecreate"=>-1))->limit(4),false);
$tpl->assign("listsong",$listsong);

$condFilm['category'] = '1450861603';
$listfilm = iterator_to_array($thuvienCl->find($condFilm)->sort(array("datecreate"=>-1))->limit(4),false);
$tpl->assign("listfilm",$listfilm);

$listgame = iterator_to_array($cateCl->find(array("parentid"=>"1425089517"),array("_id","name","avatar"))->sort(array("datecreate"=>-1))->limit(4),false);
foreach ($listgame as $key=>$aSong){
    $listgame[$key]['_id'] = $aSong['_id'];
}
$tpl->assign("listgame",$listgame);

//Popup
$url = Constant::BASE_URL.$_SERVER['REQUEST_URI'];
//echo $url;die;
if(isset($_SESSION['uinfo']))
    $login = '1';
else
    $login = '2';
$condPopup = array(
        'status' => Constant::STATUS_ENABLE,
        'start' => array('$lte'=>time()),
        'end' => array('$gte'=>time()),
        '$or' => array(
                array('url' => ''),
                array('url' => $url)
        ),
        'login' => array('$in' => array($login, '3')),
        'ver' => array('$in' => array('wap', 'ww'))
);
//print_r($popupCl);die;
$popup = $popupCl->findOne($condPopup);
$tpl->assign("popup",$popup);

//end popup
$banner = $bannerCl->findOne(array('status'=>Constant::STATUS_ENABLE, 'type'=>Constant::BANNER_WAP_FIXED));
$tpl->assign("banner",$banner);
//Banner

//End banner

//Event welcome
$show = false;
if(isset($_SESSION['uinfo'])){
    $checkFreeUser = $freecl->findOne(array('phone'=>$_SESSION['uinfo']['phone']));
    if($checkFreeUser){
        if($checkFreeUser['show'] == 0){
            $show = 'welcome';
            $freecl->update(array('phone'=>$_SESSION['uinfo']['phone']), array('$set'=>array('show'=>1)));
        }
        $dateDiff = (time() - $checkFreeUser['_id'])/86400;
        if($dateDiff > 15){
            $show = 'expired';
            $freecl->remove(array('phone'=>$_SESSION['uinfo']['phone']));
        }

    }
}
$tpl->assign("show",$show);

//end Hoc ma choi
//ads popup
$showAdsPop = isset($_SESSION['package_ads']);
$adsPopContinue = isset($_SESSION['package_ads_continue']);
$timeoutPopAds = 0;
$waittimePopAds = 0;
$activePopAds = false;
$contentPopAds = '';
$pricePopAds = '';
$linkCancelPopAds = '';
if($showAdsPop){
    $adsPopConf = $configcl->findOne(array('name'=>Constant::CONFIG_1_5TOUCH));
    if($adsPopConf){
        $timeoutPopAds = isset($adsPopConf['value']['timeout']) ? $adsPopConf['value']['timeout']*1000 : 0;
        $waittimePopAds = isset($adsPopConf['value']['waittime']) ? $adsPopConf['value']['waittime']*1000 : 0;
        $contentPopAds = isset($adsPopConf['value']['content']) ? $adsPopConf['value']['content'] : '';
        $pricePopAds = isset($adsPopConf['value']['price']) ? $adsPopConf['value']['price'] : '';
        $activePopAds = isset($adsPopConf['value']['active']) &&  $adsPopConf['value']['active']==Constant::STATUS_ENABLE;
    }
    $linkCancelPopAds = '/incoming.php?act=toPortal';
}

//var_dump($timeoutPopAds);die;
$tpl->assign("showAdsPop",$showAdsPop);
$tpl->assign("timeoutPopAds",$timeoutPopAds);
$tpl->assign("waittimePopAds",$waittimePopAds);
$tpl->assign("contentPopAds",$contentPopAds);
$tpl->assign("pricePopAds",$pricePopAds);
$tpl->assign("adsPopContinue",$adsPopContinue);
$tpl->assign("linkCancelPopAds",$linkCancelPopAds);
$tpl->assign("activePopAds",$activePopAds);

//Event
$showEvent = false;
$registedEvent = false;
if(isset($_SESSION['event_id'])){
    $event = $eventcl->findOne(array('_id'=>$_SESSION['event_id']));
    if($event){
        if(isset($_SESSION['uinfo']['_id'])){
            $checkEventUser = $eucl->findOne(array('uid'=> $_SESSION['uinfo']['_id'], 'eid'=>$_SESSION['event_id']));
            if($checkEventUser) $registedEvent = true;
        }
        $showEvent = true;
        $hasPhone = isset($_SESSION['uinfo']['phone']);
        $tpl->assign("event",$event);
        $tpl->assign("hasPhone",$hasPhone);
        $tpl->assign("registedEvent",$registedEvent);
    }
}
$tpl->assign("showEvent",$showEvent);
$showExpiredEvent = false;
if(isset($_SESSION['uinfo'])){
    $checkEventUser = $eucl->findOne(array('uid'=>$_SESSION['uinfo']['_id']));
    if($checkEventUser){
        $event = $eventcl->findOne(array('_id'=>$checkEventUser['eid']));
        if($event){
            if((time() - $checkEventUser['datecreate'])/86400 > $event['free_day']){
                $showExpiredEvent = true;
                $eucl->remove(array('_id'=>$checkEventUser['_id']));
            }
        }
    }
}
$tpl->assign("showExpiredEvent",$showExpiredEvent);
?>