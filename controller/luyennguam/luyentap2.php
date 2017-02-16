<?php
$nguamcl = $dbmg->luyennguam;
$btnguamcl = $dbmg->luyennguam_baitap;
$id= $_GET['id'];
$type = $_GET['type'];
$obj = (array)$nguamcl->findOne(array("_id"=>$id));
$baitapobj = (array)$btnguamcl->findOne(array("lnaid"=>$id,"type"=>$type));
print_r($baitapobj);
$tpl->assign("obj",$obj);
$tpl->assign("btobj",$baitapobj);
$tpl->assign("key",$key);
$tpl->assign("pagefile","luyennguam/luyentap2");
include "controller/hmc/index.php";
?>