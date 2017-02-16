<?php
$historycl = $dbmg->history_log;
$params = $_GET['params'];
list($code, $device) = explode('&', base64_decode($params));
$link = isset($_GET['link']) ? $_GET['link'] : '';
$phone = 0;
if (!empty($link)) {
    $link = str_replace(' ', '+', $link);
    $key = Network::KEY_VMS;
    $str_rs = Network::aes128_ecb_decrypt($key, base64_decode($link), "");
    if ($str_rs) {
        list($trans_id, $msisdn, $rs) = explode('&', $str_rs);
        $rs == 1 ? 'dk' : '';
        $phone = Network::reversephone($msisdn);
    } else {
        header("Location: " . Constant::BASE_URL);exit;
    }
}
$error_mss = '';
$success_mss = '';
if($phone){
    $checkPackage = Network::getUserInfo($phone);
    if ($rs == 1) {
        $listPackage = Network::getPackageItem();
        if ($listPackage[$code]) {
            if($checkPackage != 1) {
                if(Network::registedpack($phone, $device, $code) != 0){
                    if($device == 'APP'){
                        echo 'Quá trình đăng ký thất bại, vui lòng thử lại sau.';exit;
                    }
                    else{
                        $error_mss = 'Quá trình đăng ký thất bại, vui lòng thử lại sau.';
                    }
                    $newHistoryLog = array(
                            '_id' => strval(time().rand(10,99)),
                            'datecreate' => time(),
                            'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
                            'chanel' => $device == 'APP' ? HistoryLog::CHANEL_APP : HistoryLog::CHANEL_WAP,
                            'ip' => Network::ip(),
                            'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
                            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
                            'status' => Constant::STATUS_DISABLE,
                            'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
                            'price'=> 0
                    );
                    if(!isset($_SESSION['notsave_log']))
                        $historycl->insert($newHistoryLog);
                }else{
                    if($device == 'APP'){
                        echo 'Quý khách đã đăng ký thành công dịch vụ English360. Chi tiết liên hệ '.Constant::SUPPORT_PHONE.'. Trân trọng cảm ơn!';exit;
                    }
                    else{
                        $success_mss = 'Quý khách đã đăng ký thành công dịch vụ English360. Chi tiết liên hệ '.Constant::SUPPORT_PHONE.'. Trân trọng cảm ơn!';
                    }
                    $packageInfo = Network::getCancelInfo($phone);
                    $newHistoryLog = array(
                            '_id' => strval(time().rand(10,99)),
                            'datecreate' => time(),
                            'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
                            'chanel' => $device == 'APP' ? HistoryLog::CHANEL_APP : HistoryLog::CHANEL_WAP,
                            'ip' => Network::ip(),
                            'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
                            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
                            'status' => Constant::STATUS_ENABLE,
                            'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
                            'price'=>$packageInfo == 0 ? 0 : Network::getPackageItem()['E']['price']
                    );
                    if(!isset($_SESSION['notsave_log']))
                        $historycl->insert($newHistoryLog);
                }
            }else{
                if($device == 'APP'){
                    echo 'Quý khách hiện đang sử dụng dịch vụ English360. Chi tiết liên hệ '.Constant::SUPPORT_PHONE.'. Trân trọng cảm ơn!';exit;
                }
                else{
                    $error_mss = 'Quý khách hiện đang sử dụng dịch vụ English360. Chi tiết liên hệ '.Constant::SUPPORT_PHONE.'. Trân trọng cảm ơn!';
                }
                $newHistoryLog = array(
                        '_id' => strval(time().rand(10,99)),
                        'datecreate' => time(),
                        'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
                        'chanel' => $device == 'APP' ? HistoryLog::CHANEL_APP : HistoryLog::CHANEL_WAP,
                        'ip' => Network::ip(),
                        'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
                        'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
                        'status' => Constant::STATUS_DISABLE,
                        'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
                        'price'=> 0
                );
                if(!isset($_SESSION['notsave_log']))
                    $historycl->insert($newHistoryLog);
            }
        }else {
            header("Location: " . Constant::BASE_URL);exit;
        }
    }else{
        if($device == 'APP'){
            echo 'Quý khách đã bỏ qua Đăng ký dịch vụ English360.';exit;
        }else
            header("Location: " . Constant::BASE_URL);exit;
    }

}else{
    header("Location: " . Constant::BASE_URL . '/login.php');exit;
}

$tpl->assign("error_mss", "$error_mss");
$tpl->assign("success_mss", "$success_mss");
$tpl->assign("pagefile", "user/wapportal");
include "controller/hmc/index.php";