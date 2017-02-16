<?php
$nguamcl = $dbmg->luyennguam;
$btnguamcl = $dbmg->luyennguam_baitap;
$id= $_GET['id'];
$type = $_GET['type'];
$obj = (array)$nguamcl->findOne(array("_id"=>$id));
$baitapobj = (array)$btnguamcl->findOne(array("lnaid"=>$id,"type"=>$type));

foreach($baitapobj['question'] as $key=>$val){


    $baitapobj['question'][$key]['short'] = str_replace('_','<input style="width:20px" class="dt" type="text" placeholder="" maxlength="1">',$val['short']);
    $baitapobj['question'][$key]['audio'] = $val['audio'];
    $baitapobj['question'][$key]['aw'] = $val['aw'];
print_r($baitapobj[$key]['short']);
}

$tpl->assign("obj",$baitapobj);
$tpl->assign("key",$key);
$tpl->assign("pagefile","luyennguam/luyentap1");
include "controller/hmc/index.php";
?>