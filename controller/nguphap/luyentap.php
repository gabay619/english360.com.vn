<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$nguphapcl = $dbmg->nguphap;
$npbt = $dbmg->nguphap_baitap;
$id= $_GET['id'];
$obj = (array)$nguphapcl->findOne(array("_id"=>$id));
$obj['date'] = date('d/m/Y H:i', $obj['datecreate']);
//print_r($obj);
//$dienchu = $npbt->findOne(array('npid'=> $id, 'type' => 'np_dienchu'));
$chontu = $npbt->findOne(array('npid' => $id, 'type' => 'nguphap_chontu'));
$dientu = $npbt->findOne(array('npid' => $id, 'type' => 'np_dientu'));
$diennhieutu = $npbt->findOne(array('npid' => $id, 'type' => 'nguphap_diennhieutu'));
$diencumtu = $npbt->findOne(array('npid' => $id, 'type' => 'nguphap_diencumtu'));
$vietlaicau = $npbt->findOne(array('npid' => $id, 'type' => 'nguphap_vietlaicau'));
$dungsai = $npbt->findOne(array('npid' => $id, 'type' => 'nguphap_dungsai'));
$vietlaicautranh = $npbt->findOne(array('npid' => $id, 'type' => 'nguphap_vietlaicautranh'));
$tracnghiem = $npbt->findOne(array('npid' => $id, 'type' => 'nguphap_tracnghiem'));
$tracnghiemtranh = $npbt->findOne(array('npid' => $id, 'type' => 'nguphap_tracnghiemtranh'));
$dientutranh = $npbt->findOne(array('npid' => $id, 'type' => 'nguphap_dientutranh'));
$ghepcau = $npbt->findOne(array('npid' => $id, 'type' => 'nguphap_ghepcau'));

$tpl->assign("obj",$obj);

$tpl->assign("chontu",$chontu);
$tpl->assign("dientu",$dientu);
$tpl->assign("diennhieutu",$diennhieutu);
$tpl->assign("diencumtu",$diencumtu);
$tpl->assign("vietlaicau",$vietlaicau);
$tpl->assign("dungsai",$dungsai);
$tpl->assign("vietlaicautranh",$vietlaicautranh);
$tpl->assign("tracnghiem",$tracnghiem);
$tpl->assign("tracnghiemtranh",$tracnghiemtranh);
$tpl->assign("dientutranh",$dientutranh);
$tpl->assign("ghepcau",$ghepcau);

$tpl->assign("pagefile","nguphap/luyentap");
//include "controller/hmc/index.php";
?>