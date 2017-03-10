<?php
//include ("/plugin/uploadify/uploadifyy.php");
$hmcaudiocl = $dbmg->hmcaudio;
$uploadcl = $dbmg->upload;
$categorycl = $dbmg->category;
$usercl = $dbmg->user;
$id = $_GET['id'];
$catename = false;
$listcatsong = iterator_to_array($categorycl->find(array("parentid"=>"1450854263"),array("_id","name","namenoneutf"))->sort(array("key"=>-1)));
$tpl->assign("listcatsong", $listcatsong);
if(isset($_GET['letter'])){
    $letter = $_GET['letter'];
    if(!ctype_alpha($letter))
        $letter = '';
    $cond = array(
            'status' => Constant::STATUS_ENABLE,
            '$or' => array(
                    array('calendar' => array('$exists'=>false)),
                    array('calendar' => array('$lte'=> time()))
            )
    );
    if(!empty($letter)){
        $regex = new MongoRegex('/^'.$letter.'/ui');
        $cond['namenonutf'] = $regex;
    }
    $list = iterator_to_array($hmcaudiocl->find($cond,array("_id","name","avatar","contents","singer","datecreate"))->sort(array("namenonutf"=>1))->skip($cp)->limit($limit),false);
    foreach($list as $k=>$v){
        $list[$k]['datecreate'] = date('d/m/Y H:i', $v['datecreate']);
    }
    #Chu cai
    $rangeChar = array();
    for($i = 0; $i <= 25 ; $i++){
        $rangeChar[$i] = Common::numtoalpha($i);
    }
    ##Paging
    $rowcount = $hmcaudiocl->count($cond);
    $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
    $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
    $tpl->assign("paging",$paginginfo);
    $tpl->assign("listarticle",$list);
    $tpl->assign("rangeChar",$rangeChar);
    $tpl->assign("pagefile", "hmc/audio/search");

}
else if(!isset($id)) { // Lấy danh sách bài hát
    $limit = 10;
    $p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
    $cond = array(
            'status' => Constant::STATUS_ENABLE,
            '$or' => array(
                    array('calendar' => array('$exists'=>false)),
                    array('calendar' => array('$lte'=> time()))
            )
    );
    $listnew = iterator_to_array($hmcaudiocl->find($cond,array("_id","name","avatar","category","datecreate"))->limit(5)->sort(array("_id"=>-1)),false);
    $dataSlide = array();
    $slideId = array();
    foreach($listnew as $key=>$val){
        $slideId[] = $val['_id'];
        $dataSlide[] = array(
            'id' => $val['_id'],
            'name' => $val['name'],
            'avatar' => $val['avatar'],
            'url' => makelink::makehmcaudio($val['_id'], $val['name'])
        );

    }
    $cond['_id'] = array('$nin' => $slideId);
    if(isset($_GET['catid'])){
        $cate = $categorycl->findOne(array('_id'=>strval($_GET['catid'])));
        if($cate) $catename = $cate['name'];
        $cond['category'] = strval($_GET['catid']);
    }
    $list = iterator_to_array($hmcaudiocl->find($cond,array("_id","name","avatar","contents","singer","datecreate"))->sort(array("_id"=>-1))->skip($cp)->limit($limit),false);
    foreach($list as $k=>$v){
        $list[$k]['datecreate'] = date('d/m/Y H:i', $v['datecreate']);
    }
    $tpl->assign("dataSlide",$dataSlide );
    #Chu cai
    $rangeChar = array();
    for($i = 0; $i <= 25 ; $i++){
        $rangeChar[$i] = Common::numtoalpha($i);
    }
    ##Paging
    $rowcount = $hmcaudiocl->count($cond);
    $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
    $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
    $tpl->assign("paging",$paginginfo);
    $tpl->assign("listarticle",$list);
    $tpl->assign("rangeChar",$rangeChar);
    $tpl->assign("catename", $catename);
    $tpl->assign("pagefile", "hmc/audio/index");
//    $tpl->assign("pagefile", "component/hocmachoi");
}
else{ // Lấy chi tiết bài hát
    $type = Constant::TYPE_SONG;
    $obj = $hmcaudiocl->findOne(array("_id"=>$id));
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
            if($result){
                $_SESSION['flash_mss'] = 'Hãy đăng ký gói cước để tiếp tục sử dụng dịch vụ.';
                header("Location: /regispack.php");exit();
            }
        }
    }
    include "/countView.php";

    include "controller/component/emailbox.php";
    $usercl = $dbmg->user;
    $uploadCl = $dbmg->upload;
    if(isset($_FILES['file_upload'])){
        $ext = pathinfo($_FILES['file_upload']['name'])['extension'] ;
        switch($ext){
            case 'mp3':
            case 'wmv':
            case 'ogg':
                break;
            default:
                echo "Chỉ được upload tệp âm thanh (mp3, wmv, ogg)"; die;
        }
//        echo 1;die;
        $targetfolder = "/uploads/".date("d-m-Y")."/audio/";
        $targetPath = $_SERVER['DOCUMENT_ROOT'].str_replace("../","",$targetfolder);
        if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);
        $file_name = time().'_'.$_SESSION['uinfo']['_id'].'.'.$ext;
        $targetFile = str_replace("//","/",$targetPath) . $file_name;
//        var_dump($targetFile);die;

        if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $targetFile))
        {
            $newUpload = array(
                    "_id"=>strval(time()),
                    "uid"=>$_SESSION['uinfo']['_id'],
                    "path"=> $targetfolder.$file_name,
                    "type"=>Constant::TYPE_SONG,
                    "datecreate"=>time(),
                    "itemid"=>$id
            );
            $uploadCl->insert($newUpload);
//               echo "The file ". basename( $_FILES['file_upload']['name']). " is uploaded";
//            $_POST['medialink'] = $targetfolder;
        }
        else {
               echo "Problem uploading file";die;
        }
    }

    $upload = iterator_to_array($uploadcl->find(array("itemid"=>strval($id), 'type'=>Constant::TYPE_SONG),array("_id","uid","path", "datecreate"))->sort(array("_id"=>-1)),false);
    foreach($upload as $k=>$v){
//        echo $v['_id'].'<br>';
        $upload[$k]['datecreate'] = date('d/m/Y H:i', $v['datecreate']);
        $upload[$k]['delete'] = isset($_SESSION['uinfo']) && $_SESSION['uinfo']['_id'] == $v['uid'];
        $uinfo = $usercl->findOne(array("_id"=>$v['uid']), array('_id','displayname','phone'));
        if($uinfo)
            $upload[$k]['userinfo'] = $uinfo;
        else
            unset($upload[$k]);
//        print_r($upload[$k]['username']);
    }
//    print_r(count($upload));
//    die;
    $showUpload = count($upload) > 0;
//    print_r($upload);
//    foreach ($obj as $key=>$val){
//        $obj[$key]['eng'] = $val['eng'];
//        $obj[$key]['vie'] = $val['vie'];
//    }
    $obj['medialink'] = Constant::BASE_URL.$obj['medialink'];
    $obj['datecreate'] = date('h:i | d/m/Y',$obj['datecreate']);
    $type = Constant::TYPE_SONG;
    include "controller/comment/index.php";
    //bài học liên quan
    $refcond = array(
            'status' => Constant::STATUS_ENABLE,
            '_id' => array('$ne'=>$id),
            'calendar' => array('$lte'=> time()),
//            '$or' => array()
//            '$or' => array(
//                    array('calendar' => array('$exists'=>false)),
//                    array('calendar' => array('$lte'=> time()))
//            )
    );
//    $refcond['status'] = "1";
//    $refcond['_id'] = array('$ne'=>$id);
    $tagArr = explode(',',$obj['keyword']);
    foreach ($tagArr as $tag){
        $refcond['$or'][] = array('keyword' => new MongoRegex("/$tag/ui"));
    }
    if(count($o['category'])>0) $refcond['category'] = $o['category'][0];
    $listref = iterator_to_array($hmcaudiocl->find($refcond,array("_id","name","avatar","category","datecreate"))->limit(5),false);
    foreach($listref as $key=>$val){
        $listref[$key]['datecreate'] = date('h/m/Y, H:s',$val['datecreate']);
    }

    $newcond = array(
        'status' => Constant::STATUS_ENABLE,
        '_id' => array('$ne'=>$id),
        'calendar' => array('$lte'=> time()),
//            '$or' => array()
//            '$or' => array(
//                    array('calendar' => array('$exists'=>false)),
//                    array('calendar' => array('$lte'=> time()))
//            )
    );
    $listnew = iterator_to_array($hmcaudiocl->find($newcond,array("_id","name","avatar","category","datecreate"))->limit(5)->sort(array("_id"=>-1)),false);
    foreach($listnew as $key=>$val){
        $listnew[$key]['datecreate'] = date('h/m/Y, H:s',$val['datecreate']);
    }

    $tpl->assign("showUpload", $showUpload);
    $tpl->assign("ref", $listref);
    $tpl->assign("new", $listnew);
//end Bài học liên quan
    $tpl->assign("obj", $obj);
    $tpl->assign("catename", $catename);
    $tpl->assign("upload", $upload);
    $tpl->assign("pagefile", "hmc/audio/detail");
    include "controller/component/popreg.php";
}

include "controller/hmc/index.php";
?>