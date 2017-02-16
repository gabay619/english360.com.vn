<?php
if(!acceptpermiss("config_bl")) {
    $_SESSION['status'] = 'error';
    header("location: ".cpagerparm("status,id,tact"));die;
}
$phone =  $_GET['phone'];
$collection = $dbmg->bl;
if(!empty($_POST))  $collection->remove(array("phone"=>array('$in'=>$_POST['phone'])),array("multiple"=>true));
else $collection->remove(array("phone"=>"$phone"));
$_SESSION['status'] = 'success';
$link = cpagerparm("status,phone,tact")."tact=config_bl";
header("Location: $link");
?>