<?php
$userCl = $dbmg->user;
$examCl = $dbmg->saveexam;
$gtcbCl = $dbmg->gtcb;
include '/checkLogin.php';

$uid=($_SESSION['uinfo']['_id']);
$listExam = $examCl->findOne(array("uid"=>$uid));
$listExam['time'] = array_reverse($listExam['time']);
foreach(array_reverse($listExam['ex']) as $key=>$aLession){


    $postCl = Common::getClFromType($aLession['type']);
    $postCl = $dbmg->$postCl;
    $post = $postCl->findOne(['_id'=>$aLession['id']]);

    $item[] = array(
        'id' => $post['_id'],
        'name' => $post['name'],
        'avatar' => $post['avatar'],
        'url' => '/'.Common::getUrlFromType($aLession['type']).'?id='.$post['_id'],
        'datecreate' => date('h:s | d/m/Y ',$listExam['time'][$key]),
        'type'=>$aLession['type']
    );

}
if(empty($listExam)){
    $error_msg = "Bạn chưa có câu hỏi nào";
}
$tpl->assign("error_msg",$error_msg);
$tpl->assign("exam", $item);
$tpl->assign("pagefile", "user/saveexam");

include "controller/hmc/index.php";
?>