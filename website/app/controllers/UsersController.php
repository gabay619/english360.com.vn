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
			'getLogout',
			'postSetting',
            'getSaveLession',
            'postDeleteSaveLession',
            'getQuestion',
            'getPackage',
            'getNotify',
			'postDeleteNotify',
			'postLoadUnreadNotify',
            'getPackage',
            'getRegisterPackage',
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
        unset($rules['email']);
		$validator = Validator::make($input, $rules);
		if($validator->fails()){
			return Response::json(array('success'=>false, 'message'=>$validator->errors()->first()));
		}
//        if($input['password'] != $input['password_confirmation']){
//            return Redirect::back()->with('error', 'Mật khẩu xác nhận không khớp')->withInput();
//        }

//        if(!Network::mobifoneNumber($input['phone'])){
//            return Response::json(array('success'=>false, 'message'=>'Yêu cầu nhập số điện thoại MobiFone.'));
//        }

        //kiểm tra có đăng ký nhận SMS không
//        $checkSMSNoti = Network::checkTCSMS($input['phone']) == 0;

		$user = new User();
		$user->_id = strval(time());
        $user->datecreate = time();
//		$user->phone = $input['phone'];
//		$user->email = $input['email'];
		$user->un_password = $input['password'];
		$user->username = $input['username'];
		$user->password = Common::encryptpassword($user->un_password);
        $user->cmnd = '';
        $user->cmnd_ngaycap = '';
        $user->cmnd_noicap = '';
        $user->fullname = '';
        $user->priavatar = '';
        $user->thong_bao = array(
            'noti' => '1',
//            'sms' => $checkSMSNoti ? '1' : '0',
            'email' => '1',
        );
		$user->save();

		Auth::login($user);
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
                'phone' => Auth::user() ? Auth::user()->phone : '',
                'price' => 0
        );
        HisLog::insert($newHistoryLog);
		return Response::json(array('success'=> true, 'message'=>'Thanh cong'));
	}

	public function postSendAuthKey(){
		$phone = Input::get('phone', Session::get('new_user')['phone']);
		if(empty($phone))
			return Response::json(array('success'=>false, 'message' => 'Yêu cầu nhập số điện thoại Mobifone.'));

        if(!Network::mobifoneNumber($phone)){
            return Response::json(array('success'=>false, 'message' => 'Yêu cầu nhập số điện thoại Mobifone.'));
        }

		$checkUser = User::where('phone', $phone)->first();
		if($checkUser && !Input::get('check_exist', false))
			return Response::json(array('success'=>false, 'message' => 'Số điện thoại này đã đăng ký tài khoản, vui lòng đăng nhập.'));

		$authkey = AuthKey::findOrCreateNew($phone);
		//Đếm số lượt lấy mã xác thực
		if($authkey->count > 5)
		{
			return Response::json(array('success'=>false, 'message'=>'Bạn đã lấy mã xác thực quá 5 lần cho phép. Vui lòng đợi sau 60 phút để lấy lại mã xác thực.'));
		}else{
			$authkey->count = $authkey->count + 1;
			$authkey->save();
		}
        //Gửi MT
		$key = $authkey->getAuthKey();
        $info = 'Mã xác thực dịch vụ English360 của bạn là: '.$key;
        $result = Network::sentMT($phone, 'OTP', $info);
        if($result != 0){
            return Response::json(array('success'=>false, 'message' => 'Không thể gửi tin nhắn đến số điện thoại của bạn, vui lòng thử lại sau.'));
        }
		Session::put('new_user', array(
			'phone' => $phone,
			'validate' => false,
		));
		return Response::json(array('success'=> true, 'message'=>'Thanh cong: '.$key));
	}

	public function postValidateAuthKey(){
		if(!Session::has('new_user')){
			return Response::json(array('success'=>false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau!'));
		}
		$new_user = Session::get('new_user');
		$phone = $new_user['phone'];
		$auth_key = Input::get('auth_key');
		$confirm = AuthKey::findOrCreateNew($phone);

		if($confirm->checkAuthKeyExpired())
			return Response::json(array('success'=>false, 'message' => 'Mã xác thực đã hết hạn.'));

		if(!$confirm->validateAuthKey($auth_key))
			return Response::json(array('success'=>false, 'message' => 'Mã xác thực không đúng.'));

		$confirm->removeAuthKey();

		Session::put('new_user', array(
			'phone' => $new_user['phone'],
			'validate' => true
		));
		return Response::json(array('success'=>true, 'message'=>'Thanh cong!'));
	}

    public function postAuthKey(){
        $phone = Auth::user()->phone;
        $authkey = AuthKey::findOrCreateNew($phone);
        //Đếm số lượt lấy mã xác thực
        if($authkey->count > 5)
        {
            return Response::json(array('success'=>false, 'message'=>'Bạn đã lấy mã xác thực quá 5 lần cho phép. Vui lòng đợi sau 60 phút để lấy lại mã xác thực.'));
        }else{
            $authkey->count = $authkey->count + 1;
            $authkey->save();
        }
        //Gửi MT
        $key = $authkey->getAuthKey();
        $info = 'Mã xác thực dịch vụ English360 của bạn là: '.$key;
        $result = Network::sentMT($phone, 'OTP', $info);
        if($result != 0){
            return Response::json(array('success'=>false, 'message' => 'Không thể gửi tin nhắn đến số điện thoại của bạn, vui lòng thử lại sau.'));
        }
        return Response::json(array('success'=> true, 'message'=>'Thanh cong: '.$key));
    }

    public function postCheckAuthKey(){
        $phone = Auth::user()->phone;
        $auth_key = Input::get('auth_key');
        $confirm = AuthKey::findOrCreateNew($phone);

        if($confirm->checkAuthKeyExpired())
            return Response::json(array('success'=>false, 'message' => 'Mã xác thực đã hết hạn.'));

        if(!$confirm->validateAuthKey($auth_key))
            return Response::json(array('success'=>false, 'message' => 'Mã xác thực không đúng.'));

        $confirm->removeAuthKey();
        return Response::json(array('success'=>true, 'message'=>'Thanh cong!'));
    }

    public function postCheckAuthKeyAndPackage(){
        if(!Session::has('new_user')){
            return Response::json(array('success'=>false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau!'));
        }
        $new_user = Session::get('new_user');
        $phone = $new_user['phone'];
        $auth_key = Input::get('auth_key');
        $confirm = AuthKey::findOrCreateNew($phone);

        if($confirm->checkAuthKeyExpired())
            return Response::json(array('success'=>false, 'message' => 'Mã xác thực đã hết hạn.'));

        if(!$confirm->validateAuthKey($auth_key))
            return Response::json(array('success'=>false, 'message' => 'Mã xác thực không đúng.'));

        $confirm->removeAuthKey();
        $user = User::where('phone',$phone)->first();
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
            $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_DANG_KY,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => $user->_id,
                'url' => Request::url(),
                'status' => Constant::BASE_URL.'/user/quick-package',
                'phone' => $phone,
                'price' => 0
            );
            HisLog::insert($newHistoryLog);
        }
        Auth::login($user);
        if(Network::getUserInfo($phone) != 1){
            $rs = Network::registedpack($phone);
            if($rs != 0)
                return Response::json(array('success'=>false, 'message' => 'Đăng ký không thành công, vui lòng thử lại sau.'));

            $packageInfo = Network::getCancelInfo($phone);
            $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => $user->_id,
                'url' => Request::url(),
                'status' => Constant::BASE_URL.'/user/quick-package',
                'phone' => $phone,
                'price' => $packageInfo == 0 ? 0 : Network::getPackageItem()['E']['price']
            );
            HisLog::insert($newHistoryLog);
        }

        return Response::json(array('success'=>true, 'message'=>'Thanh cong!'));
    }

	public function getLogin()
	{
		return View::make('users.login');
	}

	public function postLogin(){
		$phone = Input::get('phone', Session::get('popreg_phone'));
        $phone = strtolower($phone);
		$password = Input::get('password');
        if(empty($phone) || empty($password)){
            if(Request::ajax())
                return Response::json(array('success' => false, 'message' => 'Vui lòng nhập đầy đủ Số điện thoại và Mật khẩu.'));
            else
                return Redirect::back()->with('error', 'Vui lòng nhập đầy đủ Số điện thoại và Mật khẩu.')->withInput();
        }
//        if(!Network::mobifoneNumber($phone)){
//            if(Request::ajax())
//                return Response::json(array('success' => false, 'message' => 'Yêu cầu nhập số điện thoại MobiFone.'));
//            else
//                return Redirect::back()->with('error', 'Yêu cầu nhập số điện thoại MobiFone.')->withInput();
//        }
		$user = User::where(array(
            '$or'=> array(
                array('phone'=> $phone),
                array('username' => $phone)
            )
        ))->first();
		if($user){
			if($user->password == Common::encryptpassword($password)){
				Auth::login($user);
                ##Gui tin hang ngay
                if(Session::has('popreg_phone') && !empty(Session::get('popreg_phone'))){
//                    print_r(Session::get('popreg_phone'));
                    Network::sendToDaily(Session::get('popreg_phone'));
                    Session::forget('popreg_phone');
                }
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
                        'phone' => Auth::user()->phone,
                        'price' => 0
                );
                HisLog::insert($newHistoryLog);
				if(Request::ajax())
					return Response::json(array('success' => true, 'message' => 'Đăng nhập thành công.'));
				else{
                    //Nếu đang có yêu cầu xác thực email
                    if(Session::has('required_verify_email')){
                        $verifyEmail = Session::get('required_verify_email');
                        $bodyEmail = '<p>Xin chào,</p>'.
                            '<p>Để xác thực email cho tài khoản English360, bạn vui lòng click vào link bên dưới</p>'.
                            '<p><a href="'.Common::getVerifyEmailUrl($user->_id,$verifyEmail).'">'.Common::getVerifyEmailUrl($user->_id,$verifyEmail).'</a></p>'.
                            '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>';
                        $mail = new \helpers\Mail($verifyEmail, 'Xác thực email English360.vn', $bodyEmail);
                        $mail->send();
                        Session::remove('required_verify_email');
                        return Redirect::to('/thong-bao.html')->with('success','Chúng tôi đã gửi 1 email xác nhận về địa chỉ '.$verifyEmail.', vui lòng xác nhận địa chỉ email này là của bạn.');
                    }
                    if(Session::has('return_url'))
                        return Redirect::to(Session::get('return_url'));
                    else
                        return Redirect::intended('/');
                }
			}else{
				if(Request::ajax())
					return Response::json(array('success' => false, 'message' => 'Mật khẩu không đúng.'));
				else
					return Redirect::back()->with('error', 'Mật khẩu không đúng.')->withInput();
			}
		}else{
			if(Request::ajax())
				return Response::json(array('success' => false, 'message' => 'Số điện thoại này chưa được đăng ký tài khoản.'));
			else
				return Redirect::back()->with('error', 'Số điện thoại này chưa được đăng ký tài khoản.')->withInput();
        }
	}

    public function getForgetPass(){
        return View::make('users.forget-pass');
    }

    public function postForgetPass(){
        $phone = Input::get('phone');
        if(empty($phone))
            return Redirect::back()->with('error', 'Bạn chưa nhập số điện thoại.')->withInput();

//        if(!Network::mobifoneNumber($phone)){
//
//        }
//            return Redirect::back()->with('error', 'Vui lòng nhập số điện thoại MobiFone.')->withInput();

        $user = User::where('phone', $phone)
                ->first();

        if(!$user)
            return Redirect::back()->with('error', 'Số điện thoại này hiện chưa đăng ký tài khoản.')->withInput();

        $sendPassCount = isset($user->send_pass['count']) ? $user->send_pass['count'] : 0;
        $sendPassTime = isset($user->send_pass['time']) ? $user->send_pass['time'] : time();
        if(time() - $sendPassTime > 60*60)
            $sendPassCount = 0;
        if($sendPassCount >= 5)
            return Redirect::back()->with('error', 'Quý khách đã lấy mật khẩu 5 lần. Vui lòng chờ sau 60 phút để lấy lại mật khẩu.')->withInput();


        $password = isset($user->un_password) ? $user->un_password : $user->password;
        $info = 'Mật khẩu để sử dụng dịch vụ English360 của Quý khách là:' .$password;
        //Gửi MK qua email nếu khách không phải vms
        if(!Network::mobifoneNumber($phone) && !empty($user->email)){
            if(empty($user->email)){
                return Redirect::back()->with('error', 'Tài khoản này hiện chưa thiết lập email.')->withInput();
            }
            $to = $user->email;
            $subject = 'Khôi phục mật khẩu English360';
            $body = $info;
            $mail = new \helpers\Mail($to,$subject,$body);
            if($mail->send()){
                return Redirect::back()->with('success', 'Mật khẩu đã được gửi về email của bạn. Vui lòng kiểm tra lại.')->withInput();
            }else{
                return Redirect::back()->with('error', 'Không thể gửi tin nhắn đến email của bạn, vui lòng thử lại sau.')->withInput();
            }
        }
        $result = Network::sentMT($phone, 'MK', $info);
        if($result != 0)
            return Redirect::back()->with('error', 'Không thể gửi tin nhắn đến số điện thoại của bạn, vui lòng thử lại sau.')->withInput();

		$user->send_pass = array(
			'count' => $sendPassCount +1,
			'time' => time()
		);
		$user->save();
        return Redirect::back()->with('success', 'Mật khẩu đã được gửi về số điện thoại của bạn. Vui lòng kiểm tra lại.')->withInput();

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
                'uid' => Auth::user()->_id,
                'url' => Request::url(),
                'status' => Constant::STATUS_ENABLE,
                'phone' => Auth::user()->phone,
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
		$email = Input::get('email', '');
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
			'email'=>'email',
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
		if(!empty($email)){
			$checkUniqueEmail = User::where('email', $email)->where('_id', '!=', $user->_id)->first();
			if($checkUniqueEmail)
				return Redirect::back()->with('error', 'Email đã được sử dụng.')->withInput();
			$user->email = $email;
		}
		if(!empty($displayname))
			$user->displayname = $displayname;
		$user->fullname = $fullname;
		$user->birthday = $birthday;
		$user->cmnd = $cmnd;
		$user->cmnd_ngaycap = $cmnd_ngaycap;
		$user->cmnd_noicap = $cmnd_noicap;
		$user->thong_bao = array(
			'noti' => strval(Input::get('chkNoti', 0)),
			'sms' => strval(Input::get('chkSms', 0)),
			'email' => strval(Input::get('chkEmail', 0)),
		);
        if(Input::get('chkSms', 0) == 1)
            Network::DKSMS($user->phone);
        else
            Network::TCSMS($user->phone);

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
                    'phone' => Auth::user()->phone,
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
        $user = Auth::user();
        $checkPackage = Network::getUserInfo($user->phone,'E',$user->_id);
        $eventUser = EventUser::where('uid',$user->_id)->first();
        $event = false;
        if($eventUser){
            $event = EventModel::where('_id',$eventUser->eid)->first();
        }
        return View::make('users.package', array(
            'checkPackage' => $checkPackage,
            'event' => $event,
            'eventUser' => $eventUser
        ));
    }

    public function getRegisterPackage(){
        $phone = Auth::user()->phone;
        $checkPackage = Network::getUserInfo($phone);
        if($checkPackage == 1)
            return Redirect::to('/user/package');

        $result = Network::registedpack($phone, "WEB");
//        print_r($result);die;
        if($result != 0)
            return View::make('users.register_package', array(
                'mss' => 'Quá trình đăng ký thất bại, mời quý khách thử lại.',
                'class' => 'text-danger'
            ));

        $packageInfo = Network::getCancelInfo($phone);
        $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
            'chanel' => HistoryLog::CHANEL_WEB,
            'ip' => Network::ip(),
            'uid' => Auth::user()->_id,
            'url' => Request::url(),
            'status' => Constant::STATUS_ENABLE,
            'phone' => $phone,
            'price' => $packageInfo == 0 ? 0 : Network::getPackageItem()['E']['price']
        );
        HisLog::insert($newHistoryLog);
        return View::make('users.register_package', array(
                'mss' => 'Quý khách đã đăng ký thành công dịch vụ English360. Chi tiết liên hệ '.Constant::SUPPORT_PHONE.' (200d/phút). Trân trọng cảm ơn!',
                'class' => 'text-success'
        ));
    }


    public function postRegisterPackage(){
        $phone = Auth::user()->phone;
        $checkPackage = Network::getUserInfo($phone);
        if($checkPackage == 1)
            return Redirect::to('/user/package');

        $result = Network::registedpack($phone, "WEB");
//        print_r($result);die;
        if($result != 0){
            //Log
            $newHistoryLog = array(
                    '_id' => strval(time().rand(10,99)),
                    'datecreate' => time(),
                    'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
                    'chanel' => HistoryLog::CHANEL_WEB,
                    'ip' => Network::ip(),
                    'uid' => Auth::user()->_id,
                    'url' => Constant::BASE_URL.'/user/package',
                    'status' => Constant::STATUS_DISABLE,
                    'phone' => Auth::user()->phone,
                    'price' => 0
            );
            HisLog::insert($newHistoryLog);
            return Response::json(array('success'=>false, 'message' => 'Đăng ký gói cước thất bại, vui lòng thử lại sau.'));
        }
        //Log
        $packageInfo = Network::getCancelInfo($phone);
        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => Auth::user()->_id,
                'url' => Constant::BASE_URL.'/user/package',
                'status' => Constant::STATUS_ENABLE,
                'phone' => Auth::user()->phone,
                'price' => $packageInfo == 0 ? 0 : Network::getPackageItem()['E']['price']
        );
        HisLog::insert($newHistoryLog);
        return Response::json(array('success'=>true, 'message' => 'Đăng ký gói cước E thành công.'));
    }

    public function getCancelPackage(){
        $checkPackage = Network::getUserInfo(Auth::user()->phone);
        if($checkPackage != 1)
            return Redirect::to('/user/package');

        return View::make('users.cancel_package', array(
            'checkPackage' => $checkPackage
        ));
    }

    public function postCancelPackage(){
        $phone = Auth::user()->phone;
        $checkPackage = Network::getUserInfo($phone);
        if($checkPackage != 1)
            return Response::json(array('success'=>false, 'message' => 'Bạn chưa đăng ký gói E.'));

        $result = Network::cancelpack($phone, "WEB");
        if($result != 0){
            return Response::json(array('success'=>false, 'message' => 'Hủy thất bại, vui lòng thử lại sau.'));
        }

        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_HUY_GOI_CUOC,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => Auth::user()->_id,
                'url' => Constant::BASE_URL.'/user/package',
                'status' => Constant::STATUS_ENABLE,
                'phone' => Auth::user()->phone,
                'price' => 0
        );
        HisLog::insert($newHistoryLog);
        return Response::json(array('success'=>true, 'message' => 'Bạn đã hủy gói cước E thành công.'));
    }

    public function postCheckPackage(){
        $checkPackage = Network::getUserInfo(Auth::user()->phone,'E',Auth::user()->_id);
        if($checkPackage != 1)
            return Response::json(array('success'=>false));

        return Response::json(array('success'=>true));
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
            if($emailC != $email || time() - $time > 30*60)
                throw new Exception('Thao tác không hợp lệ.');
        }catch (Exception $e){
            return Redirect::to('/thong-bao.html')->with('error',$e->getMessage());
        }
        User::where('email', $email)->update(array('email'=> ''));
        User::where('_id', strval($uid))->update(array('email'=> $email));
//        print_r($dataArr);die;
        Session::set('reg_lession_popup', true);
        if(Auth::user() && Auth::user()->_id==$uid){
            return Redirect::to('/user/reg-lession');
        }else{
            Session::set('email_reg_lession',$email);
            return Redirect::to('/');
        }
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

    public function getQuickPackage(){
        return View::make('users.quick_package');
    }

    public function postQuickPackage(){

    }
}