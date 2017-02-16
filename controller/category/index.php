<?php
$categorycl = $dbmg->category;
$historycl = $dbmg->history_log;
$catid = $_GET['catid'];
$obj = (array)$categorycl->findOne(array("_id"=>$catid));
$type = $_GET['type'];
if(!isset($type)) $type = $obj['type'];
$tpl->assign("obj",$obj);
#Pageing
$limit = 1000000;
$limit1 = 8;
$p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit1;
if($obj['type']=="tudien"){
    //Lưu log
    $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_TU_DIEN,
            'chanel' => HistoryLog::CHANEL_WAP,
            'ip' => Network::ip(),
            'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
    );
    if(!isset($_SESSION['notsave_log']))
        $historycl->insert($newHistoryLog);

    ## Lấy thông tin bài viết từ bảng Từ điển
    $tudiencl = $dbmg->tudien;
    $cond['catid'] = $catid;

    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    if(!$keyword) {$listalpha ='1';}else{$listalpha='2';}
    if (!empty($keyword)) {

        $cond['value'] = new MongoRegex("/".strtolower($keyword)."/ui");
//        $cond['catid'] = $catid;
//        $cond = array('$or' => array(array('_id' => "$keyword"), array('value' => new MongoRegex("/$keyword/iu"),"catid"=>$catid)));
    }
    $listarticle = iterator_to_array($tudiencl->find($cond,array("_id","key","value","content"))->sort(array("key"=>-1))->skip($cp)->limit($limit),false);
    $result = array();
    $tpl->assign("catid",$catid);
    foreach ($listarticle as $data) {
        $catid = $data['key'];
        if (isset($result[$catid])) $result[$catid][] = $data;
        else $result[$catid] = array($data);
        /*var_dump($data['linkdict']);die;*/
    }
    $listcat = iterator_to_array($categorycl->find(array("type"=>"tudien"),array("_id","name"))->sort(array("key"=>-1)));

    $tpl->assign("listcat", $listcat);
    ##Genpage
    $rowcount = $tudiencl->count($cond);
    $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
    $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
    $tpl->assign("paging",$paginginfo);
    $tpl->assign("keyword",$keyword);
    $tpl->assign("listalpha",$listalpha);
    ##End Paging
    $tpl->assign("listarticle",array_reverse($result));
    $tpl->assign("pagefile","category/tudien");
}
else{
    $dataSlide = array();
    ## Lấy thông tin bài viết từ bảng Thư viện
    $thuviencl = $dbmg->thuvien;
    $cond['status'] = Constant::STATUS_ENABLE;
    $cond['category'] = $catid;
    $cond['$or'] = array(
            array('calendar' => array('$exists'=>false)),
            array('calendar' => array('$lte'=> time()))
    );
    $thuvienId = '1427182938';
    if(!isset($type)){
        $cat = $categorycl->findOne(array('_id'=>$catid));
        $type = $cat['type'];
    }
    $parentCat = $categorycl->findOne(array('type'=>$type, 'parentid'=>$thuvienId));

    $listslide = iterator_to_array($thuviencl->find($cond)->sort(array("_id"=>-1))->limit(5), false);
    $slideId = array();
    foreach($listslide as $key=>$val){
        $slideId[] = $val['_id'];
        $dataSlide[] = array(
            'id' => $val['_id'],
            'name' => $val['name'],
            'avatar' => $val['avatar'],
            'url' => makelink::makethuvien($catid, $val['_id'], $val['name'])
        );
    }

    $cond['_id'] = array('$nin'=>$slideId);
    $listarticle = iterator_to_array($thuviencl->find($cond,array("_id","name","avatar","category","datecreate"))->sort(array("_id"=>-1))->skip($cp)->limit($limit1),false);
    foreach($listarticle as $key=>$val){
        $listarticle[$key]['datecreate'] = date('d/m/Y H:s',$val['datecreate']);
    }
    $tpl->assign("dataSlide",$dataSlide );

    $listcat = iterator_to_array($categorycl->find(array("parentid"=>$parentCat['_id']),array("_id","parentid","name","namenoneutf","type"))->sort(array("_id"=>1)));
    $tpl->assign("listcat", $listcat);
    ##Genpage
    $rowcount = $thuviencl->count($cond);
    $totalpage = ceil($rowcount/$limit1);if($totalpage<=1) $totalpage = 1;
    $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
    $tpl->assign("paging",$paginginfo);
    ##End Paging
    $tpl->assign("listarticle",$listarticle);
    $tpl->assign("pagefile","category/thuvien");
}
//Hoc ma choi
include "controller/hmc/index.php";

?>