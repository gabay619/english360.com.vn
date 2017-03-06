<?php

use Captioning\Format\SubripFile;
class TestController extends \BaseController {

	public function getDecode(){
        $str = '123456@789abc';
        $str = 'rDIrNP6NgzM0orNERGd0jHSCHxuauaN3Naepd54lRbo=';
        echo Common::decodeAffCookie($str);die;
		return View::make('test.chat');
	}

    public function getDate(){
        $rs = User::where('phone','01208300293')->update(array('event'=>Event::HOC_SINH_SINH_VIEN));
        var_dump($rs);
    }

    public function getTestConvert(){
        $file = '/uploads/28-05-2016/1464453187.mp3';
        $newSubEng = $file;
        $inputFile = $_SERVER['DOCUMENT_ROOT'].$file;
        $outputFile = $_SERVER['DOCUMENT_ROOT'].substr($file, 0, (strlen ($file)) - 3).'mp4';
        exec('ffmpeg -i '.$inputFile.' -f mp4 -ab 192000 -vn '.$outputFile);
//        if($this->_convertSrtToVtt($inputFile,$outputFile))
        $newSubEng = substr($file, 0, (strlen ($file)) - 3).'mp4';
        echo $newSubEng;
    }

    public function getConvertAudio(){
        $id = Input::get('id');
        $ids = explode(',',$id);
//        print_r($ids);
        $type = Input::get('type');
        if($type==Constant::TYPE_SONG){
            $model = 'Song';
        }else
            $model = 'Thuvien';
        $aRecord = $model::where('_id','=',$id)->first();
        $file = $aRecord->medialink;
        if(!empty($file) && strpos($file, '.mp3')){
            $inputFile = $_SERVER['DOCUMENT_ROOT'].$file;
            $outputFile = $_SERVER['DOCUMENT_ROOT'].substr($file, 0, (strlen ($file)) - 3).'mp4';
            exec('ffmpeg -i '.$inputFile.' -f mp4 -ab 192000 -vn '.$outputFile);
            $newLink = substr($file, 0, (strlen ($file)) - 3).'mp4';
        }
        if($newLink != $file){
            $aRecord->medialink = $newLink;
            $aRecord->save();
//            $model::where('_id', $aSong->_id)->update(array('medialink'=> $newLink));
            echo 'Da convert '.$aRecord->name.': '.$newLink.'<br>';
        }

//        print_r($allSong);die;
        foreach($allSong as $aSong){
            $file = $aSong->medialink;
            $newLink = $file;
            if(!empty($file) && strpos($file, '.mp3')){
                $inputFile = $_SERVER['DOCUMENT_ROOT'].$file;
                $outputFile = $_SERVER['DOCUMENT_ROOT'].substr($file, 0, (strlen ($file)) - 3).'mp4';
                exec('ffmpeg -i '.$inputFile.' -f mp4 -ab 192000 -vn '.$outputFile);
                $newLink = substr($file, 0, (strlen ($file)) - 3).'mp4';
            }
            if($newLink != $file){
                $model::where('_id', $aSong->_id)->update(array('medialink'=> $newLink));
                echo 'Da convert '.$aSong->name.': '.$newLink.'<br>';
            }
        }
    }

    public function getConvertVtt(){
        $allThuvien = ThuVien::where('_id', '!=', 0)->get();
        foreach($allThuvien as $aThuvien) {
            $subEng = $aThuvien->sub['eng'];
            $subVie = $aThuvien->sub['vie'];
            $newSubEng = $subEng;
            $newSubVie = $subVie;
            if(!empty($subEng) && strpos($subEng, '.srt')){
                $inputFile = $_SERVER['DOCUMENT_ROOT'].$subEng;
                $outputFile = $_SERVER['DOCUMENT_ROOT'].substr($subEng, 0, (strlen ($subEng)) - 3).'vtt';
                if($this->_convertSrtToVtt($inputFile,$outputFile))
                    $newSubEng = substr($subEng, 0, (strlen ($subEng)) - 3).'vtt';

            }
            if(!empty($subVie) && strpos($subVie, '.srt')){
                $inputFile = $_SERVER['DOCUMENT_ROOT'].$subVie;
                $outputFile = $_SERVER['DOCUMENT_ROOT'].substr($subVie, 0, (strlen ($subVie)) - 3).'vtt';
                if($this->_convertSrtToVtt($inputFile,$outputFile))
                    $newSubVie = substr($subVie, 0, (strlen ($subVie)) - 3).'vtt';
            }
            if($newSubEng!= $subEng || $newSubVie!=$subVie){
                ThuVien::where('_id', $aThuvien->_id)->update(array('sub'=> array('eng'=>$newSubEng, 'vie'=>$newSubVie)));
                echo 'Da fix phu de '.$aThuvien->_id.': '.$aThuvien->name.'<br>';
            }
        }
    }

    private function _convertSrtToVtt($input,$output){
        try {
            $srt = new SubripFile($input);
            $srt->convertTo('webvtt')->save($output);
        } catch(Exception $e) {
            echo "Error: ".$e->getMessage()."\n";
            return false;
        }
        return true;
    }

    public function getSendMail(){
//        $title = 'Các cấu trúc thể hiện sự tương phản';
//        $cate_name = 'Giao tiếp cơ bản';
//        $avatar = '';
//        $description = 'Howard Schultz thông báo Starbucks trở thành công ty đầu tiên tại Mỹ chi trả tiền học phí đại học cho tất cả nhân viên của mình.';
//        $detailUrl = '';
//        $time = date('H:i d/m/Y');
//        $related = null;

        $to = Input::get('email','congchinh.619@gmail.com');
//        $disable_url = '';
        $body = 'Test';
        $subject = 'Thông báo bài học mới English360';
        $mail = new \helpers\Mail($to,$subject,$body);
//        $mail = new \helpers\Mail('congchinh.619@gmail.com',$subject,$body);
//        print_r($mail->send());die;
        print $mail->send();
        $emailLog = new EmailLog();
        $emailLog->_id = strval(time());
        $emailLog->to = $to;
        $emailLog->userid = Auth::user() ? Auth::user()->_id : '';
        $emailLog->action = HistoryLog::LOG_XEM_BAI_HOC_PHIM;
        $emailLog->itemid = '1476435231';
        $emailLog->datecreate = time();
        $emailLog->save();
//        echo $mail->send() ? date('H:i:s d/m/Y', time()).': Thanh cong|'.$cate_name.'|'.$title.'|'.$to : date('H:i:s d/m/Y', time()).': That bai|'.$cate_name.'|'.$to;
        echo PHP_EOL;
    }

    public function getSendMail2(){
        $rs = Mail::send('emails.welcome', array('key' => 'value'), function($message)
        {
            $message->to('congchinh.619@gmail.com', 'John Smith')->subject('Welcome!');
        });

        var_dump($rs);
    }

    public function getTestLink(){
        $phone = '0123456789';
        $password = '123@abc';
        $email = 'mail@mail.com';
        $link = Common::makeLinkDisableEmailNotify($phone, $password, $email);
        echo $link;
    }


    public function getDecodeLink(){
        $key = 'MDEyMzQ1Njc4OSsxMjNAYWJjK21haWxAbWFpbC5jb20=';
        print_r(base64_decode($key));
    }

    public function getPackageInfo(){
//        echo file_get_contents(Network::getLinkService());die;
        var_dump(Common::getBalance(Auth::user()->_id));
    }

    public function getUserInfo(){
        $phone = Input::get('phone');
        $username = Input::get('uname');
        if(!empty($phone))
            $user = User::where('phone',$phone)->first();
        else
            $user = User::where('username',$username)->first();
        print_r($user);
        $savgame = SaveGame::where('uid',$user->_id)->where('degree',Constant::LEVEL_EASY)->where('category','1425089535')->update(array('level'=>5));
        print_r($savgame);
    }

    public function getPassInfo(){
        $pass = intval(Input::get('pass'));
        $user = User::where('un_password',$pass)->get();
        foreach($user as $u){
            echo $u->phone.'<br>';
        };
    }

    public function getSession(){
        print_r($_SESSION);
        print_r(Session::all());
    }

    public function getFreeUser(){
        Common::isTestUser(Input::get('phone'));
    }

    public function getEvent(){
        $user = EventUser::where('eid',Input::get('eid'))->get();
        foreach ($user as $aUser){
            var_dump($aUser->uid);
        }
    }

    public function getIsEventUser(){
        echo var_dump(Auth::user()->_id);
        var_dump(Common::isEventUser(Auth::user()->_id));
    }

    public function getTcSms(){
        var_dump(Network::checkTCSMS(Input::get('phone')));
    }

    public function getSentMt(){
        $info = 'Test';
        $sms = Network::sentMT(Input::get('phone'), 'NOTI', $info);
        print_r($sms);
    }

    public function getFreeLession(){
        var_dump(Common::isFreeLession(Input::get('id'), Input::get('type')));
    }

    public function getFixUser(){
        $regex = new MongoRegex('/^(84)?(89|90|93|120|121|122|126|128)\d{7}$/');
        $user = User::where('phone',$regex)->get();
        return View::make('test.fix_user',array(
            'user'=>$user
        ));
        foreach($user as $u){
            echo $u->phone.'<br>';
        }
//        foreach($user as $u){
//            $check = User::where(array(
//                '_id'=>array('$ne'=>$u->_id),
//                'phone' => Network::reversephoneToZero($u->phone)
//            ))->first();
//            if($check){
//                User::where('_id',$u->_id)->delete();
//                echo 'Da xoa '.$u->phone;
//            }else{
//                User::where('_id',$u->_id)->update(array('phone'=>Network::reversephoneToZero($u->phone)));
//                echo 'Da update '.$u->phone.' thanh '.Network::reversephoneToZero($u->phone);
//            }
//            echo '<br>';
//        };
    }

    public function postFixUser(){
        $phone = Input::get('phone');
        $u = User::where('phone',$phone)->first();
        $check = User::where(array(
                '_id'=>array('$ne'=>$u->_id),
                'phone' => Network::reversephoneToZero($u->phone)
            ))->first();
        if($check){
            User::where('_id',$u->_id)->delete();
            $del = true;
            $mss =  'Da xoa '.$u->phone;
        }else{
            User::where('_id',$u->_id)->update(array('phone'=>Network::reversephoneToZero($u->phone)));
            $mss = 'Da update '.$u->phone.' thanh '.Network::reversephoneToZero($u->phone);
            $del = false;
        }
        return Response::json(array('success'=>true,'del'=>$del));
    }

    public function getAdsLog(){
//        $record = new AdsLog();
//        $record->_id = strval(time());
//        $record->phone = '0903275310';
//        $record->time = time();
//        print_r($record->save());
        $record = AdsLog::where('_id','!=','')->get();
        print_r($record);
    }
}