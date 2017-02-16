<?php
$usercl = $dbmg->user;
$gtcbcl = $dbmg->gtcb;
$tvcl = $dbmg->thuvien;
$categorycl = $dbmg->category;

$showCl = $dbmg->showcl;
$categorycl = $dbmg->category;

// Nếu là bài chi tiết
$id = $_GET['id'];
$listcatgtcb = iterator_to_array($categorycl->find(array("type"=>"giaotiepcoban"),array("_id","name","namenoneutf"))->sort(array("key"=>-1)));
$tpl->assign("listcatgtcb", $listcatgtcb);
if(isset($id)) {
    $type = Constant::TYPE_GTCB;
    //Đếm số lượt xem chuyên mục
    $o = (array)$gtcbcl->findOne( array("_id" => $id));

//    if(!isset($_SESSION['CountView'.$type])){
//        $_SESSION['CountView'.$type] = 0;
//    }
//    $countView = $_SESSION['CountView'.$type];
//    if($countView >= Constant::MAX_CONTENT_CATE_FREE || !isset($o['free']) || $o['free']!='1'){
    if(!isset($o['free']) || $o['free']!='1'){
//        $_SESSION['CountView']--;
        if(!isset($_SESSION['uinfo'])){
//            header("Location: /login.php");exit();
//            header("Location: /register.php");exit();
            header("Location: /quick-package.php?link=".urlencode(Constant::BASE_URL.$_SERVER['REQUEST_URI']));exit();
        }
        else{
            $result = Network::getUserInfo($_SESSION['uinfo']['phone'],'E',$_SESSION['uinfo']['_id']);
            if($result != 1){
//                if(Network::is3g() && Network::is3gmobifone() && Network::OPEN_REG){
//                    $link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&WAP');
//                    $linkVms = Network::genLinkConfirmVms("E",$link_callback);
//                    header("Location: ".$linkVms);exit();
//                }else{
                    $_SESSION['flash_mss'] = 'Hãy đăng ký gói cước để tiếp tục sử dụng dịch vụ.';
                    header("Location: /regispack.php");exit();
//                }
            }
        }
    }
//    $_SESSION['CountView'.$type]++;
    include "/countView.php";

    include "controller/component/emailbox.php";
    $o['datecreate'] = date('h/m/Y, H:s',$o['datecreate']);
    $tpl->assign("obj", $o);


    // kiểm tra bài đã lưu hay chưa
    if(!isset($_SESSION['uinfo'])) $uid = 0;
    else $uid = $_SESSION['uinfo']['_id'];
    $saveexamcl = $dbmg->saveexam;
    $l = (array)$saveexamcl->findOne(array("uid"=>$uid));
    if(in_array($id,$l['ex']))
        $tpl->assign("saved", 1);
    else
        $tpl->assign("saved", 0);
    $tpl->assign("pagefile", "gtcb/detail");
//bài học liên quan
    $refcond['status'] = "1";
    $refcond['_id'] = array('$ne'=>$id);
    if(count($o['category'])>0) $refcond['category'] = $o['category'][0];
    $listref =iterator_to_array($gtcbcl->find($refcond,array("_id","name","avatar","category","datecreate"))->limit(5),false);
    foreach($listref as $key=>$val){
        $listref[$key]['datecreate'] = date('h/m/Y, H:s',$val['datecreate']);
    }
    $listnew = iterator_to_array($tvcl->find(array("status"=>"1"),array("_id","name","avatar","category","datecreate"))->limit(5)->sort(array("_id"=>-1)),false);
    foreach($listnew as $key=>$val){
        $listnew[$key]['datecreate'] = date('h/m/Y, H:s',$val['datecreate']);
    }
    $tpl->assign("ref", $listref);
    $tpl->assign("new", $listnew);
//end Bài học liên quan
//comment
    $type = Constant::TYPE_GTCB;
    include "controller/comment/index.php";
    include "controller/component/popreg.php";
}
//end Comment
else{
    $cond = array("status"=>"1");
    $listnew = iterator_to_array($gtcbcl->find($cond,array("_id","name","avatar","category","datecreate"))->limit(5)->sort(array("_id"=>1)),false);
    $dataSlide = array();
    $slideId = array();
    foreach($listnew as $key=>$val){
        $slideId[] = $val['_id'];
        $dataSlide[] = array(
            'id' => $val['_id'],
            'name' => $val['name'],
            'avatar' => $val['avatar'],
            'url' => makelink::makegtcb($val['_id'], $val['name'])
        );

    }


    $tpl->assign("dataSlide",$dataSlide );
//end Datasilide
    $limit = 8;
    $p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
    $cond['_id'] = array('$nin'=>$slideId);
    $list = iterator_to_array($gtcbcl->find($cond)->sort(array("_id"=>1))->skip($cp)->limit($limit),false);
    foreach($list as $k=>$v){
        $list[$k]['datecreate'] = date('d/m/Y H:i', $v['datecreate']);
    }
    $tpl->assign("listgtcb", $list);
    ##Paging
    $rowcount = $gtcbcl->count($cond);
    $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
    $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
    $tpl->assign("paging",$paginginfo);
    $tpl->assign("pagefile", "gtcb/index");
}

//Hoc ma choi
include "controller/hmc/index.php";
//end Hoc ma choi


?>