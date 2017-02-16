<?php
if(!acceptpermiss("event_delete")) {
    $_SESSION['status'] = 'error';
    header("location: ".cpagerparm("status,id,tact"));die;
}
$collection = $dbmg->free_user;
$phone = $_GET['phone'];
if(!empty($_POST))  $collection->remove(array("phone"=>array('$in'=>$_POST['phone'])),array("multiple"=>true));
else $collection->remove(array("phone"=>"$phone"));
$_SESSION['status'] = 'success';
$link = cpagerparm("status,phone,tact")."tact=event1";
header("Location: $link");
?>