<?php
$act = $_GET['act'];if(!isset($act)) $act = $_POST['act'];
switch($act){
    case "allQuestion": allQuestion(); break;
    case "detailQuestion": detailQuestion(); break;
    case "newQuestion": newQuestion(); break;
    case "likeQuestionAnswer": likeQuestionAnswer(); break;
    case "unlikeQuestionAnswer": unlikeQuestionAnswer(); break;
    case "saveLession" : saveLession(); break;
    case "checkUserActive" : checkUserActive(); break;
    case "chargeGetPassword": chargeGetPassword(); break;
    case "checkEventUser": checkEventUser(); break;
    case "chargeRegister": chargeRegister(); break;
    case "getLessionSaved": getLessionSaved(); break;
    case "deleteSavedLession": deleteSavedLession(); break;
    case "countNotify": countNotify(); break;
    case "myNotify": myNotify(); break;
    case "delNotify": delNotify(); break;
    case "listComment" : listComment(); break;
    case "newComment": newComment(); break;
    case "likeComment": likeComment(); break;
    case "unlikeComment": unlikeComment(); break;
    case "report": report(); break;
    case "dictionaryCategory": dictionaryCategory(); break;
    case "dictionary": dictionary(); break;
    case "userSetting": userSetting(); break;
    case "changePass": changePass(); break;
    case "uploadAudio": uploadAudio(); break;
    case "deleteAudio": deleteAudio(); break;
    case "uploadAvatar": uploadAvatar(); break;
    case "myQuestion": myQuestion(); break;
    case "delMyQuestion": delMyQuestion(); break;
    case "forgetPass": forgetPass(); break;
    case "registerPackage": registerPackage(); break;
    case "cancelPackage": cancelPackage(); break;
    case "checkPackage": checkPackage(); break;
    case "getLog3g": getLog3G(); break;
    case "gameCategory": gameCategory(); break;
    case "gameRank": gameRank(); break;
    case "sendAuthKey": sendAuthKey(); break;
    case "checkAuthKey": checkAuthKey(); break;
    case "getPage": getPage(); break;
    case "is3gmobifone": is3gmobilephone(); break;
    case "tratu": tratu(); break;
    case "loadTratu": loadTratu(); break;
    case "changeIpService": changeIpService(); break;
}

function changeIpService(){
    $dtr['status'] = 500;
    $ip = _getParam('ip');
    if (empty($ip)) {
        $dtr['message'] = "Bạn cần nhập địa chỉ ip cần thay đổi";
        echo json_encode($dtr);
        exit();
    }
    if(preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $ip)){
        $fileNet=__DIR__ . '/../config/service_ip.txt';
        //ghi du lieu
        $file= fopen($fileNet,"w+");
        fwrite($file,$ip);
        fclose($file);
        $dtr['status'] = 200;
        $dtr['message'] = 'Thay đổi ip thành công.';
        echo json_encode($dtr);
        exit();
    }else{
        $dtr['message'] = "Địa chỉ ip không chính xác";
        echo json_encode($dtr);
        exit();
    }
}

function getLog3G(){
    global $dbmg;
    $logCl = $dbmg->log;
    if(Network::ip() != Network::getIpService() && Network::ip() != '127.0.0.1'){
        exit;
    }
    $start = _getParam('fdate');
    $end = _getParam('tdate');
    $result = iterator_to_array($logCl->find(array(
            'date'=> array('$gte' => $start, '$lte'=> $end)
    ), array('date', 'total'))->sort(array('time'=>1)), false);
    echo json_encode($result);die;
}

function checkEventUser(){
    global $dbmg;
    $eucl = $dbmg->event_user;
    $usercl = $dbmg->user;
    $phone = _getParam('phone');
    $phone = Network::reversephoneToZero($phone);
    $result = 0;
    $user = $usercl->findOne(array('phone' => $phone));
    if(!$user){
        echo $result;exit;
    }
    $eventUser = $eucl->findOne(array('uid'=>$user['_id']));
    if($eventUser) $result = 1;
    echo $result;exit;
}

//Kiểm tra user có tồn tại
function checkUserActive(){
    global $dbmg;
    $userCl = $dbmg->user;
    $phone = _getParam('phone');
    $result = 0;
    $user = $userCl->findOne(array('phone' => $phone));
    if($user)
        $result = 1;

    echo $result;exit;
}

//Trả về password của user cho IP 10.54.128.164
function chargeGetPassword(){
    global $dbmg;
    $userCl = $dbmg->user;
//    if(Network::ip() != Network::getIpService()){
//        exit;
//    }
    $phone = Network::reversephoneToZero(_getParam('phone'));
    if(empty($phone)) exit;

    $result = '';
    $user = $userCl->findOne(array('phone' => strval($phone)));
    if($user){
        $result = isset($user['un_password']) ? $user['un_password'] : $user['password'];
    }else{
        $password = Common::generateRandomPassword();
        $newUser = array(
                '_id' => strval(time()),
                'phone' => $phone,
                'password' => Common::encryptpassword($password),
                'un_password' => $password,
                'datecreate' => time(),
                'email' => '',
                'priavatar' => '',
                'birthday' => '',
                'cmnd' => '',
                'cmnd_ngaycap' => '',
                'cmnd_noicap' => '',
                'status'=>Constant::STATUS_ENABLE,
                'displayname' => '',
                'thong_bao' => array(
                    'noti' => "1",
                    'sms' => "1",
                    'email' => "1",
                )
        );

        $userCl->insert($newUser);
        $result = $password;
    }

    echo $result;exit;
}

//
function chargeRegister(){
    global $dbmg;
    $userCl = $dbmg->user;
    $phone = Network::reversephoneToZero(_getParam('phone'));
    if(empty($phone)) exit;

    $user = $userCl->findOne(array('phone' => $phone));
    if($user){
        $result = isset($user['un_password']) ? $user['un_password'] : $user['password'];
    }else{
        $password = Common::generateRandomPassword();
        $newUser = array(
                '_id' => strval(time()),
                'phone' => $phone,
                'password' => Common::encryptpassword($password),
                'un_password' => $password,
                'datecreate' => time(),
                'email' => '',
                'priavatar' => '',
                'birthday' => '',
                'cmnd' => '',
                'cmnd_ngaycap' => '',
                'cmnd_noicap' => '',
                'status'=>Constant::STATUS_ENABLE,
                'displayname' => '',
                'thong_bao' => array(
                        'noti' => "1",
                        'sms' => '1',
                        'email' => '1',
                )
        );

        $userCl->insert($newUser);
        $result = $password;
    }

    echo $result;exit;
}

//Danh sách Hỏi đáp
function allQuestion(){
    global $dbmg;
    $faqCl = $dbmg->faq;
    $userCl = $dbmg->user;

    $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1)*$limit;

    $allFaq = iterator_to_array($faqCl->find(array(
        'status' => Constant::STATUS_ENABLE,
        'parentid' => '0',
    ), array('_id','usercreate', 'datecreate', 'content', 'like'))->sort(array("datecreate"=>-1))->skip($start)->limit($limit), false);
    foreach($allFaq as $key=>$val){
        $uinfo =  _getDisplayInfo($val['usercreate']);
        if($uinfo){
            $isLiked = false;
            if(_checkLogin() && isset($val['like']) && in_array($_SESSION['uinfo']['_id'], $val['like']))
                $isLiked = true;
            $allFaq[$key]['uinfo'] = $uinfo;
            $allFaq[$key]['datecreate'] = date('d/m/Y H:i', $val['datecreate']);
            $allFaq[$key]['likecount'] = isset($val['like']) ? count($val['like']) : 0;
            $allFaq[$key]['is_liked'] = $isLiked;
            $allFaq[$key]['content'] = html_entity_decode($val['content']);
        }else
            unset($allFaq[$key]);

    }
    $dtr['status'] = 200;
    $dtr['data'] = $allFaq;
    echo json_encode($dtr);exit();
}

//Chi tiết câu hỏi Hỏi đáp
function detailQuestion(){
    global $dbmg;
    $faqCl = $dbmg->faq;
    $dtr['status'] = 500;
    $id = _getParam('id');
    if(empty($id)){
        $dtr['mss'] = 'Cần truyền ID câu hỏi.';
        echo json_encode($dtr);exit();
    }

    $detail = $faqCl->findOne(array('_id'=>$id, 'status' => Constant::STATUS_ENABLE), array('_id','content', 'usercreate', 'datecreate', 'like'));
    if(!$detail){
        $dtr['mss'] = 'Câu hỏi không tồn tại.';
        echo json_encode($dtr);exit();
    }
    $detail['datecreate'] = date('d/m/Y H:i', $detail['datecreate']);
    $detail['uinfo'] = _getDisplayInfo($detail['usercreate']);
    $detail['content'] = html_entity_decode($detail['content']);
    $isLiked = false;
    if(_checkLogin() && isset($detail['like']) && in_array($_SESSION['uinfo']['_id'], $detail['like']))
        $isLiked = true;
    $detail['is_liked'] = $isLiked;
    $detail['likecount'] = isset($detail['like']) ? count($detail['like']) : 0;

    $allAns = iterator_to_array($faqCl->find(array(
        'status' => Constant::STATUS_ENABLE,
        'parentid' => $id,
    ), array('_id','usercreate', 'datecreate', 'content', 'like'))->sort(array("datecreate"=>1)), false);
    foreach($allAns as $key=>$val){
        $uinfo =  _getDisplayInfo($val['usercreate']);
        if($uinfo){
            $isLiked = false;
            if(_checkLogin() && isset($val['like']) && in_array($_SESSION['uinfo']['_id'], $val['like']))
                $isLiked = true;
            $allAns[$key]['uinfo'] = $uinfo;
            $allAns[$key]['datecreate'] = date('d/m/Y H:i', $val['datecreate']);
            $allAns[$key]['is_liked'] = $isLiked;
            $allAns[$key]['likecount'] = isset($val['like']) ? count($val['like']) : 0;
            $allAns[$key]['content'] = html_entity_decode(strip_tags($val['content']));
        }else
            unset($allAns[$key]);
    }
    $dtr['status'] = 200;
    $dtr['data'] = $detail;
    $dtr['aw'] = $allAns;
    echo json_encode($dtr);exit();
}

//Gửi câu hỏi mới Hỏi đáp
function newQuestion(){
    global $dbmg;
    $faqCl = $dbmg->faq;
    $notifyCl = $dbmg->notify;
    $historycl = $dbmg->history_log;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $content = _getParam('content');
    $parent = _getParam('parentid', '0');
    $newFaq = array(
        '_id' => strval(time()),
        'name' => $content,
        'content' => $content,
        'parentid' => $parent,
        'status' => Constant::STATUS_ENABLE,
        'usercreate' => $_SESSION['uinfo']['_id'],
        'datecreate' => time()
    );
    $faqCl->insert($newFaq);
    //Gửi thông báo
    if($parent != '0'){
        $parentItem = $faqCl->findOne(array('_id'=> $parent));
        if($parentItem && $parentItem['usercreate'] != $_SESSION['uinfo']['_id']){
            $newNotify = array(
                '_id' => strval(time()),
                'uid' => $parentItem['usercreate'],
                'usercreate' => $_SESSION['uinfo']['_id'],
                'datecreate' => time(),
                'mss' => _getDisplayName($_SESSION['uinfo']['_id']). ' đã trả lời Câu hỏi của bạn',
                'status' => Constant::STATUS_ENABLE,
                'type' => Constant::TYPE_NOTIFY,
                'to' => array(
                    'type' => Constant::TYPE_HOIDAP,
                    'id' => $parent
                )
            );
            $notifyCl->insert($newNotify);
        }
        $dtr['mss'] = 'Trả lời câu hỏi thành công.';
    }else{
        $dtr['mss'] = 'Đăng câu hỏi thành công.';
    }
    $dtr['status'] = 200;

    ##log
    $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_HOI_DAP,
            'chanel' => HistoryLog::CHANEL_APP,
            'ip' => Network::ip(),
            'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
            'price'=> 0
    );
    $historycl->insert($newHistoryLog);
    echo json_encode($dtr);exit();
}

//Like câu hỏi, bình luận phần Hỏi đáp
function likeQuestionAnswer(){
    global $dbmg;
    $faqCl = $dbmg->faq;
    $notifyCl = $dbmg->notify;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = _getParam('id');
    if(empty($id)){
        $dtr['mss'] = 'Thiếu tham số ID của câu hỏi hoặc trả lời.';
        echo json_encode($dtr);exit();
    }

    $item = $faqCl->findOne(array('_id' => $id));
    if(!$item){
        $dtr['mss'] = 'Câu hỏi hoặc trả lời không tồn tại.';
        echo json_encode($dtr);exit();
    }

    $like = isset($item['like']) ? $item['like'] : array();
    if(!in_array($_SESSION['uinfo']['_id'], $like))
        array_push($like, $_SESSION['uinfo']['_id']);

    $faqCl->update(array('_id' => $id), array('$set' => array('like' => $like)));
    if($item['uid'] != $_SESSION['uinfo']['_id']){
        $isAns = $item['parentid'] == ''? 'hỏi' : 'trả lời';
        $newNotify = array(
                '_id' => strval(time()),
                'uid' => $item['usercreate'],
                'usercreate' => $_SESSION['uinfo']['_id'],
                'datecreate' => time(),
                'mss' => _getDisplayName($_SESSION['uinfo']['_id']).' đã thích câu '.$isAns.' của bạn.',
                'status' => Constant::STATUS_ENABLE,
                'type' => Constant::TYPE_NOTIFY,
                'to' => array(
                    'type' => Constant::TYPE_HOIDAP,
                    'id' => $id
                )
        );
        $notifyCl->insert($newNotify);
    }
    $dtr['status'] = 200;
    $dtr['mss'] = 'Đã thích câu trả lời.';
    echo json_encode($dtr);exit();
}

//Bỏ like câu trả lời
function unlikeQuestionAnswer(){
    global $dbmg;
    $faqCl = $dbmg->faq;
    $notifyCl = $dbmg->notify;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = _getParam('id');
    if(empty($id)){
        $dtr['mss'] = 'Thiếu tham số ID của câu hỏi hoặc trả lời.';
        echo json_encode($dtr);exit();
    }

    $item = $faqCl->findOne(array('_id' => $id));
    if(!$item){
        $dtr['mss'] = 'Câu hỏi hoặc trả lời không tồn tại.';
        echo json_encode($dtr);exit();
    }

    $like = isset($item['like']) ? $item['like'] : array();
    if(($key = array_search($_SESSION['uinfo']['_id'], $like)) !== false) {
        unset($like[$key]);
    }

    $faqCl->update(array('_id' => $id), array('$set' => array('like' => $like)));

    $dtr['status'] = 200;
    $dtr['mss'] = 'Đã bỏ thích câu trả lời.';
    echo json_encode($dtr);exit();
}

//Lưu bài học
function saveLession(){
    global $dbmg;
    $savelessionCl = $dbmg->saveexam;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = _getParam('id');
    $type = _getParam('type');
    $postCl = Common::getClFromType($type);
    $postCl = $dbmg->$postCl;
    if(!$postCl->findOne(array('_id'=>$id))){
        $dtr['mss'] = 'Bài học này không tồn tại.';
        echo json_encode($dtr);exit();
    }

    $newEx = array(
        'id' => $id,
        'type' => $type
    );
    $save = $savelessionCl->findOne(array('uid' => $_SESSION['uinfo']['_id']));
    if($save){
        $ex = isset($save['ex']) ? $save['ex'] : array();
        $time = isset($save['time']) ? $save['time'] : array();

        if(!in_array($newEx, $ex)){
            array_push($ex, $newEx);
            array_push($time, time());
        }

        $savelessionCl->update(array('uid' => $_SESSION['uinfo']['_id']), array('$set'=> array('ex' => $ex, 'time' => $time)));
    }else{
        $newSave = array(
            'uid' => $_SESSION['uinfo']['_id'],
            'ex' => array($newEx),
            'time' => array(time())
        );
        $savelessionCl->insert($newSave);
    }

    $dtr['status'] = 200;
    $dtr['mss'] = 'Lưu bài học thành công.';
    echo json_encode($dtr);exit();
}

//Xem các bài học đã lưu
function getLessionSaved(){
    global $dbmg;
    $savelessionCl = $dbmg->saveexam;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $save = $savelessionCl->findOne(array('uid' => $_SESSION['uinfo']['_id']));
    if($save){
        $list = isset($save['ex']) ? $save['ex'] : array();
    }else{
        $list = array();
        $newSave = array(
            'uid' => $_SESSION['uinfo']['_id'],
            'ex' => $list,
            'time' => array()
        );
    }

    $list = array_reverse($list);
    $save['time'] = array_reverse($save['time']);
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1)*$limit;

    $listLession = array();
    if(count($list) > 0){
        for($i=$start; $i< $start+ $limit; $i++){
            if(isset($list[$i])) {
                $postCl = Common::getClFromType($list[$i]['type']);
                $postCl = $dbmg->$postCl;
                $lession = $postCl->findOne(array('_id'=> $list[$i]['id']));
                if($lession){
                    $cate = Common::getcategorytype($list[$i]['type']);
                    $listLession[] = array(
                            '_id' => $lession['_id'],
                            'type' => $list[$i]['type'],
                            'name' => $lession['name'],
                            'avatar' => Common::getWebImageLink($lession['avatar']),
                            'cate' => $cate['name'],
                            'date' => date('d/m/Y H:i', $save['time'][$i])
                    );
                }
            }
        }
    }

    $dtr['status'] = 200;
    $dtr['data'] = $listLession;
    echo json_encode($dtr);exit();
}

//Xóa bài học đã lưu
function deleteSavedLession(){
    global $dbmg;
    $savelessionCl = $dbmg->saveexam;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = _getParam('id');
    $type = _getParam('type');
    if(empty($id) || empty($type)){
        $dtr['mss'] = 'Bạn chưa nhập id hoặc type của bài học.';
        echo json_encode($dtr);exit();
    }

    $lession = array(
        'id' => $id,
        'type' => $type
    );

    $save = $savelessionCl->findOne(array('uid' => $_SESSION['uinfo']['_id']));
    $list = isset($save['ex']) ? $save['ex'] : array();
    $time = isset($save['time']) ? $save['time'] : array();
    if(($key = array_search($lession, $list)) !== false) {
        unset($list[$key]);
        unset($time[$key]);
    }else{
        $dtr['mss'] = 'Bài học này chưa được lưu trước đó.';
        echo json_encode($dtr);exit();
    }

    $savelessionCl->update(array('uid' => $_SESSION['uinfo']['_id']), array('$set' => array('ex' => array_values($list), 'time' => array_values($time))));
    $dtr['status'] = 200;
    $dtr['mss'] = 'Xóa thành công.';
    echo json_encode($dtr);exit();
}

function countNotify(){
    global $dbmg;
    $notifyCl = $dbmg->notify;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }
    $dtr['data'] = $notifyCl->count(array('uid'=>$_SESSION['uinfo']['_id'], 'status'=>Constant::STATUS_ENABLE, 'type'=>Constant::TYPE_NOTIFY));
    $dtr['status'] = 200;
    echo json_encode($dtr);
    exit();
}

//Thông báo của tôi
function myNotify(){
    global $dbmg;
    $notifyCl = $dbmg->notify;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1)*$limit;

    $allNotify = iterator_to_array($notifyCl->find(array('uid' => $_SESSION['uinfo']['_id'], 'type'=>Constant::TYPE_NOTIFY))->sort(array('status'=>-1, 'datecreate'=>-1))->skip($start)->limit($limit),false);
    $dtr['data'] = array();
    foreach($allNotify as $aNotify){
        $dtr['data'][] = array(
            '_id' => $aNotify['_id'],
            'avatar' => _getDisplayAvatar($aNotify['usercreate']),
            'mss' => $aNotify['mss'],
            'to' => isset($aNotify['to']) ? $aNotify['to'] : null,
            'date' => date('d/m/Y H:i', $aNotify['datecreate'])
        );
    }

    $notifyCl->update(array('uid'=>$_SESSION['uinfo']['_id']), array('$set'=>array('status'=>Constant::STATUS_DISABLE)),array('multiple'=>true));
    $dtr['status'] = 200;
    echo json_encode($dtr);exit();
}

//Xoá thông báo
function delNotify(){
    global $dbmg;
    $notifyCl = $dbmg->notify;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = _getParam('id');
    $item = $notifyCl->findOne(array('uid' => $_SESSION['uinfo']['_id'], 'type'=>Constant::TYPE_NOTIFY, '_id' => $id));
    if(!$item){
        $dtr['mss'] = 'Thông báo không tồn tại.';
        echo json_encode($dtr);exit();
    }

    $notifyCl->remove(array('_id'=>$id));
    $dtr['status'] = 200;
    $dtr['mss'] = 'Xóa thành công.';
    echo json_encode($dtr);exit();
}

//Danh sách comment trong bài viết
function listComment(){
    global $dbmg;
    $commentCl = $dbmg->comment;
    $dtr['status'] = 500;
    $id = _getParam('id');
    $type = _getParam('type');
    $page = _getParam('page', 1);
    $limit = _getParam('limit', 10);
    $start = ($page - 1)*$limit;
    if(empty($id) || empty($type)){
        $dtr['mss'] = 'Bạn cần truyền đủ tham số id và type của bài học.';
        echo json_encode($dtr);exit();
    }

    $list = array();
    $allComment = iterator_to_array($commentCl->find(array('type' => $type, 'objid' => $id, 'parentid' => '', 'status' => Constant::STATUS_ENABLE))->sort(array('datecreate'=> -1))->skip($start)->limit($limit), false);
    foreach($allComment as $aComment){
        $allChilds = iterator_to_array($commentCl->find(array('parentid' => array('$in'=>array(strval($aComment['_id']), intval($aComment['_id']))), 'status' => Constant::STATUS_ENABLE))->sort(array('datecreate'=> 1)), false);
        $listChild = array();
        foreach($allChilds as $aChild){
            $isLiked = false;
            if(_checkLogin() && isset($aChild['like']) && in_array($_SESSION['uinfo']['_id'], $aChild['like']))
                $isLiked = true;
            if(_getDisplayInfo($aChild['uid'])){
                $listChild[] = array(
                        '_id' => $aChild['_id'],
                        'uinfo' => _getDisplayInfo($aChild['uid']),
                        'content' => $aChild['content'],
                        'likecount' => isset($aChild['like']) ? count($aChild['like']) : 0,
                        'is_liked' => $isLiked ? 1 : 0,
                        'datecreate' => date('d/m/Y H:i', $aChild['datecreate'])
                );
            }
        }
        $isLiked = false;
        if(_checkLogin() && isset($aComment['like']) && in_array($_SESSION['uinfo']['_id'], $aComment['like']))
            $isLiked = true;
        if(_getDisplayInfo($aComment['uid'])){
            $list[] = array(
                    '_id' => $aComment['_id'],
                    'uinfo' => _getDisplayInfo($aComment['uid']),
                    'content' => $aComment['content'],
                    'childs' => $listChild,
                    'likecount' => isset($aComment['like']) ? count($aComment['like']) : 0,
                    'is_liked' => $isLiked ? 1 : 0,
                    'datecreate' => date('d/m/Y H:i', $aComment['datecreate'])

            );
        }
    }

    $dtr['status'] = 200;
    $dtr['data'] = $list;
    echo json_encode($dtr);exit();
}

//Bình luận
function newComment(){
    global $dbmg;
    $commentCl = $dbmg->comment;
    $notifyCl = $dbmg->notify;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $parent = _getParam('parentid', '0');
    $id = _getParam('id');
    $type = _getParam('type');
    $content = _getParam('content');
    if(empty($id) || empty($type)){
        $dtr['mss'] = 'Bạn cần truyền đủ tham số id và type của bài học.';
        echo json_encode($dtr);exit();
    }

    $newComment = array(
        '_id' => strval(time()),
        'uid' => $_SESSION['uinfo']['_id'],
        'type' => $type,
        'content' => strip_tags($content),
        'objid' => $id,
        'parentid' => $parent,
        'datecreate' => time(),
        'status' => Constant::STATUS_ENABLE
    );

    $commentCl->insert($newComment);
    if($parent != '0'){
        $parentComment = $commentCl->findOne(array('_id'=>$parent));
        if($parentComment && $parentComment['uid'] != $_SESSION['uinfo']['_id']){
            $newNotify = array(
                '_id' => strval(time()),
                'uid' => $parentComment['uid'],
                'usercreate' => $_SESSION['uinfo']['_id'],
                'datecreate' => time(),
                'mss' => _getDisplayName($_SESSION['uinfo']['_id']). ' đã trả lời Bình luận của bạn',
                'status' => Constant::STATUS_ENABLE,
                'type' => Constant::TYPE_NOTIFY,
                'to' => array(
                    'type' => $type,
                    'id' => $id
                )
            );
            $notifyCl->insert($newNotify);
        }
    }

    $newComment['datecreate'] = date('d/m/Y H:i', $newComment['datecreate']);
    if($newComment['parentid'] == '0')
        $newComment['parentid'] = '';
    $dtr['status'] = 200;
    $dtr['mss'] = 'Bình luận đã được gửi.';
    $dtr['data'] = $newComment;
    echo json_encode($dtr);exit();
}

function likeComment(){
    global $dbmg;
    $commentCl = $dbmg->comment;
    $notifyCl = $dbmg->notify;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = _getParam('id');
    if(empty($id)){
        $dtr['mss'] = 'Thiếu tham số ID của bình luận.';
        echo json_encode($dtr);exit();
    }

    $comment = $commentCl->findOne(array('_id' => $id));
    if(!$comment){
        $dtr['mss'] = 'Comment không tồn tại.';
        echo json_encode($dtr);exit();
    }

    $like = isset($comment['like']) ? $comment['like'] : array();
    if(!in_array($_SESSION['uinfo']['_id'], $like))
        array_push($like, $_SESSION['uinfo']['_id']);

    $commentCl->update(array('_id' => $id), array('$set' => array('like' => $like)));
    if($comment['uid'] != $_SESSION['uinfo']['_id']){
        $newNotify = array(
            '_id' => strval(time()),
            'uid' => $comment['uid'],
            'usercreate' => $_SESSION['uinfo']['_id'],
            'datecreate' => time(),
            'mss' => _getDisplayName($_SESSION['uinfo']['_id']).' đã thích Bình luận của bạn.',
            'status' => Constant::STATUS_ENABLE,
            'type' => Constant::TYPE_NOTIFY,
            'to' => array(
                'type' => $comment['type'],
                'id' => $comment['objid']
            )
        );
        $notifyCl->insert($newNotify);
    }
    $dtr['status'] = 200;
    $dtr['mss'] = 'Đã thích bình luận.';
    echo json_encode($dtr);exit();
}

function unlikeComment(){
    global $dbmg;
    $commentCl = $dbmg->comment;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = _getParam('id');
    if(empty($id)){
        $dtr['mss'] = 'Thiếu tham số ID của bình luận.';
        echo json_encode($dtr);exit();
    }

    $comment = $commentCl->findOne(array('_id' => $id));
    if(!$comment){
        $dtr['mss'] = 'Comment không tồn tại.';
        echo json_encode($dtr);exit();
    }

    $like = isset($comment['like']) ? $comment['like'] : array();
    if(($key = array_search($_SESSION['uinfo']['_id'], $like)) !== false) {
        unset($like[$key]);
    }

    $commentCl->update(array('_id' => $id), array('$set' => array('like' => $like)));
    $dtr['status'] = 200;
    $dtr['mss'] = 'Đã bỏ thích bình luận.';
    echo json_encode($dtr);exit();
}

function report(){
    global $dbmg;
    $reportCl = $dbmg->report;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = _getParam('id');
    if(empty($id)){
        $dtr['mss'] = 'Có lỗi xảy ra, vui lòng thử lại.';
        echo json_encode($dtr);exit();
    }
    $type = _getParam('type');
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
    $dtr['status'] = 200;
    echo json_encode($dtr);exit();
}

function dictionaryCategory(){
    global $dbmg;
    $cateCl = $dbmg->category;

    $allCate = iterator_to_array($cateCl->find(array('type'=>Constant::TYPE_TUDIEN), array('_id', 'name')), false);
    $dtr['status'] = 200;
    $dtr['data'] = $allCate;
    echo json_encode($dtr);exit();
}

function dictionary(){
    global $dbmg;
    $tudienCl = $dbmg->tudien;
    $historycl = $dbmg->history_log;

    $letter = _getParam('letter');
    $cate = _getParam('category');
    $searchWord = _getParam('keyword');
    $page = _getParam('page', 1);
    $limit = _getParam('limit', 20);
    $start = ($page - 1)*$limit;
    $cond = array();

    if(!empty($letter)){
        $cond['key'] = $letter;
    }
    if(!empty($cate)){
        $cateArr = explode(',', $cate);
        $cond['catid'] = array('$in' => $cateArr);
    }
    if(!empty($searchWord)){
        $keywordRegex = new MongoRegex('/'.strtolower(Common::convert_vi_to_en($searchWord)).'/ui');
        $cond['value'] = $keywordRegex;
    }

    $totalpage = ceil($tudienCl->count($cond) / $limit);
    $allTudien = iterator_to_array($tudienCl->find($cond, array('_id', 'value', 'key', 'content'))->sort(array('value'=>1))->skip($start)->limit($limit), false);
    foreach($allTudien as $key=>$val){
        $allTudien[$key]['value'] = $val['value'] ? $val['value'] : '';
        $allTudien[$key]['key'] = $val['key'] ? $val['key'] : '';
        $allTudien[$key]['content'] = $val['content'] ? $val['content'] : '';
    }
    $dtr['status'] = 200;
    $dtr['data'] = $allTudien;
    $dtr['totalpage'] = $totalpage;
    ##log
    $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_TU_DIEN,
            'chanel' => HistoryLog::CHANEL_APP,
            'ip' => Network::ip(),
            'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
            'price'=> 0
    );
    $historycl->insert($newHistoryLog);
    echo json_encode($dtr);exit();
}

//Sửa thông tin cá nhân
function userSetting(){
    global $dbmg;
    $userCl = $dbmg->user;
    $historycl = $dbmg->history_log;

    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $user = $userCl->findOne(array('_id'=> $_SESSION['uinfo']['_id']));
    $user['fullname'] = isset($user['fullname']) ? $user['fullname'] : '';
    $user['birthday'] = isset($user['birthday']) ? $user['birthday'] : '';
    $user['email'] = isset($user['email']) ? $user['email'] : '';
    $user['cmnd'] = isset($user['cmnd']) ? $user['cmnd'] : '';
    $user['cmnd_ngaycap'] = isset($user['cmnd_ngaycap']) ? $user['cmnd_ngaycap'] : '';
    $user['cmnd_noicap'] = isset($user['cmnd_noicap']) ? $user['cmnd_noicap'] : '';
    $user['displayname'] = isset($user['displayname']) ? $user['displayname'] : '';
    $user['thong_bao']['noti'] = isset($user['thong_bao']['noti']) ? $user['thong_bao']['noti'] : 0;
    $user['thong_bao']['sms'] = isset($user['thong_bao']['sms']) ? $user['thong_bao']['sms'] : 0;
    $user['thong_bao']['email'] = isset($user['thong_bao']['email']) ? $user['thong_bao']['email'] : 0;

    $fullname = _getParam('fullname', $user['fullname']);
    $birthday = _getParam('birthday', $user['birthday']);
    $email = _getParam('email', $user['email']);
    $cmnd = _getParam('cmnd', $user['cmnd']);
    $cmnd_ngaycap = _getParam('cmnd_ngaycap', $user['cmnd_ngaycap']);
    $cmnd_noicap = _getParam('cmnd_noicap', $user['cmnd_noicap']);
    $displayname = _getParam('displayname', $user['displayname']);
    $chkNoti = _getParam('chkNoti', $user['thong_bao']['noti']);
    $chkSms = _getParam('chkSms', $user['thong_bao']['sms']);
    $chkEmail = _getParam('chkEmail', $user['thong_bao']['email']);

    if(!empty($email)){
        $checkUniqueEmail = $userCl->findOne(array('_id'=>array('$ne'=>$_SESSION['uinfo']['_id']), 'email'=>$email));
        if($checkUniqueEmail){
            $dtr['mss'] = 'Email này đã được sử dụng.';
            echo json_encode($dtr);exit();
        }
    }
    if(!empty($birthday)){
        if(!DateTime::createFromFormat('d/m/Y', $birthday)){
            $dtr['mss'] = 'Ngày sinh không hợp lệ.';
            echo json_encode($dtr);exit();
        }
    }
    if(!empty($cmnd_ngaycap)){
        if(!DateTime::createFromFormat('d/m/Y', $cmnd_ngaycap)){
            $dtr['mss'] = 'Ngày cấp CMND không hợp lệ.';
            echo json_encode($dtr);exit();
        }
    }

    if($chkSms == 1)
        Network::DKSMS($_SESSION['uinfo']['phone']);
    else
        Network::TCSMS($_SESSION['uinfo']['phone']);
    $checkTCSMS = Network::checkTCSMS($_SESSION['uinfo']['phone']);

    $userCl->update(array('_id'=> $_SESSION['uinfo']['_id']), array('$set'=>array(
            'fullname' => $fullname,
            'birthday' =>$birthday,
            'cmnd' => $cmnd,
            'cmnd_ngaycap' => $cmnd_ngaycap,
            'cmnd_noicap' => $cmnd_noicap,
            'displayname' => $displayname,
            'email' => $email,
            'thong_bao' => array(
                    'noti' => strval($chkNoti),
                    'sms' => $checkTCSMS == 0 ? '1' : '0',
                    'email' => strval($chkEmail),
            ))
    ));

    //thiết lập lại thông tin
    $o = $userCl->findOne(array('_id'=>$_SESSION['uinfo']['_id']),  array('_id', 'phone', 'thong_bao', 'fullname', 'birthday', 'cmnd', 'cmnd_ngaycap', 'cmnd_noicap', 'displayname', 'email', 'priavatar'));
    $o['displayname'] = getFullDisplayName($o);
    $o['priavatar'] = isset($o['priavatar']) && !empty($o['priavatar']) ? Common::getWebImageLink($o['priavatar']) : '';
    $o['cmnd'] = isset($o['cmnd']) ? $o['cmnd'] : '';
    $o['cmnd_ngaycap'] = isset($o['cmnd_ngaycap']) ? $o['cmnd_ngaycap'] :'';
    $o['cmnd_noicap'] = isset($o['cmnd_noicap']) ? $o['cmnd_noicap'] :'';
    $o['birthday'] = isset($o['birthday']) ? $o['birthday'] :'';
    $o['email'] = isset($o['email']) ? $o['email'] : '';

    unset ($o['password']);
    unset ($o['namenoneutf']);
    unset ($o['datecreate']);
    unset ($o['priority']);
    unset ($o['status']);
    unset ($o['sendsmscount']);
    unset ($o['is_active']);
    unset ($o['role']);
    unset ($o['file_upload']);
    unset ($o['permission']);
    unset ($o['dob']);
    unset ($o['un_password']);

    $_SESSION['uinfo'] = $o;
    $dtr['data'] = $_SESSION['uinfo'];

    $dtr['status'] = 200;
    $dtr['mss'] = 'Cập nhật thông tin cá nhân thành công.';

    ##log
    $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_EDIT_PROFILE,
            'chanel' => HistoryLog::CHANEL_APP,
            'ip' => Network::ip(),
            'uid' => $_SESSION['uinfo']['_id'],
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => $_SESSION['uinfo']['phone'],
            'price'=> 0
    );
    $historycl->insert($newHistoryLog);
    echo json_encode($dtr);exit();
}

//Đổi mật khẩu
function changePass(){
    global $dbmg;
    $userCl = $dbmg->user;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $old_pass = _getParam('old_pass');
    $new_pass = _getParam('new_pass');
    if(empty($old_pass) || empty($new_pass)){
        $dtr['mss'] = 'Bạn cần nhập đầy đủ mật khẩu cũ và mật khẩu mới.';
        echo json_encode($dtr);exit();
    }

    $user = $userCl->findOne(array('_id'=> $_SESSION['uinfo']['_id']));
    if($user['password'] != Common::encryptpassword($old_pass)){
        $dtr['mss'] = 'Mật khẩu cũ không đúng.';
        echo json_encode($dtr);exit();
    }

    $userCl->update(array('_id'=> $_SESSION['uinfo']['_id']), array('$set'=>array(
            'password' => Common::encryptpassword($new_pass),
            'un_password' => $new_pass
        )
    ));

    $dtr['status'] = 200;
    $dtr['mss'] = 'Thay đổi mật khẩu thành công.';
    echo json_encode($dtr);exit();
}

function deleteAudio(){
    global $dbmg;
    $uploadCl = $dbmg->upload;
    $dtr['status'] = 500;
    $id = strval(_getParam('id'));
    if(empty($id)){
        $dtr['mss'] = 'Cần truyền id bản thu.';
        echo json_encode($dtr);exit();
    }
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }
    $item = $uploadCl->findOne(array('_id'=>$id));
    if(!$item){
        $dtr['mss'] = 'Bản thu không tồn tại.';
        echo json_encode($dtr);exit();
    }
    if($item['uid'] != $_SESSION['uinfo']['_id']){
        $dtr['mss'] = 'Bạn không được phép xóa bản thu này.';
        echo json_encode($dtr);exit();
    }
    $uploadCl->remove(array('_id'=>$id));
    $dtr['status'] = 200;
    $dtr['mss'] = 'Xóa bản thu thành công';
    echo json_encode($dtr);exit();
}

//Upload audio bài hát tiếng Anh
function uploadAudio(){
    global $dbmg;
    $uploadCl = $dbmg->upload;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $id = _getParam('id');
    if(empty($id)){
        $dtr['mss'] = 'Cần nhập ID bài hát tiếng anh.';
        echo json_encode($dtr);exit();
    }

    $dtr['status'] = 200;
    $targetFolder = "/uploads/".date("d-m-Y")."/";
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    $folder_name = '/';
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
    $targetPath = $_SERVER['DOCUMENT_ROOT'].str_replace("../","",$targetFolder . $folder_name);
    if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);
    $file_name = preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['Filedata']['name']);
    $file_name =  str_replace(" ","_",strtotime("now")."_".$file_name);
    $targetFile = str_replace("//","/",$targetPath) . $file_name;
    $rs = move_uploaded_file($tempFile,$targetFile);
    if($rs){
        $file_path = $targetFolder.$folder_name.$file_name;
        $file_path = str_replace("//","/",$file_path);
        $image = $file_path;
        $dtr['status'] = 200;
        $dtr['mss'] = "Upload thành công";


        $newUpload = array(
            '_id' => strval(time()),
            'uid' => $_SESSION['uinfo']['_id'],
            'path' => $file_path,
            'type' => Constant::TYPE_SONG,
            'datecreate' => time(),
            'itemid' => $id
        );
        $uploadCl->insert($newUpload);
        $dtr['file'] = array(
                '_id' => $newUpload['_id'],
                "filename"=>"$file_name",
                "path"=>Common::getWebImageLink($file_path),
        );
    }else{
        $dtr['status'] = 500;
        $dtr['mss'] = "Không thể upload file: $targetFile";
    }
    echo json_encode($dtr);exit;
}

//Upload Avatar
function uploadAvatar(){
    global $dbmg;
    $userCl = $dbmg->user;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }

    $targetFolder = "/uploads/".date("d-m-Y")."/";
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    if(!in_array($fileParts['extension'],array('jpg','jpeg','gif','png'))){
        $dtr['status'] = 500;
        $dtr['mss'] = "Chỉ được upload file ảnh.";
        echo json_encode($dtr);exit;
    }

    $folder_name = '/';
    $targetPath = $_SERVER['DOCUMENT_ROOT'].str_replace("../","",$targetFolder . $folder_name);
    if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);
    $file_name =  str_replace(" ","_",strtotime("now")."_".$_FILES['Filedata']['name']);
    $targetFile = str_replace("//","/",$targetPath) . $file_name;
    $rs = move_uploaded_file($tempFile,$targetFile);
    if($rs){
        $file_path = $targetFolder.$folder_name.$file_name;
        $file_path = str_replace("//","/",$file_path);
        $image = $file_path;
        $dtr['status'] = 200;
        $dtr['mss'] = "Upload thành công";
        $dtr['file'] = array(
            "filename"=>"$file_name",
            "path"=>Common::getWebImageLink($file_path),
        );
        $userCl->update(array('_id'=>$_SESSION['uinfo']['_id']), array('$set'=> array('priavatar'=>$file_path)));
    }else{
        $dtr['status'] = 500;
        $dtr['mss'] = "Không thể upload file: $targetFile";
    }
    echo json_encode($dtr);exit;
}

function forgetPass(){
    global $dbmg;
    $userCl = $dbmg->user;
    $dtr['status'] = 500;
    $phone = isset($_GET['phone']) ? $_GET['phone'] : '';
    if(empty($phone)){
        $dtr['mss'] = 'Bạn chưa nhập số điện thoại.';
        echo json_encode($dtr);exit();
    }
    if(!Network::mobifoneNumber($phone)){
        $dtr['mss'] = 'Vui lòng nhập số điện thoại MobiFone.';
        echo json_encode($dtr);exit();
    }
    $user = $userCl->findOne(array('phone' => $phone));
    if(!$user){
        $dtr['mss'] = 'Số điện thoại này chưa đăng ký tài khoản.';
        echo json_encode($dtr);exit();
    }
    $sendPassCount = isset($user['send_pass']['count']) ? $user['send_pass']['count'] : 0;
    $sendPassTime = isset($user['send_pass']['time']) ? $user['send_pass']['time'] : time();
    if(time() - $sendPassTime > 60*60){
        $sendPassCount = 0;
    }
    if($sendPassCount >= 5){
        $dtr['mss'] = 'Quý khách đã lấy mật khẩu 5 lần. Vui lòng chờ sau 60 phút để lấy lại mật khẩu.';
        echo json_encode($dtr);exit;
    }
    $password = isset($user['un_password']) ? $user['un_password'] : $user['password'];
    $mss = 'Mật khẩu để sử dụng dịch vụ English360 của Quý khách là:'.$password;
    $result = Network::sentMT($phone, 'MK', $mss);
    if($result != 0){
        $dtr['mss'] = 'Không thể gửi tin nhắn đến số điện thoại của bạn, vui lòng thử lại sau.';
        echo json_encode($dtr);exit();
    }
    $userCl->update(array('phone' => $phone), array('$set'=>array('send_pass'=>array('count'=>$sendPassCount + 1, 'time'=>time()))));
    $dtr['mss'] = 'Mật khẩu đã được gửi về số điện thoại của bạn. Vui lòng kiểm tra lại.';
    $dtr['status'] = 200;
    echo json_encode($dtr);exit();
}

function is3gmobilephone(){
    global $dbmg;
    $userCl = $dbmg->user;
    $dtr['status'] = 500;
    if (Network::is3gmobifone() == 1 && Network::is3g()) {
        $phone = Network::is3g();
        $o = $userCl->findOne(['phone' => $phone]);
        if (!$o){
            $password = Common::generateRandomPassword();
            $newUser = array(
                    '_id' => strval(time()),
                    'phone' => $phone,
                    'un_password' => $password,
                    'password' => Common::encryptpassword($password),
                    'datecreate' => time(),
                    'email' => '',
                    'priavatar' => '',
                    'birthday' => '',
                    'cmnd' => '',
                    'cmnd_ngaycap' => '',
                    'cmnd_noicap' => '',
                    'status'=>Constant::STATUS_ENABLE,
                    'displayname' => '',
                    'thong_bao' => array(
                        'noti' => "1",
                        'sms' => '1',
                        'email' => '1',
                    )
            );
            $userCl->insert($newUser);
        }
        $o = $userCl->findOne(['phone' => $phone]);
        $o['displayname'] = getFullDisplayName($o);
        $o['priavatar'] = isset($o['priavatar']) && !empty($o['priavatar']) ? Common::getWebImageLink($o['priavatar']) : '';
        $o['cmnd'] = isset($o['cmnd']) ? $o['cmnd'] : '';
        $o['cmnd_ngaycap'] = isset($o['cmnd_ngaycap']) ? $o['cmnd_ngaycap'] :'';
        $o['cmnd_noicap'] = isset($o['cmnd_noicap']) ? $o['cmnd_noicap'] :'';
        $o['birthday'] = isset($o['birthday']) ? $o['birthday'] :'';
        $o['email'] = isset($o['email']) ? $o['email'] : '';
//        $checkTCSMS = Network::checkTCSMS($phone);
        $o['thong_bao'] = array(
            'noti' => $o['thong_bao']['noti'],
            'sms' => '0',
            'email' => $o['thong_bao']['email']
        );

        unset ($o['password']);
        unset ($o['namenoneutf']);
        unset ($o['datecreate']);
        unset ($o['priority']);
        unset ($o['status']);
        unset ($o['sendsmscount']);
        unset ($o['is_active']);
        unset ($o['role']);
        unset ($o['file_upload']);
        unset ($o['permission']);
        unset ($o['dob']);
        unset ($o['un_password']);
        $_SESSION['uinfo'] = $o;
        $dtr['mss'] = "Đăng nhập thành công";
        $dtr['data'] = $_SESSION['uinfo'];
        $dtr['status'] = 200;
        $dtr['ssid'] = session_id();

    } else {
        $dtr['data'] = "Không sử dụng 3g.";
    }
    echo json_encode($dtr);
    exit();
}

function registerPackage(){
    global $dbmg;
    $historycl = $dbmg->history_log;
    $dtr['status'] = 500;
    $code = _getParam('code', 'E');
    if(!Network::OPEN_REG){
        $dtr['mss'] = 'Để đăng ký bạn vui lòng soạn tin DK '.$code.' gửi 9317. (Cước phí: 2.000đ/ngày, tự động gia hạn)';
        echo json_encode($dtr);
        exit();
    }
    //Trường hợp dùng 3g
    if (Network::is3g() && Network::is3gmobifone() == 1) {
        $phone = Network::is3g();
        $checkPackage = Network::getUserInfo($phone,'E',$_SESSION['uinfo']['_id']);
        $link_vms = '';
        if ($checkPackage != 1) {
            $link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&APP');
            $link_vms = Network::genLinkConfirmAppVms($code, $link_callback);
            $dtr['status'] = 200;
            $dtr['link_vms'] = $link_vms;
//            $dtr['']
            $dtr['redirect_vms'] = "<script>location.href = '".$link_vms."'</script>";
//                echo '<a href="'.$link_vms.'">LINK</a>';exit;
        }else{
            $dtr['mss'] = 'Quý khách hiện đang sử dụng dịch vụ English360.';
        }
        echo json_encode($dtr);
        exit();
    }

    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }
    $phone = $_SESSION['uinfo']['phone'];
    $checkPackage = Network::getUserInfo($phone,'E',$_SESSION['uinfo']['_id']);
    if($checkPackage == 1){
        $dtr['mss'] = 'Quý khách hiện đang sử dụng dịch vụ English360.';
        if(Common::isHssvUser($_SESSION['uinfo']['_id']))
            $dtr['mss'] = 'Quý khách hiện đang tham gia chương trình English360 đồng hành cùng học sinh – sinh viên.';
        echo json_encode($dtr);exit();
    }
    $result = Network::registedpack($phone, 'APP', $code);
    if($result != 0){
        $dtr['mss'] = 'Quá trình đăng ký thất bại, mời quý khách thử lại.';
        echo json_encode($dtr);exit();
    }
    $dtr['status'] = 200;
    $dtr['mss'] = 'Quý khách đã đăng ký thành công dịch vụ English360. Chi tiết liên hệ '.Constant::SUPPORT_PHONE.'. Trân trọng cảm ơn!';
    ##log
    $packageInfo = Network::getCancelInfo($phone);
    $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
            'chanel' => HistoryLog::CHANEL_APP,
            'ip' => Network::ip(),
            'uid' => $_SESSION['uinfo']['_id'],
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => $_SESSION['uinfo']['phone'],
            'price'=> $packageInfo == 0 ? 0 : Network::getPackageItem()['E']['price']
    );
    $historycl->insert($newHistoryLog);
    echo json_encode($dtr);exit();
}

function cancelPackage(){
    global $dbmg;
    $historycl = $dbmg->history_log;
    $usercl =$dbmg->user;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }
    $phone = $_SESSION['uinfo']['phone'];
    if(Common::isHssvUser($_SESSION['uinfo']['_id'])){
        $usercl->update(array('_id' => $_SESSION['uinfo']['_id']), array('$set'=>array('event'=>'')));
        $dtr['mss'] = 'Bạn đã hủy thành công dịch vụ English360, để đăng ký lại dịch vụ xin vui lòng chọn Đăng ký hoặc soạn DK E gửi 9317. Chi tiết liên hệ '.Constant::SUPPORT_PHONE.'. Trân trọng cảm ơn!';
        $dtr['status'] = 200;
        echo json_encode($dtr);exit();
    }
    $checkPackage = Network::getUserInfo($phone);
    if($checkPackage != 1){
        $dtr['mss'] = 'Quý khách hiện chưa đăng ký dịch vụ English360.';
        echo json_encode($dtr);exit();
    }
    $result = Network::cancelpack($phone, 'APP');
    if($result != 0){
        $dtr['mss'] = 'Quá trình hủy thất bại, mời quý khách thử lại.';
        echo json_encode($dtr);exit();
    }
    $dtr['status'] = 200;
    $dtr['mss'] = 'Bạn đã hủy thành công dịch vụ English360, để đăng ký lại dịch vụ xin vui lòng chọn Đăng ký hoặc soạn DK E gửi 9317. Chi tiết liên hệ '.Constant::SUPPORT_PHONE.'. Trân trọng cảm ơn!';
    ##log
    $newHistoryLog = array(
        '_id' => strval(time().rand(10,99)),
        'datecreate' => time(),
        'action' => HistoryLog::LOG_HUY_GOI_CUOC,
        'chanel' => HistoryLog::CHANEL_APP,
        'ip' => Network::ip(),
        'uid' => $_SESSION['uinfo']['_id'],
        'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
        'status' => Constant::STATUS_ENABLE,
        'phone' => $_SESSION['uinfo']['phone'],
        'price'=> 0
    );
    $historycl->insert($newHistoryLog);
    echo json_encode($dtr);exit();
}

function checkPackage(){
    $dtr['status'] = 500;
    $dtr['data'] = array();
    $dtr['description'] = '<p>Hãy đăng ký dịch vụ để học tiếng anh mỗi ngày với English360</p>
                                <p>- Dịch vụ miễn phí 3G/GPRS</p>
                                <p>- Sử dụng tất cả các tính năng của English360</p>
                                <p>- Miễn phí 1 ngày sử dụng</p>';
    $dtr['registed'] = 0;
    if (Network::is3g() && Network::is3gmobifone() == 1) {
        $phone = Network::is3g();
//        $checkPackage = Network::getUserInfo($phone, $pack);
        $dtr['status'] = 200;
        foreach(Network::getPackageItem() as $key=>$aPkg){
            $checkPackage = Network::getUserInfo($phone, $key,$_SESSION['uinfo']['_id']);
            $dtr['data'][] = array(
                'code' => $key,
                'name' => 'Gói English360 '.$aPkg['info'],
                'price' => $aPkg['price'].'đ/'.$aPkg['info'],
                'registed' => $checkPackage == 1 ? 1 : 0
            );
            if($checkPackage == 1) {
                $dtr['registed'] = 1;
                $dtr['description'] = 'Bạn đã đăng ký gói '.$key.' '.$aPkg['price'].'đ/'.$aPkg['info'].' từ dịch vụ English360. Bạn được xem không giới hạn các nội dung bài học. Dịch vụ miễn phí 3G/GPRS';
            };
        }
//        $dtr['data'] = $checkPackage == 1 ? 1 : 0;
//        $dtr['mss'] = $checkPackage == 1 ? 'Bạn đang sử dụng gói cước '.$pack.'.' : 'Bạn chưa đăng ký gói cước '.$pack.'.';
//        $dtr['price'] = 1000;
        if(Common::isFreeUser($phone)){
            $dtr['description'] = '<p>Bạn đã nhận được học bổng của English360, khóa học hoàn toàn miễn phí trong 15 ngày.</p>
                                    <p>Chúc bạn có khoảng thời gian học tập thú vị cùng English360.</p>';
        }
        if(Common::isHssvUser($_SESSION['uinfo']['_id'])) {
            $dtr['description'] = 'Chúc mừng Quý khách đã đăng ký tham gia chương trình English360 đồng hành cùng học sinh – sinh viên. MIỄN PHÍ 30 ngày trải nghiệm. Hết thời gian khuyến mãi, dịch vụ sẽ tự động huỷ.';
        }
//        $dtr['description'] .= '<style>p{font-family: Arial}</style>';
        echo json_encode($dtr);
        exit();
    }
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }
    $phone = $_SESSION['uinfo']['phone'];
//    $checkPackage = Network::getUserInfo($phone, $pack);
    $dtr['status'] = 200;
    foreach(Network::getPackageItem() as $key=>$aPkg){
        $checkPackage = Network::getUserInfo($phone, $key, $phone = $_SESSION['uinfo']['_id']);
        $dtr['data'][] = array(
            'code' => $key,
            'name' => 'Gói English360 '.$aPkg['info'],
            'price' => $aPkg['price'].'đ/'.$aPkg['info'],
            'registed' => $checkPackage == 1 ? 1 : 0
        );
        if($checkPackage == 1){
            if(Common::isHssvUser($_SESSION['uinfo']['_id'])){
                $dtr['description'] = 'Chúc mừng Quý khách đã đăng ký tham gia chương trình English360 đồng hành cùng học sinh – sinh viên. MIỄN PHÍ 30 ngày trải nghiệm. Hết thời gian khuyến mãi, dịch vụ sẽ tự động huỷ.';
            }else
                $dtr['description'] = 'Bạn đã đăng ký gói '.$key.' '.$aPkg['price'].'đ/'.$aPkg['info'].' từ dịch vụ English360. Bạn được xem không giới hạn các nội dung bài học. Dịch vụ miễn phí 3G/GPRS';
            $dtr['registed'] = 1;
        }
    }
    if(Common::isFreeUser($phone)){
        $dtr['description'] = '<p>Bạn đã nhận được học bổng của English360, khóa học hoàn toàn miễn phí trong 15 ngày.</p>
                                    <p>Chúc bạn có khoảng thời gian học tập thú vị cùng English360.</p>';
    }
//    $dtr['data'] = $checkPackage == 1 ? 1 : 0;
//    $dtr['mss'] = $checkPackage == 1 ? 'Bạn đang sử dụng gói cước '.$pack.'.' : 'Bạn chưa đăng ký gói cước '.$pack.'.';
//    $dtr['price'] = 1000;

//    $dtr['description'] .= '<style>p{font-family: Arial}</style>';
    echo json_encode($dtr);exit();
}

function sendAuthKey(){
    global $dbmg;
    $authkeyCl = $dbmg->auth_key;
    $dtr['status'] = 500;
    $phone = _getParam('phone');
    if(empty($phone)){
        $dtr['mss'] = 'Số điện thoại không để trống.';
        echo json_encode($dtr);exit();
    }
    if(!Network::mobifoneNumber($phone)){
        $dtr['mss'] = 'Yêu cầu nhập số điện thoại MobiFone.';
        echo json_encode($dtr);exit();
    }

    $authKey = $authkeyCl->findOne(array('phone' => $phone));
    if(!$authKey){
        $newAuthkey = array(
            'phone' => $phone,
            'count' => 0,
            'key' => null,
            'time' => time()
        );
        $authkeyCl->insert($newAuthkey);
    }elseif(time()- $authKey['time'] >= 60*60){
        $authkeyCl->update(array('phone' => $phone), array('$set'=>array('key'=>null, 'count'=>0)));
    }

    $authKey = $authkeyCl->findOne(array('phone' => $phone));
    if($authKey['count'] > 5){
        $dtr['mss'] = 'Bạn đã lấy mã xác thực quá 5 lần cho phép. Vui lòng đợi sau 60 phút để lấy lại mã xác thực.';
        echo json_encode($dtr);exit();
    }
    $authkeyCl->update(array('phone' => $phone), array('$set'=> array('count'=> $authKey['count']+1)));
    $expired = 2*60;
    $checkAuthKeyExpired = !isset($authKey['key']) || ((time() - $authKey['time']) > $expired);
    if ($checkAuthKeyExpired) {
        $authkeyCl->update(array('phone' => $phone), array('$set'=>array('key'=>rand(100000, 999999), 'time'=>time())));
        $authKey = $authkeyCl->findOne(array('phone' => $phone));
    }
    $key = $authKey['key'];
    $info = 'Mã xác thực dịch vụ English360 của bạn là: '.$key;
    $resultSMS = Network::sentMT($phone,'OTP', $info);
    if($resultSMS != 0){
        $dtr['mss'] = 'Không thể gửi tin nhắn đến số điện thoại của bạn. Vui lòng thử lại sau.';
        echo json_encode($dtr);
        exit();
    }
    $dtr['status'] = 200;
    $dtr['message'] = 'Mã xác thực đã được gửi về số điện thoại của Quý khách.';
    echo json_encode($dtr);
    exit();
}

function checkAuthKey(){
    global $dbmg;
    $authkeyCl = $dbmg->auth_key;
    $dtr['status'] = 500;
    $phone = _getParam('phone');
    $key = _getParam('auth_key');
    if(empty($phone)){
        $dtr['mss'] = 'Số điện thoại không để trống.';
        echo json_encode($dtr);exit();
    }

    $auth = $authkeyCl->findOne(array("phone"=>$phone));
    $expired = 2*60;
    $checkAuthKeyExpired = !isset($auth['key']) || ((time() - $auth['time']) > $expired);
    if ($checkAuthKeyExpired) {
        $dtr['mss'] = 'Mã xác thực đã hết hạn. Vui lòng click Lấy lại mã xác thực.';
        echo json_encode($dtr);
        exit();
    }
    if($auth['key'] != $key){
        $dtr['mss'] = 'Mã xác thực không đúng.';
        echo json_encode($dtr);
        exit();
    }
    $authkeyCl->update(array('phone'=>$phone, array('$set'=>array('count'=>0))));

    $dtr['status'] = 200;
    $dtr['mss'] = 'Mã xác thực chính xác.';
    echo json_encode($dtr);exit;
}

//Câu hỏi của tôi
function myQuestion(){
    global $dbmg;
    $faqCl = $dbmg->faq;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }
    $page = _getParam('page', 1);
    $limit = _getParam('limit', 10);
    $start = ($page - 1)*$limit;
    $cond = array('usercreate'=> $_SESSION['uinfo']['_id'], 'parentid'=>'0');
    $myQuestion = iterator_to_array($faqCl->find($cond, array('_id','content','datecreate'))->sort(array('datecreate'=>-1))->skip($start)->limit($limit), false);
    foreach($myQuestion as $key=>$val){
        $myQuestion[$key]['datecreate'] = date('d/m/Y H:i',$val['datecreate']);
        $myQuestion[$key]['content'] = html_entity_decode($val['content']);
    }
    $totalpage = ceil($faqCl->count($cond) / $limit);
    $dtr['status'] = 200;
    $dtr['data'] = $myQuestion;
    $dtr['totalpage'] = $totalpage;
    echo json_encode($dtr);exit;
}

function delMyQuestion(){
    global $dbmg;
    $faqCl = $dbmg->faq;
    $dtr['status'] = 500;
    if(!_checkLogin()){
        $dtr['mss'] = 'Bạn cần đăng nhập để thực hiện chức năng này.';
        echo json_encode($dtr);exit();
    }
    $id = _getParam('id');
    if(empty($id)){
        $dtr['mss'] = 'Chưa nhập ID câu hỏi.';
        echo json_encode($dtr);exit();
    }
    $item = $faqCl->findOne(array('usercreate' => $_SESSION['uinfo']['_id'], '_id' => $id));
    if(!$item){
        $dtr['mss'] = 'Câu hỏi không tồn tại.';
        echo json_encode($dtr);exit();
    }

    $faqCl->remove(array('_id'=>$id));
    $dtr['status'] = 200;
    $dtr['mss'] = 'Xóa thành công.';
    echo json_encode($dtr);exit();
}

//Danh mục trò chơi
function gameCategory(){
    global $dbmg;
    $categoryCl = $dbmg->category;
    $dtr['status'] = 200;
    $hmcParent = $categoryCl->findOne(array('parentid'=> array('$in'=> array('0',0)), 'type'=>Constant::TYPE_HOCMACHOI));
    $allTopic = iterator_to_array($categoryCl->find(array('parentid'=>$hmcParent['_id'])), false);
    $dtr['data'] = $allTopic;
    echo json_encode($dtr);exit;
}

//Bảng xếp hạng
function gameRank(){
    global $dbmg;
    $pointCl = $dbmg->game_point;
    $rank = iterator_to_array($pointCl->find()->sort(array('point'=>-1))->limit(10), false);
    foreach($rank as $key=>$aRank){
        $dtr['data'][$key] = array(
            'rank' => $key+1,
            'name' => _getDisplayName($aRank['uid']),
            'point' => $aRank['point']
        );
    }
    $me = false;
    if(_checkLogin()){
        $me = $pointCl->findOne(array('uid'=> $_SESSION['uinfo']['_id']));
    }
    $dtr['me'] = $me ? $me['point'] : 0;
    $dtr['status'] = 200;
    echo json_encode($dtr);exit;
}

function getPage(){
    global $dbmg;
    $pageCl = $dbmg->page;
    $slug = _getParam('slug');
    switch($slug){
        case "gioi-thieu":
            $type = Constant::TYPE_INFO;
            $name = 'Giới thiệu';
            break;
        case "dieu-khoan":
            $type = Constant::TYPE_TERM;
            $name = 'Điều khoản';
            break;
        default:
            $type = Constant::TYPE_CONTACT;
            $name = 'Liên hệ';
            break;
    }
    $dtr['status'] = 200;
    $dtr['data'] = $pageCl->findOne(array('status'=>Constant::STATUS_ENABLE, 'type'=>$type), array('_id','content','datecreate', 'captions'));
    $dtr['data']['name'] = $name;
    $dtr['data']['datecreate'] = date('d/m/Y H:i', $dtr['data']['datecreate']);
    $dtr['data']['content'] = str_replace('../', Constant::BASE_URL.'/', $dtr['data']['content']);
    echo json_encode($dtr);exit;

}

function loadTratu(){
    global $dbmg;
    $dict = _getParam('dict', 'av');
    $word = strtolower(_getParam('word'));
    $limit = _getParam('limit', 10);

    switch($dict){
        case 'av':
            $dictCl = $dbmg->anh_viet;
            break;
        default:
            $dictCl = $dbmg->viet_anh;
            break;
    }

    $regexWord = new MongoRegex('/^'.$word.'/ui');

    $result = iterator_to_array($dictCl->find(array('word'=>$regexWord), array('word', 'id'))->limit($limit), false);
    foreach($result as $key=>$val){
        unset($result[$key]['_id']);
    }
    $dtr['status'] = 200;
    $dtr['data'] = $result;
    echo json_encode($dtr);exit();
}

function tratu(){
    global $dbmg;
    $dict = _getParam('dict', 'av');
    $word = strtolower(_getParam('word'));
    $id = _getParam('id');

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
    if($result){
        $dtr['status'] = 200;
        $dtr['data'] = array(
            'word' => $result['word'],
            'content' => $result['content']
        );
    }else{
        $dtr['mss'] = 'Không tìm thấy từ này.';
    }

    echo json_encode($dtr);exit();
}


?>