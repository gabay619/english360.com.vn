<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
foreach (glob(__DIR__.'/helpers/*.php') as $filename)
{
    include $filename;
}
include "config/config.php";
include "config/connect.php";

header('Content-Type: application/json; charset=UTF-8');
$act = $_GET['act'];
if (!isset($act)) $act = $_POST['act'];

switch($act){
    case  'sent_auth_key': sent_auth_key();break;
    case 'deletenotify':deletenotify();break;
    case 'deletefaq':deletefaq();break;
    case 'saveexam':saveexam();break;
    case 'deleteexam':deleteexam();break;
    case 'savecomment':savecomment();break; // Lưu comment
    case 'getcomment':getcomment();break; // Lưu comment
    case 'hoidap' : hoidap();break;
    case 'sendconfirmkey' : sendconfirmkey();break;
    case 'confirmnewpass' : confirmnewpass();break;
    case 'addlike' : addlike();break;
    case 'checkbtsapxep' : checkbtsapxep();break;
    case 'register' : register();break;
    case 'regispack' : regispack();break;
    case 'cancelpack': cancelpack();break;
    case 'likecomment': likecomment();break;
    case 'unlikecomment': unlikecomment();break;
    case 'report': report();break;
    case 'check_auth_key': check_auth_key(); break;
    case 'likefaq': likefaq(); break;
    case 'unlikefaq': unlikefaq(); break;
    case 'count_notify' : count_notify();break;
    case 'add-lession' : addLession();break;
    case 'tratu':tratu();break;
    case 'loadTratu': loadTratu(); break;
    case 'importexcel':
        set_include_path(get_include_path() . PATH_SEPARATOR . 'plugin/Classes/');
        /** PHPExcel_IOFactory */
        include("/plugin/Classes/PHPExcel/IOFactory.php");
        importexcel(); break;
    case 'deleteSong': deleteSong(); break;
    case 'addPopupNumber': addPopupNumber(); break;
    case 'regPackageAds': regPackageAds(); break;
    case 'cancelPackageAds': cancelPackageAds(); break;
    case 'toPortal': toPortal(); break;
    case 'reg-lession': regLession(); break;
    case 'reg-email-lession': regEmailLession(); break;
    case 'test': test(); break;
    case 'removeEvent': removeEvent(); break;
    case 'regEvent': regEvent(); break;

}
function cancelpack(){
    global $dbmg;
    $historycl = $dbmg->history_log;
    $result = Network::cancelpack($_SESSION['uinfo']['phone']);
    if($result==0){
        $dtr['status'] = 200;
        $dtr['mss'] = "thanh cong";

        $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_HUY_GOI_CUOC,
            'chanel' => HistoryLog::CHANEL_WAP,
            'ip' => Network::ip(),
            'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
            'price'=>0
        );
        if(!isset($_SESSION['notsave_log']))
            $historycl->insert($newHistoryLog);
    }else{
        $dtr['status'] = 250;
        $dtr['mss'] = " Huy that bai";
    }

    echo json_encode($dtr);exit;
}
function sent_auth_key(){
    global $dbmg;
    $usercl = $dbmg->user;
    $authCl = $dbmg->auth_key;
    $dtr['status'] = 500;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : $_SESSION['uinfo']['phone'];
    if(empty($phone)){
        $dtr['mss'] = 'Vui lòng nhập số điện thoại.';
        echo json_encode($dtr);exit();
    }
    if(!Network::mobifoneNumber($phone)){
        $dtr['mss'] = 'Vui lòng nhập số điện thoại MobiFone.';
        echo json_encode($dtr);exit();
    }
    if(isset($_POST['check'])){
        $check = Network::getUserInfo($phone);
        if($check == 1){
            $dtr['mss'] = 'Thuê bao này hiện đã đăng ký gói cước E.';
            echo json_encode($dtr);exit();
        }
        $packageInfo = Network::getCancelInfo($phone);
        $dtr['first'] = $packageInfo == 0;
    }
    $auth = (array)$authCl->findOne(array("phone"=>$phone));
    if(!$auth){
        $newAuthkey = array(
            'phone' => $phone,
            'count' => 0,
            'key' => null,
            'time' => time()
        );
        $authCl->insert($newAuthkey);
    }
    elseif(time() - $auth['time'] >= 60*60){
        $authCl->update(array('phone' => $phone), array('$set'=>array('key'=>null, 'count'=>0)));
    }
    $auth = $authCl->findOne(array('phone' => $phone));
    if($auth['count'] > 5){
        $dtr['mss'] = 'Bạn đã lấy mã xác thực quá 5 lần cho phép. Vui lòng đợi sau 60 phút để lấy lại mã xác thực.';
        echo json_encode($dtr);exit();
    }
    $authCl->update(array('phone' => $phone), array('$set'=> array('count'=> $auth['count']+1)));
    $expired = 2*60;
    $checkAuthKeyExpired = !isset($auth['key']) || ((time() - $auth['time']) > $expired);
    if ($checkAuthKeyExpired) {
        $authCl->update(array('phone' => $phone), array('$set'=>array('key'=>rand(100000, 999999), 'time'=>time())));
        $auth = $authCl->findOne(array('phone' => $phone));
    }

    $key = $auth['key'];
    $info = 'Mã xác thực dịch vụ English360 của bạn là: '.$key;
    $resultSMS = Network::sentMT($phone,'OTP', $info);
    if($resultSMS != 0){
        $dtr['mss'] = 'Không thể gửi tin nhắn đến số điện thoại của bạn. Vui lòng thử lại sau.';
        echo json_encode($dtr);
        exit();
    }
    $dtr['status'] = 200;
    $dtr['mss'] = 'Mã xác thực đã được gửi về số điện thoại của Quý khách. Vui lòng nhập mã xác thực và nhấn nút Đồng ý.';
    echo json_encode($dtr);
    exit();
}

function check_auth_key(){
    global $dbmg;
    $usercl = $dbmg->user;
    $authCl = $dbmg->auth_key;
    $historycl = $dbmg->history_log;
    $dtr['status'] = 500;
    $is3g = Network::is3g();
    $token = $_POST['token'];

    $phone = isset($_POST['phone']) ? $_POST['phone'] : $_SESSION['uinfo']['phone'];
    if(empty($phone) || !Network::mobifoneNumber($phone)){
        $dtr['mss'] = 'Có lỗi xảy ra, vui lòng thử lại sau.';
        echo json_encode($dtr);
        exit();
    }
    if(!isset($_POST['token']) || empty($_POST['token'])){
        $dtr['mss'] = 'Vui lòng nhập mã xác thực.';
        echo json_encode($dtr);
        exit();
    }
//    $token = $_POST['token'];
    $auth = (array)$authCl->findOne(array("phone"=>$phone));
    $expired = 2*60;
    $checkAuthKeyExpired = !isset($auth['key']) || ((time() - $auth['time']) > $expired);
    if ($checkAuthKeyExpired) {
        $dtr['mss'] = 'Mã xác thực đã hết hạn. Vui lòng click Lấy lại mã xác thực.';
        echo json_encode($dtr);
        exit();
    }
    if($auth['key'] != $token){
        $dtr['mss'] = 'Mã xác thực không đúng.';
        echo json_encode($dtr);
        exit();
    }

    //reset
    $authCl->update(array('phone'=>$phone), array('$set'=>array('count'=>0)));
    //login
    if(isset($_POST['login'])){
        $o = $usercl->findOne(array('phone'=>$phone));
        if(!$o){
            $password = Common::generateRandomPassword();
            $newUser = array(
                '_id' => strval(time()),
                'phone' => $phone,
                'password' => Common::encryptpassword($password),
                'un_password' => $password,
                'datecreate' => time(),
                'status'=>Constant::STATUS_ENABLE,
                'thong_bao' => array(
                    'noti' => "1",
                    'sms' => "1",
                    'email' => "1",
                ),
                'cmnd'=>'',
                'cmnd_noicap'=>'',
                'cmnd_ngaycap'=>'',
                'email'=>'',
                'birthday'=>'',
                'priavatar' => '',
                'fullname' => ''
            );
            $usercl->insert($newUser);
            $o = $newUser;
        }
        unset ($o['password'], $o['datecreate'], $o['status'], $o['un_password']);
        $_SESSION['uinfo'] = $o;
    }

    if(Network::getUserInfo($phone) == 1){
        $dtr['status'] = 200;
        echo json_encode($dtr);exit();
    }

    //Check đk lần đầu
    $packageInfo = Network::getCancelInfo($phone);
    //Đăng ký gói cước

    $result = Network::registedpack($phone);
    if($result != 0){
        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
                'chanel' => HistoryLog::CHANEL_WAP,
                'ip' => Network::ip(),
                'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
                'url' => Constant::BASE_URL.'/regispack.php',
                'status' => Constant::STATUS_DISABLE,
                'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
                'price'=> 0
        );
        if(!isset($_SESSION['notsave_log']))
            $historycl->insert($newHistoryLog);

        $dtr['mss'] = 'Đăng ký gói cước thất bại, vui lòng thử lại sau.';
        echo json_encode($dtr);
        exit();
    }
    $dtr['status'] = 200;
    $dtr['mss'] = 'Đăng ký gói cước E thành công.';
    $dtr['return_url'] = isset($_SESSION['return_url']) ? $_SESSION['return_url'] : '/';


    $newHistoryLog = array(
        '_id' => strval(time().rand(10,99)),
        'datecreate' => time(),
        'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
        'chanel' => HistoryLog::CHANEL_WAP,
        'ip' => Network::ip(),
        'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
        'url' => Constant::BASE_URL.'/regispack.php',
        'status' => Constant::STATUS_ENABLE,
        'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
        'price'=>$packageInfo == 0 ? 0 : Network::getPackageItem()['E']['price']
    );
    if(!isset($_SESSION['notsave_log']))
        $historycl->insert($newHistoryLog);
    echo json_encode($dtr);exit;
}

function regispack(){
    global $dbmg;
    $usercl = $dbmg->user;
    $authCl = $dbmg->auth_key;
    $key = $_POST['key'];
    $auth = (array)$authCl->findOne(array("phone"=>$_SESSION['uinfo']['phone']));
    $dtr['key'] = $key;
    $dtr['auth'] = $auth['key'];

    if($key==$auth['key']){
        $re = Network::getUserInfo($_SESSION['uinfo']['phone']);
        if($re==1){
            $dtr['status'] = 400;
            $dtr['mss'] = 'Bạn hiện đang sử dụng gói cước này.';
        }else {
            $result = Network::registedpack($_SESSION['uinfo']['phone'], $chanel = "WAP", $code = "E");
            if ($result == 0) {
                $dtr['status'] = 200;
                $dtr['mss'] = 'DK thanh cong';
            } else {
                $dtr['status'] = 250;
                $dtr['mss'] = 'DK that bai';
            }
        }
    }else{
        $dtr['status'] = 300;
        $dtr['mss'] = 'Mã xác thực không đúng';
    }

    echo json_encode($dtr);exit;
}
function register(){
    global $dbmg;
    $usercl = $dbmg->user;
    $historycl = $dbmg->history_log;
//    $authcl = $dbmg->auth_key;
    if(!isset($_POST['phone'])){
        $dtr['mss'] = 'Vui lòng nhập số điện thoại.';
        $dtr['status'] = 202;
        echo json_encode($dtr);exit;
    }
    if(!Network::mobifoneNumber($_POST['phone'])){
        $dtr['status'] = 250;
        $dtr['mss'] = 'Vui lòng nhập số điện thoại MobiFone';
        echo json_encode($dtr);exit;
    }
    $phone = $_POST['phone'];
    $checkUser = $usercl->findOne(array('phone' => $phone));
    if($checkUser){
        $sendPassCount = isset($checkUser['send_pass']['count']) ? $checkUser['send_pass']['count'] : 0;
        $sendPassTime = isset($checkUser['send_pass']['time']) ? $checkUser['send_pass']['time'] : time();
        if(time() - $sendPassTime > 60*60){
            $sendPassCount = 0;
        }
        if($sendPassCount >= 5){
            $dtr['mss'] = 'Quý khách đã lấy mật khẩu 5 lần. Vui lòng chờ sau 60 phút để lấy lại mật khẩu.';
            echo json_encode($dtr);exit;
        }
        $info = 'Mật khẩu để sử dụng dịch vụ English360 của Quý khách là: '.$checkUser['un_password'];
        Network::sentMT($phone, 'MK', $info);
        $usercl->update(array('phone' => $phone), array('$set'=>array('send_pass'=>array('count'=>$sendPassCount + 1, 'time'=>time()))));
        $dtr['status'] = 201;
        $dtr['mss'] = 'Tài khoản đã tồn tại. Mật khẩu đã được gửi về số điện thoại của quý khách. Vui lòng đăng nhập để sử dụng dịch vụ.';
        echo json_encode($dtr);exit;
    }
    $timeNow = time();

    $unpassword = Common::generateRandomPassword();
    $password = encryptpassword($unpassword);

    $newAccount = array(
        '_id' => strval($timeNow),
        'phone' => $phone,
        'un_password'=>$unpassword,
        'password' => $password,
        'datecreate' => $timeNow,
        'status'=>Constant::STATUS_ENABLE,
        'email'=>'',
        'priavatar'=>'',
        'cmd'=>'',
        'cmnd_noicap'=>'',
        'cmnd_ngaycap'=>'',
        'birthday'=>'',
        'thong_bao' => array(
            'noti' => "1",
            'sms' => "1",
            'email' => "1",
        )
    );
    $info = 'Mật khẩu để sử dụng dịch vụ English360 của Quý khách là: '.$unpassword;
    $usercl->insert($newAccount);
    $result = Network::sentMT($phone, 'MK', $info);
    $dtr['status'] = 200;
    $dtr['mss'] = 'Đăng ký thành công. Mật khẩu đã được gửi về số điện thoại của bạn.';
    $_SESSION['flash_mss'] = 'Mật khẩu đã được gửi về số điện thoại của bạn. Mời bạn đăng nhập.';
    $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_DANG_KY,
            'chanel' => HistoryLog::CHANEL_WAP,
            'ip' => Network::ip(),
            'uid' => '',
            'url' => Constant::BASE_URL.'/register.php',
            'status' => Constant::STATUS_ENABLE,
            'phone' => $phone,
            'price' => 0
    );
    if(!isset($_SESSION['notsave_log']))
        $historycl->insert($newHistoryLog);

    echo json_encode($dtr);exit;
}
function deletenotify(){
    global $dbmg;
    $uinfo = $_SESSION['uinfo'];
    if(!isset($uinfo)) $dtr = array("status"=>505,"mss"=>"Bạn cần đăng nhập để thực hiện tính năng này");
    else {
        $notifycl = $dbmg->notify;
        $ntid = $_POST['id'];
        $notifycl->remove(array("uid"=>$uinfo['_id'],"_id"=>$ntid));
        $dtr = array("status"=>200,"mss"=>"Xóa thành công");
    }
    echo json_encode($dtr);
}
function deletefaq(){
    global $dbmg;
    $uinfo = $_SESSION['uinfo'];
    if(!isset($uinfo)) $dtr = array("status"=>505,"mss"=>"Bạn cần đăng nhập để thực hiện tính năng này");
    else {
        $notifycl = $dbmg->faq;
        $ntid = $_POST['id'];
        $dtr['id'] = $ntid;
        $notifycl->remove(array("_id"=>$ntid));
        $dtr = array("status"=>200,"mss"=>"Xóa thành công");
    }
    echo json_encode($dtr);
}
function saveexam(){
    global $dbmg;
    $uinfo = $_SESSION['uinfo'];

    if(!isset($uinfo)) {
        $dtr = array("status"=>505,"mss"=>"Bạn cần đăng nhập để thực hiện tính năng này");
        echo json_encode($dtr);exit;
    }

    $checkPackage= Network::getUserInfo($uinfo['phone']);
    if($checkPackage != 1){
        $dtr = array("status"=>400,"mss"=>"Bạn cần đăng ký gói cước để thực hiện tính năng này");
        $_SESSION['return_url'] = isset($_POST['return_url']) ? $_POST['return_url'] : '/';
        echo json_encode($dtr);exit;
    }
    $saveexamcl = $dbmg->saveexam;
    $exid = $_POST['id'];
    $type = $_POST['type'];$dtr['type'] = $type;
    $ex = array('type'=>$type, 'id'=>$exid);
    $save = $saveexamcl->findOne(array('uid'=>$uinfo['_id']));
    if($save){
        $lession = isset($save['ex']) ? $save['ex'] : array();
        $time = isset($save['time']) ? $save['time'] : array();
        if(!in_array($ex, $lession)){
            array_push($lession, $ex);
            array_push($time, time());
        }

        $saveexamcl->update(array("uid"=>$uinfo['_id']),array('$set'=>array("ex"=>$lession, "time"=>$time)),array("upsert"=>true));
    }else{
        $saveexamcl->insert(array(
            'uid' => $_SESSION['uinfo']['_id'],
            'ex' => array($ex),
            'time' => array(time())
        ));
    }

    $dtr = array("status"=>200,"mss"=>"Lưu thành công");
    echo json_encode($dtr);
}
function addlike(){
    global $dbmg;
    $uinfo = $_SESSION['uinfo'];
    if(!isset($uinfo)) $dtr = array("status"=>505,"mss"=>"Bạn cần đăng nhập để thực hiện tính năng này");
    else {
        $commentLikecl = $dbmg->comment;
        $exid = $_POST['id'];
        $commentLikecl->update(array("uid"=>$uinfo['_id']),array('$addToSet'=>array("like"=>$exid)),array("upsert"=>true));
        $dtr = array("status"=>200,"mss"=>"Lưu thành công");
    }
    echo json_encode($dtr);
}
function deleteexam(){
    global $dbmg;
    $uinfo = $_SESSION['uinfo'];
    if(!isset($uinfo)) $dtr = array("status"=>505,"mss"=>"Bạn cần đăng nhập để thực hiện tính năng này");
    else {
        $saveexamcl = $dbmg->saveexam;
        $exid = $_POST['id'];
        $type = $_POST['type'];
        $ex = array('type'=>$type, 'id'=>$exid);
        $save = $saveexamcl->findOne(array('uid'=>$uinfo['_id']));
        $lession = isset($save['ex']) ? $save['ex'] : array();
        $time = isset($save['time']) ? $save['time'] : array();
        if(($key = array_search($ex, $lession)) !== false) {
            unset($lession[$key]);
            unset($time[$key]);
        }
        $saveexamcl->update(array("uid"=>$uinfo['_id']),array('$set'=>array("ex"=>array_values($lession), "time"=>array_values($time))),array("upsert"=>false));
        $dtr = array("status"=>200,"mss"=>"Xóa thành công");
    }
    echo json_encode($dtr);
}
function savecomment(){
    // Post id bài viết, type: gtcb,luyennghe , content: nội dung comment
    global $dbmg;
    $uinfo = $_SESSION['uinfo'];
    if(!isset($uinfo)){
        $dtr = array("status"=>505,"mss"=>"Bạn cần đăng nhập để thực hiện tính năng này");
        echo json_encode($dtr);exit;
    }
    $checkPackage= Network::getUserInfo($uinfo['phone']);
    if($checkPackage != 1){
        $dtr = array("status"=>400,"mss"=>"Bạn cần đăng ký gói cước để thực hiện tính năng này");
        $_SESSION['return_url'] = isset($_POST['return_url']) ? $_POST['return_url'] : '/';
        echo json_encode($dtr);exit;
    }
    else {
        $commentcl = $dbmg->comment;
        $objid = $_POST['id'];
        $type = $_POST['type'];
        $content = wordFilter($_POST['content']);
        $record = array(
            "_id"=>strtotime("now"),
            "uid"=>$uinfo['_id'],
            "objid"=>$objid,
            "type"=>$type,
            "content"=>$content,
            "parentid"=>empty($_POST['parentid']) ? "0" : $_POST['parentid'],
            "datecreate"=>strtotime("now"),
            "status"=>"1"
        );
        $commentcl->insert($record); // Inssert vào DB trước
        $record['userinfo'] = array("displayname"=>$_SESSION['uinfo']['displayname']);
        $record['userinfo'] = array("avatar"=>$_SESSION['uinfo']['avatar']);
        $record['datecreate'] = date("d-m-Y", $record['datecreate']);
        $dtr = array("status"=>200,"mss"=>"Gửi bình luận thành công","data"=>$record);
    }
    echo json_encode($dtr);
}
function getcomment(){
    global $dbmg;
    $commentcl = $dbmg->comment;
    $usercl = $dbmg->user;
    $objid = $_POST['id'];
    $type = $_POST['type'];
    $limit = 20;
    $p = $_POST['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
    //$cond = array("type"=>$type,"objid"=>$objid,"status"=>"1");
    $cond = array("type"=>$type,"objid"=>$objid, 'parentid'=> '0');
    $listcomment = iterator_to_array($commentcl->find($cond)->sort(array("_id"=>-1))->skip($cp)->limit($limit),false);
    foreach($listcomment as $key=>$val){
        $listcomment[$key]['datecreate'] = date("d-m-Y", $listcomment[$key]['datecreate']);
        $listcomment[$key]['userinfo'] = (array)$usercl->findOne(array("_id"=>$val['uid']),array("_id","name","displayname","phone"));
    }

    $dtr = array("status"=>200,"data"=>$listcomment);
    echo json_encode($dtr);
}
function hoidap(){
    global $dbmg;
    $uinfo = $_SESSION['uinfo'];
    if(!isset($uinfo)) $dtr = array("status"=>505,"mss"=>"Bạn cần đăng nhập để thực hiện tính năng này");
    else {
        $commentcl = $dbmg->faq;
        $objid = $_POST['id'];
        $type = $_POST['type'];
        $content = wordFilter($_POST['content']);
        $record = array(
            "_id"=>strval(time()),
            "uid"=>$uinfo['_id'],

            "content"=>$content,
            "parentid"=>empty($_POST['parentid']) ? "0" : $_POST['parentid'],
            "datecreate"=>strtotime("now"),
            "status"=>"1"
        );
        $commentcl->insert($record); // Inssert vào DB trước
        $record['userinfo'] = array("displayname"=>$_SESSION['uinfo']['phone']);
        $record['datecreate'] = date("d-m-Y", $record['datecreate']);
        $dtr = array("status"=>200,"mss"=>"Gửi cảm nhận thành công","data"=>$record);
    }
    echo json_encode($dtr);exit;
}
function sendconfirmkey() {
    global $dbmg;
    $usercl = $dbmg->user;
    $dtr['status'] = 404;
    if (!isset($_POST['phone']) || empty($_POST['phone'])){
        $dtr['mss'] = 'Vui lòng nhập số điện thoại.';
        echo json_encode($dtr);exit;
    }
    $phone = $_POST['phone'];
    if(!Network::mobifoneNumber($phone)){
        $dtr['mss'] = 'Vui lòng nhập số điện thoại MobiFone.';
        echo json_encode($dtr);exit;
    }
    $criteria = array('phone' => $phone);
    $userinfo = $usercl->findOne($criteria);
    if(!$userinfo){
        $dtr['mss'] = 'Số điện thoại này hiện chưa đăng ký tài khoản.';
        echo json_encode($dtr);exit;
    }

    $sendPassCount = isset($userinfo['send_pass']['count']) ? $userinfo['send_pass']['count'] : 0;
    $sendPassTime = isset($userinfo['send_pass']['time']) ? $userinfo['send_pass']['time'] : time();
    if(time() - $sendPassTime > 60*60){
        $sendPassCount = 0;
    }
    if($sendPassCount >= 5){
        $dtr['mss'] = 'Quý khách đã lấy mật khẩu 5 lần. Vui lòng chờ sau 60 phút để lấy lại mật khẩu.';
        echo json_encode($dtr);exit;
    }
    $password = $userinfo['un_password'];
    $info = 'Mật khẩu để sử dụng dịch vụ English360 của Quý khách là:'.$password;
    $result = Network::sentMT($phone, 'MK', $info);
    if($result != 0){
        $dtr['mss'] = 'Không thể gửi tin nhắn đến số điện thoại của bạn, vui lòng thử lại sau.';
        echo json_encode($dtr);exit;
    }
    $usercl->update(array('phone' => $phone), array('$set'=>array('send_pass'=>array('count'=>$sendPassCount + 1, 'time'=>time()))));
    $dtr['status'] = 200;
    $dtr['mss'] = 'Mật khẩu đã được gửi về số điện thoại của bạn. Vui lòng kiểm tra lại.';
    $_SESSION['flash_mss'] = 'Mật khẩu đã được gửi về số điện thoại của bạn. Mời bạn đăng nhập.';
    echo json_encode($dtr);exit;
}
function confirmnewpass() {
    global $dbmg;
    $usercl = $dbmg->user;
    $dtr['status'] = 500;
    if(!isset($_SESSION['uinfo'])){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
    }
    $lackInfor = empty($_POST['current_pass']) || empty($_POST['newpassword']) || empty($_POST['renewpassword']);
    if (!$lackInfor) {
        if ($_POST['newpassword'] === $_POST['renewpassword']) {
            $current_pass = encryptpassword($_POST['current_pass']);
            $userinfo = $usercl->findOne(array('_id'=>$_SESSION['uinfo']['_id']));
            if ($current_pass == $userinfo['password']) {
                $newPass = strval($_POST['newpassword']);
                $usercl->update(array('_id' => $_SESSION['uinfo']['_id']), array('$set' => array('un_password'=>$newPass,'password' => encryptpassword($newPass))));
                $dtr['status'] = 200;
                $dtr['mss'] = 'Mật khẩu của bạn đã được đổi thành công.';
            } else {
                $dtr['mss'] = 'Mật khẩu cũ không đúng. Vui lòng thử lại.';
            }
        } else {
            $dtr['mss'] = 'Mật khẩu nhập vào không khớp. Vui lòng xem lại';
        }
    } else {
        $dtr['mss'] = 'Bạn cần điền đầy đủ thông tin.';
    }
    echo json_encode($dtr);exit;
}

function likefaq(){
    global $dbmg;
    $commentCl = $dbmg->faq;
    $notifyCl = $dbmg->notify;
    $dtr['success'] = false;
    if(!isset($_SESSION['uinfo'])){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    if(empty($id)){
        $dtr['mss'] = 'Có lỗi xảy ra, vui lòng thử lại.';
        echo json_encode($dtr);exit();
    }
    $cond = array('_id' =>array('$in' => array(strval($id), intval($id))));
    $comment = $commentCl->findOne($cond);
    if(!$comment){
        $dtr['mss'] = 'Comment không tồn tại.';
        echo json_encode($dtr);exit();
    }

    $like = isset($comment['like']) ? $comment['like'] : array();
    if(!in_array($_SESSION['uinfo']['_id'], $like))
        array_push($like, $_SESSION['uinfo']['_id']);

    $commentCl->update($cond, array('$set' => array('like' => $like)));
    if($comment['usercreate'] != $_SESSION['uinfo']['_id']){
        $isAns = $comment['parentid'] == ''? 'hỏi' : 'trả lời';
        $newNotify = array(
            '_id' => strval(time()),
            'uid' => $comment['usercreate'],
            'usercreate' => $_SESSION['uinfo']['_id'],
            'datecreate' => time(),
            'mss' => getDisplayName($_SESSION['uinfo']).' đã thích câu '.$isAns.' của bạn.',
            'status' => Constant::STATUS_ENABLE,
            'type' => Constant::TYPE_NOTIFY,
            'to' => array(
                'type' => Constant::TYPE_HOIDAP,
                'id' => $id
            )
        );
        $notifyCl->insert($newNotify);
    }
    $dtr['success'] = true;
    $dtr['mss'] = 'Đã thích câu trả lời.';
    $dtr['countlike'] = count($like);
    echo json_encode($dtr);exit();
}

function unlikefaq(){
    global $dbmg;
    $commentCl = $dbmg->faq;
    $notifyCl = $dbmg->notify;
    $dtr['success'] = false;
    if(!isset($_SESSION['uinfo'])){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    if(empty($id)){
        $dtr['mss'] = 'Có lỗi xảy ra, vui lòng thử lại.';
        echo json_encode($dtr);exit();
    }
    $cond = array('_id' =>array('$in' => array(strval($id), intval($id))));
    $comment = $commentCl->findOne($cond);
    if(!$comment){
        $dtr['mss'] = 'Comment không tồn tại.';
        echo json_encode($dtr);exit();
    }

    $like = isset($comment['like']) ? $comment['like'] : array();
    if(($key = array_search($_SESSION['uinfo']['_id'], $like)) !== false) {
        unset($like[$key]);
    }

    $commentCl->update($cond, array('$set' => array('like' => $like)));
    $dtr['success'] = true;
    $dtr['mss'] = 'Đã bỏ thích bình luận.';
    $dtr['countlike'] = count($like);
    echo json_encode($dtr);exit();
}

function likecomment(){
    global $dbmg;
    $commentCl = $dbmg->comment;
    $notifyCl = $dbmg->notify;
    $dtr['success'] = false;
    if(!isset($_SESSION['uinfo'])){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    if(empty($id)){
        $dtr['mss'] = 'Có lỗi xảy ra, vui lòng thử lại.';
        echo json_encode($dtr);exit();
    }
    $cond = array('_id' =>array('$in' => array(strval($id), intval($id))));
    $comment = $commentCl->findOne($cond);
    if(!$comment){
        $dtr['mss'] = 'Comment không tồn tại.';
        echo json_encode($dtr);exit();
    }

    $like = isset($comment['like']) ? $comment['like'] : array();
    if(!in_array($_SESSION['uinfo']['_id'], $like))
        array_push($like, $_SESSION['uinfo']['_id']);

    $commentCl->update($cond, array('$set' => array('like' => $like)));
    if($comment['uid'] != $_SESSION['uinfo']['_id']){
        $newNotify = array(
            '_id' => strval(time()),
            'uid' => $comment['uid'],
            'usercreate' => $_SESSION['uinfo']['_id'],
            'datecreate' => time(),
            'mss' => getDisplayName($_SESSION['uinfo']).' đã thích Bình luận của bạn.',
            'status' => Constant::STATUS_ENABLE,
            'type' => Constant::TYPE_NOTIFY,
            'to' => array(
                'type' => $comment['type'],
                'id' => $comment['objid']
            )
        );
        $notifyCl->insert($newNotify);
    }
    $dtr['notify'] = $newNotify;
    $dtr['success'] = true;
    $dtr['mss'] = 'Đã thích bình luận.';
    $dtr['countlike'] = count($like);
    echo json_encode($dtr);exit();
}

function unlikecomment(){
    global $dbmg;
    $commentCl = $dbmg->comment;
    $notifyCl = $dbmg->notify;
    $dtr['success'] = false;
    if(!isset($_SESSION['uinfo'])){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    if(empty($id)){
        $dtr['mss'] = 'Có lỗi xảy ra, vui lòng thử lại.';
        echo json_encode($dtr);exit();
    }
    $cond = array('_id' =>array('$in' => array(strval($id), intval($id))));
    $comment = $commentCl->findOne($cond);
    if(!$comment){
        $dtr['mss'] = 'Comment không tồn tại.';
        echo json_encode($dtr);exit();
    }

    $like = isset($comment['like']) ? $comment['like'] : array();
    if(($key = array_search($_SESSION['uinfo']['_id'], $like)) !== false) {
        unset($like[$key]);
    }

    $commentCl->update($cond, array('$set' => array('like' => $like)));
    $dtr['success'] = true;
    $dtr['mss'] = 'Đã bỏ thích bình luận.';
    $dtr['countlike'] = count($like);
    echo json_encode($dtr);exit();
}

function report(){
    global $dbmg;
    $reportCl = $dbmg->report;
    $dtr['success'] = false;
    if(!isset($_SESSION['uinfo'])){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    if(empty($id)){
        $dtr['mss'] = 'Có lỗi xảy ra, vui lòng thử lại.';
        echo json_encode($dtr);exit();
    }
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $newReport = array(
        '_id' => strval(time()),
        'content' => 'Vi phạm',
        'uid' => $_SESSION['uinfo']['_id'],
        'itemid' => $id,
        'type' => $type,
        'datecreate' => time(),
    );

    $reportCl->insert($newReport);
    $dtr['mss'] = 'Cảm ơn bạn đã gửi báo cáo. Chúng tôi sẽ xem xét trong thời gian sớm nhất.';
    $dtr['success'] = true;
    echo json_encode($dtr);exit();
}
function count_notify(){
    global $dbmg;
    $notifycl = $dbmg->notify;
    $count = $notifycl->count(array("uid" => $_SESSION['uinfo']['_id'], "status" => "1"), array("_id", "to", "datecreate", "mss", "type"));
//        $count = count($listNotify);
    $dtr['status'] = 200;
    $dtr['count'] = $count;
    echo json_encode($dtr);exit();
}

function tratu(){
    global $dbmg;
    $dict = $_POST['dict'];
    $word = strtolower($_POST['word']);
    $id = $_POST['id'];


    switch($dict){
        case 'av':
            $dictCl = $dbmg->anh_viet;
            break;
        default:
            $dictCl = $dbmg->viet_anh;
            break;
    }
    if(!empty($id)){
        $cond = array('id'=>intval($id));
    }else{
        $cond = array('word'=>$word);
    }
    $result = $dictCl->findOne($cond);
    $dtr['status'] = 500;
    $dtr['cond'] =$cond;
    if($result){
        $dtr['status'] = 200;
        $dtr['content'] = $result['content'];
    }

    echo json_encode($dtr);exit();
}

function loadTratu(){
    global $dbmg;
    $dict = $_POST['dict'];
    $word = strtolower($_POST['word']);
    $limit = 10;

    switch($dict){
        case 'av':
            $dictCl = $dbmg->anh_viet;
            break;
        default:
            $dictCl = $dbmg->viet_anh;
            break;
    }

    $regexWord = new MongoRegex('/^'.$word.'/ui');
    $cond = array('word'=>$regexWord);

    $result = iterator_to_array($dictCl->find($cond, array('word', 'id'))->limit($limit), false);
    $dtr['status'] = 200;
    $dtr['data'] = $result;
    echo json_encode($dtr);exit();
}

function deleteSong(){
    global $dbmg;
    $uploadcl = $dbmg->upload;
    $dtr['success'] = false;

    $id = $_POST['id'];
    $item = $uploadcl->findOne(array('_id'=>strval($id), 'type'=>Constant::TYPE_SONG));
    if(!$item){
        $dtr['mss'] = 'Bản thu không tồn tại';
        echo json_encode($dtr);exit();
    }
    if(!isset($_SESSION['uinfo']) || $item['uid'] != $_SESSION['uinfo']['_id']){
        $dtr['mss'] = 'Bạn không được phép xóa bản thu này.';
        echo json_encode($dtr);exit();
    }

    $uploadcl->remove(array('_id'=>strval($id)));
    $dtr['success'] = true;
    $dtr['mss'] = 'Xóa bản thu thành công.';
    echo json_encode($dtr);exit();
}

function addPopupNumber(){
    $number = isset($_SESSION['number_popreg']) ? $_SESSION['number_popreg'] : 0;
    $number++;
    $_SESSION['number_popreg'] = $number;
    $dtr['success'] = true;
    echo json_encode($dtr);exit();
}

function cancelPackageAds(){
    unset($_SESSION['package_ads']);
}

function toPortal(){
    unset($_SESSION['package_ads']);
    $link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&WAP');
    $link_vms = Network::genLinkConfirmVms('E', $link_callback);
    header("Location: ".$link_vms);exit;
}

function regLession(){
    global $dbmg;
    $userCl = $dbmg->user;
    $dtr['success'] = false;
    $select = $_POST['select'];
    $email = isset($_POST['email']) ? $_POST['email'] : (isset($_SESSION['email_reg_lession']) ? $_SESSION['email_reg_lession'] : '');
    if(empty($email) && !isset($_SESSION['uinfo'])){
        $dtr['mss'] = 'Có lỗi xảy ra, vui lòng thử lại sau.';
        echo json_encode($dtr);exit();
    }
    $update = array('$set'=>array('reg_lession'=>$select));
    if(isset($_SESSION['uinfo'])){
        $userCl->update(array('_id'=>$_SESSION['uinfo']['_id']),$update);
    }else{
        $userCl->update(array('email'=>$email),$update);
    }
    unset($_SESSION['reg_lession_popup']);
    $dtr['success'] = true;
    $dtr['mss'] = 'Lưu thay đổi thành công';
    echo json_encode($dtr);exit();
}

function regEmailLession(){
    global $dbmg;
    $userCl = $dbmg->user;
    $dtr['success'] = false;
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $dtr['mss'] = 'Email không hợp lệ.';
        echo json_encode($dtr);exit();
    }
    if(isset($_SESSION['uinfo'])){
        $checkUser = $userCl->findOne(array(
            'email' => $email,
            '_id' => array('$ne'=>$_SESSION['uinfo']['_id'])
        ));
        if($checkUser){
            //Gửi email yêu cầu xác nhận
            $bodyEmail = '<p>Xin chào,</p>'.
                '<p>Để xác thực email cho tài khoản English360, bạn vui lòng click vào đường link bên dưới:</p>'.
                '<p><a href="'.Common::getVerifyEmailUrl($_SESSION['uinfo']['_id'],$email).'">'.Common::getVerifyEmailUrl($_SESSION['uinfo']['_id'],$email).'</a></p>'.
                '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>';
            $mail = new \helpers\Mail($email, 'Xác thực email English360.vn', $bodyEmail);
            $mail->send();
            $dtr['mss'] = 'Chúng tôi đã gửi 1 email xác nhận về địa chỉ '.$email.', vui lòng xác nhận địa chỉ email này là của bạn.';
            $dtr['verify'] = true;
            echo json_encode($dtr);exit();
        }else{
            $userCl->update(array('_id'=>$_SESSION['uinfo']['_id']), array('$set'=> array('email'=>$email)));
            $dtr['success'] = true;
            echo json_encode($dtr);exit();
        }
    }else{
        $checkUser = $userCl->findOne(array(
            'email' => $email
        ));
        if($checkUser){
            // Nếu không phải chính user vừa tạo thì yêu cầu xác thực
            $ssEmail = isset($_SESSION['email_reg_lession']) ? $_SESSION['email_reg_lession'] : '';
            if($email != $ssEmail){
                $_SESSION['required_verify_email'] = $email;
                $dtr['mss'] = 'Email đã được sử dụng, vui lòng xác thực';
                $dtr['login'] = true;
                echo json_encode($dtr);exit();
            }
            $dtr['success'] = true;
            echo json_encode($dtr);exit();
        }else{
        //Check nếu là user vừa tạo thì update email
            if(isset($_SESSION['email_reg_lession'])){
                if($_SESSION['email_reg_lession'] != $email){
                    $userCl->update(array(
                        'email'=> $_SESSION['email_reg_lession'],
                        'phone' => array('$exists' => false)),array('$set'=>array('email'=>$email)));
                    $_SESSION['email_reg_lession'] = $email;
                }
                $dtr['success'] = true;
                echo json_encode($dtr);exit();
            }
            //Email mới thì tạo TK mới
            $userCl->insert(array(
                '_id' => strval(time()),
                'email' => $email
            ));
            $_SESSION['email_reg_lession'] = $email;
            $dtr['success'] = true;
            echo json_encode($dtr);exit();
        }
    }
}



function regPackageAds(){
    global $dbmg;
    $historyCl = $dbmg->history_log;

    $_SESSION['notsave_log'] = 1;
    $phone = $_SESSION['uinfo']['phone'];
//    $timeDiff = isset($_POST['time']) ? $_POST['time'] : 0;
//    if($timeDiff<7){
//        $_SESSION['package_ads_continue'] = 1;
//        return;
//    }
    //Trường hợp chuyển trang khi chưa kịp đăng ký gói thì sau khi chuyển trang sẽ đk gói luôn
    if(isset($_SESSION['package_ads_continue'])){
        $randomIp = isset($_SESSION['random_ip']) ? $_SESSION['random_ip'] : Common::getRandomIp();
        _createLogAfter($randomIp);

        ##ĐĂng ký gói cước
        $smsRegister = Network::registedpack($phone);

        $historyCl->insert(array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
            'chanel' => HistoryLog::CHANEL_WEB,
            'ip' => $randomIp,
            'uid' => $_SESSION['uinfo']['_id'],
            'url' => Constant::BASE_URL.'/user/package',
            'status' => $smsRegister==0 ? Constant::STATUS_ENABLE : Constant::STATUS_DISABLE,
            'phone' => $phone,
            'price'=> $smsRegister==0 ? Network::getPackageItem()['E']['price'] : 0
        ));
        unset($_SESSION['package_ads_continue']);
        return json_encode(array('success'=>true));
    }
    $randomIp = Common::getRandomIp();
    $_SESSION['random_ip'] = $randomIp;
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
    unset($_SESSION['package_ads']);
    $_SESSION['package_ads_continue'] = 1;
    sleep(rand(7,10));
    ##tạo log ảo
    _createLogAfter($randomIp);

    ##ĐĂng ký gói cước
    $smsRegister = Network::registedpack($phone);

    $historyCl->insert(array(
        '_id' => strval(time().rand(10,99)),
        'datecreate' => time(),
        'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
        'chanel' => HistoryLog::CHANEL_WEB,
        'ip' => $randomIp,
        'uid' => $_SESSION['uinfo']['_id'],
        'url' => Constant::BASE_URL.'/user/package',
        'status' => $smsRegister==0 ? Constant::STATUS_ENABLE : Constant::STATUS_DISABLE,
        'phone' => $phone,
        'price'=> $smsRegister==0 ? Network::getPackageItem()['E']['price'] : 0
    ));
    unset($_SESSION['package_ads_continue']);
    return json_encode(array('success'=>true));
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
    global $dbmg;
    $historyCl = $dbmg->history_log;
    $phone = $_SESSION['uinfo']['phone'];
    $time = time();
    $catidArr = array(
        '1427344743' => 'kinh-nghiem',
        '1427183137' => 'thanh-ngu',
        '1427183162' => 'video',
        '1427344702' => 'radio',
        '1428995217' => 'tieng-anh-hang-ngay',
        '1450844989' => 'nguoi-noi-tieng',
    );
    $logArr = array(
        '1427344743' => HistoryLog::LOG_XEM_BAI_HOC_KINH_NGHIEM,
        '1427183137' => HistoryLog::LOG_XEM_BAI_HOC_THANH_NGU,
        '1427183162' => HistoryLog::LOG_XEM_BAI_HOC_VIDEO,
        '1427344702' => HistoryLog::LOG_XEM_BAI_HOC_RADIO,
        '1428995217' => HistoryLog::LOG_XEM_BAI_HOC_HANG_NGAY,
        '1450844989' => HistoryLog::LOG_XEM_BAI_HOC_NGUOI_NOI_TIENG,
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
            'action' => $logArr[$catid],
            'chanel' => HistoryLog::CHANEL_WEB,
            'ip' => $randomIp,
            'uid' => '',
            'url' => Constant::BASE_URL.'/'.$catidArr[$catid].'/'.Common::utf8_to_url($post['name']).'-'.$post['_id'].'.html',
            'status' => Constant::STATUS_ENABLE,
            'phone' => '',
            'price'=> 0
        ));
    }
}

function removeEvent(){
    unset($_SESSION['event_id']);
    return 1;
}

function regEvent(){
    global $dbmg;
    unset($_SESSION['event_id']);
    $dtr['success'] = false;
    $eucl = $dbmg->event_user;
    $usercl = $dbmg->user;
    $eventcl = $dbmg->event;
    $eventId = $_POST['id'];
    $event = $eventcl->findOne(array('_id'=>strval($eventId)));
    if(!$event){
        $dtr['mss'] = 'Có lỗi xảy ra, vui lòng thử lại sau.';
        echo json_encode($dtr);exit;
    }
    if(isset($_SESSION['uinfo']['phone'])){
//        $user = $usercl->findOne(array('_id'=>$_SESSION['uinfo']['_id']));
//        $eventUser = $eucl->findOne(array('eid'=>$eventId, 'uid'=>$_SESSION['uinfo']['_id']));
//        if(!$eventUser){
//            $eucl->insert(array(
//                '_id' => strval(time()),
//                'datecreate' => time(),
//                'uid' => $_SESSION['uinfo']['_id'],
//                'eid' => $eventId
//            ));
//            $start = time();
//            $end = $start + $event['free_day']*24*60*60;
//            $mtcontent = str_replace(array('{phone}','{pass}','{start}','{end}'), array($user['phone'], $user['un_password'],date('d/m/Y',$start), date('d/m/Y',$end)), $event['contentMT']);
//            $rs = Network::sentMT($_SESSION['uinfo']['phone'], 'DKKM', $mtcontent);
//            if($rs != 0){
//                $dtr['mss'] = 'Không thể gửi tin nhắn đến số điện thoại của bạn. Vui lòng thử lại sau.';
//                echo json_encode($dtr);exit;
//            }
//        }

        $dtr['success'] = true;
        $dtr['mss'] = '<p>Cảm ơn bạn đã tham gia Chương trình Khuyến mại của English360.</p>
        <p>Tài khoản miễn phí đã được gửi về số điện thoại của bạn</p>';
        echo json_encode($dtr);exit;
    }else{
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $dtr['mss'] = 'Địa chỉ Email không hợp lệ.';
            echo json_encode($dtr);exit;
        }
        $user = $usercl->findOne(array('email'=>$email));
        if(!$user){
            $unpassword = Common::generateRandomPassword();
            $password = Common::encryptpassword($unpassword);
            $now = time();
            $username = 'user'.$now;
            $uid = strval($now);
            $usercl->insert(array(
                '_id' => $uid,
                'phone' => '',
                'username' => $username,
                'un_password'=>$unpassword,
                'password' => $password,
                'datecreate' => $now,
                'status'=>Constant::STATUS_ENABLE,
                'email'=>$email,
                'priavatar'=>'',
                'cmd'=>'',
                'cmnd_noicap'=>'',
                'cmnd_ngaycap'=>'',
                'birthday'=>'',
                'thong_bao' => array(
                    'noti' => "1",
                    'email' => "1",
                )
            ));
        }else{
            if(!isset($user['un_password'])){
                $unpassword = Common::generateRandomPassword();
                $password = Common::encryptpassword($unpassword);
                $usercl->update(array('_id'=>$user['_id']), array('$set'=>array(
                    'un_password'=>$unpassword,
                    'password' => $password,
                )));
            }else{
                $unpassword = $user['un_password'];
            }
            if(!isset($user['username'])){
                $username = 'user'.time();
                $usercl->update(array('_id'=>$user['_id']), array('$set'=>array(
                    'username'=>$username,
                )));
            }else{
                $username = $user['username'];
            }
            $uid = $user['_id'];
        }
        $eventUser = $eucl->findOne(array('eid'=>$eventId, 'uid'=>$uid));
        if(!$eventUser){
            $eucl->insert(array(
                '_id' => strval(time()),
                'datecreate' => time(),
                'uid' => $uid,
                'eid' => $eventId
            ));
            $start = time();
            $end = $start + $event['free_day']*24*60*60;
            $emailcontent = str_replace(array('{username}','{pass}','{start}','{end}'), array($username, $unpassword,date('d/m/Y',$start), date('d/m/Y',$end)), $event['contentEmail']);
            $subject = $event['name'];
            $mail = new \helpers\Mail($email,$subject,$emailcontent);
            if(!$mail->send()){
                $dtr['mss'] = 'Không thể gửi email cho bạn. Vui lòng thử lại sau.';
                echo json_encode($dtr);exit;
            }
        }else{
//            $start = $eventUser['datecreate'];
        }
//        echo $unpassword;

        $dtr['success'] = true;
        $dtr['mss'] = '<p>Cảm ơn bạn đã tham gia Chương trình Khuyến mại của English360.</p>
        <p>Tài khoản miễn phí đã được gửi về địa chỉ email của bạn. Vui lòng kiểm tra email và làm theo hướng dẫn.</p>';
        echo json_encode($dtr);exit;
    }
}

function test(){
    global $dbmg;
    $id = '';
    $catidArr = array(
        '1427344743' => 'kinh-nghiem',
        '1427183137' => 'thanh-ngu',
        '1427183162' => 'video',
        '1427344702' => 'radio',
        '1428995217' => 'tieng-anh-hang-ngay',
        '1450844989' => 'nguoi-noi-tieng',
    );

    $catid = '1427183137';
    $input = array_keys($catidArr);
//            $rand_keys = array_rand($input, 1);
    $catid = $input[array_rand($input)];
    var_dump($catid);
    $thuviencl = $dbmg->thuvien;
//    $currentPost = $thuviencl->findOne(array('_id'=>$id));
    $cond = array('category'=> strval($catid), '_id' => array('$ne'=>$id));
    $count = $thuviencl->count($cond);
    print_r($count);
    if($count > 0){
        $rand = rand(0, $count-1);
        $item = iterator_to_array($thuviencl->find($cond)->skip($rand)->limit(1), false);
    }else{
        $item = iterator_to_array($thuviencl->find(array('_id'=>array('$ne'=>$id)))->sort(array('datecreate'=>-1))->limit(1), false);
    }
    print_r($item[0]);exit;

    return $item[0];
}

function _createLogAfter($randomIp){
    global $dbmg;
    $historyCl = $dbmg->history_log;
    $phone = $_SESSION['uinfo']['phone'];
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
    $logArr = array(
        '1427344743' => HistoryLog::LOG_XEM_BAI_HOC_KINH_NGHIEM,
        '1427183137' => HistoryLog::LOG_XEM_BAI_HOC_THANH_NGU,
        '1427183162' => HistoryLog::LOG_XEM_BAI_HOC_VIDEO,
        '1427344702' => HistoryLog::LOG_XEM_BAI_HOC_RADIO,
        '1428995217' => HistoryLog::LOG_XEM_BAI_HOC_HANG_NGAY,
        '1450844989' => HistoryLog::LOG_XEM_BAI_HOC_NGUOI_NOI_TIENG,
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
            'action' => $logArr[$catid],
            'chanel' => HistoryLog::CHANEL_WEB,
            'ip' => $randomIp,
            'uid' => $_SESSION['uinfo']['_id'],
            'url' => Constant::BASE_URL.'/'.$catidArr[$catid].'/'.Common::utf8_to_url($post['name']).'-'.$post['_id'].'.html',
            'status' => Constant::STATUS_ENABLE,
            'phone' => $phone,
            'price'=> 0
        ));
    }
}

function _getRandomPost($id, $catid){
    global $dbmg;
    $thuviencl = $dbmg->thuvien;
//    $currentPost = $thuviencl->findOne(array('_id'=>$id));
    $cond = array('category'=>strval($catid), '_id'=>array('$ne'=>$id));
    $count = $thuviencl->count($cond);
    if($count > 0){
        $rand = rand(0, $count-1);
        $item = iterator_to_array($thuviencl->find($cond)->skip($rand)->limit(1), false);
    }else{
        $item = iterator_to_array($thuviencl->find(array('_id'=>array('$ne'=>$id)))->sort(array('datecreate'=>-1))->limit(1), false);
    }

    return $item[0];
}

function importexcel(){
//    ini_set('display_errors', 'On');
//    error_reporting(E_ALL);
    if(isset($_FILES["myfile"])){
        $ret = array();
        $error = $_FILES["myfile"]["error"];
        include "plugin/Classes/PHPExcel.php";
        if(!is_array($_FILES["myfile"]["name"])) //single file
        {
            $ext = pathinfo($_FILES["myfile"]["name"], PATHINFO_EXTENSION);
            if(in_array($ext,array('xls','xlsx'))){
                $file_location = getcwd();
                /*$excel_file = $_FILES["myfile"]["tmp_name"];*/
                $excel_file = $file_location."/uploads/" . $_FILES["myfile"]["name"];

                try {
                    move_uploaded_file($_FILES["myfile"]["tmp_name"],$excel_file);
                    $objPHPExcel = PHPExcel_IOFactory::load($excel_file);
                } catch (Exception $e) {
                    die($e->getMessage());
                }
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

                $type = $_POST['type'] ? trim($_POST['type']) : '';

                switch($type){
                    case 'video': saveMedia($sheetData,$type);break;
                    case 'audio': saveMedia($sheetData,$type);break;
                    case 'singer': saveSinger($sheetData);break;
                    case 'album': saveAlbum($sheetData);break;
                    case 'musicchannel': saveMChannel($sheetData);break;
                    case 'ranking': saveRanking($sheetData);break;
                }
                unlink($excel_file);
                $ret= array('status'=>200,'mss'=>'Import thành công');
            }else{
                $ret= array('status'=>500,'mss'=>'File không đúng định dạng');
            }
        }
    }else{
        $ret= array('status'=>500,'mss'=>'File không tồn tại');
    }
    echo json_encode($ret);exit;
}

function addLession(){
//        ini_set('display_errors', 'On');
//    error_reporting(E_ALL);
    global $dbmg;
    $usercl = $dbmg->user;
    $email = $_POST['email'];
    $type = $_POST['type'];
    $dtr['success'] = false;
    if(isset($_SESSION['uinfo'])){
        $checkUser =  $usercl->findOne(array('email'=>$email));
        if($checkUser){
            $reg_lession = isset($checkUser['reg_lession']) ? $checkUser['reg_lession'] : array();
            if(!in_array($type, $reg_lession))
                array_push($reg_lession, $type);

            $usercl->update(array('email' => $email), array('$set'=>array('reg_lession'=>$reg_lession)));
            $dtr['success'] = true;
            echo json_encode($dtr);exit;
        }
        $usercl->insert(array(
            '_id' => strval(time()),
            'email' => $email,
            'reg_lession' => array($type)
        ));
        $dtr['success'] = true;
        echo json_encode($dtr);exit;
    }
    $checkUser = $usercl->findOne(array('email'=>$email, '_id'=>array('$ne'=>$_SESSION['uinfo']['_id'])));
    if($checkUser){
        $dtr['mss'] = 'Email này đã có người sử dụng';
        echo json_encode($dtr);exit;
    }
    $reg_lession = isset($_SESSION['uinfo']['reg_lession']) ? $_SESSION['uinfo']['reg_lession'] : array();
    if(!in_array($type, $reg_lession))
        array_push($reg_lession, $type);

    $usercl->update(array('_id' => $_SESSION['uinfo']['_id']), array('$set'=>array('reg_lession'=>$reg_lession, 'email'=>$email)));
    $dtr['success'] = true;
    echo json_encode($dtr);exit;
}

$mgconn->close();