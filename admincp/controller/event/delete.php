<?php
if(!acceptpermiss("event_delete")) {
    $_SESSION['status'] = 'error';
    header("location: ".cpagerparm("status,id,tact"));die;
}
$collection = $dbmg->event;
$id = $_GET['id'];
if(!empty($_POST))  $collection->remove(array("_id"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
else $collection->remove(array("_id"=>"$id"));
$_SESSION['status'] = 'success';
$link = cpagerparm("status,id,tact")."tact=event_view";
header("Location: $link");
?>