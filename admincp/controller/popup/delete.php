<?php
$collection = $dbmg->popup;
$id = $_GET['id'];
if(!empty($_POST))  $collection->remove(array("_id"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
else $collection->remove(array("_id"=>"$id"));
$_SESSION['status'] = 'success';
$link = cpagerparm("status,phone,tact")."tact=popup_view";
header("Location: $link");
?>