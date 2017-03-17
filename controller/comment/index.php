<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
/**
 * Created by PhpStorm.
 * User: changha
 * Date: 1/27/16
 * Time: 10:32 AM
 */
$usercl = $dbmg->user;
$commentcl = $dbmg->comment;
$cond['status'] = "1";
$cond['parentid'] = "0";
$cond['objid'] = $id;
$cond['type'] = $type;
$comment = iterator_to_array($commentcl->find($cond,array("_id","objid","uid","content","parentid","type","datecreate", "like"))->sort(array("_id"=>-1))->limit(20),false);
foreach($comment as $key=>$item){
    $comment[$key]['datecreate'] = date("d-m-Y H:i",$item['datecreate']);
    $comment[$key]["userinfo"] = (array)$usercl->findOne(array("_id"=>$item["uid"]), array("_id","email", "displayname", "priavatar"));
//    print_r($comment[$key]["userinfo"]);
    $comment[$key]['countlike'] = isset($item['like']) ? count($item['like']) : 0;
    $comment[$key]['islike'] = isset($_SESSION['uinfo']) ? (isset($item['like']) ? in_array($_SESSION['uinfo']['_id'], $item['like']) : false) : false;
    $comment[$key]['childs'] = iterator_to_array($commentcl->find(array('parentid'=>array('$in'=>array(strval($item['_id']), intval($item['_id'])))))->sort(array('datecreate'=>1)), false);
    foreach($comment[$key]['childs'] as $k=>$v){
        $comment[$key]['childs'][$k]["datecreate"] = date("d-m-Y H:i",$v['datecreate']);
        $comment[$key]['childs'][$k]["userinfo"] = (array)$usercl->findOne(array("_id"=>$v["uid"]), array("_id","phone", "displayname", "priavatar"));
        $comment[$key]['childs'][$k]["countlike"] = isset($v['like']) ? count($v['like']) : 0;
        $comment[$key]['childs'][$k]['islike'] = isset($_SESSION['uinfo']) ? (isset($v['like']) ? in_array($_SESSION['uinfo']['_id'], $v['like']) : false) : false;
    }
}
//$showComment = count($comment) > 0;
$tpl->assign("comment",$comment);
$tpl->assign("objid",$id);
$tpl->assign("type",$type);
//$tpl->assign("showComment",$showComment);
$tpl->assign("commentFile", "component/comment");
//print_r($comment);
//print_r($cond);
?>