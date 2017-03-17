<?php
$npCl = $dbmg->nguphap;
$tvcl = $dbmg->thuvien;
$categorycl = $dbmg->category;
$usercl = $dbmg->user;
// Nếu có ID -> Show detail
$id = $_GET['id'];
$type = $_GET['type'];
$listcat = iterator_to_array($categorycl->find(array("type"=>"nguphap"),array("_id","name","namenoneutf"))->sort(array("key"=>-1)));
$tpl->assign("listcat", $listcat);
if(isset($_GET['act']) && $_GET['act']=='luyentap'){
    include "controller/nguphap/luyentap.php";
//    exit;
}
elseif(isset($id)) {
    $o = (array)$npCl->findOne(array("_id" => $id));
    //bài học liên quan
    $refcond['status'] = "1";
    $refcond['_id'] = array('$ne'=>$id);
    if(count($o['category'])>0) $refcond['category'] = $o['category'][0];
    $listref =iterator_to_array($npCl->find($refcond,array("_id","name","avatar","category","datecreate"))->limit(5),false);
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

    $type = Constant::TYPE_NGUPHAP;
    //Đếm số lượt xem chuyên mục
    if(!isset($o['free']) || $o['free']!='1'){
        if(!isset($_SESSION['uinfo'])){
            header("Location: /login.php");exit();
//            header("Location: /register.php");exit();
//            header("Location: /quick-package.php?link=".urlencode(Constant::BASE_URL.$_SERVER['REQUEST_URI']));exit();
        }
        else{
            $user = $usercl->findOne(array('_id'=>$_SESSION['uinfo']['_id']));
            if($user['ssid'] != session_id()){
                unset($_SESSION['uinfo']);
                $_SESSION['flash_mss'] = 'Tài khoản của bạn được đăng nhập từ nơi khác.';
                header("Location: /login.php");exit();
            }
            $result = Common::isRegPackage($_SESSION['uinfo']['_id']);
//            var_dump($result);die;

            if(!$result){
                $_SESSION['flash_mss'] = 'Hãy đăng ký gói cước để tiếp tục sử dụng dịch vụ.';
                header("Location: /regispack.php");exit();
            }
        }
    }

    include "/countView.php";

    $o['datecreate'] = date("d/m/Y h:s",$o['datecreate']);
    $type = Constant::TYPE_NGUPHAP;
    include "controller/comment/index.php";
    $tpl->assign("obj", $o);
    $tpl->assign("pagefile", "nguphap/detail");
    include "controller/component/popreg.php";
}
else {
    $limit = 8;
    $p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
    $cond = array("status"=>"1");

    $dataSlide = array();
    $listslide = iterator_to_array($npCl->find($cond)->sort(array("_id"=>1))->limit(5), false);
    $slideId = array();
    foreach($listslide as $key=>$val){
        $slideId[] = $val['_id'];
        $dataSlide[] = array(
            'id' => $val['_id'],
            'name' => $val['name'],
            'avatar' => $val['avatar'],
            'url' => makelink::makenp($val['_id'], $val['name'])
        );
    }
    $cond['_id'] = array('$nin'=>$slideId);
    $list = iterator_to_array($npCl->find($cond,array("_id","name","avatar","category","datecreate"))->sort(array("_id"=>1))->skip($cp)->limit($limit),false);
    foreach($list as $k=>$v){
        $list[$k]['datecreate'] = date('d/m/Y H:i', $v['datecreate']);
    }
    $tpl->assign("dataSlide",$dataSlide );
    $tpl->assign("listnp", $list);
    ##Paging
    $rowcount = $npCl->count($cond);
    $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
    $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
    $tpl->assign("paging",$paginginfo);
    $tpl->assign("pagefile", "nguphap/index");
}

include "controller/hmc/index.php";
?>