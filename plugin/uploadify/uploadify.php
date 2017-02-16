<?php
    $data['status'] = 200;
    $targetFolder = "/uploads/".date("d-m-Y")."/";
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    $folder_name = '/';
    if($_POST['create_folder_type'] == 'true'){
        $folder_name = '/general/';
        if(in_array($fileParts['extension'],array('jpg','jpeg','gif','png'))){
            $folder_name = '/picture/';
        }
        if(in_array($fileParts['extension'],array('mp3','mp4','avi','mkv'))){
            $folder_name = '/video/';
        }
    }
    //$targetPath = getcwd() . $targetFolder . $folder_name;
    $targetPath = $_SERVER['DOCUMENT_ROOT'].str_replace("../","",$targetFolder . $folder_name);
    if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);    
    $file_name =  str_replace(" ","_",strtotime("now")."_".$_FILES['Filedata']['name']);
    $targetFile = str_replace("//","/",$targetPath) . $file_name;	
    $rs = move_uploaded_file($tempFile,$targetFile);
    if($rs){
        $file_path = $targetFolder.$folder_name.$file_name;
        $file_path = str_replace("//","/",$file_path);
        $image = $file_path;
        $data['status'] = 200;
        $data['mss'] = "Upload thành công";
        $data['file'] = array("index"=>(string)strtotime("now").rand(0,99999),"filename"=>"$file_name","src"=>"$file_path","path"=>"$file_path","image"=>"$image","type"=>"$type");
    }else{
        $data['status'] = 500;
        $data['mss'] = "Không thể upload file: $targetFile";    
    }
    echo json_encode($data);
?>