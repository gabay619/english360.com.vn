<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$usercl = $dbmg->user;
//$notifycl = $dbmg->notify;
$historycl = $dbmg->history_log;
//$ui = $_SESSION['uinfo'];
//$uid = $ui['_id'];
$token = new Csrf(true, true, false);
$tpl->assign("csrf_name", $token->get_token_name());
$tpl->assign("csrf_value", $token->get_token_value());

//$phone = $_SESSION['uinfo']['phone'];
$uid = $_SESSION['uinfo']['_id'];
$t = $_GET['t'];if(!isset($t)) $t="home";
if (isset($_SESSION['uinfo'])) {
//    $checkTCSMS = Network::checkTCSMS($_SESSION['phone']);
    $thong_bao = array(
            'noti' => $_SESSION['uinfo']['thong_bao']['noti'],
//            'sms' => $checkTCSMS==0 ? '1' : '0',
            'email' => $_SESSION['uinfo']['thong_bao']['email']
    );
    $usercl->update(array('_id'=>$uid), array('$set'=>array('thong_bao'=>$thong_bao)));
    $_SESSION['uinfo']['thong_bao'] = $thong_bao;
if(!empty($_POST)){
    if(isset($_FILES['file_upload']) && !empty($_FILES['file_upload']['name'])){
        $ext = pathinfo($_FILES['file_upload']['name'])['extension'] ;
        switch($ext){
            case "jpg":
            case "png":
            case "gif":
                break;
            default:
                echo "Chỉ được upload tệp ảnh (jpg, png, gif)"; die;
        }
//        echo 1;die;
        $targetfolder = "/uploads/avatar/";
        $targetPath = $_SERVER['DOCUMENT_ROOT'].str_replace("../","",$targetfolder);
        if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);
        $file_name =  str_replace(" ","_",strtotime("now")."_".$_FILES['file_upload']['name']);
        $targetFile = str_replace("//","/",$targetPath) . $file_name;
        if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $targetFile))
        {
            $_POST['priavatar'] = $targetfolder.$file_name;
        }
        else {
//               echo "Problem uploading file";
        }
    }else{
        $_POST['priavatar'] = $_SESSION['uinfo']['priavatar'];
    }

    $o = (array)$usercl->findOne(array('_id'=>$uid));
    $error = false;
    if(!empty($_POST['birthday']) && strtotime($_POST['birthday']) > time()){
        $messageinfo = array("mss"=>"Ngày sinh không được lớn hơn ngày hiện tại.","display"=>"");
        $error = true;
        $tpl->assign("messageinfo",$messageinfo);
    }
    if(!empty($_POST['birthday']) && !empty($_POST['cmnd_ngaycap'])&& strtotime($_POST['birthday']) > strtotime($_POST['cmnd_ngaycap'])){
        $messageinfo = array("mss"=>"Ngày cấp CMND không được nhỏ hơn ngày sinh.","display"=>"");
        $error = true;
        $tpl->assign("messageinfo",$messageinfo);
    }
//    if(!empty($_POST['email'])){
//        $checkEmail = $usercl->findOne(array('email'=>$_POST['email'], '_id'=>array('$ne'=>$_SESSION['uinfo']['_id'])));
//        if($checkEmail){
//            $messageinfo = array("mss"=>"Email đã được sử dụng.","display"=>"");
//            $error = true;
//            $tpl->assign("messageinfo",$messageinfo);
//        }
//    }

    if(!$error){
        $set = array(
            "fullname"=>empty($_POST['fullname']) ? $o['fullname'] : $_POST['fullname'],
            "priavatar"=>$_POST['priavatar'],
            "birthday"=>empty($_POST['birthday']) ? $o['birthday'] : date('d/m/Y', strtotime($_POST['birthday'])),
//            "email"=>empty($_POST['email']) ? $o['email'] : $_POST['email'],
            "cmnd"=>empty($_POST['cmnd']) ? $o['cmnd'] : $_POST['cmnd'],
            "cmnd_ngaycap"=>empty($_POST['cmnd_ngaycap']) ? $o['cmnd_ngaycap'] : date('d/m/Y', strtotime($_POST['cmnd_ngaycap'])),
            "cmnd_noicap"=>empty($_POST['cmnd_noicap']) ? $o['cmnd_noicap'] : $_POST['cmnd_noicap'],
            "displayname"=>empty($_POST['displayname']) ? $o['displayname'] : $_POST['displayname'],
            "thong_bao"=>array(
                'noti' => empty($_POST['chkNoti']) ? '0' : strval($_POST['chkNoti']),
//                'sms' => empty($_POST['chkSms']) ? '0' : strval($_POST['chkSms']),
                'email' => empty($_POST['chkEmail']) ? '0' : strval($_POST['chkEmail']),
            )
        );

        $usercl->update(array("_id"=>$uid),array('$set'=>$set),array("multiple"=>false));

        $messageinfo = array("mss"=>"Cập nhật thông tin thành công","display"=>"");
        $tpl->assign("messageinfo",$messageinfo);
        //Lưu log
        $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_EDIT_PROFILE,
            'chanel' => HistoryLog::CHANEL_WAP,
            'ip' => Network::ip(),
            'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
//            'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
            'price'=>0,
            'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""

        );
        if(!isset($_SESSION['notsave_log']))
            $historycl->insert($newHistoryLog);
    }
//    }
}
}else{
    header('Location: /login.php');exit;
    $messageinfo = array("mss"=>"Bạn cần đăng nhập để thực hiện chức năng này","display"=>"");
    $tpl->assign("messageinfo",$messageinfo);
}
$ui = (array)$usercl->findOne(array("_id"=>$uid));
$_SESSION['uinfo'] = $ui;
$ui['birthday'] = DateTime::createFromFormat('d/m/Y', $ui['birthday']) ? DateTime::createFromFormat('d/m/Y', $ui['birthday'])->format('Y-m-d') : '';
$ui['cmnd_ngaycap'] = DateTime::createFromFormat('d/m/Y', $ui['cmnd_ngaycap']) ? DateTime::createFromFormat('d/m/Y', $ui['cmnd_ngaycap'])->format('Y-m-d') : '';
$tpl->assign("alert", $messageinfo);
$tpl->assign("uinfo",$ui);
$tpl->assign("pagefile", "user/setup");
include "controller/hmc/index.php";
?>