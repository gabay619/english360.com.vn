<?php
$gtcbcl = $dbmg->gtcb;
$gtcbbt = $dbmg->gtcb_baitap;
$gtcbln = $dbmg->gtcb_luyennghe;
$id = $_GET['id'];
$obj = (array)$gtcbcl->findOne(array("_id" => $id));
$obj['datecreate'] = date('d/m/y h:i',$obj['datecreate']);
$tracnghiem = iterator_to_array($gtcbbt->find(array('gtcbid'=> $id, 'type' => 'gtcb_tracnghiem')), false);
$dientu = $gtcbbt->findOne(array('gtcbid' => $id, 'type' => 'gtcb_dientu'));
$sapxep = $gtcbbt->findOne(array('gtcbid' => $id, 'type' => 'gtcb_sapxep'));

foreach($sapxep['aw'] as $key=>$val){
    $listaw[] = array("sort"=>$key+1,"aw"=>$val);
}
shuffle($listaw);

$ghepcau = $gtcbbt->findOne(array('gtcbid' => $id, 'type' => 'gtcb_ghepcau'));
$luyennghe = $gtcbln->findOne(array('gtcbid' => $id));
$tpl->assign("obj",$obj);
$tpl->assign("tracnghiem",$tracnghiem);
$tpl->assign("dientu",$dientu);
$tpl->assign("sapxep",$sapxep);
$tpl->assign("listaw",$listaw);
$tpl->assign("ghepcau",$ghepcau);
$tpl->assign("luyennghe",$luyennghe);
$tpl->assign("pagefile","gtcb/ex");
include "controller/hmc/index.php";
?>