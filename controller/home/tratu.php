<?php

$anh_vietCl = $dbmg->anh_viet;
$viet_anhCl = $dbmg->viet_anh;
$keyword = !empty($_GET['tratu']) ? convert_vi_to_en(strip_tags(trim($_GET['keyword']))) : '';

$keywordRegex = new MongoRegex('/' . $keyword . '/ui');
$cursor = $anh_vietCl->find(array('namenonutf'=>$keywordRegex));
$data['anh_viet'] = iterator_to_array($cursor->sort(array('_id'=>-1)),true);
unset ($cursor);
$cursor = $viet_anhCl->find(array('namenonutf'=>$keywordRegex));
$data['viet_anh'] = iterator_to_array($cursor->sort(array('_id'=>-1)),true);
##Draw da
$tpl->assign("keyword",$keyword);
$tpl->assign("data",$data);
$tpl->assign("tratu","component/tratu  ");
