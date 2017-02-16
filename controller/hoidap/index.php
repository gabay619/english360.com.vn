<?php
$faqcl = $dbmg->faq;
$usercl = $dbmg->user;
$historycl = $dbmg->history_log;
$notifyCl = $dbmg->notify;
$ui = $_SESSION['uinfo'];
$id = $_GET['id'];
$limit = 4;
$p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
if(!isset($id)){
    if(isset($_POST['submit'])){
        include '/checkPackage.php';
        $contentfaq = $_POST['content'];
        $newFaq = array(
            '_id' => strval(time()),
            'parentid' => '0',
            'content' => strip_tags($contentfaq),
            'status' => Constant::STATUS_ENABLE,
            'usercreate' => $_SESSION['uinfo']['_id'],
            'datecreate' => time()
        );
        $faqcl->insert($newFaq);
    }
    $cond['status'] = "1";
    $cond['parentid'] = "0";

    $comment = iterator_to_array($faqcl->find($cond,array("_id","usercreate","name","content","parentid","datecreate", "like"))->sort(array("_id"=>-1))->limit(20),false);

    foreach($comment as $key=>$item){
        $comment[$key]['datecreate'] = date("d-m-Y H:i",$item['datecreate']);
        $comment[$key]["userinfo"] = (array)$usercl->findOne(array("_id"=>$item["usercreate"]), array("_id","displayname", "phone","priavatar"));
        $comment[$key]['countlike'] = isset($item['like']) ? count($item['like']) : 0;
        $comment[$key]['islike'] = isset($_SESSION['uinfo']) ? (isset($item['like']) ? in_array($_SESSION['uinfo']['_id'], $item['like']) : false) : false;
    }

    $tpl->assign("comment",$comment);

    $tpl->assign("faq",$faq);
    $tpl->assign("pagefile","hoidap/index");
}else{
    $obj = $faqcl->findOne(array('_id'=>$id));
    $obj['datecreate'] = date('d/m/Y H:i', $obj['datecreate']);
    $obj['userinfo'] = $usercl->findOne(array('_id'=>$obj['usercreate']), array('phone', 'displayname','priavatar'));

    if(isset($_POST['submit'])){
        include '/checkPackage.php';
        $contentfaq = $_POST['content'];

        $newFaq = array(
            '_id' => strval(time()),
            'parentid' => $id,
            'content' => strip_tags($contentfaq),
            'status' => Constant::STATUS_ENABLE,
            'usercreate' => $_SESSION['uinfo']['_id'],
            'datecreate' => time()
        );
        $faqcl->insert($newFaq);
        //Gửi thông báo
        $parentUser = $usercl->findOne(array('_id'=>$obj['usercreate']));
        if($parentUser && $obj['usercreate'] != $_SESSION['uinfo']['_id']){
            $newNotify = array(
                    '_id' => strval(time()),
                    'uid' => $obj['usercreate'],
                    'usercreate' => $_SESSION['uinfo']['_id'],
                    'datecreate' => time(),
                    'mss' => getDisplayName($_SESSION['uinfo']). ' đã trả lời Câu hỏi của bạn',
                    'status' => Constant::STATUS_ENABLE,
                    'type' => Constant::TYPE_NOTIFY,
                    'to' => array(
                            'type' => Constant::TYPE_HOIDAP,
                            'id' => $id
                    )
            );
            $notifyCl->insert($newNotify);
            //Gửi email
            if(!empty($parentUser['email']) && $parentUser['thong_bao']['email']==Constant::STATUS_ENABLE){
                $to = $parentUser['email'];
                $user = getDisplayName($_SESSION['uinfo']);
                $time = date('H:i d/m/Y');
                $url = Constant::BASE_URL.'/hoi-dap/chi-tiet.html?id='.$parentid;
                $disable_url = Common::makeLinkDisableEmailNotify($_SESSION['uinfo']['phone'], $_SESSION['uinfo']['password']);
                include $_SERVER['DOCUMENT_ROOT'].'/mail/newAns.php';
                $mail = new \helpers\Mail($to,$subject,$body);
                @$mail->send();
            }
        }
    }

    $cond['status'] = "1";
    $cond['parentid'] = $id;
    $comment = iterator_to_array($faqcl->find($cond,array("_id","name","usercreate","parentid", "content", "datecreate", "like"))->sort(array("_id"=>-1))->skip($cp)->limit($limit),false);

    foreach($comment as $key=> $item) {
        $comment[$key]['datecreate'] = date("d-m-Y H:i",$item['datecreate']);
        $comment[$key]["userinfo"] = (array)$usercl->findOne(array("_id" => $item["usercreate"]), array("phone", "displayname","priavatar"));
        $comment[$key]['countlike'] = isset($item['like']) ? count($item['like']) : 0;
        $comment[$key]['islike'] = isset($_SESSION['uinfo']) ? (isset($item['like']) ? in_array($_SESSION['uinfo']['_id'], $item['like']) : false) : false;
    }
    $tpl->assign("comment",$comment);
    $tpl->assign("obj",$obj);
    $tpl->assign("pagefile","hoidap/detail");
}
$newHistoryLog = array(
        '_id' => strval(time().rand(10,99)),
        'datecreate' => time(),
        'action' => HistoryLog::LOG_HOI_DAP,
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
include "controller/hmc/index.php";
?>