<?php
if(!isset($mgconn)){
$mgconn = new MongoClient("mongodb://localhost:27017");
$dbmg = $mgconn->tagt;
    if(isset($_SESSION['uinfo'])){
        $usercl = $dbmg->user;
        $user = $usercl->findOne(array('_id'=>$_SESSION['uinfo']['_id']));
        if($user['ssid'] != session_id()){
            unset($_SESSION['uinfo']);
        }
    }
}
//$memcache = new Memcache;
//$memcache->connect("localhost",11211);
?>