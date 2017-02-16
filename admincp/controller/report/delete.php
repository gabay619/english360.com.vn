<?php
if(!acceptpermiss("report_delete")) {header("location: ".cpagerparm("status,id,tact")."status=error");die;}
$id =  $_GET['id'];
$collection = $dbmg->report;
$commentcl = $dbmg->comment;
$faqcl = $dbmg->faq;
if(!empty($_POST))  {
    foreach($_POST['_id'] as $i){
        $report = $collection->findOne(array('_id' => $i));
        if($report['type'] == Constant::TYPE_COMMENT){
            $commentcl->remove(array("_id"=>array('$in'=>array(strval($report['itemid']), intval($report['itemid'])))));
        }else{
            $faqcl->remove(array("_id"=>array('$in'=>array(strval($report['itemid']), intval($report['itemid'])))));
        }
    }
    $collection->remove(array("_id"=>array('$in'=>$_POST['id'])),array("multiple"=>true));
}
else {
    $report = $collection->findOne(array('_id' => $id));
    if($report['type'] == Constant::TYPE_COMMENT){
        $commentcl->remove(array("_id"=>array('$in'=>array(strval($report['itemid']), intval($report['itemid'])))));
    }else{
        $faqcl->remove(array("_id"=>array('$in'=>array(strval($report['itemid']), intval($report['itemid'])))));
    }
    $collection->remove(array("_id"=>"$id"));
}
$link = cpagerparm("status,id,tact")."status=success";
header("Location: $link");
?>