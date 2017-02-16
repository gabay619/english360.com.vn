<?php
$gtcbcl = $dbmg->gtcb;
$gtcbbt = $dbmg->gtcb_baitap;
$id = $_GET['id'];
$type = "gtcb_dientu";
$obj = (array)$gtcbcl->findOne(array("_id"=>$id));
// Nếu là câu hỏi đầu tiên. (Không có Get next ID)
if(!isset($_GET['nextid'])) $question = iterator_to_array($gtcbbt->find(array("gtcbid"=>$id,"type"=>$type))->sort(array("sort"=>1))->limit(1),false);
else $question = iterator_to_array($gtcbbt->find(array("_id"=>$_GET['nextid']))->sort(array("sort"=>1))->limit(1),false);

if(count($question)>0) $question = $question[0];
else $question = array();
$nowshort = $question['sort']; // Lấy vị trí của câu hỏi hiện tại
$nextquestion = iterator_to_array($gtcbbt->find(array("gtcbid"=>$id,"type"=>"gtcb_dientu","sort"=>array('$gt'=>$nowshort)))->sort(array("sort"=>1))->limit(1),false);
if(count($nextquestion)>0) $nextquestion = $nextquestion[0];
else $nextquestion = array();
$tpl->assign("obj",$obj);
$tpl->assign("question",$question);
$tpl->assign("nextquestion",$nextquestion);
$tpl->assign("POST",$_POST);
$tpl->assign("pagefile","gtcb/dientu");
?>