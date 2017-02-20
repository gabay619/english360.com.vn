<?php
//$file = '3.jpg';
//var_dump(file_exists($file));

//if(!copy(__DIR__.'/../../MongoStore/data/tagt.4','tagt.4.bak')) echo 'Failed';
//var_dump($rs);
//if ($handle = opendir(__DIR__.'/../../MongoStore/data/')) {
//    while (false !== ($entry = readdir($handle))) {
//        if ($entry != "." && $entry != "..") {
//            echo "<a href='download.php?file=".$entry."'>".$entry."</a>\n";
//        }
//    }
//    closedir($handle);
//}
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'helpers/Mail.php';
require 'helpers/Curl.php';
$mail = new \helpers\Mail('congchinh.619@gmail.com','test','noi dung');
var_dump($mail->send());