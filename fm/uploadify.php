<?php
include("config/config.php");
$targetFolder = empty($_POST['path']) ? '/uploads/'.date('Y/m/d') : '/'.ltrim($_POST['path'],'/') ; // Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    $folder_name = '/general';
    if(in_array($fileParts['extension'],array('jpg','jpeg','gif','png'))){
        $folder_name = '/picture';
    }
    if(in_array($fileParts['extension'],array('mp3','mp4','avi','mkv'))){
        $folder_name = '/video';
    }
    
	$targetPath = getcwd() . $targetFolder . $folder_name;
    if (!file_exists($targetPath)) {
        mkdir($targetPath, 0777, true);
    }
    $name = standardStr(convertToUtf8($_FILES['Filedata']['name']));
    $file_name = time() . '_' . $name;
	$targetFile = rtrim($targetPath,'/') . '/' . $file_name;	
	
    $rs = move_uploaded_file($tempFile,$targetFile);
    echo $rs;
	
}
?>