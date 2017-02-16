<?php
$gtcbcl= $dbmg->faq;
$keyword = !empty($_GET['keyword']) ? convert_vi_to_en(strip_tags(trim($_GET['keyword']))) : '';

$error_msg = "";

$keywordRegex = new MongoRegex('/' . $keyword . '/ui');

$page = !empty($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
$limit = 10;
$cp = ($page - 1) * $limit;

$cursor = $gtcbcl->find(array('namenonutf'=>$keywordRegex));
$totalCount = 0;
$totalCount = $cursor->count();
$data['gtcb'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),true);
unset ($cursor);

if(empty($data)){
    $error_msg = "Không tìm thấy nội dung phù hợp";
}
$totalPage = ceil($totalCount / $limit);
$paging = show_paging($totalPage,$page,'page');

$tpl->assign("keyword",$keyword);
$tpl->assign("data",$data);
$tpl->assign("paging",$paging);
$tpl->assign("error_msg",$error_msg);
$tpl->assign("pageinfo",$pageinfo);
##Draw template
$tpl->assign("pagefile", 'search/index');

include "controller/hmc/index.php";
