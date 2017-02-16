<?php
$faqcl = $dbmg->faq;
# Dat cau hoi
if (!empty($_POST)){

    $id = (string)strtotime("now");
    $name = wordFilter($_POST['name']);
  $contents = wordFilter($_POST['contents']);
    $timeNow = time();
    $datecreate = strtotime("now");
    $uinfo = $_SESSION['uinfo'];if(!isset($uinfo)) $uinfo["_id"] = "0";
    $_POST['usercreate'] = $uinfo["_id"];
    $_POST['namenonutf'] = convert_vi_to_en($_POST['name']);
    $newFaq = array('_id'=>$id,'name'=>$name, 'contents'=>$contents,'usercreate'=>$_POST['usercreate'], 'datecreate'=>$datecreate, 'status'=>'1', 'parentid'=>'0','namenonutf'=>$_POST['namenonutf']);
    $faq = (object)$faqcl->insert($newFaq);

}
header ("location: hoidap.php");
$tpl->assign("pagefile","hoidap/datcauhoi");
?>