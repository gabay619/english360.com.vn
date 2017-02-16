<?php 
ini_set('display_errors','On');
error_reporting(1);
include("config/config.php");
header('Content-type: application/json; charset=utf8');
$act = $_GET['act'];if(empty($act)) $act= $_POST["act"];

switch ($act)
{
	case "listfolder": listfolder(); break;
    case "fileinfo": fileInfo(); break;
    case "renamefile": renameFile(); break;
    case "savefile": saveFile(); break;
    case "searchfile": searchFile(); break;
    case "createfolder": createfolder(); break;
    case "zipfile":zipfile();break;
    case "delfolder":delfolder();break;
    case "delfile":delfile();break;
    case "uploadfile" : uploadfile();break;
}
function listfolder(){
    global $siteUrl,$uinfoadmin;
    $rootfolder= "uploads/file/".md5($uinfoadmin)."/";
    $path = $_GET["path"];$path = strlen($path)>0?$path."/":$rootfolder;    
    $path = str_replace('//','/',$path);
    
    $firstload =$_GET['firstload'];
    if($firstload=="true" && isset($_SESSION['lastpath'])) $path = $_SESSION['lastpath'];
    $_SESSION['lastpath'] = $path; //Support Last Access
    $lasttime = isset($_GET['ltime']) ? $_GET['ltime'] : 999999999999999;
    $files = glob($path . "*");
    usort($files, sortFileByCreateDate);
    $count = 0; $filescount = count($files); $id = 0;
    $newltime = $lasttime;
    
    foreach($files as $file)
    {   
        $file = str_replace("//","/",$file);
        ++$id;
        if (filectime($file) < $lasttime) {           
            if(!is_dir($file)){
                $filename = end(explode("/",$file));
                $type = strtolower(end(explode(".",$filename)));
                if(!in_array($type,array("png","jpg","jpeg","gif","bmp"))) $image = "holder.js/60x60/text:$type";
                else $image = $siteUrl . str_replace("E:/videohotmedia/","videohot/uploads/",$file);
                $webpath =  $siteUrl . str_replace("E:/videohotmedia/","videohot/uploads/",$file);
                $item = array("index"=>(string)strtotime("now").rand(0,99999),"filename"=>"$filename","src"=>"$file","path"=>"$file","image"=>"$image","type"=>"$type","chose"=>false,"webpath"=>"$webpath");
                $listfile[] = $item;  
            }
            ++$count;
            if (($count > 34) || ($id == $filescount)) {
                $newltime = filectime($file);
                break;
            }
        }
    }
    if ($lasttime == 999999999999999) {
        $dirs = glob($path . "*", GLOB_ONLYDIR);
        foreach($dirs as $file)
        {   
            $file = str_replace("//","/",$file);
            ++$id;
            if(is_dir($file))
            {
                $foldername = end(explode("/",$file));
                $item = array("index"=>(string)strtotime("now").rand(0,99999),"foldername"=>"$foldername","src"=>"$file","indexfolder"=>count($folder));
                $folder[] = $item;
            }   
        }
        if ($newltime == $lasttime) $newltime = filectime(end($dirs));
    }
    
    $dtr["folder"] = $folder;
    $dtr["file"] = $listfile;
    $temppath = str_replace($rootfolder,'$rootfolder/', $path);
    $lpath = explode("/",$temppath);
    $apath = array();$src = "";
    foreach ($lpath as $item)
    {
        if(strlen($item)>0){
            if($item=='$rootfolder')     $src = $rootfolder."/";
            else $src .= $item."/";
            $apath[] = array("name"=>$item,"src"=>$src);
        }
    }
    
    $dtr["inpath"] = $apath;
    $dtr["realpath"] = $path;
    $dtr["firstload"] =$firstload;
    $dtr['lasttime'] = $newltime;
    //print_r($dtr);die;
    echo json_encode($dtr);
}
function fileInfo(){
    global $filetypes, $siteUrl;
    $path = $_GET["path"];
    $data['status'] = 404;
    $data['mss'] = "Success";
    $data['data'] = null;
    $path = ltrim($path,'/');
    if (strlen($path)>0) {
        if (file_exists($path)) {
            $data['status'] = 200;
            $info = stat($path);
            if ($info !== false) {
                $filename = end(explode("/",$path));
                $type = strtolower(end(explode(".",$filename)));
                $kb = $info['size'] / 1024;
                if ($kb > 100) {
                    $kb /= 1024;
                    $elem['size'] = strval(round($kb, 3))." mb";
                } else if($kb > 1) {
                    $elem['size'] = strval(round($mb, 3))." kb";
                } else {
                    $elem['size'] = $info['size']."  byte";
                }
                $elem['lastaccess'] = date('d/m/Y',$info['atime']);
                $elem['lastmodified'] = date('d/m/Y',$info['mtime']);
                $data['fileinfor'] = $elem;
                $data['name'] = $filename;
                if(in_array($type, $filetypes['text'])) {
                    $el['text'] = file_get_contents($path);
                }
                else if(in_array($type, $filetypes['media'])) {
                    if (in_array($type, array("mp3", "wav", "ogg")))
                        $el['type'] = "audio" ;
                    else $el['type'] = "video" ;
                    $el['media'] = "/".$path;
                }
                if(in_array($type, $filetypes['image'])) {
                    $el['image'] = $path;
                }
                $data['data'] = 'default';
            }
        } else {
            $data['mss'] = "Khong co file nay hoac khong the truy cap";
        }
    }    
    echo json_encode($data);
}

function renameFile() {
    global $siteUrl;
    $checkfalse = ($_POST['newname'] =='') || ($_POST['path']  =='');
    $data['status'] = 404;
    if (!$checkfalse) {
        $oldname = $_POST['path'];
        $_POST['newname'] = standardStr(convertToUtf8($_POST['newname']));
        $patharray = array_filter(explode("/", $oldname));
        $count = count($patharray);
        array_pop($patharray);
        if($count === 0) {
            $newname = $_POST['newname'];
        }
        else if($count >= 1) {
            $newname = implode("/", $patharray).'/'.$_POST['newname'];
        }
        if (!file_exists($newname)) {
            if (file_exists($oldname)) {
                if(rename($oldname, $newname)) {
                    $data['status'] = 200;
                    $data['mess'] = "Đổi tên thành công";
                    $data['newname'] = $_POST['newname'];
                    $data['newpath'] = $newname;
                    $data['newwebpath'] = str_replace("../","",$siteUrl.$newname);
                } else {
                    $data['mess'] = "Không thể đổi được tên file này";
                }
            } else {
                $data['mess'] = "File không tồn tại hoặc không thể truy cập";
            }
        } else {
            $data['mess'] = "Đã có file cùng tên";
        }
    } else {
        $data['mess'] = "Cần điền đầy đủ thông tin";
    }
    echo json_encode($data);
}

function saveFile() {
    $checkfalse = ($_POST['path']  =='') || !isset($_POST['content']);
    $data['status'] = 404;
    if (!$checkfalse) {
        $path = $_POST['path'];
        if (file_exists($path)) {
            $res = file_put_contents($path, $_POST['content']);
            if ($res !== FALSE) {
                $data['status'] = 200;
                $data['mess'] = "Save file success";
            } else {
                $data['status'] = 500;
                $data['mess'] = "Internal Server Error or File is Read-Only";
            }
        } else {
            $data['mss'] = "Khong co file nay hoac khong the truy cap";
        }
    } else {
        $data['mess'] = "Cần điền đầy đủ thông tin";
    }
    echo json_encode($data);
}

function createfolder(){
    $path = isset($_POST['path']) ? $_POST['path']  : '';
    $folder_name = isset($_POST['name']) ? $_POST['name']  : '';
    $folder_name = standardStr(convertToUtf8($folder_name));
    $permission = isset($_POST['permission']) ? intval($_POST['permission'])  : 0;
    $file = $path.$folder_name.'/';
    if(!empty($path) && !empty($folder_name)){
        if(!file_exists($file)){
            $rs = mkdir($path.$folder_name,$permission,true);
            $data['status'] = 200;
            $data['mss'] = $rs;
            $data['folder'] = array("index"=>(string)strtotime("now").rand(0,99999),"foldername"=>"$folder_name","src"=>"$file");
        }else{
            $data['status'] = 500;
            $data['mss'] = "Folder đã tồn tại";
            $data['folder'] = null;
        }        
        
    }else{
        $data['status'] = 500;
        $data['mss'] = "Đường dẫn và tên folder không được để trống.";
        $data['folder'] = null;
    }
    echo json_encode($data);
}

function zipfile(){
    $path = isset($_POST['path']) ? $_POST['path']  : '';
    $list_file = isset($_POST['list_file']) ? rtrim($_POST['list_file'],',')  : '';
    $data['status'] = 200;
    if(empty($path)){
        $data['status'] = 500;
        $data['mss'] = "Lỗi đường dẫn";
        $data['file'] = null;    
    }
    if(empty($list_file)){
        $data['status'] = 500;
        $data['mss'] = "Bạn phải chọn ít nhất 1 file";
        $data['file'] = null;    
    }
    if($data['status'] == 200){
        $list_file = explode(',',$list_file);
        $zip = new ZipArchive;
        $zipname = date("d-m-Y_h-i-s").".zip";
        $zippath = $path."/".$zipname;
        $res = $zip->open($zippath, ZipArchive::CREATE);
        if ($res === TRUE) {
            foreach($list_file as $file){
                $zip->addFile($path."/".$file,$file);
            }
            $zip->close();                           
        }
        $image = "holder.js/60x60/text:zip";
        $data['status'] = 200;
        $data['mss'] = "Success";
        $data['file'] = array("index"=>(string)strtotime("now").rand(0,99999),"filename"=>"$zipname","src"=>"$zippath","path"=>"$zippath","image"=>"$image","type"=>"zip","chose"=>false);
    }
    echo json_encode($data);
}
function delfolder(){
    $path = isset($_POST['path']) ? $_POST['path']  : '';
    if(empty($path)){
        $data['status'] = 500;
        $data['mss'] = "Lỗi đường dẫn";
        $data['data'] = null;    
    }else{
        deleteDir($path);
        $data['status'] = 200;
        $data['mss'] = "Success";
        $data['data'] = $path;
    }
    echo json_encode($data);
}
function deleteDir($path){
    $path = realpath($path);
    return is_file($path) ? @unlink($path) :   array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);    
}

function delfile(){
    $path = isset($_POST['path']) ? $_POST['path']  : '';
    $list_file = isset($_POST['list_file']) ? rtrim($_POST['list_file'],',')  : '';
    $data['status'] = 200;
    if(empty($path)){
        $data['status'] = 500;
        $data['mss'] = "Lỗi đường dẫn";
        $data['file'] = null;    
    }
    if(empty($list_file)){
        $data['status'] = 500;
        $data['mss'] = "Bạn phải chọn ít nhất 1 file";
        $data['file'] = null;    
    }
    if($data['status'] == 200){
        $list_file = explode(',',$list_file);
        foreach($list_file as $file){
            unlink(rtrim($path,"/")."/".$file);
        }
        $data['status'] = 200;
        $data['mss'] = "Success";
        $data['file'] = null;
    }
    echo json_encode($data);
}

function uploadfile(){
    global $siteUrl,$uinfoadmin;
    $rootfolder= "uploads/file/";
    $data['status'] = 200;
    $targetFolder = empty($_POST['path']) ? $rootfolder.date('Y/m/d') : ltrim($_POST['path'],'/') ; // Relative to the root
    $overwrite = (empty($_POST['overwrite']))?"false":$_POST['overwrite'];


    $targetFolder = rtrim($targetFolder,'/');
    if (!empty($_FILES) && $data['status'] == 200) {
        $tempFile = $_FILES['Filedata']['tmp_name'];

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
        //$targetPath = getcwd() . $targetFolder . $folder_name;
        $targetPath =$targetFolder . $folder_name;
        if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);
        $standardName = standardStr(convertToUtf8($_FILES['Filedata']['name']));
        if($overwrite=="false") {
            $file_name = time() . '_' . $standardName;
            $targetFile = $targetPath . str_replace(" ","_",$file_name);
            $data['newfile'] = true;
        }
        else if($overwrite=="true") {            
            $file_name =  $standardName;
            $targetFile = $targetPath . str_replace(" ","_",$file_name);
            if (file_exists($targetFile)) $data['newfile'] = false;
            else $data['newfile'] = true;
        }
        $rs = move_uploaded_file($tempFile, $targetFile);
        $fileParts = pathinfo($_FILES['Filedata']['name']);

        if ($rs) {
            $file_path = $targetFolder . $folder_name . $file_name;
            $type = $fileParts['extension'];
            if (!in_array($type, array("png", "jpg", "jpeg", "gif", "bmp"))) $image = "holder.js/60x60/text:$type";
            else
                $image = $siteUrl . str_replace("E:/videohotmedia/", "videohot/uploads/", $file_path);
            $webpath = $siteUrl . str_replace("E:/videohotmedia/", "videohot/uploads/", $file_path);
            $data['status'] = 200;
            $data['mss'] = "Upload thành công";
            $data['file'] = array("index" => (string)strtotime("now") . rand(0, 99999), "filename" => "$file_name", "src" => "$webpath", "path" => "$webpath", "image" => "$image", "type" => "$type", "chose" => false, "webpath" => "$webpath");
        } else {
            $data['status'] = 500;
            $data['mss'] = "Không thể upload file";
        }
    }
    echo json_encode($data);
}

function searchFile() {
    global $rootfolder, $siteUrl;
    $key = $_GET['keyword'];
    $path = $_GET["path"];
    $path = strlen($path)>0?$path:$rootfolder;
    $path = str_replace('//','/',$path);
    $lasttime = isset($_GET['ltime']) ? $_GET['ltime'] : 999999999999999999;
    $files = glob($path . "/*$key*");
    usort($files, sortFileByCreateDate);
    $count = 0; $filescount = count($files); $id = 0;
    $newltime = $lasttime;
    foreach($files as $file) {   
        $file = str_replace("//","/",$file);
        ++$id;
        if (filectime($file) < $lasttime) {
            if(is_file($file))
            {
                $filename = end(explode("/",$file));
                $type = strtolower(end(explode(".",$filename)));
                if(!in_array($type,array("png","jpg","jpeg","gif","bmp"))) $image = "holder.js/60x60/text:$type";
                else $image = $siteUrl.$file;
                $webpath = $siteUrl.str_replace("../","",$file);
                $item = array("index"=>(string)strtotime("now").rand(0,99999),"filename"=>"$filename","src"=>"$file","path"=>"$file","image"=>"$image","type"=>"$type","chose"=>false,"webpath"=>"$webpath");
                $listfile[] = $item;  
                
                ++$count;
                $newltime = filectime($file);
                if (($count > 14) || ($id == $filescount)) {
                    break;
                }
            }
        }
    }
    
    $dtr["realpath"] = $path;
    $dtr['lasttime'] = $newltime;
    $dtr['file'] = $listfile;
    $dtr['keyword'] = $key;
    
    echo json_encode($dtr);
}
//----------------------------------------

function sortFileByCreateDate($a, $b) {
    return filectime($b) - filectime($a);
}
?>