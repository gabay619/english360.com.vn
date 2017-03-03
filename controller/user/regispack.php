<?php
//$usercl = $dbmg->user;
//$authKey = $dbmg->auth_key;
//$ui = $_SESSION['uinfo']['phone'];
//$sentKey = (array)$authKey->findOne(array('phone'=>$ui));
//if(!$sentKey){
//    $newKey = array(
//        'phone' => $ui,
//        'key' => rand(100000, 999999),
//        'time' => time()
//    );
//    $authKey->insert($newKey);
//}
//Gui SMS
//Network::sentMT($phone, 'INVALID', 'message');
//result 0  = thành công

//Đăng ký gói cước

//$re = Network::registedpack($_SESSION['uinfo']['phone']);

//result 0 = thành công

//Hủy gói
//Network::cancelpack($phone);
//result 0 = thành công

//Kiểm tra có đang đk gói ko
//$result = Network::getUserInfo($_SESSION['uinfo']['phone']);

//result 1 = đang sử dụng gói

//$tpl->assign("obj", $sentKey);
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include '/checkLogin.php';
$packagecl = $dbmg->package;
$usercl = $dbmg->user;
$step = isset($_GET['step']) ? $_GET['step'] : 1;
switch ($step){
    case 1:
        $allPackage = iterator_to_array($packagecl->find(array('status'=>Constant::STATUS_ENABLE)));
        $tpl->assign("allPackage", $allPackage);
        $tpl->assign("pagefile", "user/regispack_1");
        break;
    case 2:
        $selectPkg = $packagecl->findOne(array('_id'=>$_GET['pkg']));
        if(!$selectPkg){
            $_SESSION['flash_mss'] = 'Gói cước không tồn tại';
            header('Location: /thong-bao.html');exit;
        }
        $user = $usercl->findOne(array('_id'=>$_SESSION['uinfo']['_id']));
        $balance = isset($user['balance']) ? $user['balance'] : 0;
//        $balance = Common::getBalance($_SESSION['uinfo']['_id']);
        $tpl->assign("selectPkg", $selectPkg);
        $tpl->assign("balance", $balance);
        $tpl->assign("pagefile", "user/regispack_2");
        break;
    case 3:
        $selectPkg = $packagecl->findOne(array('_id'=>$_GET['pkg']));
        if(!$selectPkg){
            $_SESSION['flash_mss'] = 'Gói cước không tồn tại';
            header('Location: /thong-bao.html');exit;
        }
        switch ($_GET['type']){
            case 'card':
                $listCardType = array(''=>'--Chọn loại thẻ--')+Common::getCardType();
                $tpl->assign("selectPkg", $selectPkg);
                $tpl->assign("listCardType", $listCardType);
                $tpl->assign("pagefile", "user/regispack_card");
                break;
            case 'bank':
                $txnbankcl = $dbmg->txn_bank;
                $amount = $selectPkg['price'];
                $txnbank = array(
                    '_id' => strval(time()),
                    'datecreate' => time(),
                    'uid' => $_SESSION['uinfo']['_id'],
                    'amount' => $amount,
                    'pkg_id' => $selectPkg['_id']
                );
                $txnbankcl->insert($txnbank);
                require_once '/sdk/1pay/OnePayBank.php';
                $mpc = new OnePayBank();
                $order_id = $txnbank['_id'];
                $order_info = $_SESSION['uinfo']['email'].' nap '.$amount.'d English360';
                $payUrl = $mpc->getPayUrl($amount, $order_id, $order_info);
//                echo $payUrl;exit;
//                var_dump($payUrl);die;
                if(!$payUrl){
                    $_SESSION['flash_mss'] = 'Có lỗi xảy ra, vui lòng thử lại sau.';
                    header('Location: /thong-bao.html');exit;
                }
                header('Location: '.$payUrl);exit;
                break;
            case 'cash';
                $user = $usercl->findOne(array('_id'=>$_SESSION['uinfo']['_id']));
                $balance = isset($user['balance']) ? $user['balance'] : 0;
                $missBalance = $selectPkg['price'] - $balance;
                //So du nho hon hoc phi
                if($missBalance > 0){
                    $_SESSION['flash_mss'] = 'Số dư không đủ. Vui lòng nạp tiền vào tài khoản để thanh toán khóa học.';
                    header('Location: /thong-bao.html');exit;
                }
                //Tao giao dich
                $txncl = $dbmg->txn;
                $txn = array(
                    '_id' => strval(time()),
                    'datecreate' => time(),
                    'uid' => $_SESSION['uinfo']['_id'],
                    'amount' => $selectPkg['price']
                );
                $txncl->insert($txn);
                //Update số dư+đăng ký gói
                $time = $selectPkg['time']*86400;
                $balance = $balance - $selectPkg['price'];
                if(isset($user['pkg_expired']) && $user['pkg_expired']>time()){
                    //Cong don
                    $time = $user['pkg_expired'] + $time;
                }else{
                    $time = time() + $time;
                }
                $usercl->update(array('_id'=>$txn['uid']), array('$set'=>array('pkg_id'=>$txn['pkg_id'],'pkg_expired'=>$time,'balance'=>$balance)));
                $_SESSION['flash_mss'] = 'Thanh toán khóa học thành công. Số dư tài khoản hiện tại: '.number_format($balance).'đ';
                header('Location: /thong-bao.html');exit;
                break;
            case 'sms':
                $contentId = 'NAP';
                $contentId .= $selectPkg['price']/1000;
                $mo = array(
                    'VTE' => 'MW '.$selectPkg['price'].' E360 NAP '.$_SESSION['uinfo']['_id'].'.'.$selectPkg['code'],
                    'VMS' => 'MW E360 '.$contentId.' '.$_SESSION['uinfo']['_id'].'.'.$selectPkg['code'],
                    'VNP' => 'MW E360 '.$contentId.' '.$_SESSION['uinfo']['_id'].'.'.$selectPkg['code']
                );
                $tpl->assign("mo", $mo);
                $tpl->assign("selectPkg", $selectPkg);
                $tpl->assign("pagefile", "user/regispack_sms");
                break;
            default:
                $_SESSION['flash_mss'] = 'Phương thức thanh toán không hỗ trợ';
                header('Location: /thong-bao.html');exit;
                break;
        }
        break;
    default:
        break;
}
//$is3g = Network::is3g();
//$linkVms = '';
//if($is3g && Network::is3gmobifone() && Network::OPEN_REG){
//    $link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&WAP');
//    $linkVms = Network::genLinkConfirmVms("E",$link_callback);
//}
//$act = isset($_GET['act']) ? $_GET['act'] : '';
//$confirm = $act == 'confirm';
//$isLogin = isset($_SESSION['uinfo']);
//$flash_mss = isset($_SESSION['flash_mss']) ? $_SESSION['flash_mss'] : '';
//$tpl->assign("flash_mss", $flash_mss);
//unset($_SESSION['flash_mss']);
//
//$tpl->assign("confirm", "$confirm");
//$tpl->assign("isLogin", $isLogin);
//$tpl->assign("linkVms", "$linkVms");
//$tpl->assign("is3g", "$is3g");
//$tpl->assign("pagefile", "user/regispack");
include "controller/hmc/index.php";
?>