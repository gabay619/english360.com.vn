<?php
$pagecl = $dbmg->page;
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

$obj = $pagecl->findOne(array('slug'=>$slug, 'status'=>Constant::STATUS_ENABLE));
$obj['name'] = $name;
$tpl->assign("obj",$obj);
$tpl->assign("pagefile","component/page");
include "controller/hmc/index.php";
