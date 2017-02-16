<?php
$faqcl = $dbmg->faq;
$usercl = $dbmg->user;
$ui = $_SESSION['uinfo'];
$id = $_GET['id'];
$uid = $_SESSION['uinfo']['_id'];
$limit = 20;
$p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
$cond['status'] = "1";
$cond['parentid'] = "0";
$cond['usercreate'] = $_SESSION['uinfo']['_id'];

$faq = iterator_to_array($faqcl->find(array("usercreate"=>$uid),array("_id","name","usercreate","parentid"))->sort(array("_id"=>-1))->skip($cp)->limit($limit),false);
/*$faq['userinfo']=array("phone"=>$_SESSION['uinfo']['phone']);*/
foreach($faq as $key=> $item){
    $faq[$key]["userinfo"] = (array)$usercl->findOne(array("_id"=>$item["usercreate"]), array("phone","displayname","username"));
    $faq[$key]["answercount"] = $faqcl->count(array("parentid"=>$item['_id']));
}
if(empty($faq)){
    $error_msg = "Bạn chưa có câu hỏi nào";
}

$tpl->assign("GET", $_GET);
$tpl->assign("error_msg",$error_msg);
$tpl->assign("faq", $faq);
$tpl->assign("pagefile", "user/yourfaq");