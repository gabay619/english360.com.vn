<?php
$gtcbcl= $dbmg->gtcb;
$lnacl = $dbmg->luyennguam;
$thuviencl = $dbmg->thuvien;
$hmcaudiocl = $dbmg->hmcaudio;
//$hmcvideocl = $dbmg->hmcvideo;
//$hmcgamecl = $dbmg->hmcgame;
//$hmcfaqcl = $dbmg->faq;
//$tudiencl = $dbmg->tudien;
$faqcl = $dbmg->faq;
$keyword = !empty($_GET['keyword']) ? convert_vi_to_en(strip_tags(html_entity_decode($_GET['keyword']))) : '';
//echo $keyword;

$error_msg = "";

$keywordRegex = new MongoRegex('/' . $keyword . '/ui');

$page = !empty($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
$limit = 10;
$cp = ($page - 1) * $limit;

$cursor = $gtcbcl->find(array('namenonutf'=>$keywordRegex));
$totalCount = 0;
$totalCount = $cursor->count();
$data['gtcb'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),true);
foreach($data['gtcb'] as $k=>$v){
    $data['gtcb'][$k]['datecreate'] = date('H:i d/m/Y', $v['datecreate']);
}
unset ($cursor);

$cursor = $lnacl->find(array('namenonutf'=>$keywordRegex));
$totalCount = 0;
$totalCount = $cursor->count();
$data['lna'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),true);
foreach($data['lna'] as $k=>$v){
    $data['lna'][$k]['datecreate'] = date('H:i d/m/Y', $v['datecreate']);
}
unset ($cursor);

$cursor = $hmcaudiocl->find(array('namenonutf'=>$keywordRegex));
$totalCount = 0;
$totalCount = $cursor->count();
$data['song'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),true);
foreach($data['song'] as $k=>$v){
    $data['song'][$k]['datecreate'] = date('H:i d/m/Y', $v['datecreate']);
}
unset ($cursor);

$cursor = $thuviencl->find(array('namenonutf'=>$keywordRegex));
$totalCount = 0;
$totalCount = $cursor->count();
$data['thuvien'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),true);
foreach($data['thuvien'] as $k=>$v){
    $data['thuvien'][$k]['datecreate'] = date('H:i d/m/Y', $v['datecreate']);
}
unset ($cursor);
//$cursor = $hmcaudiocl->find(array('namenonutf'=>$keywordRegex));
//$totalCount = 0;
//$totalCount = $cursor->count();
//$data['hmcaudio'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),true);
//unset ($cursor);
//$cursor = $hmcvideocl->find(array('namenonutf'=>$keywordRegex));
//$totalCount = 0;
//$totalCount = $cursor->count();
//$data['hmcvideo'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),true);
//unset ($cursor);
//$cursor = $hmcgamecl->find(array('namenonutf'=>$keywordRegex));
//$totalCount = 0;
//$totalCount = $cursor->count();
//$data['hmcgame'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),true);
//unset ($cursor);
//$cursor = $faqcl->find(array('namenonutf'=>$keywordRegex));
//$totalCount = 0;
//$totalCount = $cursor->count();
//$data['faq'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),true);
//$cursor = $faqcl->find(array('namenonutf'=>$keywordRegex));
//$totalCount = 0;
//$totalCount = $cursor->count();
//$data['thuvien'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),true);
//unset ($cursor);
//$cursor = $tudiencl->find(array('value'=>$keywordRegex));
//$totalCount = 0;
//$totalCount = $cursor->count();
//$data['tudien'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),true);

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
