<?php
$gtcbcl = $dbmg->gtcb;
$gtcbbt = $dbmg->gtcb_baitap;
$gtcbln = $dbmg->gtcb_luyennghe;
$id = $_GET['id'];
$obj = (array)$gtcbcl->findOne(array("_id" => $id));
$tracnghiem = iterator_to_array($gtcbbt->find(array('gtcbid'=> $id, 'type' => 'gtcb_tracnghiem')), false);
print_r($tracnghiem);
$dientu = $gtcbbt->findOne(array('gtcbid' => $id, 'type' => 'gtcb_dientu'));
$sapxep = $gtcbbt->findOne(array('gtcbid' => $id, 'type' => 'gtcb_sapxep'));

$ghepcau = $gtcbbt->findOne(array('gtcbid' => $id, 'type' => 'gtcb_ghepcau'));
foreach($ghepcau['aw'] as $key=>$val){
    $listaw[] = array("sort"=>$key,"aw"=>$val);
}
foreach($ghepcau['ax'] as $key=>$val){
    $listax[] = array("sort"=>$key,"ax"=>$val);
}
$luyennghe = $gtcbln->findOne(array('gtcbid' => $id));
$tpl->assign("obj",$obj);

$tpl->assign("gc",$listaw);
$tpl->assign("tl",$listax);
$tpl->assign("true",$ghepcau['true']);

$tpl->assign("tracnghiem",$tracnghiem);
$tpl->assign("dientu",$dientu);
$tpl->assign("sapxep",$sapxep);
$tpl->assign("ghepcau",$ghepcau);
$tpl->assign("luyennghe",$luyennghe);
$tpl->assign("pagefile","gtcb/ghepcau");

include "controller/hmc/index.php";
?>