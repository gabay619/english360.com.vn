<?php
$thuviencl = $dbmg->thuvien;
$categorycl = $dbmg->category;
// Nếu là bài chi tiết
$id = $_GET['id'];
$listcat = iterator_to_array($categorycl->find(array("type"=>"famous"),array("_id","name","namenoneutf"))->sort(array("key"=>-1)));
$tpl->assign("listcat", $listcat);
if(isset($id)) {
    $o = (array)$thuviencl->findOne( array("_id" => $id));

    $tpl->assign("obj", $o);
    // kiểm tra bài đã lưu hay chưa
    if(!isset($_SESSION['uinfo'])) $uid = 0;
    else $uid = $_SESSION['uinfo']['_id'];
    $saveexamcl = $dbmg->saveexam;
    $l = (array)$saveexamcl->findOne(array("uid"=>$uid));
    if(in_array($id,$l['ex'])) $tpl->assign("saved", 1);
    else $tpl->assign("saved", 0);
    $tpl->assign("pagefile", "thuvien/detail");

}
else{
    $limit = 8;
    $p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
    $cond = array("type"=>"famous","status"=>"1");
    $listfamous = iterator_to_array($thuviencl->find(array("category"=>array("1450844989")),array("_id","name","avatar"))->sort(array("_id"=>-1))->limit(4),false);
    $tpl->assign("listfamous", $listfamous);
    ##Paging
    $rowcount = $thuviencl->count($cond);
    $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
    $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
    $tpl->assign("paging",$paginginfo);
    $tpl->assign("pagefile", "thuvien/famous");
}
include "controller/hmc/index.php";


?>