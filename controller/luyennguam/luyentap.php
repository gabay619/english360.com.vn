<?php
$nguamcl = $dbmg->luyennguam;
$lnabt = $dbmg->luyennguam_baitap;
$id= $_GET['id'];
$obj = (array)$nguamcl->findOne(array("_id"=>$id));
$obj['date'] = date('d/m/Y H:i', $obj['datecreate']);
$dienchu = $lnabt->findOne(array('lnaid'=> $id, 'type' => 'lna_dienchu'));
$dientu = $lnabt->findOne(array('lnaid' => $id, 'type' => 'lna_dientu'));
$tracnghiem = iterator_to_array($lnabt->find(array('lnaid' => $id, 'type' => 'lna_tracnghiem'))->sort(array('_id'=>1)), false);
$xemtranh = iterator_to_array($lnabt->find(array('lnaid' => $id, 'type' => 'lna_xemtranh')), false);
$phatam = $lnabt->findOne(array('lnaid' => $id, 'type' => 'lna_phatam'));
$showXemtranh = count($xemtranh) > 0;
$showTracnghiem = count($tracnghiem) > 0;
foreach($dienchu['question'] as $key=>$val){
    $dienchu['question'][$key]['short'] = str_replace('_','<input style="width:20px" class="dt" type="text" placeholder="" maxlength="1">',$val['short']);
}

$tpl->assign("obj",$obj);
$tpl->assign("dienchu",$dienchu);
$tpl->assign("dientu",$dientu);
$tpl->assign("tracnghiem",$tracnghiem);
$tpl->assign("xemtranh",$xemtranh);
$tpl->assign("phatam",$phatam);
$tpl->assign("showXemtranh",$showXemtranh);
$tpl->assign("showTracnghiem",$showTracnghiem);
$tpl->assign("pagefile","luyennguam/luyentap");
include "controller/hmc/index.php";
?>