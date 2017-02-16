<?php
$hmcaudiocl = $dbmg->hmcaudio;
$id = $_GET['id'];
$obj = (array)$hmcaudiocl->findOne(array("_id"=>$id));
$tpl->assign("obj", $obj);
$tpl->assign("pagefile","hmc/audio/luyentap");
include "controller/hmc/index.php";
?>