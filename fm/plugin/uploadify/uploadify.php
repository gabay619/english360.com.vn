<?php
include("../../config/config.php");
$targetFolder = empty($_POST['path']) ? $rootfolder.date('Y/m/d') : ltrim($_POST['path'],'/') ; // Relative to the root
$overwrite = (empty($_POST['overwrite']))?"false":$_POST['overwrite'];
if (!empty($_FILES)) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    $folder_name = '/';
    if(in_array($fileParts['extension'],array('jpg','jpeg','gif','png','bmp'))){
        $folder_name = '/picture';
    }
    else if(in_array($fileParts['extension'],array('mp4','avi','mkv','flv'))){
        $folder_name = '/video';
    }
    else if(in_array($fileParts['extension'],array('mp3','wav','m4a'))){
        $folder_name = '/video';
    }
    else {
        $folder_name = '/general';
    }


    $targetPath =$targetFolder . $folder_name;
    if (!file_exists($targetPath)) {
        mkdir($targetPath, 0777, true);
    }
    if($overwrite=="false")  $file_name = time() . '_' . $_FILES['Filedata']['name'];
    else if($overwrite=="true")  $file_name =  $_FILES['Filedata']['name'];
    $file_name = convertToUtf8($file_name);
    $targetFile = rtrim($targetPath,'/') . '/' . str_replace(" ","_",$file_name);
    $rs = move_uploaded_file($tempFile,$targetFile);
    if($rs){
        $image = "holder.js/60x60/text:zip";
        $data['status'] = 200;
        $data['mss'] = "$overwrite";
        $data['file'] = array("index"=>(string)strtotime("now").rand(0,99999),"filename"=>"$zipname","src"=>"$zippath","path"=>"$zippath","image"=>"$image","type"=>"zip","chose"=>false);
    }
    echo $targetPath;
}
?>