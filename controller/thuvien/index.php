<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$thuviencl = $dbmg->thuvien;
$categorycl = $dbmg->category;
$usercl = $dbmg->user;
$id = $_GET['id'];
$cat = $_GET['cat'];
$thuvienId = '1427182938';
$catname = (array)$categorycl->findOne(array("_id"=>$cat));
if(!isset($cat)){
    $catname = (array)$categorycl->findOne(array("type"=>$_GET['type'], "parentid"=>$thuvienId));
}

$listcat = iterator_to_array($categorycl->find(array("parentid"=>"$cat"),array("_id","parentid","name","namenoneutf"))->sort(array("key"=>-1)));
$tpl->assign("listcat", $listcat);
if(isset($id)){
    ##Lấy chi tiết bài viết thư viện
    $obj = $thuviencl->findOne(array("_id"=>$id));
//    print_r($id);
    if(!$catname){
        $catname = (array)$categorycl->findOne(array("_id"=>array('$in'=>$obj['category']), "parentid"=>$thuvienId));
    }

//    print_r($obj);
    if(isset($obj['calendar']))
        $obj['datecreate'] = $obj['calendar'];
    $obj['datecreate'] = date("d/m/Y h:s",$obj['datecreate']);
    $obj['lession'] = str_replace('&nbsp;',' ',$obj['lession']);
    $tpl->assign("obj", $obj);
    $c=strlen($obj['medialink']);
    $tpl->assign("c", $c);
    ##reference
    $refcond['status'] = Constant::STATUS_ENABLE;
    $refcond['_id'] = array('$ne'=>$id);
    $refcond['$or'] = array(
            array('calendar' => array('$exists'=>false)),
            array('calendar' => array('$lte'=> time()))
    );
    if(count($obj['category'])>0) $refcond['category'] = $catname['_id'];
//    print_r($refcond);
    $listref =iterator_to_array($thuviencl->find($refcond,array("_id","name","avatar","category","datecreate"))->limit(10)->sort(array("_id"=>-1)),false);
    foreach($listref as $key=>$val){
        $listref[$key]['datecreate'] = date("d/m/Y h:i",$val['datecreate']);
    }
    $newcond = $refcond;
    unset($newcond['category']);
    $listnew = iterator_to_array($thuviencl->find($newcond,array("_id","name","avatar","category","datecreate"))->limit(5)->sort(array("_id"=>-1)),false);
    foreach($listnew as $key=>$val){
        $listnew[$key]['datecreate'] = date("d/m/Y h:s",$val['datecreate']);
    }
    $type = $catname['type'];
    //Đếm số lượt xem chuyên mục
    if(!isset($obj['free']) || $obj['free']!='1'){
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
            if(!$result){
                $_SESSION['flash_mss'] = 'Hãy đăng ký gói cước để tiếp tục sử dụng dịch vụ.';
                header("Location: /regispack.php");exit();
            }
        }
    }
    include "/countView.php";

    include "controller/comment/index.php";
    include "controller/component/emailbox.php";

    if(in_array($type, array(Constant::TYPE_DAILY, Constant::TYPE_EXP, Constant::TYPE_IDIOM))) $fix = 12;
    $showMedia = !empty($obj['medialink']);
    $showAV = !empty($obj['content']['eng']) && !empty($obj['content']['vie']) ;
    $showLession = in_array($type, array(Constant::TYPE_IDIOM))|| empty($obj['lession']) ? false : true;
    $showCautruc = !in_array($type, array(Constant::TYPE_DAILY, Constant::TYPE_EXP));
    $emailboxTop = in_array($type,array(Constant::TYPE_VIDEO, Constant::TYPE_RADIO, Constant::TYPE_FILM, Constant::TYPE_FAMOUS, Constant::TYPE_IDIOM));
//    var_dump($emailboxTop);die;
//    print_r($obj['lession']);
//    if(in_array($type, array(Constant::TYPE_IDIOM, Constant::TYPE_FILM))) $fixThanhngu = 1;
//    if($catnamefix['_id'] == 1427344702) $fixRadio = 1;
    $tpl->assign("showMedia", $showMedia);
    $tpl->assign("showAV", $showAV);
    $tpl->assign("showLession", $showLession);
    $tpl->assign("showCautruc", $showCautruc);
    $tpl->assign("emailboxTop", $emailboxTop);
    $listcat = iterator_to_array($categorycl->find(array('status'=>Constant::STATUS_ENABLE, 'parentid'=>$catname['_id']),array("_id","namenoneutf","type", "name"))->sort(array("_id"=>1)),false);
    $tpl->assign("catname", $catname);
    $tpl->assign("listcat", $listcat);
//end Comment
    $tpl->assign("pagefile", "thuvien/detail");
    //}
    $tpl->assign("ref", $listref);
    $tpl->assign("new", $listnew);
    include "controller/component/popreg.php";
}
else{

    $tpl->assign("pagefile", "thuvien/index");
}
include "controller/hmc/index.php";
?>