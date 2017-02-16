<?php
if(!acceptpermiss("audio_upload_delete")) {header("location: ".cpagerparm("status,id,tact")."status=error");die;}
$id =  $_GET['id'];
$collection = $dbmg->upload;
if(!empty($_POST))  $collection->remove(array("_id"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
else $collection->remove(array("_id"=>"$id"));
$link = cpagerparm("status,id,tact")."tact=audio_upload_view&status=success";
header("Location: $link");
?>