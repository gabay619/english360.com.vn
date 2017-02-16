<?php
$gtcbcl = $dbmg->news;
// Nếu là bài chi tiết
$id = $_GET['id'];
if(isset($id)) {
    $o = (array)$gtcbcl->findOne(array("_id" => $id));
    $tpl->assign("obj", $o);
    $tpl->assign("pagefile", "news/detail");
}
?>