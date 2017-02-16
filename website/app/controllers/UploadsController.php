<?php

class UploadsController extends \BaseController {

	public function postUploadSong(){

		$data['status'] = 200;
        if(!Auth::user())
            return Response::json(array('status'=>500, 'mss'=>'Bạn cần đăng nhập trước.'));

        if(Network::getUserInfo(Auth::user()->phone,'E',Auth::user()->_id) != 1){
            return Response::json(array('status'=>500, 'mss' => 'Bạn cần đăng ký gói cước.', 'package' => true));
        }
		$targetFolder = "/uploads/audio/".date("d-m-Y")."/";
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$fileParts = pathinfo($_FILES['Filedata']['name']);
		if(!in_array($fileParts['extension'],array('mp3', 'wmv', 'ogg'))){
			$data['status'] = 500;
			$data['mss'] = "Chỉ được upload tệp âm thanh (mp3, wmv, ogg).";
			return Response::json($data);
		}

		$folder_name = '/';
		$targetPath = $_SERVER['DOCUMENT_ROOT'].str_replace("../","",$targetFolder . $folder_name);
		if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);
//        $file_name = preg_replace("/\p{P}|\p{S}/u", "", $_FILES['Filedata']['name']);
		$file_name =  str_replace(" ","_",strtotime("now")."_".Input::get('id')."_".Auth::user()->_id.".".$fileParts['extension']);
		$targetFile = str_replace("//","/",$targetPath) . $file_name;
		$rs = move_uploaded_file($tempFile,$targetFile);
		if($rs){
			$file_path = $targetFolder.$folder_name.$file_name;
			$file_path = str_replace("//","/",$file_path);
			$image = $file_path;
			$data['status'] = 200;
			$data['mss'] = "Upload thành công";

			$newUpload = new Upload();
			$newUpload->_id = strval(time());
			$newUpload->uid = Auth::user()->_id;
			$newUpload->path = $file_path;
			$newUpload->type = Constant::TYPE_SONG;
			$newUpload->datecreate = time();
			$newUpload->itemid = Input::get('id');
			$newUpload->save();
            $data['file'] = array(
                    "index"=>$newUpload->_id,
                    "filename"=>"$file_name",
                    "src"=>"$file_path",
                    "path"=>"$file_path",
                    "image"=>"$image",
            );
		}else{
			$data['status'] = 500;
			$data['mss'] = "Không thể upload file: $targetFile";
		}
		return Response::json($data);
	}
}