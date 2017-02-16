<?php
if(!acceptpermiss("luyennguam_test_del")) {header("location: ".cpagerparm("status,id,tact")."tact=lna_dc_view&status=error");die;}
$id =  $_GET['id'];
$collection = $dbmg->luyennguam_baitap;
if(!empty($_POST))  $collection->remove(array("_id"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
else $collection->remove(array("_id"=>"$id"));
$link = cpagerparm("status,id,tact")."tact=lna_dc_view&status=success";
header("Location: $link");
?>