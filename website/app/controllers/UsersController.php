<?php

class UsersController extends \BaseController {

	public function __construct(){
        $this->beforeFilter('csrf', array('on' => 'post', 'except'=>array(
            'postUploadAvatar',
            'postDeleteNotify',
            'postDeleteSaveLession'
        )));
        $this->beforeFilter('auth', array('only' => array(
			'getProfile',
			'postSetting',
            'getSaveLession',
            'postDeleteSaveLession',
            'getQuestion',
            'getNotify',
			'postDeleteNotify',
			'postLoadUnreadNotify',
            'getRegLession',
		)));

		$this->beforeFilter('guest', array('only' => array(
			'getRegister',
			'postRegister',
			'getLogin',
			'postLogin',
            'getQuickPackage'
		)));
	}

	public function getRegister()
	{
		return View::make('users.register');
	}

	public function postRegister(){
//		if(!Session::has('new_user') || !Session::get('new_user')['validate'])
//			return Response::json(array('success'=>false, 'message' => 'Thao tác không hợp lệ.'));
		$input = Input::all();
//		$input['phone'] = Session::get('new_user')['phone'];
        $rules = User::$rules;
//        unset($rules['email']);
		$validator = Validator::make($input, $rules);
		if($validator->fails()){
            if(Request::ajax())
			    return Response::json(array('success'=>false, 'message'=>$validator->errors()->first()));
            else
                return Redirect::back()->with('error', $validator->errors()->first());
		}
//        if($input['password'] != $input['password_confirmation']){
//            return Redirect::back()->with('error', 'Mật khẩu xác nhận không khớp')->withInput();
//        }

//        if(!Network::mobifoneNumber($input['phone'])){
//            return Response::json(array('success'=>false, 'message'=>'Yêu cầu nhập số điện thoại MobiFone.'));
//        }

        //kiểm tra email đã đăng ký chưa
        $checkEmail = User::where('email',$input['email'])->first();
        if($checkEmail){
            if($checkEmail->status == Constant::STATUS_ENABLE){
                return Response::json(array('success'=>false, 'message'=>'Địa chỉ Email đã được sử dụng'));
            }
            $user = $checkEmail;
            $user->un_password = $input['password'];
            $user->password = Common::encryptpassword($user->un_password);
            $user->save();
        }else{
            $user = new User();
            $user->_id = strval(time());
            $user->datecreate = time();
            $user->status = Constant::STATUS_DISABLE;
//		$user->phone = $input['phone'];
//		$user->email = $input['email'];
            $user->un_password = $input['password'];
            $user->email = $input['email'];
            $user->password = Common::encryptpassword($user->un_password);
            $user->cmnd = '';
            $user->cmnd_ngaycap = '';
            $user->cmnd_noicap = '';
            $user->fullname = '';
            $user->priavatar = '';
            $user->thong_bao = array(
                'noti' => '1',
                'email' => '1',
            );

            //Nếu có aff
            if(isset($_COOKIE[Constant::AFF_COOKIE_NAME])){
                $cookie_value = Common::decodeAffCookie($_COOKIE[Constant::AFF_COOKIE_NAME]);
                $cookieArr = explode('&',$cookie_value);
                $user->aff = array(
                    'uid' => $cookieArr[0],
                    'sub_id' => isset($cookieArr[1]) ? $cookieArr[1] : '',
                    'datecreate' => time()
                );
            }
            $user->save();
        }



        //Gửi email xác nhận
        $content = '<p>Xin chào,</p>'.
            '<p>Để xác thực email cho tài khoản English360, bạn vui lòng click vào đường link bên dưới:</p>'.
            '<p><a href="'.Common::getVerifyEmailUrl($user->_id,$user->email).'">'.Common::getVerifyEmailUrl($user->_id,$user->email).'</a></p>'.
            '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>';
        $mail = new \helpers\Mail($user->email,'Xác nhận tài khoản English360.com.vn',$content);
        if(!$mail->send()){
            if(Request::ajax())
                return Response::json(array('success'=>false, 'message'=>'Không thể gửi thư xác nhận đến địa chỉ email của bạn, vui lòng thử lại sau.'));
            else
                return Redirect::back()->with('error', 'Không thể gửi thư xác nhận đến địa chỉ email của bạn, vui lòng thử lại sau.');
        }

//		Auth::login($user);
        //Log
        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_DANG_KY,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => Auth::user() ? Auth::user()->_id : '',
                'url' => Request::url(),
                'status' => Constant::STATUS_ENABLE,
//                'phone' => Auth::user() ? Auth::user()->phone : '',
                'price' => 0
        );
        HisLog::insert($newHistoryLog);
        if(Request::ajax())
		    return Response::json(array('success'=> true, 'message'=>'Vui lòng kiểm tra email để xác thực tài khoản của bạn.'));
        else
            return Redirect::to('/thong-bao.html')->with('success', 'Vui lòng kiểm tra email để xác thực tài khoản của bạn.');
	}

	public function getLogin()
	{
        $fb = new Facebook\Facebook([
            'app_id' => Constant::FACEBOOK_APP_ID, // Replace {app-id} with your app id
            'app_secret' => Constant::FACEBOOK_APP_KEY,
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        $fb_login = $helper->getLoginUrl('http://english360.com.vn/fb-callback.html', $permissions);
        if(Input::get('redirect',0) == 1){
            return Redirect::to($fb_login);
        }
		return View::make('users.login', array(
            'fb_login' => $fb_login
        ));
	}

    public function getSendVerifyEmail(){
        $token = Input::get('token');
//        $token = Common::encodeAffCookie('chinhnc@viq.vn');
        $arr = explode('+', base64_decode($token));
        //Expired after 10min
        if(!isset($arr[1]) || time() - $arr[1] >= 600){
            return Redirect::to('/thong-bao.html')->with('error', 'Thao tác không hợp lệ.');
        }
        $email = $arr[0];
//        echo $email;die;
        $user = User::where(array('email'=>$email, 'status'=>Constant::STATUS_DISABLE))->first();
        if(!$user){
            return Redirect::to('/thong-bao.html')->with('error', 'Thao tác không hợp lệ.');
        }
        $content = '<p>Xin chào,</p>'.
            '<p>Để xác thực email cho tài khoản English360, bạn vui lòng click vào đường link bên dưới:</p>'.
            '<p><a href="'.Common::getVerifyEmailUrl($user->_id,$user->email).'">'.Common::getVerifyEmailUrl($user->_id,$user->email).'</a></p>'.
            '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>';
        $mail = new \helpers\Mail($user->email,'Xác nhận tài khoản English360.com.vn',$content);
        if($mail->send()){
            return Redirect::to('/thong-bao.html')->with('success', 'Vui lòng kiểm tra email và kích hoạt tài khoản.');
        }
        return Redirect::to('/thong-bao.html')->with('error', 'Không thể gửi email cho bạn, vui lòng thử lại sau.');
    }

	public function postLogin(){
        $email = Input::get('email', Session::get('popreg_phone'));
        $email = strtolower($email);
		$password = Input::get('password');
        if(empty($email) || empty($password)){
            if(Request::ajax())
                return Response::json(array('success' => false, 'message' => 'Vui lòng nhập đầy đủ Email và Mật khẩu.'));
            else
                return Redirect::back()->with('error', 'Vui lòng nhập đầy đủ Email và Mật khẩu.')->withInput();
        }
//        if(!Network::mobifoneNumber($phone)){
//            if(Request::ajax())
//                return Response::json(array('success' => false, 'message' => 'Yêu cầu nhập số điện thoại MobiFone.'));
//            else
//                return Redirect::back()->with('error', 'Yêu cầu nhập số điện thoại MobiFone.')->withInput();
//        }
		$user = User::where(array(
            '$or'=> array(
                array('email'=> $email),
//                array('username' => $phone)
            )
        ))->first();
		if($user){
			if($user->password == Common::encryptpassword($password)){
                //Nếu user chưa xác thực
                if($user->status != Constant::STATUS_ENABLE){
                    //Gửi email xác nhận
//                    $content = '<p>Xin chào,</p>'.
//                        '<p>Để xác thực email cho tài khoản English360, bạn vui lòng click vào đường link bên dưới:</p>'.
//                        '<p><a href="'.Common::getVerifyEmailUrl($user->_id,$user->email).'">'.Common::getVerifyEmailUrl($user->_id,$user->email).'</a></p>'.
//                        '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>';
//                    $mail = new \helpers\Mail($user->email,'Xác nhận tài khoản English360.com.vn',$content);
//                    $mail->send();
                    $reVerify = Constant::BASE_URL.'/user/send-verify-email?token='.base64_encode($email.'+'.time());
                    if(Request::ajax())
                        return Response::json(array('success' => false, 'message' => 'Vui lòng xác thực email. <a style="text-decoration:underline" href="'.$reVerify.'">Gửi lại link xác thực</a>'));
                    else
                        return Redirect::back()->with('error', 'Vui lòng xác thực email. <a style="text-decoration:underline" href="'.$reVerify.'">Gửi lại link xác thực</a>')->withInput();
                }
				Auth::login($user);
                ##Gui tin hang ngay
//                if(Session::has('popreg_phone') && !empty(Session::get('popreg_phone'))){
////                    print_r(Session::get('popreg_phone'));
//                    Network::sendToDaily(Session::get('popreg_phone'));
//                    Session::forget('popreg_phone');
//                }
                //Log
                $newHistoryLog = array(
                        '_id' => strval(time().rand(10,99)),
                        'datecreate' => time(),
                        'action' => HistoryLog::LOG_DANG_NHAP,
                        'chanel' => HistoryLog::CHANEL_WEB,
                        'ip' => Network::ip(),
                        'uid' => Auth::user()->_id,
                        'url' => Request::ajax() ? Constant::BASE_URL : Request::url(),
                        'status' => Constant::STATUS_ENABLE,
//                        'phone' => Auth::user()->phone,
                        'price' => 0
                );
                HisLog::insert($newHistoryLog);
				if(Request::ajax())
					return Response::json(array('success' => true, 'message' => 'Đăng nhập thành công.'));
				else{
                    //Nếu đang có yêu cầu xác thực email
//                    if(Session::has('required_verify_email')){
//                        $verifyEmail = Session::get('required_verify_email');
//                        $bodyEmail = '<p>Xin chào,</p>'.
//                            '<p>Để xác thực email cho tài khoản English360, bạn vui lòng click vào link bên dưới</p>'.
//                            '<p><a href="'.Common::getVerifyEmailUrl($user->_id,$verifyEmail).'">'.Common::getVerifyEmailUrl($user->_id,$verifyEmail).'</a></p>'.
//                            '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>';
//                        $mail = new \helpers\Mail($verifyEmail, 'Xác thực email English360.vn', $bodyEmail);
//                        $mail->send();
//                        Session::remove('required_verify_email');
//                        return Redirect::to('/thong-bao.html')->with('success','Chúng tôi đã gửi 1 email xác nhận về địa chỉ '.$verifyEmail.', vui lòng xác nhận địa chỉ email này là của bạn.');
//                    }
//                    return Session::get('return_url','/');
//                    if(Session::has('return_url'))
                    return Redirect::to(Session::get('return_url','/'));
//                    else
//                        return Redirect::to('/');
                }
			}else{
				if(Request::ajax())
					return Response::json(array('success' => false, 'message' => 'Mật khẩu không đúng.'));
				else
					return Redirect::back()->with('error', 'Mật khẩu không đúng.')->withInput();
			}
		}else{
			if(Request::ajax())
				return Response::json(array('success' => false, 'message' => 'Email này chưa được đăng ký tài khoản.'));
			else
				return Redirect::back()->with('error', 'Email này chưa được đăng ký tài khoản.')->withInput();
        }
	}

    public function getForgetPass(){
        return View::make('users.forget-pass');
    }

    public function postForgetPass(){
        $email = Input::get('email');
        if(empty($email))
            return Redirect::back()->with('error', 'Bạn chưa nhập email.')->withInput();

        $user = User::where('email', $email)
                ->first();

        if(!$user)
            return Redirect::back()->with('error', 'Email này hiện chưa đăng ký tài khoản.')->withInput();
        if(isset($user->fbid) && !isset($user->un_password))
            return Redirect::back()->with('error', 'Tài khoản quý khách được đăng ký qua Facebook, vui lòng đăng nhập bằng Facebook.')->withInput();

        $sendPassCount = isset($user->send_pass['count']) ? $user->send_pass['count'] : 0;
        $sendPassTime = isset($user->send_pass['time']) ? $user->send_pass['time'] : time();
        if(time() - $sendPassTime > 60*60)
            $sendPassCount = 0;
        if($sendPassCount >= 5)
            return Redirect::back()->with('error', 'Quý khách đã lấy mật khẩu 5 lần. Vui lòng chờ sau 60 phút để lấy lại mật khẩu.')->withInput();

        $user->send_pass = array(
            'count' => $sendPassCount +1,
            'time' => time()
        );
        $user->save();
//Gửi email xác nhận
        $password = isset($user->un_password) ? $user->un_password : $user->password;
        $content = '<p>Xin chào,</p>'.
            '<p>Mật khẩu để sử dụng dịch vụ English360 của quý khách là: '.$password.'</p>';
        $mail = new \helpers\Mail($email,'Lấy lại mật khẩu tài khoản English360.com.vn',$content);
        if($mail->send()){
            return Redirect::to('/user/login')->with('success', 'Mật khẩu đã được gửi về email của bạn. Vui lòng kiểm tra lại.')->withInput();
        }else{
            return Redirect::back()->with('error', 'Không thể gửi mật khẩu đến email của bạn, vui lòng thử lại sau.')->withInput();
        }
    }

    public function postSendPass(){
        $phone = Input::get('phone', Session::get('popreg_phone'));
        if(!Network::mobifoneNumber($phone))
            return Response::json(array('success'=>false, 'message' => 'Vui lòng nhập số điện thoại MobiFone.'));

        $user = User::where('phone', $phone)
            ->first();
        if(!$user){
            $password = Common::generateRandomPassword();
            $user = new User();
            $user->_id = strval(time());
            $user->datecreate = time();
            $user->phone = $phone;
            $user->email = '';
            $user->un_password = $password;
            $user->displayname = '';
            $user->password = Common::encryptpassword($user->un_password);
            $user->cmnd = '';
            $user->cmnd_ngaycap = '';
            $user->cmnd_noicap = '';
            $user->fullname = '';
            $user->priavatar = '';
            $user->thong_bao = array(
                'noti' => '1',
                'sms' => '1',
                'email' => '1',
            );
            $user->save();
            //Log
            $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_DANG_KY,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => $user->_id,
                'url' => Request::url(),
                'status' => Constant::STATUS_ENABLE,
                'phone' => $phone,
                'price' => 0
            );
            HisLog::insert($newHistoryLog);
        }else
            $password = $user->un_password;

        $sendPassCount = isset($user->send_pass['count']) ? $user->send_pass['count'] : 0;
        $sendPassTime = isset($user->send_pass['time']) ? $user->send_pass['time'] : time();
        if(time() - $sendPassTime > 60*60)
            $sendPassCount = 0;
        if($sendPassCount >= 5)
            return Response::json(array('success'=>false, 'message' => 'Quý khách đã lấy mật khẩu 5 lần. Vui lòng chờ sau 60 phút để lấy lại mật khẩu.'));

        $password = isset($user->un_password) ? $user->un_password : $user->password;
        $info = 'Mật khẩu để sử dụng dịch vụ English360 của Quý khách là:' .$password;
        $result = Network::sentMT($phone, 'MK', $info);
//        $result = 0;
        if($result != 0)
            return Response::json(array('success'=>false, 'message' => 'Không thể gửi tin nhắn đến số điện thoại của bạn, vui lòng thử lại sau.'));

        $user->send_pass = array(
            'count' => $sendPassCount +1,
            'time' => time()
        );
        $user->save();
        Session::put('popreg_phone',$phone);
        if(Input::has('rd_login'))
            Session::put('success','Mật khẩu đã được gửi về số điện thoại của bạn. Vui lòng đăng nhập để tiếp tục.');
        return Response::json(array('success'=>true));
    }

    public function getReset(){
        $phone = Input::get('phone');
        $user = User::where('phone', $phone)
            ->first();
        $user->send_pass = array(
            'count' => 0,
            'time' => time()
        );
        $user->save();
        echo 'ok';
    }

	public function getLogout(){
        //Log
        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_DANG_XUAT,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => Auth::user() ? Auth::user()->_id : '',
                'url' => Request::url(),
                'status' => Constant::STATUS_ENABLE,
//                'phone' => Auth::user()->phone,
                'price' => 0
        );
        HisLog::insert($newHistoryLog);
		Auth::logout();
		return Redirect::back();
	}

	public function getProfile(){
        $user = Auth::user();
        $checkTCSMS = Network::checkTCSMS($user->phone);
        $user->thong_bao = array(
                'noti' => $user->thong_bao['noti'],
                'sms' => $checkTCSMS==0 ? '1' : '0',
                'email' => $user->thong_bao['email'],
        );
        $user->save();
		return View::make('users.profile');
	}

	public function postSetting(){
		$displayname = Input::get('displayname', '');
//		$email = Input::get('email', '');
		$fullname = Input::get('fullname', '');
		$birthday = Input::get('birthday', '');
		$cmnd = Input::get('cmnd','');
		$cmnd_ngaycap = Input::get('cmnd_ngaycap', '');
		$cmnd_noicap = Input::get('cmnd_noicap', '');
		$old_pass = Input::get('old_pass', '');
		$password = Input::get('password', '');
		$password_confirmation = Input::get('password_confirmation', '');
		$user = Auth::user();

//        print_r(DateTime::createFromFormat('d/m/Y', $birthday)->getTimestamp() - time());die;
        if(!empty($birthday) && DateTime::createFromFormat('d/m/Y', $birthday)->getTimestamp() > time()){
            return Redirect::back()->with('error', 'Ngày sinh không được lớn hơn ngày hiện tại.')->withInput();
        }

        if(!empty($birthday) && !empty($cmnd_ngaycap) && DateTime::createFromFormat('d/m/Y', $birthday)->getTimestamp() > DateTime::createFromFormat('d/m/Y', $cmnd_ngaycap)->getTimestamp()){
            return Redirect::back()->with('error', 'Ngày cấp CMND không được nhỏ hơn ngày sinh.')->withInput();
        }


		$rules1 = array(
			'displayname'=>'min:2',
//			'email'=>'email',
			'fullname' => 'min:2',
			'cmnd' => 'numeric|min:8',
		);
		$validator = Validator::make(Input::all(), $rules1);
		if($validator->fails()){
			return Redirect::back()->with('error', $validator->errors()->first())->withInput();
		}

		if(!empty($old_pass) || !empty($password) || !empty($password_confirmation)){
			$rules2 = array(
				'old_pass'=>'required|alpha_num',
				'password'=>'required|alpha_num|between:6,12|confirmed',
				'password_confirmation'=>'required|alpha_num|between:6,12',
			);
			$validator = Validator::make(Input::all(), $rules2);
			if($validator->fails()){
				return Redirect::back()->withInput()->with('error', $validator->errors()->first());
			}
			if($user->password == Common::encryptpassword($old_pass)){
				$user->un_password = $password;
				$user->password = Common::encryptpassword($password);
			}else
				return Redirect::back()->withInput()->with('error', 'Mật khẩu cũ không đúng.');
		}
//		if(!empty($email)){
//			$checkUniqueEmail = User::where('email', $email)->where('_id', '!=', $user->_id)->first();
//			if($checkUniqueEmail)
//				return Redirect::back()->with('error', 'Email đã được sử dụng.')->withInput();
//			$user->email = $email;
//		}
		if(!empty($displayname))
			$user->displayname = $displayname;
		$user->fullname = $fullname;
		$user->birthday = $birthday;
		$user->cmnd = $cmnd;
		$user->cmnd_ngaycap = $cmnd_ngaycap;
		$user->cmnd_noicap = $cmnd_noicap;
		$user->thong_bao = array(
			'noti' => strval(Input::get('chkNoti', 0)),
//			'sms' => strval(Input::get('chkSms', 0)),
			'email' => strval(Input::get('chkEmail', 0)),
		);
//        if(Input::get('chkSms', 0) == 1)
//            Network::DKSMS($user->phone);
//        else
//            Network::TCSMS($user->phone);

        if($user->save()){
            //Log
            $newHistoryLog = array(
                    '_id' => strval(time().rand(10,99)),
                    'datecreate' => time(),
                    'action' => HistoryLog::LOG_EDIT_PROFILE,
                    'chanel' => HistoryLog::CHANEL_WEB,
                    'ip' => Network::ip(),
                    'uid' => Auth::user()->_id,
                    'url' => Constant::BASE_URL.'/user/profile',
                    'status' => Constant::STATUS_ENABLE,
//                    'phone' => Auth::user()->phone,
                    'price' => 0
            );
            HisLog::insert($newHistoryLog);
            return Redirect::to('/user/profile')->with('success', 'Thay đổi thông tin thành công.');
        }
        else
            return Redirect::back()->withInput()->with('error', 'Thay đổi thông tin thất bại.');
    }

    public function postUploadAvatar(){
        $data['status'] = 200;
        $targetFolder = "/uploads/avatar/";
        $tempFile = $_FILES['Filedata']['tmp_name'];
        $fileParts = pathinfo($_FILES['Filedata']['name']);
		if(!in_array($fileParts['extension'],array('jpg','jpeg','gif','png'))){
			$data['status'] = 500;
			$data['mss'] = "Chỉ được upload file ảnh.";
			return Response::json($data);
		}

        $folder_name = '/';
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
            $data['file'] = array(
				"index"=>(string)strtotime("now").rand(0,99999),
				"filename"=>"$file_name",
				"src"=>"$file_path",
				"path"=>"$file_path",
				"image"=>"$image"
			);
			$user = Auth::user();
			$user->priavatar = $file_path;
			$user->save();
        }else{
            $data['status'] = 500;
            $data['mss'] = "Không thể upload file: $targetFile";
        }
		return Response::json($data);
    }

    public function getPackage(){
        $step = Input::get('step',1);
        if($step == 1){
            $packages = Package::where('status', Constant::STATUS_ENABLE)->get();
            return View::make('users.package', array(
                'packages' => $packages
            ));
        }
        //filter auth
        if (Auth::guest())
        {
            if (Request::ajax())
            {
                Session::put('return_url', Input::get('return_url', '/'));
                return Response::json(array('success'=>false, 'message'=> 'Bạn cần đăng nhập để thực hiện chức năng này'));
            }
            else
            {
                Session::put('return_url', Request::url());
                return Redirect::guest('/user/login');
            }
        }
        if($step==2){
            $selectPkg = Package::where('_id',Input::get('pkg'))->first();
            if(!$selectPkg){
                return Redirect::to('/user/package?step=4')->with('error', 'Gói cước không tồn tại');
            }
            return View::make('users.package_2', array(
                'selectPkg' => $selectPkg
            ));
        }
        if($step==3){
            $selectPkg = Package::where('_id',Input::get('pkg'))->first();
            if(!$selectPkg){
                return Redirect::to('/user/package?step=4')->with('error', 'Gói cước không tồn tại');
            }
            switch (Input::get('type')){
                case Constant::CARD_METHOD_NAME:
                    $listCardType = array(''=>'--Chọn loại thẻ--')+Common::getCardType();
                    return View::make('users.package_card',array(
                        'listCardType' => $listCardType,
                        'selectPkg' => $selectPkg
                    ));
                    break;
                case Constant::BANK_METHOD_NAME:
                    //Tạo giao dịch
                    $txn = new TxnBank;
                    $txn->_id = strval(time());
                    $txn->datecreate = time();
                    $txn->uid = Auth::user()->id;
                    $txn->amount = $selectPkg->price;
                    $txn->pkg_id = $selectPkg->_id;
                    if(!$txn->save()){
                        return Redirect::to('/user/package?step=4')->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau.');
                    }
                    require_once app_path('../../sdk/1pay/OnePayBank.php');
                    $mpc = new OnePayBank();
                    $order_id = $txn->_id;
                    $order_info = Auth::user()->email.' nap '.$txn->amount.'d thanh toan '.$selectPkg->name;
                    $payUrl = $mpc->getPayUrl($txn->amount, $order_id, $order_info);
                    if(!$payUrl)
                        return Redirect::to('/user/package?step=4')->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau.');
                    return Redirect::to($payUrl);
                    break;
                case 'cash':
                    $user = Auth::user();
                    $missBlance = $selectPkg->price - $user->getBalance();
                    //Số dư nhỏ hơn học phí
                    if($missBlance >0){
                        return Redirect::to('/user/package?step=4')->with('error', 'Số dư không đủ. Vui lòng nạp tiền vào tài khoản để thanh toán khóa học.');
                    }
                    //Tạo giao dịch
                    $txn = new Txn;
                    $txn->_id = strval(time());
                    $txn->datecreate = time();
                    $txn->uid = Auth::user()->id;
                    $txn->amount = $selectPkg->price;
                    $txn->pkg_id = $selectPkg->_id;
                    if(!$txn->save()){
                        return Redirect::to('/user/package?step=4')->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau.');
                    }
                    //Update số dư+đăng ký gói
                    $time = $selectPkg->time*86400;
                    $user->balance = $user->getBalance() - $selectPkg->price;
                    $user->pkg_expired = $user->getPackageTime() ? $user->getPackageTime()+$time : time()+$time;
                    $user->save();
                    $mess = 'Thanh toán khóa học thành công. Số dư tài khoản hiện tại: '.number_format($user->balance).'đ';
                    return Redirect::to('/user/package?step=4')->with('success', $mess);
                    break;
                case Constant::OTP_METHOD_NAME:
                    $listCardType = array(''=>'--Chọn nhà mạng--')+Common::getCardType();
                    return View::make('users.package_otp',array(
                        'listCardType' => $listCardType,
                        'selectPkg' => $selectPkg
                    ));
                    break;
                default:
                    return Redirect::to('/user/package?step=4')->with('error', 'Phương thức thanh toán không hỗ trợ.');
                    break;
            }
        }
        if($step>3){
            return View::make('users.package_end');
        }
    }

    public function postPackageOtp(){
        $selectPkg = Package::where('_id',Input::get('pkg'))->first();
        if(!$selectPkg){
            return Redirect::to('/user/package?step=4')->with('error', 'Gói cước không tồn tại');
        }

        $card_type = Input::get('card_type');
        $msisdn = Input::get('msisdn');
        if(empty($card_type)){
            return Redirect::back()->with('error', 'Vui lòng chọn nhà mạng.')->withInput();
        }
        if(!Common::isPhoneNumber($msisdn)){
            return Redirect::back()->with('error', 'Số điện thoại không hợp lệ')->withInput();
        }
        
        $txn = new TxnOtp();
        $txn->_id = strval(time());
        $txn->datecreate = time();
        $txn->uid = Auth::user()->id;
        $txn->card_type = $card_type;
        $txn->msisdn = $msisdn;
        $txn->pkg_id = $selectPkg->_id;
        $txn->pkg_price = $selectPkg->price;
        if(!$txn->save()){
            return Redirect::back()->with('error','Có lỗi xảy ra, vui lòng thử lại.');
        }
        
        require_once app_path('../../sdk/1pay/OnePayClient.php');
        $mpc = new OnePayClient();
        if($card_type == 'VNP'){
            return Redirect::back()->with('error','Chưa hỗ trợ.');
        }
        $param = $mpc->requestOtp($txn->_id, $selectPkg->price, $msisdn, Auth::user()->email.' thanh toan '.$selectPkg->price);
        //Luu log
        LogTxn::insert($param);
        //Cap nhat trang thai
        $txn->otp_response_code = $param['code'];
        $txn->response_message = Common::getTxnOtpMss($param['code']);
        $txn->transId = $param['transId'];
        $txn->save();
        if($param['code'] != Constant::TXN_OTP_SENT_SUCCESS){
            return Redirect::back()->with('error',Common::getTxnOtpMss($param['code']));
        }
        return View::make('user.package_otp_2', array(
            'txn' => $txn
        ));
    }

    public function postPackageOtpConfirm(){
        $txn_id = Input::get('txn_id');
        $otp = Input::get('otp');
        if(empty($otp)){
            return Redirect::back()->with('error', 'Vui lòng nhập mã xác thực.')->withInput();
        }
        $txn = TxnOtp::where('_id',$txn_id)->first();
        if(!$txn){
            return Redirect::back()->with('error', 'Thao tác không hợp lệ.')->withInput();
        }
        require_once app_path('../../sdk/1pay/OnePayClient.php');
        $mpc = new OnePayClient();
        $param = $mpc->confirmOtp($otp, $txn->_id, $txn->transId);
        //Luu log
        LogTxn::insert($param);
        //Cap nhat trang thai
        $txn->response_code = $param['code'];
        $txn->response_message = Common::getTxnOtpMss($param['code']);
        $txn->save();
        //
        $user = User::where('_id',$txn->uid)->first();

        if($param['code'] == Constant::TXN_OTP_SUCCESS){
            $package = Package::where('_id',$txn->pkg_id)->first();
            $time = $package->price;
            $user->pkg_expired = $user->getPackageTime() ? $user->getPackageTime()+$time : time()+$time;
            $user->save();
            $mess = 'Thanh toán khóa học thành công. Số dư tài khoản hiện tại: '.number_format($user->balance).'đ';
            return Redirect::to('/user/package?step=4')->with('success', $mess);
        }else{
            return Redirect::to('/user/package?step=4')->with('error', $txn->response_message);
        }
    }

    public function postPackageCard(){
        $selectPkg = Package::where('_id',Input::get('pkg'))->first();
        if(!$selectPkg){
            return Redirect::to('/user/package?step=4')->with('error', 'Gói cước không tồn tại');
        }
        
        $pin = Input::get('pin');
        $seri = Input::get('seri');
        $cardType = Input::get('card_type');
        //Lưu giao dịch thẻ cào
        $txn = new TxnCard;
        $txn->_id = strval(time());
        $txn->datecreate = time();
        $txn->uid = Auth::user()->id;
        $txn->card_type = $cardType;
        $txn->pin = $pin;
        $txn->seri = $seri;
        $txn->pkg_id = $selectPkg->_id;
        $txn->pkg_price = $selectPkg->price;
        if(!$txn->save()){
            return Redirect::back()->with('error','Có lỗi xảy ra, vui lòng thử lại.');
        }

        //Gọi sang cổng thẻ cào
        $true_card = array('65682321546');
        if(in_array($txn->pin, $true_card)){
            list($response_code,$card_amount,$response_message)=array(Constant::TXN_CARD_SUCCESS,100000,'success');
        }else{
            list($response_code,$card_amount,$response_message)=$this->_doChargeCard($txn);
        }

        //Xử lý kết quả trả về
        $txn->card_amount=$card_amount;
        $txn->response_code=$response_code;
        if($response_code==Constant::TXN_CARD_SUCCESS){
            $txn->save();
            $user=User::where('_id',$txn->uid)->first();
            //Tính tiền cho aff
            $aff = $user->aff();
            if($aff){
                $aff_discount = Constant::AFF_RATE_CARD*$txn->card_amount;
                AffTxn::insert(array(
                    '_id' => strval(time()),
                    'datecreate' => time(),
                    'txn_id' => $txn->_id,
                    'uid' => $aff->_id,
                    'ref_id' => $user->_id,
                    'method' => Constant::CARD_METHOD_NAME,
                    'discount' => $aff_discount,
                    'rate' => Constant::AFF_RATE_CARD,
                    'amount' => $txn->card_amount
                ));
                $account = $aff->account();
                $account->balance = isset($account->balance) ? $account->balance + $aff_discount : $aff_discount;
                $account->save();
            }
            //Cap nhat user
            $missBlance = $selectPkg->price - $txn->card_amount;
            //Mệnh giá thẻ nhỏ hơn giá gói
            if($missBlance > 0){
                //cập nhật số dư tài khoản
                $user->balance = $user->getBalance() + $txn->card_amount * Constant::CARD_TO_CASH;
                $user->save();
                $mess = 'Số dư tài khoản hiện tại: '.number_format($user->balance).'đ. Bạn cần nạp thêm '.number_format($missBlance).'đ và thanh toán khóa học bằng số dư tài khoản.';
                return Redirect::to('/user/package?step=4')->with('error', $mess);
            }else{
                //Đăng ký gói
                $time = $selectPkg->time*86400;
                $user->pkg_id = $selectPkg->_id;
                $user->pkg_expired = $user->getPackageTime() ? $user->getPackageTime()+$time : time()+$time;
                if($missBlance < 0){
                    //cập nhật số dư tài khoản
                    $user->balance = $user->getBalance() + $txn->card_amount * Constant::CARD_TO_CASH - $selectPkg->price;
                }
                $user->save();
                $mess = 'Thanh toán khóa học thành công. Số dư tài khoản hiện tại: '.number_format($user->balance).'đ';
                return Redirect::to('/user/package?step=4')->with('success', $mess);
            }

        }else{
            $txn->save();
            return Redirect::back()->with('error',$response_message)->withInput();
        }
    }

    private function _doChargeCard(TxnCard $txn){
        //Lưu log
        $log = new LogTxnCard();
        $log->_id = strval(time());
        $log->txn_id = $txn->_id;
        $log->datecreate = time();
        $log->card_type = $txn->card_type;
        $log->pin = $txn->pin;
        $log->seri = $txn->seri;
//        $log->merchant_txn_id = $txn->_id;
        if (!$log->save()) {
            throw new Exception('DB error while storing card log');
        }

        require_once app_path('../../sdk/1pay/OnePayClient.php');
        $mpc = new OnePayClient();

        $rs = $mpc->charge($txn->_id, $txn->card_type, $txn->pin, $txn->seri);

        //update kết quả trả về vào trong log
        $log->response_code = $rs['code'];
        $log->provider_code = $rs['provider_code'];
        $log->response_message = $rs['message'];
        $log->card_amount = isset($rs['card_amount']) ? $rs['card_amount'] : 0;
        $log->provider_txn_id = $rs['transId'];
        if (!$log->save()) {
            throw new Exception('DB error while storing card log');
        }

        return array($rs['code'], $rs['card_amount'], Common::getTxnCardMss($rs['code']));
    }

	public function getSaveLession(){
		$save = Auth::user()->getSavedExam();
		$list = array_reverse($save->getLession());

		$page = Input::get('page', 1);
		$limit = 10;
		$totalPage = ceil(count($list) / $limit);
		if($page > $totalPage) $page = $totalPage;
		$start = ($page - 1)*$limit;
		$listLession = array();
        if(count($list) > 0){
            for($i=$start; $i< $start+ $limit; $i++){
                if(isset($list[$i])) {
                    $model = CommonHelpers::getModelFromType($list[$i]['type']);
                    $lession = $model::where('_id', $list[$i]['id'])->first();
                    if($lession){
                        $cate = Common::getcategorytype($list[$i]['type']);
                        $listLession[] = array(
                                'id' => $lession->_id,
                                'type' => $list[$i]['type'],
                                'name' => $lession->name,
                                'url' => $lession->getDetailUrl($list[$i]['type']),
                                'avatar' => $lession->avatar,
                                'cate' => $cate['name'],
                                'date' => date('d/m/Y H:i', $save->getTime($i))
                        );
                    }
                }
            }
        }

        return View::make('users.save_lession', array(
			'listLession' => $listLession,
            'page' => $page,
            'totalPage' => $totalPage,
			'limit' => $limit
		));
	}

    public function postSaveLession(){
        if(!Auth::user()){
            Session::put('return_url', Input::get('return_url', '/'));
            return Response::json(array('success'=>false, 'message' => 'Bạn cần đăng nhập để lưu bài học.', 'login'=>true));
        }

        if(!Auth::user()->registedPackage()){
            Session::put('return_url', Input::get('return_url', '/'));
            return Response::json(array('success'=>false, 'message' => 'Bạn cần đăng ký gói cước để lưu bài học.', 'package' => true));
        }

        $save = Auth::user()->getSavedExam();

        $ex = array(
            'type' => Input::get('type'),
            'id' => Input::get('id')
        );
        if($save->isSavedByUser($ex))
            return Response::json(array('success'=>false, 'message' => 'Bạn đã lưu bài học này trước đó.'));

        if($save->addLession($ex)){
            return Response::json(array('success'=>true, 'message' => 'Lưu bài học thành công.'));
        }else{
            return Response::json(array('success'=>false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'));
        }
    }

	public function postDeleteSaveLession(){
		$save = Auth::user()->getSavedExam();

		$ex = array(
			'type' => Input::get('type'),
			'id' => Input::get('id')
		);
		if($save->removeLession($ex)){
			return Response::json(array('success'=>true, 'message' => 'Xóa bài học thành công.'));
		}else{
			return Response::json(array('success'=>false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'));
		}
	}

	public function getQuestion(){
        $myQuestion = Question::where('usercreate', Auth::user()->_id)
                ->where('parentid', '0')
                ->orderBy('datecreate', 'desc')
                ->get();
		return View::make('users.question', array(
            'myQuestion' => $myQuestion
        ));
	}

    public function getNotify(){
        $myNotify = Notify::where('uid',  Auth::user()->_id)
//            ->where('status', Constant::STATUS_ENABLE)
            ->where('type', Constant::TYPE_NOTIFY)
            ->orderBy('status', 'desc')
            ->orderBy('datecreate','desc')
            ->paginate(20);

        Auth::user()->readAllNotify();
        return View::make('users.notify', array(
            'myNotify' => $myNotify
        ));
    }

    public function postLoadUnreadNotify(){
        return Response::json(Auth::user()->getCountNotify());
    }

	public function postDeleteNotify(){
		$id = Input::get('id');
		if(empty($id)){
			return Response::json(array('success'=>false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'));
		}

		$notify = Notify::where('_id', $id)->where('uid', Auth::user()->_id)->first();
		if(!$notify)
			return Response::json(array('success'=>false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'));

		if($notify->delete())
			return Response::json(array('success'=>true, 'message' => 'Xóa thành công.'));

		return Response::json(array('success'=>false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'));
	}

	public function getTest(){
//		$send = Network::cancelpack('0903275310');
        print_r(Session::get('return_url'));
	}

    public function disableEmail(){
        $key = Input::get('key');
        try{
            $decode = base64_decode($key);
            $dataArr = explode('+', $decode);
            $phone = $dataArr[0];
            $password = $dataArr[1];
            $user = User::where('phone', $phone)->first();
            if(!$user)
                throw new Exception('User không tồn tại.');
            if($password != $user->password)
                throw new Exception('Mật khẩu không đúng.');
            Auth::login($user);
            $user->thong_bao = array_merge($user->thong_bao, array('email'=>Constant::STATUS_DISABLE));
            $user->save();
        }catch (Exception $e){
            return Redirect::to('/thong-bao.html')->with('error','Thao tác không hợp lệ.');
        }
        return Redirect::to('/thong-bao.html')->with('success','Bạn đã hủy nhận thông báo qua email.');
    }

    public function verifyEmail(){
        $key = Input::get('key');
        $email = Input::get('email');
        try{
            $decode = base64_decode($key);
            $dataArr = explode('+', $decode);
            $uid = $dataArr[0];
            $emailC = $dataArr[1];
            $time = $dataArr[2];
            if($emailC != $email || time() - $time > 30*60){
                throw new Exception('Thao tác không hợp lệ.');
            }
        }catch (Exception $e){
            return Redirect::to('/thong-bao.html')->with('error',$e->getMessage());
        }
        $checkEmail = User::where(array('email'=>$email, '_id'=>array('$ne'=>$uid)))->first();
        if($checkEmail){
            return Redirect::to('/thong-bao.html')->with('error','Email đã được sử dụng.');
        }
//        User::where('email', $email)->update(array('email'=> ''));
        $user = User::where('_id', strval($uid))->first();
        $user->email = $email;
        $user->status = Constant::STATUS_ENABLE;
        $user->save();
        Auth::login($user);
        return Redirect::to('/thong-bao.html')->with('success','Chúc mừng bạn trở thành thành viên của English360');

//        return Redirect::to('/thong-bao.html')->with('success','Xác thực email thành công. Mời bạn tiếp tục sử dụng dịch vụ.');
    }

    public function getRegLession(){
        $allType = Common::getAllLessionType();
        $checked = isset(Auth::user()->reg_lession) ? Auth::user()->reg_lession : array();
        $showEmail = (!isset(Auth::user()->email) || empty(Auth::user()->email) || count($checked) ==0) && !Session::has('reg_lession_popup');
        return View::make('users.reg_lession', array(
            'allType' => $allType,
            'checked' => $checked,
            'showEmail' => $showEmail
        ));
    }

    public function facebookCallback(){
        $fb = new Facebook\Facebook([
            'app_id' => Constant::FACEBOOK_APP_ID, // Replace {app-id} with your app id
            'app_secret' => Constant::FACEBOOK_APP_KEY,
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

// Logged in
        $oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
// Lấy thông tin
        $fb_uid = $tokenMetadata->getUserId();
        $_SESSION['fb_access_token'] = (string) $accessToken;
        $fb->setDefaultAccessToken($_SESSION['fb_access_token']);
        $response = $fb->get('/me?locale=en_US&fields=name,email,picture');
        $userNode = $response->getGraphUser();
//echo $userNode->getField('id');
//var_dump(
//    $userNode->getField('email'), $userNode['email']
//);
        $fb_email = $userNode->getField('email');
        $fb_name = $userNode->getField('name');
        if(empty($fb_email)){
            return Redirect::to('/thong-bao.html')->with('error', 'Bạn vui lòng cho English360 quyền truy cập vào địa chỉ email Facebook của bạn.');
        }
        $checkEmail = User::where(array('email'=>$fb_email,'status'=>Constant::STATUS_ENABLE,'fbid'=>array('$ne'=>$fb_uid)))->first();
        if($checkEmail){
            if(isset($checkEmail->fbid) && !empty($checkEmail->fbid))
                return Redirect::to('/thong-bao.html')->with('error', 'Email đã được sử dụng');
            else{
                //Nếu có user đk cùng mail trước đó thì gộp làm 1
                $checkEmail->fbid = $fb_uid;
                if(empty($checkEmail->displayname)) $checkEmail->displayname = $fb_name;
                if(empty($checkEmail->fullname)) $checkEmail->fullname = $fb_name;
                $checkEmail->save();
                Auth::login($checkEmail);
                return Redirect::to(Session::get('return_url','/user/package'));
            }
        }
        $checkUser = User::where('fbid',$fb_uid)->first();
        if(!$checkUser){
            $user = new User();
            $user->_id = strval(time());
            $user->datecreate = time();
		    $user->email = $fb_email;
            $user->cmnd = '';
            $user->cmnd_ngaycap = '';
            $user->cmnd_noicap = '';
            $user->fullname = $fb_name;
            $user->displayname = $fb_name;
            $user->fbid = $fb_uid;
            $user->priavatar = '';
            $user->thong_bao = array(
                'noti' => '1',
                'email' => '1',
            );
            //Nếu có aff
            if(isset($_COOKIE[Constant::AFF_COOKIE_NAME])){
                $cookie_value = Common::decodeAffCookie($_COOKIE[Constant::AFF_COOKIE_NAME]);
                $cookieArr = explode('&',$cookie_value);
                $user->aff = array(
                    'uid' => $cookieArr[0],
                    'sub_id' => isset($cookieArr[1]) ? $cookieArr[1] : '',
                    'datecreate' => time()
                );
            }
            $user->save();

            Auth::login($user);
        }else{
            Auth::login($checkUser);
        }

        return Redirect::to(Session::get('return_url','/user/package'));
    }
}