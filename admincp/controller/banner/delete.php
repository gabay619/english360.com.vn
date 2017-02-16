<?php
$collection = $dbmg->banner;
$id = $_GET['id'];
if(!empty($_POST))  $collection->remove(array("_id"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
else $collection->remove(array("_id"=>"$id"));
$_SESSION['status'] = 'success';
$link = cpagerparm("status,tact")."tact=banner_view";
header("Location: $link");exit;
?>