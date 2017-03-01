<?php
##List News For Slideshow
//echo $_SESSION['uinfo']['_id'];die;
$gtcbcl = $dbmg->gtcb;

//$songCl = $dbmg->song;
$showCl = $dbmg->showcl;
$slideshowCl = $dbmg->slideshow;
$categorycl = $dbmg->category;
$listmedia = $showCl->findOne(array('type'=>'slideshow'));
$dataSlide = array();
foreach($listmedia['lession'] as $aLession){
    $postCl = Common::getClFromType($aLession['type']);
    $postCl = $dbmg->$postCl;
    $post = $postCl->findOne(['_id'=>$aLession['id']]);
    $dataSlide[] = array(
        'id' => $post['_id'],
        'name' => $post['name'],
        'avatar' => $post['avatar'],
        'url' => '/'.Common::getUrlFromType($aLession['type']).'?id='.$post['_id'].'&type='.$aLession['type']
    );
}

$tpl->assign("dataSlide",$dataSlide );

#List Giao tiếp cơ bản

$listgtcb = iterator_to_array($gtcbcl->find(array("status"=>"1",'free'=>'1'),array("_id","name","avatar","captions","datecreate"))->sort(array("_id"=>1))->limit(5),false);
foreach($listgtcb as $key=>$val){
    $listgtcb[$key]['datecreate'] = date('d/m/Y h:s',$val['datecreate']);
    $listgtcb[$key]['avatar'] = returnImage($val['avatar']);
}

$ogtcb = $listgtcb[0];
unset($listgtcb[0]);
$tpl->assign("objgtcb",$ogtcb);

$listcatgtcb = iterator_to_array($categorycl->find(array("parentid"=>"1425089128"),array("_id","name","namenoneutf","type"))->sort(array("key"=>-1)));
$tpl->assign("listcatgtcb", $listcatgtcb);
$tpl->assign("listgtcb",$listgtcb);

#List Luyện ngữ âm
$lnacl = $dbmg->luyennguam;
$listlna = iterator_to_array($lnacl->find(array("status"=>"1",'free'=>'1'),array("_id","name","avatar","captions"))->sort(array("_id"=>-1))->limit(4),false);
$tpl->assign("listlna",$listlna);
#List thư viện

$tvcl = $dbmg->thuvien;
$condTv = array(
    'status' => Constant::STATUS_ENABLE,
    '$or' => array(
            array('calendar' => array('$exists'=>false)),
            array('calendar' => array('$lte'=> time()))
    ),
    'free'=>'1'
);
//$refcond['status'] = "1";
//$refcond['_id'] = array('$ne'=>$id);
//$listtv = iterator_to_array($tvcl->find(array("category"=>array("1427183162")),array("_id","name","avatar","captions","category","datecreate"))->sort(array("_id"=>-1))->limit(4),false);
//foreach($listtv as $key=>$val){
//    $listtv[$key]['datecreate'] = date('d/m/Y h:s',$val['datecreate']);
//}
//$tpl->assign("listtv",$listtv);

//Radio
$condTv['category'] = '1427344702';
$listaudio = iterator_to_array($tvcl->find($condTv,array("_id","name","datecreate","avatar","category","datecreate"))->sort(array("_id"=>-1))->limit(5),false);
foreach($listaudio as $key=>$val){
    $listaudio[$key]['datecreate'] = date('d/m/Y h:s',$val['datecreate']);
}
$oaudio = $listaudio[0];
unset($listaudio[0]);
$tpl->assign("objaudio",$oaudio);

$listcatradio = iterator_to_array($categorycl->find(array("parentid"=>"1427344702"),array("_id","name","namenoneutf","type"))->sort(array("key"=>-1)));
$tpl->assign("listcatradio", $listcatradio);
$tpl->assign("listaudio",$listaudio);

//Video
$condTv['category'] = '1427183162';
$listvideo = iterator_to_array($tvcl->find($condTv,array("_id","name","avatar","category","datecreate"))->sort(array("_id"=>-1))->limit(5),false);
foreach($listvideo as $key=>$val){
    $listvideo[$key]['datecreate'] = date('d/m/Y h:s',$val['datecreate']);
}
$ovideo = $listvideo[0];
unset($listvideo[0]);
$tpl->assign("objvideo",$ovideo);

$listcatvideo = iterator_to_array($categorycl->find(array("parentid"=>"1427183162"),array("_id","name","namenoneutf","type"))->sort(array("key"=>-1)));
$tpl->assign("listcatvideo", $listcatvideo);
$tpl->assign("listvideo",$listvideo);

//hang ngay
//$condTv['category'] = '1428995217';
//$listthongdung = iterator_to_array($tvcl->find($condTv,array("_id","name","avatar","category","datecreate"))->sort(array("_id"=>-1))->limit(4),false);
//foreach($listthongdung as $key=>$val){
//    $listthongdung[$key]['datecreate'] = date('d/m/Y h:s',$val['datecreate']);
//}
//$tpl->assign("listthongdung",$listthongdung);

/*Thanh ngu*/
$condTv['category'] = '1427183137';
$listtn = iterator_to_array($tvcl->find($condTv,array("_id","name","avatar","category","datecreate"))->sort(array("_id"=>-1))->limit(5),false);
foreach($listtn as $key=>$val){
    $listtn[$key]['datecreate'] = date('d/m/Y h:s',$val['datecreate']);
}
$othanhngu = $listtn[0];
unset($listtn[0]);
$tpl->assign("objthanhngu",$othanhngu);
$listcatthanhngu = iterator_to_array($categorycl->find(array("parentid"=>"1427183137"),array("_id","name","namenoneutf","type"))->sort(array("key"=>-1)));
$tpl->assign("listcatthanhngu", $listcatthanhngu);
$tpl->assign("listtn",$listtn);
/*End Thanh ngu*/

/*Hang ngay*/
$condTv['category'] = '1428995217';
$listhangngay = iterator_to_array($tvcl->find($condTv,array("_id","name","avatar","category","datecreate"))->sort(array("_id"=>-1))->limit(5),false);
foreach($listhangngay as $key=>$val){
    $listhangngay[$key]['datecreate'] = date('d/m/Y h:s',$val['datecreate']);
}
$ohangngay = $listhangngay[0];
unset($listhangngay[0]);
$tpl->assign("objhangngay",$ohangngay);
$listcathangngay = iterator_to_array($categorycl->find(array("parentid"=>"1427183137"),array("_id","name","namenoneutf","type"))->sort(array("key"=>-1)));
$tpl->assign("listcathangngay", $listcathangngay);
$tpl->assign("listhangngay",$listhangngay);
/*End hang ngay*/

/*Kinhg nghiem*/
$condTv['category'] = '1427344743';
$listkinhnghiem = iterator_to_array($tvcl->find($condTv,array("_id","name","avatar","category","datecreate"))->sort(array("_id"=>-1))->limit(5),false);
foreach($listkinhnghiem as $key=>$val){
    $listkinhnghiem[$key]['datecreate'] = date('d/m/Y h:s',$val['datecreate']);
}
$okinhnghiem = $listkinhnghiem[0];
unset($listkinhnghiem[0]);
$tpl->assign("objkinhnghiem",$okinhnghiem);
$listcatkinhnghiem = iterator_to_array($categorycl->find(array("parentid"=>"1427344743"),array("_id","name","namenoneutf","type"))->sort(array("_id"=>1)));
$tpl->assign("listcatkinhnghiem", $listcatkinhnghiem);
$tpl->assign("listkinhnghiem",$listkinhnghiem);
/*End KN*/

//Famous
$condTv['category'] = '1450844989';
$listfamous = iterator_to_array($tvcl->find($condTv,array("_id","name","avatar","category","datecreate"))->sort(array("_id"=>-1))->limit(5),false);
foreach($listfamous as $key=>$val){
    $listfamous[$key]['datecreate'] = date('d/m/Y h:s',$val['datecreate']);
}
//print_r($listfamous);die;
$ofamous = $listfamous[0];
unset($listfamous[0]);
$tpl->assign("objfamous",$ofamous);

$listcatfamous = iterator_to_array($categorycl->find(array("parentid"=>"1450844989"),array("_id","name","namenoneutf","type"))->sort(array("key"=>-1)));
$tpl->assign("listcatfamous", $listcatfamous);
$tpl->assign("listfamous",$listfamous);

$allType = Common::getAllLessionType();
$showRegLessionPop = isset($_SESSION['reg_lession_popup']);
$tpl->assign("allType",$allType);
$tpl->assign("showRegLessionPop",$showRegLessionPop);

$tpl->assign("pagefile","home/index");

//Hoc ma choi
include "controller/home/tratu.php";
include "controller/hmc/index.php";//end Hoc ma choi

?>