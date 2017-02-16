<?php
if(!acceptpermiss("config_1t")) {
    $_SESSION['status'] = 'error';
    header("location: ".cpagerparm("status,id,tact")."status=error");die;
}
$id =  $_GET['id'];
$collection = $dbmg->partner;
if(!empty($_POST))  $collection->remove(array("_id"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
else $collection->remove(array("_id"=>"$id"));
$_SESSION['status'] = 'success';
$link = cpagerparm("status,id,tact")."tab=partner&tact=config_1t";
header("Location: $link");
?>