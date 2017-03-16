<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14/03/2017
 * Time: 3:51 PM
 */
include "config/connect.php";
$get = $_GET['cl'];
$collection = $dbmg->$get;
$url = 'http://english360.vn/clonedata.php?cl='.$get;
$data = json_decode(file_get_contents($url),true);
//print_r($data);die;
foreach ($data as $item){
    if(!$collection->findOne(array('_id'=>$item['_id']))){
        $collection->insert($item);
        echo 'Insert '.$item['_id'].'<br>';
    }else{
        $collection->update(array('_id'=>$item['_id']), array('$set'=>$item));
        echo 'Update '.$item['_id'].'<br>';
    }
}
