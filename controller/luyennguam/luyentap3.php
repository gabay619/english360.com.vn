<?php
$gtcbcl = $dbmg->luyennguam;
$gtcbbt = $dbmg->luyennguam_baitap;
$id = $_GET['id'];
$type = "lna_tracnghiem";
$obj = (array)$gtcbcl->findOne(array("_id"=>$id));
$question = iterator_to_array($gtcbbt->find(array("lnaid"=>$id,"type"=>$type))->sort(array('sort'=>1)),false);

if(!empty($_POST)){
    $truechoosen = 0;
    foreach($question as $key=>$val) if($_POST["kq_".$val['_id']]==$val['trueaw']) ++$truechoosen;
    $tpl->assign("truechoosen",$truechoosen);
}
else $tpl->assign("truechoosen",0);
//bài học liên quan
$refcond['status'] = "1";
$refcond['_id'] = array('$ne'=>$id);
if(count($obj['category'])>0) $refcond['category'] = $obj['category'][0];
$listref =iterator_to_array($gtcbcl->find($refcond,array("_id","name","avatar","category"))->limit(5),false);
$listnew = iterator_to_array($gtcbcl->find(array("status"=>"1"),array("_id","name","avatar","category"))->limit(5)->sort(array("_id"=>-1)),false);
$tpl->assign("ref", $listref);
$tpl->assign("new", $listnew);
//end Bài học liên quan
$tpl->assign("obj",$obj);
$tpl->assign("question",$question);
$tpl->assign("POST",$_POST);
$tpl->assign("pagefile","gtcb/ex");
include "controller/hmc/index.php";
?>

