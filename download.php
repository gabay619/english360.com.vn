<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 06/01/2017
 * Time: 8:37 AM
 */
set_time_limit(0);
ini_set("memory_limit", "-1");
$file = basename($_GET['file']);
$file = __DIR__.'/../../MongoStore/data/'.$file;

if(!$file){ // file does not exist
    die('file not found');
} else {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$file");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
//    if (ob_get_level()) {
//        ob_end_clean();
//    }
    ob_end_clean();
    flush();
    // read the file from disk
    readfile($file);exit;
}