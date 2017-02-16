<?php
$lnaCl = $dbmg->luyennguam;
$tvcl = $dbmg->thuvien;
$categorycl = $dbmg->category;
// Nếu có ID -> Show detail
$id = $_GET['id'];
$type = $_GET['type'];
$listcat = iterator_to_array($categorycl->find(array("type"=>"luyennguam"),array("_id","name","namenoneutf"))->sort(array("key"=>-1)));
$tpl->assign("listcat", $listcat);
if(isset($id)) {
    $o = (array)$lnaCl->findOne(array("_id" => $id));
    //bài học liên quan
    $refcond['status'] = "1";
    $refcond['_id'] = array('$ne'=>$id);
    if(count($o['category'])>0) $refcond['category'] = $o['category'][0];
    $listref =iterator_to_array($lnaCl->find($refcond,array("_id","name","avatar","category","datecreate"))->limit(5),false);
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

    $type = Constant::TYPE_LUYENNGUAM;
    //Đếm số lượt xem chuyên mục
//    if(!isset($_SESSION['CountView'.$type])){
//        $_SESSION['CountView'.$type] = 1;
//    }else{
//        $_SESSION['CountView'.$type]++;
//    }
//    $countView = $_SESSION['CountView'.$type];
//    if($countView > Constant::MAX_CONTENT_CATE_FREE){
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
    include "/countView.php";

    $o['datecreate'] = date("d/m/Y h:s",$o['datecreate']);
    $type = Constant::TYPE_LUYENNGUAM;
    include "controller/comment/index.php";
    $tpl->assign("obj", $o);
    $tpl->assign("pagefile", "luyennguam/detail");
    include "controller/component/popreg.php";
}
else {
    $limit = 8;
    $p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
    $cond = array("status"=>"1");

    $dataSlide = array();
    $listslide = iterator_to_array($lnaCl->find($cond)->sort(array("_id"=>1))->limit(5), false);
    $slideId = array();
    foreach($listslide as $key=>$val){
        $slideId[] = $val['_id'];
        $dataSlide[] = array(
            'id' => $val['_id'],
            'name' => $val['name'],
            'avatar' => $val['avatar'],
            'url' => makelink::makelna($val['_id'], $val['name'])
        );
    }
    $cond['_id'] = array('$nin'=>$slideId);
    $list = iterator_to_array($lnaCl->find($cond,array("_id","name","avatar","category","datecreate"))->sort(array("_id"=>1))->skip($cp)->limit($limit),false);
    foreach($list as $k=>$v){
        $list[$k]['datecreate'] = date('d/m/Y H:i', $v['datecreate']);
    }
    $tpl->assign("dataSlide",$dataSlide );
    $tpl->assign("listlna", $list);
    ##Paging
    $rowcount = $lnaCl->count($cond);
    $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
    $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
    $tpl->assign("paging",$paginginfo);
    $tpl->assign("pagefile", "luyennguam/index");
}

include "controller/hmc/index.php";
?>