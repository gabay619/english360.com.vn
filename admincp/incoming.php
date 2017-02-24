<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
foreach (glob(__DIR__.'/../helpers/*.php') as $filename)
{
    include $filename;
}
include "../config/config.php";
include "../config/connect.php";
include("inc/permission.php");
header('Content-Type: application/json; charset=UTF-8');
$act = $_GET['act'];if(!isset($act)) $act = $_POST['act'];
switch($act){
    case "sport_getteam":sport_getteam();break;
    case 'getcategory': getcategory(); break;
    case 'saveCatShow': saveCatShow(); break;
    case 'getmediabypagetype': getmediabypagetype(); break;
    case 'savetoslideshow': savetoslideshow(); break;
    case 'getroundchampion': getroundchampion(); break;
    case 'changestatus' : changestatus();break;
    case 'changefree' : changefree();break;
    case 'changestatuslna' : changestatuslna();break;
    case 'changestatusnguphap' : changestatusnguphap();break;
    case 'changestatusgtcb' : changestatusgtcb();break;
    case 'changestatusaudio' : changestatusaudio();break;
    case 'getlession': getlession();break;
    case 'savetohotlession' : savetohotlession();break;
    case 'savetofreelession' : savetofreelession();break;
    case 'createFreeUser': createFreeUser(); break;
    case 'deleteAllFree': deleteAllFree(); break;
    case 'getPassword': getPassword(); break;
    case 'createTag': createTag(); break;
    case 'suggestTag': suggestTag(); break;
    case 'importHssv': importHssv(); break;
    case 'importEvent': importEvent(); break;
    case 'regEvent': regEvent(); break;
    case 'uploadHssv': uploadHssv(); break;
    case 'importFreeUser': importFreeUser(); break;
    case 'uploadFreeUser': uploadFreeUser(); break;
    case 'mtHssv': mtHssv(); break;
    case 'exportAds': exportAds(); break;
    case 'exportHssv': exportHssv(); break;
	case 'exportHistory': exportHistory(); break;
	case 'exportEventUser': exportEventUser(); break;
	case 'exportLog3g': exportLog3g(); break;
	case 'sendMail': sendMail(); break;
    case 'uploadExcel': uploadExcel(); break;
    case 'sendSMS': sendSMS(); break;
    case 'recheckCard': recheckCard(); break;
    case 'getLogBank': getLogBank(); break;
}
function sport_getteam(){
    global $dbmg;
    $sportteamscl = $dbmg->sport_team;
    $q = $_GET['q'];
    $cond = array("name"=>new MongoRegex("/$q/ui"));
    $ar = iterator_to_array($sportteamscl->find($cond),false);
    echo json_encode($ar);
}

function getcategory(){
    global $dbmg;
    $categorycl = $dbmg->category;
    $limit = 30;
    $keyword = $_GET['q'];
    $keywordRegex = new MongoRegex('/'.convert_vi_to_en($keyword).'/ui');
    $query['$or'] = array(array("namenoneutf"=>$keywordRegex),array("_id"=>$keywordRegex)) ;
    if(!empty($_GET['t']) && $_GET['t'] !='home')
        $query['type'] = strval($_GET['t']);

    $data = $categorycl->find($query)->skip(0)->limit($limit);
    while ($data->hasNext())
    {
        $item = $data->getNext();
        $hdata[] = $item;
    }

    $dtr['status'] = 1;
    $dtr['mss'] = 'Successfully';
    $dtr['data'] = $hdata;
    echo json_encode($dtr);
}

function saveCatShow(){
    global $dbmg;
    $showcl = $dbmg->showcl;
    if(empty($_POST['type'])){
        $dtr['status'] = 400;
        $dtr['mss'] = 'Lỗi không xác định';
    }else{
        $data['_id'] = time();
        $data['category'] = explode(',',rtrim($_POST['category'],','));
        $data['category'] = array_values(array_unique($data['category']));
        $data['type'] = $_POST['type'];
        $showcl->remove(array('type'=>strval($data['type'])));
        $showcl->insert($data);
        $dtr['status'] = 200;
        $dtr['mss'] = 'Success';
    }
    echo json_encode($dtr);
}

function getmediabypagetype() {
    global $dbmg;
    $categorycl = $dbmg->category;
    $pageType = isset($_GET['pageType']) ? $_GET['pageType'] : 'music';
    if ($pageType == 'music') {
        $collection = $dbmg->media;
        $filterField = "namenoneutf";
    }
    else if ($pageType == 'movie') {
        $collection = $dbmg->movie;
        $filterField = "namenonutf";
    }
    else if ($pageType == 'home') {
        $collection = $dbmg->news;
        $filterField = "namenonutf";
    }
    else if ($pageType == 'sport_news') {
        $collection = $dbmg->sport_news;
        $filterField = "namenonutf";
    }
    else if ($pageType == 'game_list') {
        $collection = $dbmg->game_list;
        $filterField = "namenonutf";
    }
    $limit = 30;
    $keyword = $_GET['keyword'];
    $keywordRegex = new MongoRegex('/'.convert_vi_to_en($keyword).'/ui');
    $query['$or'] = array(array("$filterField"=>$keywordRegex),array("_id"=>$keywordRegex)) ;
    if(!empty($_GET['t']) && $_GET['t'] !='home')
        $query['type'] = strval($_GET['t']);

    $data = $collection->find($query, array("_id", "name"))->skip(0)->limit($limit);
    while ($data->hasNext())
    {
        $item = $data->getNext();
        $hdata[] = $item;
    }

    $dtr['status'] = 1;
    $dtr['mss'] = 'Successfully';
    $dtr['data'] = $hdata;
    $dtr['query'] = $query;
    echo json_encode($dtr);
}

function savetoslideshow() {
    global $dbmg;
    $showCl = $dbmg->showcl;
    $list = explode(',',rtrim($_POST['lession'],','));
    $list = array_values(array_unique($list));
    $lessions = array();
    foreach($list as $item){
        $itemArr = explode('-', $item);
        $type = $itemArr[0];
        $id = $itemArr[1];
        $lessions[] = array(
            'type' => $type,
            'id' => $id
        );
    }

    $pagetype = 'slideshow';
    $data['_id'] = time();
    $data['lession'] = $lessions;
    $data['type'] = $pagetype;
    $showCl->remove(array('type'=>strval($pagetype)));
    $showCl->insert($data);
    $dtr['status'] = 200;
    $dtr['mss'] = 'Success';
    echo json_encode($dtr);
}
function getroundchampion(){
    global $dbmg;
    $sportroundcl = $dbmg->sport_roundchampion;
    $id = $_GET['champion'];
    $o = iterator_to_array($sportroundcl->find(array("champion"=>"$id"),array("_id","name")),false);
    $dtr['status'] = 200;
    $dtr['mss'] = 'Success';
    $dtr['data'] = $o;
    echo json_encode($dtr);
}
function changestatus() {
    global $dbmg;
    $videoCl = $dbmg->thuvien;
    if ($_SESSION['uinfo']['_id']) {
        $atid = $_POST['atid'];
            $videoObj = $videoCl->findOne(array("_id"=> $atid), array("usercreate"));
        if ($videoObj['usercreate']) {
            if ($videoObj['usercreate'] !== $_SESSION['uinfo']['_id'] && !isacceptpermission("thuvien_status")) {
                $dtr['status'] = 403;
                $dtr['mss'] = "Bạn không có quyền thực hiện chức năng này";
            } else{
                $updateInfor = array("status"=>strval($_POST['status']));
                if ($_POST['isUpdateTime'] === "true") {
                    $updateInfor['datecreate'] = time();
                }
                $videoCl->update(array("_id"=> $atid), array('$set'=> $updateInfor));
                $dtr['status'] = 200;
                $dtr['mss'] = "Thay đổi thành công";
                if (strval($_POST['status']) === "0") $dtr['statusString'] = "Ẩn";
                else $dtr['statusString'] = "Hiện";
                $dtr['isUpdateTime'] = $_POST['isUpdateTime'];
            }
        } else {
            $dtr['status'] = 404;
            $dtr['mss'] = "Không có bài đăng này";
        }
    } else {
        $dtr['status'] = 401;
        $dtr['mss'] = "Bạn cần đăng nhập để thực hiện chức năng này";
    }
    echo json_encode($dtr);
}
function changefree() {
    global $dbmg;
    if ($_SESSION['uinfo']['_id']) {
        $atid = $_POST['atid'];
        $type = $_POST['type'];
        $colection = Common::getClFromType($type);
        $colection = $dbmg->$colection;

        $obj = $colection->findOne(array("_id"=> $atid));
        if ($obj) {
            $updateInfor = array("free"=>strval($_POST['status']));
            $colection->update(array("_id"=> $atid), array('$set'=> $updateInfor));
                $dtr['status'] = 200;
                $dtr['mss'] = "Thay đổi thành công";
                if (strval($_POST['status']) == "1") $dtr['statusString'] = "Có";
                else $dtr['statusString'] = "Không";
        } else {
            $dtr['status'] = 404;
            $dtr['mss'] = "Không có bài đăng này";
        }
    } else {
        $dtr['status'] = 401;
        $dtr['mss'] = "Bạn cần đăng nhập để thực hiện chức năng này";
    }
    echo json_encode($dtr);exit;
}
function changestatusnguphap() {
    global $dbmg;
    $videoCl = $dbmg->nguphap;
    if ($_SESSION['uinfo']['_id']) {
        $atid = $_POST['atid'];
        $videoObj = $videoCl->findOne(array("_id"=> $atid), array("usercreate"));
        if ($videoObj['usercreate']) {
            if ($videoObj['usercreate'] !== $_SESSION['uinfo']['_id'] && !isacceptpermission("nguphap_update")) {
                $dtr['status'] = 403;
                $dtr['mss'] = "Bạn không có quyền thực hiện chức năng này";
            } else{
                $updateInfor = array("status"=>strval($_POST['status']));
                if ($_POST['isUpdateTime'] === "true") {
                    $updateInfor['datecreate'] = time();
                }
                $videoCl->update(array("_id"=> $atid), array('$set'=> $updateInfor));
                $dtr['status'] = 200;
                $dtr['mss'] = "Thay đổi thành công";
                if (strval($_POST['status']) === "0") $dtr['statusString'] = "Ẩn";
                else $dtr['statusString'] = "Hiện";
                $dtr['isUpdateTime'] = $_POST['isUpdateTime'];
            }
        } else {
            $dtr['status'] = 404;
            $dtr['mss'] = "Không có bài đăng này";
        }
    } else {
        $dtr['status'] = 401;
        $dtr['mss'] = "Bạn cần đăng nhập để thực hiện chức năng này";
    }
    echo json_encode($dtr);
}
function changestatuslna() {
    global $dbmg;
    $videoCl = $dbmg->luyennguam;
    if ($_SESSION['uinfo']['_id']) {
        $atid = $_POST['atid'];
        $videoObj = $videoCl->findOne(array("_id"=> $atid), array("usercreate"));
        if ($videoObj['usercreate']) {
            if ($videoObj['usercreate'] !== $_SESSION['uinfo']['_id'] && !isacceptpermission("luyennguam_update")) {
                $dtr['status'] = 403;
                $dtr['mss'] = "Bạn không có quyền thực hiện chức năng này";
            } else{
                $updateInfor = array("status"=>strval($_POST['status']));
                if ($_POST['isUpdateTime'] === "true") {
                    $updateInfor['datecreate'] = time();
                }
                $videoCl->update(array("_id"=> $atid), array('$set'=> $updateInfor));
                $dtr['status'] = 200;
                $dtr['mss'] = "Thay đổi thành công";
                if (strval($_POST['status']) === "0") $dtr['statusString'] = "Ẩn";
                else $dtr['statusString'] = "Hiện";
                $dtr['isUpdateTime'] = $_POST['isUpdateTime'];
            }
        } else {
            $dtr['status'] = 404;
            $dtr['mss'] = "Không có bài đăng này";
        }
    } else {
        $dtr['status'] = 401;
        $dtr['mss'] = "Bạn cần đăng nhập để thực hiện chức năng này";
    }
    echo json_encode($dtr);
}
function changestatusgtcb() {
    global $dbmg;
    $videoCl = $dbmg->gtcb;
    if ($_SESSION['uinfo']['_id']) {
        $atid = $_POST['atid'];
        $videoObj = $videoCl->findOne(array("_id"=> $atid), array("usercreate"));
        if ($videoObj['usercreate']) {
            if ($videoObj['usercreate'] !== $_SESSION['uinfo']['_id'] && !isacceptpermission("gtcb_update")) {
                $dtr['status'] = 403;
                $dtr['mss'] = "Bạn không có quyền thực hiện chức năng này";
            } else{
                $updateInfor = array("status"=>strval($_POST['status']));
                if ($_POST['isUpdateTime'] === "true") {
                    $updateInfor['datecreate'] = time();
                }
                $videoCl->update(array("_id"=> $atid), array('$set'=> $updateInfor));
                $dtr['status'] = 200;
                $dtr['mss'] = "Thay đổi thành công";
                if (strval($_POST['status']) === "0") $dtr['statusString'] = "Ẩn";
                else $dtr['statusString'] = "Hiện";
                $dtr['isUpdateTime'] = $_POST['isUpdateTime'];
            }
        } else {
            $dtr['status'] = 404;
            $dtr['mss'] = "Không có bài đăng này";
        }
    } else {
        $dtr['status'] = 401;
        $dtr['mss'] = "Bạn cần đăng nhập để thực hiện chức năng này";
    }
    echo json_encode($dtr);
}

function changestatusaudio(){
    global $dbmg;
    $videoCl = $dbmg->hmcaudio;
    if ($_SESSION['uinfo']['_id']) {
        $atid = $_POST['atid'];
        $videoObj = $videoCl->findOne(array("_id"=> $atid), array("usercreate"));
        if ($videoObj['usercreate']) {
            if ($videoObj['usercreate'] !== $_SESSION['uinfo']['_id'] && !isacceptpermission("gtcb_update")) {
                $dtr['status'] = 403;
                $dtr['mss'] = "Bạn không có quyền thực hiện chức năng này";
            } else{
                $updateInfor = array("status"=>strval($_POST['status']));
                if ($_POST['isUpdateTime'] === "true") {
                    $updateInfor['datecreate'] = time();
                }
                $videoCl->update(array("_id"=> $atid), array('$set'=> $updateInfor));
                $dtr['status'] = 200;
                $dtr['mss'] = "Thay đổi thành công";
                if (strval($_POST['status']) === "0") $dtr['statusString'] = "Ẩn";
                else $dtr['statusString'] = "Hiện";
                $dtr['isUpdateTime'] = $_POST['isUpdateTime'];
            }
        } else {
            $dtr['status'] = 404;
            $dtr['mss'] = "Không có bài đăng này";
        }
    } else {
        $dtr['status'] = 401;
        $dtr['mss'] = "Bạn cần đăng nhập để thực hiện chức năng này";
    }
    echo json_encode($dtr);
}

function getlession(){
    global $dbmg;
    $hdata = [];
    $limit = 30;
    $keyword = $_GET['keyword'];
    $keywordRegex = array('$regex'=> convert_vi_to_en($keyword));
//            new MongoRegex('/'.convert_vi_to_en($keyword).'/ui');
    $query['$or'] = array(array("name"=>$keywordRegex),array("_id"=>$keywordRegex));
    $collection = $dbmg->thuvien;
    $data = $collection->find($query, array("_id", "name", "category"))->skip(0)->limit($limit);
    while ($data->hasNext())
    {
        $item = $data->getNext();
        $categorycl = $dbmg->category;
        $cate = $categorycl->findOne(array("_id"=>array('$in'=>$item['category'])));
        $hdata[] = array(
                '_id' => $item['_id'],
                'name' => $item['name'],
                'type' => $cate['type'],
                'catename' => $cate['name']
        );
    }
    $collection = $dbmg->gtcb;
    $data = $collection->find($query, array("_id", "name", "category"))->skip(0)->limit($limit);
    while ($data->hasNext())
    {
        $item = $data->getNext();
        $hdata[] = array(
                '_id' => $item['_id'],
                'name' => $item['name'],
                'type' => Constant::TYPE_GTCB,
                'catename' => 'Giao tiếp cơ bản'
        );
    }
    $collection = $dbmg->hmcaudio;
    $data = $collection->find($query, array("_id", "name", "category"))->skip(0)->limit($limit);
    while ($data->hasNext())
    {
        $item = $data->getNext();
        $hdata[] = array(
                '_id' => $item['_id'],
                'name' => $item['name'],
                'type' => Constant::TYPE_SONG,
                'catename' => 'Bài hát tiếng Anh'
        );
    }
    $collection = $dbmg->lna;
    $data = $collection->find($query, array("_id", "name", "category"))->skip(0)->limit($limit);
    while ($data->hasNext())
    {
        $item = $data->getNext();
        $hdata[] = array(
            '_id' => $item['_id'],
            'name' => $item['name'],
            'type' => Constant::TYPE_LUYENNGUAM,
            'catename' => 'Luyện ngữ âm'
        );
    }
    $dtr['status'] = 1;
    $dtr['mss'] = 'Successfully';
    $dtr['data'] = $hdata;
    $dtr['query'] = $query;
    echo json_encode($dtr);
}

function savetofreelession(){
    global $dbmg;
    $showCl = $dbmg->showcl;
    $list = explode(',',rtrim($_POST['lession'],','));
    $list = array_values(array_unique($list));
    $lessions = array();
    foreach($list as $item){
        $itemArr = explode('-', $item);
        $type = $itemArr[0];
        $id = $itemArr[1];
        $lessions[] = array(
            'type' => $type,
            'id' => $id
        );
    }

    $pagetype = 'free_lession';
    $data['_id'] = time();
    $data['lession'] = $lessions;
    $data['type'] = $pagetype;
    $showCl->remove(array('type'=>strval($pagetype)));
    $showCl->insert($data);
    $dtr['status'] = 200;
    $dtr['mss'] = 'Success';
    echo json_encode($dtr);exit;
}

function savetohotlession(){
    global $dbmg;
    $showCl = $dbmg->showcl;
    $list = explode(',',rtrim($_POST['lession'],','));
    $list = array_values(array_unique($list));
    $lessions = array();
    foreach($list as $item){
        $itemArr = explode('-', $item);
        $type = $itemArr[0];
        $id = $itemArr[1];
        $lessions[] = array(
            'type' => $type,
            'id' => $id
        );
    }

    $pagetype = 'hot_lession';
    $data['_id'] = time();
    $data['lession'] = $lessions;
    $data['type'] = $pagetype;
    $showCl->remove(array('type'=>strval($pagetype)));
    $showCl->insert($data);
    $dtr['status'] = 200;
    $dtr['mss'] = 'Success';
    echo json_encode($dtr);exit;
}

function deleteAllFree(){
    global $dbmg;
    $freecl = $dbmg->free_user;
    $freecl->remove(array());
    echo json_decode(array());exit;
}

function createFreeUser(){
    global $dbmg;
    $freecl = $dbmg->free_user;
    $usercl = $dbmg->user;
    $dtr['success'] = false;
    if(!acceptpermiss("event_insert")){
        $dtr['mss'] = 'Bạn không có quyền thực hiện thao tác này.';
        echo json_encode($dtr);exit;
    }
    $phone = Network::reversephoneToZero($_POST['phone']);
//    echo $phone;
    if(!Network::mobifoneNumber($phone)){
        $dtr['mss'] = 'Yêu cầu nhập số điện thoại Mobifone';
        echo json_encode($dtr);exit;
    }
    try{
        $checkUser = $usercl->findOne(array('phone'=>$phone));
        if(!$checkUser){
            $unpassword = Common::generateRandomPassword();
            $password = encryptpassword($unpassword);
            $usercl->insert(array(
                '_id' => strval(time()),
                'phone' => $phone,
                'un_password'=>$unpassword,
                'password' => $password,
                'datecreate' => time(),
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
            ));
        }else{
            $unpassword = $checkUser['un_password'];
        }
        if(!$freecl->findOne(array('phone'=>$phone))){
            $mtcontent = str_replace(array('{pass}','{phone}'),array($unpassword, $phone),$_POST['mtcontent']);
            $rs = Network::sentMT($phone,'KM',$mtcontent);
            if($rs==0){
                $freecl->insert(array('_id'=>strval(time()),'phone'=>$phone, 'show'=>0));
            }
        }
//        $dtr['send'] = $phone.'-'.$mtcontent;
    }catch (Exception $e){
        $dtr['mss'] = $e->getMessage();
        echo json_encode($dtr);exit;
    }

    $dtr['success'] = $rs == 0;
//    $dtr['user'] = $phone.'/'.$unpassword;
    $dtr['mtrs'] = $rs;
//    $dtr['mt'] = $mtcontent;
//    $dtr['post'] = $_POST;
    echo json_encode($dtr);exit;
}

function getPassword(){
    global $dbmg;
    $usercl = $dbmg->user;
    if(!acceptpermiss("event_view")){
        $dtr['mss'] = 'Bạn không có quyền thực hiện thao tác này.';
        echo json_encode($dtr);exit;
    }
    $phone = $_POST['phone'];
    $id = $_POST['id'];
    $dtr['success'] = false;
    if(!empty($phone))
        $checkUser = $usercl->findOne(array('phone'=>$phone));
    else if(!empty($id))
        $checkUser = $usercl->findOne(array('_id'=>$id));
    if(!$checkUser){
        $dtr['mss'] = 'User không tồn tại.';
        echo json_encode($dtr);exit;
    }
    $dtr['password'] = $checkUser['un_password'];
    echo json_encode($dtr);exit;
}

function suggestTag(){
    global $dbmg;
    $tagcl = $dbmg->tag;
    $query = $_POST['query'];
    $slug = Common::utf8_to_url($query);
    $convert = new MongoRegex("/$slug/ui");
    $allTags = iterator_to_array($tagcl->find(array('slug' => $convert)), false);
    $result = array();
    foreach($allTags as $item){
        $result[] = $item['name'];
    }
    echo json_encode($result);exit;
}

function mtHssv(){
    global $dbmg;
//    echo json_encode(array('success'=>true));exit;
    $usercl = $dbmg->user;
    $uid = $_POST['uid'];
    $user = $usercl->findOne(array('_id'=>strval($uid)));
    $data['success'] = false;
    if(!$user){
        $data['mss'] = 'User khong ton tai';
        echo json_encode($data);exit;
    }
    //Khong co sdt => Gui email
    if(Network::mobifoneNumber($user['phone'])){
//        $user = $usercl->findOne(array('phone'=>$phone));
//        if(!$user){
//            echo json_encode($data);exit;
//        }
        $rs = Network::registedpack($user['phone'],'WEB');
        if($rs!=0){
            $data['mss'] = 'Service dang ky loi';
            echo json_encode($data);exit;
        }
        $data['success'] = true;
        $data['mss'] = 'Đã đăng ký CTKM cho sđt';
    }elseif(!empty($user['email'])){
        $username = empty($user['phone']) ? $user['username'] : $user['phone'];
        $password = $user['un_password'];
        include $_SERVER['DOCUMENT_ROOT'].'/mail/event.php';
        $subject = 'Chương trình English360 đồng hành cùng học sinh – sinh viên';
        $mail = new \helpers\Mail($user['email'],$subject,$body);
        if($mail->send()) $data['success'] = true;
        else $data['mss'] = 'Khong the gui email cho '.$user['email'];
        //TODO: Gửi email cho thuê bao ngoại mạng
    }else{
        $data['mss'] = 'Thue bao ngoai mang khong co email';
        //TODO: Xử lý thuê bao ngoại mạng ko có email
    }

    echo json_encode($data);exit;
}

function sendSMS(){
    $dtr['success'] = false;
    $phone = $_POST['phone'];
    $content = html_entity_decode(strip_tags($_POST['content']));
//    print_r($content);die;
    $rs = Network::sentMT($phone, 'NOTI', $content);
//    $rs = 1;
    if($rs != 0){
        echo json_encode($dtr);exit;
    }
    $dtr['success'] = true;
    echo json_encode($dtr);exit;
}

function uploadExcel(){
    if(isset($_FILES["Filedata"])){
        $ret = array();
        $error = $_FILES["Filedata"]["error"];
        include "../plugin/Classes/PHPExcel.php";
//        $objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/uploads/listphone.xlsx");
//        print_r($objPHPExcel);die;

        if(!is_array($_FILES["Filedata"]["name"])) //single file
        {
            $ext = pathinfo($_FILES["Filedata"]["name"], PATHINFO_EXTENSION);
            if(in_array($ext,array('xls','xlsx'))){
                $file_location = $_SERVER['DOCUMENT_ROOT'];
                /*$excel_file = $_FILES["myfile"]["tmp_name"];*/
                $filePart = "/uploads/" . $_FILES["Filedata"]["name"];
                $excel_file = $file_location.$filePart;

                try {
                    $rs = move_uploaded_file($_FILES["Filedata"]["tmp_name"],$excel_file);
//                    var_dump($rs);die;
//                    print_r(file_exists($excel_file));die;
                    $objPHPExcel = PHPExcel_IOFactory::load($excel_file);
                } catch (Exception $e) {
                    die($e->getMessage());
                }
//                print_r($excel_file);die;
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

//                print_r($sheetData);die;
//                unlink($excel_file);
                $ret= array('status'=>200,'mss'=>'Import thành công', 'data' => $sheetData);
            }else{
                $ret= array('status'=>500,'mss'=>'File không đúng định dạng');
            }
        }
    }else{
        $ret= array('status'=>500,'mss'=>'File không tồn tại');
    }
    echo json_encode($ret);exit;
}

function recheckCard(){
    global $dbmg;
    $txncl = $dbmg->txn_card;
    $logcl = $dbmg->log_txn_card;
    $id = $_POST['id'];
    $txn = $txncl->findOne(array('_id',$id));
    if(!$txn){
        $dtr['mss'] = 'Giao dịch không tồn tại';
        echo json_encode($dtr);exit;
    }

    $log = $logcl->findOne(array('txn_id',$id));
    if(!$log){
        $dtr['mss'] = 'Log giao dịch không tồn tại';
        echo json_encode($dtr);exit;
    }

    require_once __DIR__.'../sdk/1pay/OnePayClient.php';
    $mpc = new OnePayClient();
    $query = $mpc->recheck('', $txn['pin'], $txn['seri'], $logcl['provider_txn_id'], $txn['card_type']);
    if($query['code'] == Constant::TXN_CARD_SUCCESS){
        $set = array(
            'response_code'=>Constant::TXN_CARD_SUCCESS,
            'card_amount' => $query['card_amount']
        );
        $txncl->update(array('_id'=>$id), array('$set'=>$set));
        $dtr['mss'] = 'Giao dịch thành công.';
        echo json_encode($dtr);exit;
    }elseif ($query['code'] != Constant::TXN_CARD_PENDING){
        $set = array(
            'response_code'=>$query['code']
        );
        $txncl->update(array('_id'=>$id), array('$set'=>$set));
        $dtr['mss'] = $query['message'];
    }else{
        $dtr['mss'] = 'Giao dịch chờ xử lý';
        echo json_encode($dtr);exit;
    }
}

function getLogBank(){
    global $dbmg;
    $logcl = $dbmg->log_txn_bank;
    $id = $_POST['id'];
    $log = $logcl->findOne(array('order_id'=>$id));
//    $dtr['mss'] = json_encode($log);
    echo json_encode($log);exit;
}

function uploadHssv(){
    $data['status'] = 500;
    $targetFolder = "/uploads/";
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    $folder_name = '/';
    if($fileParts['extension'] != 'xlsx'){
        $data['mss'] = 'Chỉ upload file *.xlsx';
        echo json_encode($data);exit;
    }
    if($_POST['create_folder_type'] == 'true'){
        $folder_name = '/general/';
        if(in_array($fileParts['extension'],array('jpg','jpeg','gif','png'))){
            $folder_name = '/picture/';
        }
        if(in_array($fileParts['extension'],array('mp3','mp4','avi','mkv'))){
            $folder_name = '/video/';
        }
    }
    //$targetPath = getcwd() . $targetFolder . $folder_name;
    $targetPath = $_SERVER['DOCUMENT_ROOT'].str_replace("../","",$targetFolder);
    if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);
//    $file_name = preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['Filedata']['name']);
    $file_name =  'HSSV.xlsx';
    $targetFile = str_replace("//","/",$targetPath) . $file_name;
    try{
        $rs = move_uploaded_file($tempFile,$targetFile);
    }catch (Exception $e){
        $data['status'] = 500;
        $data['mss'] = $e->getMessage();
        echo json_encode($data);exit;
    }
    if($rs){
        $file_path = $targetFolder.$file_name;
        $file_path = str_replace("//","/",$file_path);
        $image = $file_path;
        $data['status'] = 200;
        $data['mss'] = "Upload thành công";
        $data['file'] = array("index"=>strval(time().rand(0,99999)),"filename"=>"$file_name","src"=>"$file_path","path"=>"$file_path","image"=>"$image");
    }else{
        $data['status'] = 500;
        $data['mss'] = "Không thể upload file: $targetFile";
    }
    echo json_encode($data);
}

function uploadFreeUser(){
    require_once 'plugin/phpexcel/Classes/PHPExcel/IOFactory.php';
    $data['status'] = 500;
    $targetFolder = "/uploads/";
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    $folder_name = '/';
    $objPHPExcel = PHPExcel_IOFactory::load($tempFile);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    $phone = array();
    foreach ($sheetData as $k=>$value){
        if(Network::mobifoneNumber($value['A']));
        $phone[] = $value['A'];
    }
    $data['status'] = 200;
    $data['phone'] = $phone;
    echo json_encode($data);exit;

    if($fileParts['extension'] != 'xlsx'){
        $data['mss'] = 'Chỉ upload file *.xlsx';
        echo json_encode($data);exit;
    }
    //$targetPath = getcwd() . $targetFolder . $folder_name;
    $targetPath = $_SERVER['DOCUMENT_ROOT'].str_replace("../","",$targetFolder);
    if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);
//    $file_name = preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['Filedata']['name']);
    $file_name =  'FreeUser.xlsx';
    $targetFile = str_replace("//","/",$targetPath) . $file_name;
    try{
        $rs = move_uploaded_file($tempFile,$targetFile);
    }catch (Exception $e){
        $data['status'] = 500;
        $data['mss'] = $e->getMessage();
        echo json_encode($data);exit;
    }
    if($rs){
        $objPHPExcel = PHPExcel_IOFactory::load($targetFile);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $phone = array();
        foreach ($sheetData as $k=>$value){
            if(Network::mobifoneNumber($value['A']));
                $phone[] = $value['A'];
        }
        $file_path = $targetFolder.$file_name;
        $file_path = str_replace("//","/",$file_path);
        $image = $file_path;
        $data['status'] = 200;
        $data['mss'] = "Upload thành công";
        $data['phone'] = $phone;
//        $data['file'] = array("index"=>strval(time().rand(0,99999)),"filename"=>"$file_name","src"=>"$file_path","path"=>"$file_path","image"=>"$image");
    }else{
        $data['status'] = 500;
        $data['mss'] = "Không thể upload file: $targetFile";
    }
    echo json_encode($data);
}

function importHssv(){
    global $dbmg;
    $usercl = $dbmg->user;
    require_once 'plugin/phpexcel/Classes/PHPExcel/IOFactory.php';
    if (!file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/HSSV.xlsx")) {
        exit(json_encode(array('success'=>false, 'mss'=>'File không tồn tại.')));
    }
    $objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/uploads/HSSV.xlsx");
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    foreach ($sheetData as $k=>$value){
        if($k > 1){
            $phone = $value['E'];
            $email = $value['F'];
            $birthday = $value['D'];
            if(empty($phone)){
                $checkMail = $usercl->findOne(array(
                    'email' => $email,
                    'phone' => '',
                    'event' => array('$ne'=>Event::HOC_SINH_SINH_VIEN)
                ));
                if($checkMail){
                    $update = array(
                        'birthday'=>$birthday,
                        'event'=>Event::HOC_SINH_SINH_VIEN,
                        'event_time' => time(),
                    );
                    $usercl->update(array('email'=>$email,'phone'=>''), array('$set'=>$update));
                }else{
                    $unpassword = Common::generateRandomPassword();
                    $password = encryptpassword($unpassword);
                    $usercl->insert(array(
                        '_id' => strval(time()).$k,
                        'phone' => '',
                        'username' => 'user'.Common::generateRandomPassword().$k,
                        'un_password'=>$unpassword,
                        'password' => $password,
                        'datecreate' => time(),
                        'status'=>Constant::STATUS_ENABLE,
                        'email'=>$email,
                        'priavatar'=>'',
                        'cmd'=>'',
                        'cmnd_noicap'=>'',
                        'cmnd_ngaycap'=>'',
                        'birthday'=>$birthday,
                        'event' => Event::HOC_SINH_SINH_VIEN,
                        'event_time' => time(),
                        'thong_bao' => array(
                            'noti' => "1",
                            'sms' => "1",
                            'email' => "1",
                        )
                    ));
                }
            }else{
                $checkPhone = $usercl->findOne(array(
                    'phone' => $phone
                ));
                $checkMail = $usercl->findOne(array(
                    'email' => $email,
                    'phone' => array('$ne'=>$phone)
                ));
                if($checkMail) $email = '';
                if(!$checkPhone){
                    $unpassword = Common::generateRandomPassword();
                    $password = encryptpassword($unpassword);
                    $usercl->insert(array(
                        '_id' => strval(time()).$k,
                        'phone' => $phone,
                        'un_password'=>$unpassword,
                        'password' => $password,
                        'datecreate' => time(),
                        'status'=>Constant::STATUS_ENABLE,
                        'email'=>$email,
                        'priavatar'=>'',
                        'cmd'=>'',
                        'cmnd_noicap'=>'',
                        'cmnd_ngaycap'=>'',
                        'birthday'=>$birthday,
                        'event' => Event::HOC_SINH_SINH_VIEN,
                        'event_time' => time(),
                        'thong_bao' => array(
                            'noti' => "1",
                            'sms' => "1",
                            'email' => "1",
                        )
                    ));
                }else{
                    $update = array(
                        'email'=>$email,
                        'birthday'=>$birthday,
                        'event'=>Event::HOC_SINH_SINH_VIEN,
                        'event_time' => time(),
                    );
                    $usercl->update(array('phone'=>$phone), array('$set'=>$update));
                }
            }

        }
    }
    exit(json_encode(array('success'=>true)));
}

function regEvent(){
    global $dbmg;
    $eucl = $dbmg->event_user;
    $usercl = $dbmg->user;
    $eventcl = $dbmg->event;
    $data['status'] = 500;
    $event_id = $_GET['eid'];
    $event = $eventcl->findOne(array('_id'=>$event_id));
    $phone = Network::reversephoneToZero($_POST['phone']);
    $email = strtolower($_POST['email']);
    $index = isset($_POST['index']) ? $_POST['index'] : '';
    if(!empty($phone) && Network::mobifoneNumber($phone)){
        $user = $usercl->findOne(array('phone' => $phone));
        if(!$user){
            $password = Common::generateRandomPassword();
            $uid = strval(time()).$index;
            $usercl->insert(array(
                '_id' => $uid,
                'phone' => $phone,
                'un_password' => $password,
                'password' => Common::encryptpassword($password),
                'datecreate' => time(),
                'status' => Constant::STATUS_ENABLE,
                'fullname'=>'',
                'email'=> '',
                'cmnd'=> '',
                'cmnd_ngaycap'=>'',
                'cmnd_noicap'=>'',
                'birthday'=>'',
                'priavatar'=>'',
                'thong_bao' => array(
                    'noti' => "1",
                    'sms' => "1",
                    'email' => "1",
                )
            ));
        }else{
            $uid = $user['_id'];
        }
        if(Network::getUserInfo($phone) != 1){
            $userEvent = $eucl->findOne(array('uid'=>$uid, 'eid'=>$event_id));
            if(!$userEvent){
                $user = $usercl->findOne(array('_id'=>$uid));
                $eucl->insert(array(
                    '_id' => strval(time()).$index,
                    'datecreate' => time(),
                    'uid' => $uid,
                    'eid' => $event_id
                ));
                $start = time();
                $end = $start + $event['free_day']*24*60*60;
                $mtcontent = str_replace(array('{phone}','{pass}','{start}','{end}'), array($phone, $user['un_password'],date('d/m/Y',$start), date('d/m/Y',$end)), $event['contentMT']);
                $rsmt = Network::sentMT($phone, 'DKKM', $mtcontent);
                $data['mtcontent'] = $mtcontent;
                $data['rsmt'] = $rsmt.'-'.$phone;
            }
        }else{
            $data['mss'] = 'Không thành công. User đã đăng ký gói cước hoặc đang trong khuyến mãi.';
            echo json_encode($data);exit;
        }

    }else if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        try{
            $user = $usercl->findOne(array('email'=>$email));
            if(!$user){
                $unpassword = Common::generateRandomPassword();
                $password = Common::encryptpassword($unpassword);
                $now = time();
                $username = $email;
                $uid = strval($now).$index;
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
                    $username = $email;
                    $usercl->update(array('_id'=>$user['_id']), array('$set'=>array(
                        'username'=>$username,
                    )));
                }else{
                    $username = $user['username'];
                }
                $uid = $user['_id'];
            }
            $eventUser = $eucl->findOne(array('eid'=>$event_id, 'uid'=>$uid));
            if(!$eventUser){
                $eucl->insert(array(
                    '_id' => strval(time()).$index,
                    'datecreate' => time(),
                    'uid' => $uid,
                    'eid' => $event_id
                ));
                $start = time();
                $end = $start + $event['free_day']*24*60*60;
                $emailcontent = str_replace(array('{username}','{pass}','{start}','{end}'), array($username, $unpassword,date('d/m/Y',$start), date('d/m/Y',$end)), $event['contentEmail']);
                $subject = $event['name'];
                $mail = new \helpers\Mail($email,$subject,$emailcontent);
                $rsemail = $mail->send();
                $data['emailcontent'] = $emailcontent;
                $data['rsemail'] = $rsemail;
            }
        }catch (Exception $e){
            $data['mss'] = $e->getMessage();
            echo json_encode($data);exit;
        }

    }else{
        $data['mss'] = 'Số điện thoại hoặc email không hợp lệ';
        echo json_encode($data);exit;
    }
    $data['status'] = 200;
//    $data['phone'] = $phone;
    echo json_encode($data);exit;
}

function importEvent(){
    global $dbmg;
    $eucl = $dbmg->event_user;
    $usercl = $dbmg->user;
    $eventcl = $dbmg->event;
    require_once 'plugin/phpexcel/Classes/PHPExcel/IOFactory.php';
    $data['status'] = 500;
    $event_id = $_GET['eid'];
    $event = $eventcl->findOne(array('_id'=>$event_id));
    $targetFolder = "/uploads/";
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    if($fileParts['extension'] != 'xlsx'){
        $data['mss'] = 'Chỉ upload file *.xlsx';
        echo json_encode($data);exit;
    }
    $folder_name = '/';
    $objPHPExcel = PHPExcel_IOFactory::load($tempFile);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    $phone = array();
    foreach ($sheetData as $k=>$value){
        $phone = Network::reversephoneToZero($value['A']);
        $email = $value['B'];
        if(!empty($phone) && Network::mobifoneNumber($phone)){
            $user = $usercl->findOne(array('phone' => $phone));
            if(!$user){
                $password = Common::generateRandomPassword();
                $uid = strval(time()).$k;
                $usercl->insert(array(
                    '_id' => $uid,
                    'phone' => $phone,
                    'un_password' => $password,
                    'password' => Common::encryptpassword($password),
                    'datecreate' => time(),
                    'status' => Constant::STATUS_ENABLE,
                    'fullname'=>'',
                    'email'=> '',
                    'cmnd'=> '',
                    'cmnd_ngaycap'=>'',
                    'cmnd_noicap'=>'',
                    'birthday'=>'',
                    'priavatar'=>'',
                    'thong_bao' => array(
                        'noti' => "1",
                        'sms' => "1",
                        'email' => "1",
                    )
                ));
            }else{
                $uid = $user['_id'];
            }
//            if(Network::getUserInfo($phone) != 1){
            if(0 != 1){
                $userEvent = $eucl->findOne(array('uid'=>$uid, 'eid'=>$event_id));
                if(!$userEvent){
                    $user = $usercl->findOne(array('_id'=>$uid));
                    $eucl->insert(array(
                        '_id' => strval(time()).$k,
                        'datecreate' => time(),
                        'uid' => $uid,
                        'eid' => $event_id
                    ));
                    $start = time();
                    $end = $start + $event['free_day']*24*60*60;
                    $mtcontent = str_replace(array('{phone}','{pass}','{start}','{end}'), array($phone, $user['un_password'],date('d/m/Y',$start), date('d/m/Y',$end)), $event['contentMT']);
                    $rsmt = Network::sentMT($phone, 'DKKM', $mtcontent);
                    $data['mtcontent'] = $mtcontent;
                    $data['rsmt'] = $rsmt.'-'.$phone;
                }
            }

        }else if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
            $user = $usercl->findOne(array('email'=>$email));
            if(!$user){
                $unpassword = Common::generateRandomPassword();
                $password = Common::encryptpassword($unpassword);
                $now = time();
                $username = $email;
                $uid = strval($now).$k;
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
                    $username = $email;
                    $usercl->update(array('_id'=>$user['_id']), array('$set'=>array(
                        'username'=>$username,
                    )));
                }else{
                    $username = $user['username'];
                }
                $uid = $user['_id'];
            }
            $eventUser = $eucl->findOne(array('eid'=>$event_id, 'uid'=>$uid));
            if(!$eventUser){
                $eucl->insert(array(
                    '_id' => strval(time()).$k,
                    'datecreate' => time(),
                    'uid' => $uid,
                    'eid' => $event_id
                ));
                $start = time();
                $end = $start + $event['free_day']*24*60*60;
                $emailcontent = str_replace(array('{username}','{pass}','{start}','{end}'), array($username, $unpassword,date('d/m/Y',$start), date('d/m/Y',$end)), $event['contentEmail']);
                $subject = $event['name'];
                $mail = new \helpers\Mail($email,$subject,$emailcontent);
                $rsemail = $mail->send();
                $data['emailcontent'] = $emailcontent;
                $data['rsemail'] = $rsemail;
            }
        }
    }
    $data['status'] = 200;
//    $data['phone'] = $phone;
    echo json_encode($data);exit;
}

function exportLog3g(){
    global $dbmg;
    ini_set('memory_limit', '2048M');
    $logcl = $dbmg->log3g;
    $cond = array();
    if(isset($_GET['phone'])){
        $cond['phone'] = new MongoRegex('/'.$_GET['phone'].'/iu');
    }
    if(!empty($_GET['from'])){
        $convertFrom = DateTime::createFromFormat('d/m/Y', $_GET['from'])->format('Y-m-d 00:00:00');
        $cond['datecreate']['$gte'] = strtotime($convertFrom);
    }
    if(!empty($_GET['to'])){
        $convertTo = DateTime::createFromFormat('d/m/Y', $_GET['to'])->format('Y-m-d 23:59:59');
        $cond['datecreate']['$lte'] = strtotime($convertTo);
    }
    $sort = array("datecreate" => -1);
    $cursor = $logcl->find($cond)->sort($sort);
    require_once __DIR__.'/plugin/phpexcel/Classes/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("Nguyen Cong Chinh")
        ->setLastModifiedBy("Nguyen Cong Chinh")
        ->setTitle("Export Log3g")
        ->setSubject("Export Log3g")
        ->setDescription("Export Log3g")
        ->setKeywords("Export Log3g")
        ->setCategory("Export Log3g");
//    echo '<table>';
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Phone')
        ->setCellValue('B1', 'IP')
        ->setCellValue('C1', 'Chanel')
        ->setCellValue('D1', 'Browser')
        ->setCellValue('E1', 'Time');
    $column = 2;
    foreach ($cursor as $k=>$val){
//        echo '<tr>';

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$column, $val['phone'])
            ->setCellValue('B'.$column, $val['ip'])
            ->setCellValue('C'.$column, $val['chanel'])
            ->setCellValue('D'.$column, $val['useragent'])
            ->setCellValue('E'.$column, date('d/m/Y H:i:s', $val['datecreate']));

//        echo '<td>A'.$column.'-'.$val['phone'].'</td>';
//        echo '<td>B'.$column.'-'.$val['ip'].'</td>';
//        echo '<td>'.date('d/m/Y H:i:s', $val['time']).'</td>';
//        echo '<td>'.$val['source'].'</td>';
//        echo '<td>'.$val['link'].'</td>';
//        echo '<td>'.$val['cuphap'].'</td>';
//        echo '</tr>';
        $column++;

    }

//    echo '</table>';

    $objPHPExcel->getActiveSheet()->setTitle('Simple');
    $objPHPExcel->setActiveSheetIndex(0);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
//    print_r($objPHPExcel);die;

// Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ExportLog3g.xlsx"');
    header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');die;
}

function exportEventUser(){
    global $dbmg;
    $eucl = $dbmg->event_user;
    $eventcl = $dbmg->event;
    $usercl = $dbmg->user;
    $eid = $_GET['eid'];
    $event = $eventcl->findOne(array('_id'=>$eid));
    $cond = array();
    if(!empty($_GET['from'])){
        $convertFrom = DateTime::createFromFormat('d/m/Y', $_GET['from'])->format('Y-m-d 00:00:00');
        $cond['datecreate']['$gte'] = strtotime($convertFrom);
    }
    if(!empty($_GET['to'])){
        $convertTo = DateTime::createFromFormat('d/m/Y', $_GET['to'])->format('Y-m-d 23:59:59');
        $cond['datecreate']['$lte'] = strtotime($convertTo);
    }
    $sort = array("datecreate" => -1);
    $cursor = $eucl->find($cond)->sort($sort);

    require_once __DIR__.'/plugin/phpexcel/Classes/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("Nguyen Cong Chinh")
        ->setLastModifiedBy("Nguyen Cong Chinh")
        ->setTitle("Export History")
        ->setSubject("Export History")
        ->setDescription("Export History")
        ->setKeywords("Export History")
        ->setCategory("Export History");
//    echo '<table>';
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Phone')
        ->setCellValue('B1', 'Email')
        ->setCellValue('C1', 'Time');

    $column = 2;
    foreach ($cursor as $k=>$val){
//        echo '<tr>';
        $user = $usercl->findOne(array('_id'=>$val['uid']));
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$column, $user['phone'])
            ->setCellValue('B'.$column, $user['email'])
            ->setCellValue('C'.$column, date('d/m/Y H:i:s',$val['datecreate']));


//        echo '<td>A'.$column.'-'.$val['phone'].'</td>';
//        echo '<td>B'.$column.'-'.$val['ip'].'</td>';
//        echo '<td>'.date('d/m/Y H:i:s', $val['time']).'</td>';
//        echo '<td>'.$val['source'].'</td>';
//        echo '<td>'.$val['link'].'</td>';
//        echo '<td>'.$val['cuphap'].'</td>';
//        echo '</tr>';
        $column++;

    }

//    echo '</table>';

    $objPHPExcel->getActiveSheet()->setTitle('Simple');
    $objPHPExcel->setActiveSheetIndex(0);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
//    print_r($objPHPExcel);die;

// Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ExportHistory.xlsx"');
    header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');die;
}

function exportHistory(){
    global $dbmg;
    ini_set('memory_limit', '2048M');
    $logcl = $dbmg->history_log;
    $cond = array();
    if(!empty($_GET['phone'])){
        $cond['phone'] = new MongoRegex('/'.$_GET['phone'].'/iu');
    }
    if(!empty($_GET['ip'])){
        $cond['ip'] = $_GET['ip'];
    }
    if(!empty($_GET['action'])){
        $cond['action'] = $_GET['action'];
    }
    if(!empty($_GET['chanel'])){
        $cond['chanel'] = $_GET['chanel'];
    }
    if(!empty($_GET['from'])){
        $convertFrom = DateTime::createFromFormat('d/m/Y', $_GET['from'])->format('Y-m-d 00:00:00');
        $cond['datecreate']['$gte'] = strtotime($convertFrom);
    }
    if(!empty($_GET['to'])){
        $convertTo = DateTime::createFromFormat('d/m/Y', $_GET['to'])->format('Y-m-d 23:59:59');
        $cond['datecreate']['$lte'] = strtotime($convertTo);
    }

    $sort = array("time" => -1);
    $cursor = $logcl->find($cond)->sort($sort);
    require_once __DIR__.'/plugin/phpexcel/Classes/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("Nguyen Cong Chinh")
        ->setLastModifiedBy("Nguyen Cong Chinh")
        ->setTitle("Export History")
        ->setSubject("Export History")
        ->setDescription("Export History")
        ->setKeywords("Export History")
        ->setCategory("Export History");
//    echo '<table>';
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Phone')
        ->setCellValue('B1', 'Action')
        ->setCellValue('C1', 'Url')
        ->setCellValue('D1', 'IP')
        ->setCellValue('E1', 'Chanel')
        ->setCellValue('F1', 'Price')
        ->setCellValue('G1', 'Time')
        ->setCellValue('H1', 'Status');
    $column = 2;
    foreach ($cursor as $k=>$val){
//        echo '<tr>';

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$column, $val['phone'])
            ->setCellValue('B'.$column, HistoryLog::getArr()[$val['action']])
            ->setCellValue('C'.$column, $val['url'])
            ->setCellValue('D'.$column, $val['ip'])
            ->setCellValue('E'.$column, $val['chanel'])
            ->setCellValue('F'.$column, isset($val['price']) ? $val['price'] : 0)
            ->setCellValue('G'.$column, date('d/m/Y H:i:s', $val['datecreate']))
            ->setCellValue('H'.$column, $val['status'] == Constant::STATUS_ENABLE ? 'Thành công' : 'Thất bại');


//        echo '<td>A'.$column.'-'.$val['phone'].'</td>';
//        echo '<td>B'.$column.'-'.$val['ip'].'</td>';
//        echo '<td>'.date('d/m/Y H:i:s', $val['time']).'</td>';
//        echo '<td>'.$val['source'].'</td>';
//        echo '<td>'.$val['link'].'</td>';
//        echo '<td>'.$val['cuphap'].'</td>';
//        echo '</tr>';
        $column++;

    }

//    echo '</table>';

    $objPHPExcel->getActiveSheet()->setTitle('Simple');
    $objPHPExcel->setActiveSheetIndex(0);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
//    print_r($objPHPExcel);die;

// Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ExportHistory.xlsx"');
    header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');die;
}

function exportHssv(){
//    echo 1; die;
    global $dbmg;
    $usercl = $dbmg->user;
    $mobiRegex =  new MongoRegex('/^(84|0)?(89|90|93|120|121|122|126|128)\d{7}$/');

    $cond = array(
        'event'=>Event::HOC_SINH_SINH_VIEN,
        'phone' => array('$not'=>$mobiRegex)
    );
//    $p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
    $sort = array("_id" => -1);
    $cursor = $usercl->find($cond)->sort($sort);
    require_once __DIR__.'/plugin/phpexcel/Classes/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("Nguyen Cong Chinh")
        ->setLastModifiedBy("Nguyen Cong Chinh")
        ->setTitle("Export HSSV")
        ->setSubject("Export HSSV")
        ->setDescription("Export HSSV")
        ->setKeywords("Export HSSV")
        ->setCategory("Export HSSV");
//    echo '<table>';
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Phone')
        ->setCellValue('B1', 'Email')
        ->setCellValue('C1', 'Username')
        ->setCellValue('D1', 'Password')
        ->setCellValue('E1', 'Birthday');
    $column = 2;
    foreach ($cursor as $k=>$val){
//        echo '<tr>';

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$column, $val['phone'])
            ->setCellValue('B'.$column, $val['email'])
            ->setCellValue('C'.$column, isset($val['username']) ? $val['username'] : '')
            ->setCellValue('D'.$column, $val['un_password'])
            ->setCellValue('E'.$column, $val['birthday']);

//        echo '<td>A'.$column.'-'.$val['phone'].'</td>';
//        echo '<td>B'.$column.'-'.$val['ip'].'</td>';
//        echo '<td>'.date('d/m/Y H:i:s', $val['time']).'</td>';
//        echo '<td>'.$val['source'].'</td>';
//        echo '<td>'.$val['link'].'</td>';
//        echo '<td>'.$val['cuphap'].'</td>';
//        echo '</tr>';
        $column++;

    }

//    echo '</table>';

    $objPHPExcel->getActiveSheet()->setTitle('Hssv');
    $objPHPExcel->setActiveSheetIndex(0);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
//    print_r($objPHPExcel);die;

// Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ExportHssv.xlsx"');
    header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');die;
}

function exportAds(){
    global $dbmg;
    $logcl = $dbmg->ads;
    $cond = array('time'=>array('$exists'=>true));
    if(isset($_GET['phone']) && !empty($_GET['phone'])){
        $cond['phone'] = new MongoRegex('/'.$_GET['phone'].'/iu');
    }
    if(isset($_GET['source']) && !empty($_GET['source'])){
        $cond['source'] = $_GET['source'];
    }
    if(isset($_GET['link']) && !empty($_GET['link'])){
        $cond['link'] = new MongoRegex('/'.$_GET['link'].'/iu');
    }
    $startdate = $_GET['start'];
    $enddate = $_GET['end'];
    if(isset($startdate) && !empty($startdate)){
        $convertStartdate = DateTime::createFromFormat('d/m/Y', $startdate)->format('Y-m-d');
        $cond['time']['$gte'] = (int)strtotime($convertStartdate. ' 00:00:00');
    }
    if(isset($enddate) && !empty($enddate)){
        $convertEnddate = DateTime::createFromFormat('d/m/Y', $enddate)->format('Y-m-d');
        $cond['time']['$lte'] = (int)strtotime($convertEnddate. ' 23:59:59');
    }
    $limit = 25;
//    $p = $_GET['p'];if($p<=1) $p=1;$cp = ($p-1)*$limit; $stpage = $p;
    $sort = array("time" => -1);
    $cursor = $logcl->find($cond)->sort($sort);
    require_once __DIR__.'/plugin/phpexcel/Classes/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("Nguyen Cong Chinh")
        ->setLastModifiedBy("Nguyen Cong Chinh")
        ->setTitle("Export Ads")
        ->setSubject("Export Ads")
        ->setDescription("Export Ads")
        ->setKeywords("Export Ads")
        ->setCategory("Export Ads");
//    echo '<table>';
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Phone')
        ->setCellValue('B1', 'IP')
        ->setCellValue('C1', 'Time')
        ->setCellValue('D1', 'Source')
        ->setCellValue('E1', 'Link')
        ->setCellValue('F1', 'Cuphap');
    $column = 2;
    foreach ($cursor as $k=>$val){
//        echo '<tr>';

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$column, $val['phone'])
            ->setCellValue('B'.$column, $val['ip'])
            ->setCellValue('C'.$column, date('d/m/Y H:i:s', $val['time']))
            ->setCellValue('D'.$column, $val['source'])
            ->setCellValue('E'.$column, $val['link'])
            ->setCellValue('F'.$column, $val['cuphap']);

//        echo '<td>A'.$column.'-'.$val['phone'].'</td>';
//        echo '<td>B'.$column.'-'.$val['ip'].'</td>';
//        echo '<td>'.date('d/m/Y H:i:s', $val['time']).'</td>';
//        echo '<td>'.$val['source'].'</td>';
//        echo '<td>'.$val['link'].'</td>';
//        echo '<td>'.$val['cuphap'].'</td>';
//        echo '</tr>';
        $column++;

    }

//    echo '</table>';

    $objPHPExcel->getActiveSheet()->setTitle('Simple');
    $objPHPExcel->setActiveSheetIndex(0);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
//    print_r($objPHPExcel);die;

// Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ExportAds.xlsx"');
    header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');die;
}

function sendMail(){
    global $dbmg;
    $emailCl = $dbmg->email_log;
    $userCl = $dbmg->user;
    $emailQueue = $dbmg->email_queue;

    $email = $_POST['email'];
    $title = $_POST['title'];
//    $action = $_POST['action'];
    $content = $_POST['content'];
//    $user = $userCl->findOne(array('email'=>$email));
//    $mail = new \helpers\Mail($email,$title,$content);
//    @$mail->send();
    $sent = array();
    foreach ($email as $aEmail){
        if(filter_var($aEmail, FILTER_VALIDATE_EMAIL)){
            $emailQueue->insert(array(
                'to' => $aEmail,
                'subject' => $title,
                'content' => $content,
            ));
            $sent[] = $aEmail;
        }

    }
    echo json_encode(array('success'=>true, 'sent'=>$sent));exit;
}

function createTag(){
    global $dbmg;
    $tagcl = $dbmg->tag;
    $word = ltrim($_POST['tag']);
    $slug = Common::utf8_to_url($word);
    if(!$tagcl->findOne(array('slug'=>$slug))){
        $tagcl->insert(array(
            '_id' => strval(time()),
            'name' => $word,
            'slug' => $slug
        ));
    }
    echo json_encode(array('status'=>200));exit;
}
$mgconn->close();
?>
