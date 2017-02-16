<?php
$userCl = $dbmg->user;
$examCl = $dbmg->saveexam;
$gtcbCl = $dbmg->gtcb;
$uid=($_SESSION['uinfo']['_id']);

$listExam = $examCl->findOne(array("uid"=>$uid));

foreach ($listExam['ex'] as $ex){
    $listgtcb = iterator_to_array($gtcbCl->find(array("_id"=>$ex),array("_id","name","avatar"))->limit(5)->sort(array("_id"=>-1)),false);
foreach ($listgtcb as $i){
    $item[]=array(
        'id'=>$i['_id'],
        'name'=>$i['name'],
        'avatar'=>$i['avatar']
    );
}
}
$tpl->assign("exam", $item);
$tpl->assign("pagefile", "user/saveexam");

//Hoc ma choi
$hmcaudiocl = $dbmg->hmcaudio;
$gameCl = $dbmg->category;
$thuvienCl = $dbmg->thuvien;
$cond['status'] = "1";
$listsong = iterator_to_array($hmcaudiocl->find(array("status"=>"1"),array("_id","name","avatar","contents"))->sort(array("_id"=>-1))->limit(4),false);
$tpl->assign("listsong",$listsong);

$listfilm = iterator_to_array($thuvienCl->find(array("category"=>"1450861603"),array("_id","name","avatar"))->sort(array("_id"=>-1))->limit(4),false);
$tpl->assign("listfilm",$listfilm);
$listgame = iterator_to_array($gameCl->find(array("parentid"=>"1425089517"),array("_id","name","avatar"))->sort(array("_id"=>-1))->limit(4),false);
$tpl->assign("listgame",$listgame);
//end Hoc ma choi
?>