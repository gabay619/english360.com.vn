<?php
$thuvienCl = $dbmg->thuvien;
$hmcvideocl = $dbmg->hmcvideo;
$commentcl = $dbmg->comment;
$categorycl = $dbmg->category;
$usercl = $dbmg->user;
$id = $_GET['id'];
if(!isset($id)) { // Lấy danh sách video
    $limit = 20;
    $p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
    $cond['status'] = "1";
    $listfilm = iterator_to_array($thuvienCl->find(array("category"=>"1450861603"),array("_id","name","avatar"))->sort(array("_id"=>-1))->limit(4),false);
    //$listslide = iterator_to_array($thuviencl->find($cond,array("_id","name","avatar","category","datecreate"))->sort(array("_id"=>-1))->skip($cp)->limit(5),false);
    foreach($listfilm as $key=>$val){

        $dataSlide[] = array(
            'id' => $val['_id'],
            'name' => $val['name'],
            'avatar' => $val['avatar'],
            'url' => '/'.Common::getUrlFromType($val['type']).'?id='.$val['_id']
        );
    }
    $tpl->assign("dataSlide",$dataSlide );
    $listcat = iterator_to_array($categorycl->find(array("parentid"=>"1450861603"),array("_id","parentid","name","namenoneutf"))->sort(array("key"=>-1)));
    $tpl->assign("listcat", $listcat);
    ##Paging

    $rowcount = $hmcvideocl->count($cond);
    $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
    $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
    $tpl->assign("paging",$paginginfo);

    $tpl->assign("listfilm",$listfilm);
    $tpl->assign("pagefile", "hmc/video/index");
}
else{ // Lấy chi tiết video
    $obj = (array)$thuvienCl->findOne(array("_id"=>$id));
    $obj['datecreate'] = date('h:s | d/m/Y',$obj['datecreate']);
    foreach ($obj as $key=>$val){
        $obj[$key]['eng'] = $val['eng'];
        $obj[$key]['vie'] = $val['vie'];
    }

    $tpl->assign("obj", $obj);
    $tpl->assign("pagefile", "hmc/video/detail");
}

//bài học liên quan
$refcond['status'] = "1";
$refcond['_id'] = array('$ne'=>$id);
$refcond['category'] = "1450861603";
if(count($obj['category'])>0) $refcond['category'] = $obj['category'][0];

$listref =iterator_to_array($thuvienCl->find($refcond,array("_id","name","avatar","category","datecreate"))->limit(5),false);
foreach($listref as $key=>$val){
    $listref[$key]['datecreate'] = date('h/m/Y, H:s',$val['datecreate']);
}
$listnew = iterator_to_array($thuvienCl->find(array("category"=>"1450861603","status"=>"1"),array("_id","name","avatar","category","datecreate"))->limit(5)->sort(array("_id"=>-1)),false);
foreach($listnew as $key=>$val){
    $listnew[$key]['datecreate'] = date('h/m/Y, H:s',$val['datecreate']);
}
$tpl->assign("ref", $listref);
$tpl->assign("new", $listnew);
//end Bài học liên quan
//comment
$cond['status'] = "1";
$cond['parentid'] = "0";
$cond['objid'] = $id;
$comment = iterator_to_array($commentcl->find($cond,array("_id","objid","uid","content","parentid","type","datecreate"))->sort(array("_id"=>-1))->limit(20),false);
foreach($comment as $key=>$item){
    $comment[$key]['datecreate'] = date("d-m-Y H:i",$item['datecreate']);
    $comment[$key]["userinfo"] = (array)$usercl->findOne(array("_id"=>$item["uid"]), array("_id","phone"));
    $comment[$key]['childs'] = iterator_to_array($commentcl->find(array('parentid'=>array('$in'=>array(strval($item['_id']), intval($item['_id'])))))->sort(array('datecreate'=>1)), false);
    foreach($comment[$key]['childs'] as $k=>$v){
        $comment[$key]['childs'][$k]["datecreate"] = date("d-m-Y H:i",$v['datecreate']);
        $comment[$key]['childs'][$k]["userinfo"] = (array)$usercl->findOne(array("_id"=>$v["uid"]), array("_id","phone"));
    }
}
$refcond['objid'] = $id;
$refcond['status'] = "1";
$refcond['parentid'] = array('$ne'=>'0');
$commentson = iterator_to_array($commentcl->find($refcond,array("_id","objid","uid","content","parentid","type"))->sort(array("_id"=>-1))->limit(20),false);
foreach($commentson as $key=>$item){
    $commentson[$key]["userinfoson"] = (array)$usercl->findOne(array("_id"=>$item["uid"]), array("_id","phone"));
}
$tpl->assign("comment",$comment);
$tpl->assign("commentson",$commentson);
//end Comment
include "controller/hmc/index.php";//end Hoc ma choi
?>