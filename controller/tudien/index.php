<?php
$tudienc = $dbmg->tudien;
$categorycl = $dbmg->category;
$id = $_GET['id'];
if(isset($id)){

}
else{

    $cond['status'] = "1";
    $cond['type'] = "tudien";
    $listcat = iterator_to_array($categorycl->find($cond,array("_id","name","avatar"))->sort(array("_id"=>-1)),false);
    var_dump($listcat); die;
    $tpl->assign("listcat", $listcat);
    $tpl->assign("pagefile", "tudien/index");
}

include "controller/hmc/index.php";
?>