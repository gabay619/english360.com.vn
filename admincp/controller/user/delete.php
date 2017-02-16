<?php
if(!acceptpermiss("user_delete")) {header("location: ".cpagerparm("status,id,tact")."status=error");die;}
$id =  $_GET['id'];
$collection = $dbmg->user;
$gamepointcl = $dbmg->game_point;
$commentcl = $dbmg->comment;
$faqcl = $dbmg->faq;
if(!empty($_POST)){
  $collection->remove(array("_id"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
    $gamepointcl->remove(array("uid"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
    $commentcl->remove(array("uid"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
    $faqcl->remove(array("usercreate"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
}
else {
    $collection->remove(array("_id"=>"$id"));
    $gamepointcl->remove(array("uid"=>"$id"));
    $commentcl->remove(array("uid"=>"$id"));
    $faqcl->remove(array("usercreate"=>"$id"));
}
$link = cpagerparm("status,id,tact")."status=success";
header("Location: $link");
?>