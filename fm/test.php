<?php
//echo 1;die;
echo ini_get('max_input_time');
echo ini_get('upload_max_filesize');
include("config/config.php");
if(!isset($_SESSION['uinfoadmin'])) header("Location: login.php");

// Nếu người dùng click Upload
if (isset($_POST['submit']))
{
    // Nếu người dùng có chọn file để upload
    if (isset($_FILES['file']))
    {
        // Nếu file upload không bị lỗi,
        // Tức là thuộc tính error > 0
        if ($_FILES['file']['error'] > 0)
        {
            echo 'File Upload Bị Lỗi';
        }
        else{
            $rootfolder= "uploads/file/";
            $targetFolder = empty($_POST['path']) ? $rootfolder.date('Y/m/d') : ltrim($_POST['path'],'/') ; // Relative to the root
            $targetFolder = rtrim($targetFolder,'/');
            $fileParts = pathinfo($_FILES['file']['name']);
            $tempFile = $_FILES['file']['tmp_name'];
            $folder_name = '/';
            if($_POST['create_folder_type'] == 'true'){
                $folder_name = '/general/';
                if(in_array($fileParts['extension'],array('jpg','jpeg','gif','png'))){
                    $folder_name = '/picture/';
                }
                if(in_array($fileParts['extension'],array('mp4','avi','mkv'))){
                    $folder_name = '/video/';
                }
                if(in_array($fileParts['extension'],array('mp3','m4a'))){
                    $folder_name = '/audio/';
                }
            }
            $targetPath =$targetFolder . $folder_name;
            if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);

            $targetFile = $targetPath . str_replace(" ","_",$file_name);
            // Upload file
            $rs = move_uploaded_file($tempFile, $targetPath);
            if ($rs) {
                $file_path = $targetFolder . $folder_name . $file_name;
                echo 'Upload thành công: '.$file_path;
            }else{
                echo 'Upload thất bại.';
            }
        }
    }
    else{
        echo 'Bạn chưa chọn file upload';
    }
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" value="UPLOAD" name="submit">
</form>
