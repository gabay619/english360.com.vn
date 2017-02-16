<?php
$collection = $dbmg->user;
$id = $_GET['id'];
if(!empty($_POST))  $collection->update(array("_id"=>array('$in'=>$_POST['id'])),array('$set'=>array('event'=>'')));
else if($id == 'all') {
//    echo 1;die;
    $collection->update(array("event"=>Event::HOC_SINH_SINH_VIEN),array('$set'=>array('event'=>'')), array('multiple'=>true));
}
else $collection->update(array("_id"=>"$id"),array('$set'=>array('event'=>'')), array('multiple'=>true));
$_SESSION['status'] = 'success';
$link = cpagerparm("status,phone,tact,id")."tact=hssv_view";
header("Location: $link");exit;
?>