<?php
$gtcbcl = $dbmg->gtcb;
$gtcbln = $dbmg->gtcb_luyennghe;
$id = $_GET['id'];
$obj = (array)$gtcbcl->findOne(array("_id"=>$id));
// Nếu là câu hỏi đầu tiên. (Không có Get next ID)
if(!isset($_GET['nextid'])) $question = iterator_to_array($gtcbln->find(array("gtcbid"=>$id))->sort(array("sort"=>1))->limit(1),false);
else $question = iterator_to_array($gtcbln->find(array("_id"=>$_GET['nextid']))->sort(array("sort"=>1))->limit(1),false);
foreach($question as $key=>$item){
    $question[$key]['datecreate'] = date('d/m/y, h:s',$item['datecreate']);
}

if(count($question)>0) $question = $question[0];
else $question = array();
$xx=$question['type'];
$nowshort = $question['sort']; // Lấy vị trí của câu hỏi hiện tại
$nextquestion = iterator_to_array($gtcbln->find(array("gtcbid"=>$id,"sort"=>array('$gt'=>$nowshort)))->sort(array("sort"=>1))->limit(1),false);

if(count($nextquestion)>0) $nextquestion = $nextquestion[0];
else $nextquestion = array();
$tpl->assign("obj",$obj);
$tpl->assign("question",$question);
//var_dump($nextquestion);die;
$tpl->assign("nextquestion",$nextquestion);
$tpl->assign("xx",$xx);
$tpl->assign("POST",$_POST);
$tpl->assign("pagefile","gtcb/listen");
include "controller/hmc/index.php";
?>