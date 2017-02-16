<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 30/12/2016
 * Time: 3:57 PM
 */
$collection = $dbmg->event_user;
$id = $_GET['id'];
$collection->remove(array("_id"=>"$id"));
$_SESSION['status'] = 'success';
$link = cpagerparm("status,id,tact")."tact=event_user";
header("Location: $link");