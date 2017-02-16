<?php
$gtcbcl = $dbmg->gtcb;
$gtcbbt = $dbmg->gtcb_baitap;
$id = $_GET['id'];
$type = "gtcb_sapxep";
$obj = (array)$gtcbcl->findOne(array("_id"=>$id));
$sapxep = (array)$gtcbbt->findOne(array("gtcbid"=>$id,"type"=>$type));

foreach($sapxep['aw'] as $key=>$val){
    $listaw[] = array("sort"=>$key+1,"aw"=>$val);
}

$listaw_old = $listaw;

shuffle($listaw);
foreach($listaw_old as $keyold=>$itemold){
   foreach ($listaw as $key=> $item){
       if($itemold["aw"]==$item["aw"]){
           $listaw_new[$keyold]["aw"] = numtoalpha($key);
       }
   }
}
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
$tpl->assign("sx",$listaw);
$tpl->assign("sx_new",$listaw_new);
$tpl->assign("pagefile","gtcb/sapxep");
include "controller/hmc/index.php";
?>