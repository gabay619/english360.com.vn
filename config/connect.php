<?php
if(!isset($mgconn)){
$mgconn = new MongoClient("mongodb://root:123456$@friendclub.vn:27017");
$dbmg = $mgconn->tagt;
}
//$memcache = new Memcache;
//$memcache->connect("localhost",11211);
?>