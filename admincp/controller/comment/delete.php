<?php
if(!acceptpermiss("comment_delete")) {header("location: ".cpagerparm("status,id,tact")."status=error");die;}
$id =  $_GET['id'];
$collection = $dbmg->comment;
if(!empty($_POST))  $collection->remove(array("_id"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
else $collection->remove(array("_id"=> intval($id)));
$link = cpagerparm("status,id,tact")."status=success";
header("Location: $link");
?>