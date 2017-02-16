<?php
$hmcaudiocl = $dbmg->hmcaudio;
$filmCl = $dbmg->film;
$filmCl = $dbmg->hmcgame;
$cond['status'] = "1";
$limit = 20;
$p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
$list = iterator_to_array($hmcaudiocl->find($cond,array("_id","name","avatar","contents"))->sort(array("_id"=>-1))->skip($cp)->limit($limit),false);
echo 1;die;
$tpl->assign("listsong",$listsong);

$listfilm = iterator_to_array($filmCl->find(array("status"=>"1"),array("_id","name","avatar"))->sort(array("_id"=>-1))->limit(4),false);
$tpl->assign("listfilm",$listfilm);
$listgame = iterator_to_array($gameCl->find(array("status"=>"1"),array("_id","name","avatar"))->sort(array("_id"=>-1))->limit(4),false);
$tpl->assign("listgame",$listgame);

$tpl->assign("pagefile","component/hocmachoi");
?>