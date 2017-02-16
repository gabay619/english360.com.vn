<?php
$pagecl = $dbmg->page;
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
switch($slug){
    case "gioi-thieu":
        $type = Constant::TYPE_INFO;
        $name = 'Giới thiệu';
        break;
    case "dieu-khoan":
        $type = Constant::TYPE_TERM;
        $name = 'Điều khoản';
        break;
    case "tai-ung-dung":
        $type = Constant::TYPE_DOWNLOAD;
        $name = 'Tải ứng dụng';
        break;
    default:
        $type = Constant::TYPE_CONTACT;
        $name = 'Liên hệ';
        break;
}

$obj = $pagecl->findOne(array('type'=>$type, 'status'=>Constant::STATUS_ENABLE));
$obj['name'] = $name;
$tpl->assign("obj",$obj);
$tpl->assign("pagefile","component/page");
include "controller/hmc/index.php";
