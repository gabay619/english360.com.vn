<?php
if(!acceptpermiss("hmcgame_delete")) {header("location: ".cpagerparm("status,id,tact")."status=error");die;}
$id =  $_GET['id'];
$collection = $dbmg->hmcgame;
if(!empty($_POST))  $collection->remove(array("_id"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
else $collection->remove(array("_id"=>"$id"));
$link = cpagerparm("status,id,tact,p")."status=success&tact=hmcgame_view";
header("Location: $link");
?>