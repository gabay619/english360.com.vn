<?php
if(!acceptpermiss("gtcb_listen_del")) {header("location: ".cpagerparm("status,id,tact")."status=error");die;}
$id =  $_GET['id'];
$collection = $dbmg->gtcb_luyennghe;
if(!empty($_POST))  $collection->remove(array("_id"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
else $collection->remove(array("_id"=>"$id"));
$link = cpagerparm("status,id,tact")."status=success";
header("Location: $link");
?>