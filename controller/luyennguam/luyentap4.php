<?php
$nguamcl = $dbmg->luyennguam;
$btnguamcl = $dbmg->luyennguam_baitap;
$id= $_GET['id'];
$type = "lna_phatam";
$obj = (array)$nguamcl->findOne(array("_id"=>$id));
$baitapobj = (array)$btnguamcl->findOne(array("lnaid"=>$id,"type"=>$type));
foreach($baitapobj['question'] as $key=>$val){
    $baitapobj['question'][$key]['word']  = $val['word'];
    $baitapobj['question'][$key]['spelling']  = $val['spelling'];
    $baitapobj['question'][$key]['audio']  = $val['audio'];
}
$tpl->assign("obj",$obj);
$tpl->assign("btobj",$baitapobj);
$tpl->assign("key",$key);
$tpl->assign("pagefile","luyennguam/luyentap4");
include "controller/hmc/index.php";
?>