<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(isset($_POST['submit'])){
    $data['status'] = 200;
    $targetFolder = "/uploads/".date("d-m-Y")."/";
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    $folder_name = '/';
//    if($_POST['create_folder_type'] == 'true'){
//        $folder_name = '/general/';
//        if(in_array($fileParts['extension'],array('jpg','jpeg','gif','png'))){
//            $folder_name = '/picture/';
//        }
//        if(in_array($fileParts['extension'],array('mp3','mp4','avi','mkv'))){
//            $folder_name = '/video/';
//        }
//    }
    //$targetPath = getcwd() . $targetFolder . $folder_name;
    $targetPath = $_SERVER['DOCUMENT_ROOT'].str_replace("../","",$targetFolder . $folder_name);
    if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);
//    $file_name = preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['Filedata']['name']);
    $file_name =  str_replace(" ","_",strtotime("now").".".$fileParts['extension']);
    $targetFile = str_replace("//","/",$targetPath) . $file_name;
    try{
        $rs = move_uploaded_file($tempFile,$targetFile);
    }catch (Exception $e){
        $data['status'] = 500;
        $data['mss'] = $e->getMessage();
        echo json_encode($data);exit;
    }
    if($rs){
        $file_path = $targetFolder.$folder_name.$file_name;
        $file_path = str_replace("//","/",$file_path);
        $image = $file_path;
        $data['status'] = 200;
        $data['mss'] = "Upload thành công";
        $data['file'] = array("index"=>strval(time().rand(0,99999)),"filename"=>"$file_name","src"=>"$file_path","path"=>"$file_path","image"=>"$image");
    }else{
        $data['status'] = 500;
        $data['mss'] = "Không thể upload file: $targetFile";
    }
    echo json_encode($data);exit;
}

?>
<form action="" enctype="multipart/form-data" method="post">
    <input type="file" name="Filedata">
    <input type="submit" value="Upload" name="submit">
</form>
