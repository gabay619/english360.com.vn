<?php
if(!acceptpermiss("chat_delete")) {header("location: ".cpagerparm("status,id,tact")."status=error");die;}
$id =  $_GET['id'];
$collection = $dbmg->chat;
if(!empty($_POST))  $collection->remove(array("ssid"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
else $collection->remove(array("ssid"=>"$id"));
$link = cpagerparm("status,id,tact")."status=success";
header("Location: $link");
?>