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
//			'getLogout',
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
		$input = Input::all();
        $rules = User::$rules;
		$validator = Validator::make($input, $rules);
		if($validator->fails()){
			return Response::json(array('success'=>false, 'message'=>$validator->errors()->first()));
		}

        //kiểm tra có đăng ký nhận SMS không
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
            $user->save();
        }
        //Gửi email xác nhận
        $content = '<p>Xin chào,</p>'.
            '<p>Để xác thực email cho tài khoản English360, bạn vui lòng click vào đường link bên dưới:</p>'.
            '<p><a href="'.Common::getVerifyEmailUrl($user->_id,$user->email).'">'.Common::getVerifyEmailUrl($user->_id,$user->email).'</a></p>'.
            '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>';
        $mail = new \helpers\Mail($user->email,'Xác nhận tài khoản English360.com.vn',$content);
        if(!$mail->send()){
            return Response::json(array('success'=>false, 'message'=>'Không thể gửi thư xác nhận đến địa chỉ email của bạn, vui lòng thử lại sau.'));
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
		return Response::json(array('success'=> true, 'message'=>'Vui lòng kiểm tra email để xác thực tài khoản của bạn.'));
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
                    $content = '<p>Xin chào,</p>'.
                        '<p>Để xác thực email cho tài khoản English360, bạn vui lòng click vào đường link bên dưới:</p>'.
                        '<p><a href="'.Common::getVerifyEmailUrl($user->_id,$user->email).'">'.Common::getVerifyEmailUrl($user->_id,$user->email).'</a></p>'.
                        '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>';
                    $mail = new \helpers\Mail($user->email,'Xác nhận tài khoản English360.com.vn',$content);
                    $mail->send();
                    if(Request::ajax())
                        return Response::json(array('success' => false, 'message' => 'Vui lòng xác thực email.'));
                    else
                        return Redirect::back()->with('error', 'Vui lòng xác thực email.')->withInput();
                }
				Auth::login($user);
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
                    return Redirect::to(Session::get('return_url','/'));
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
        if(isset($user->fbid))
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

	public function getTest(){
//		$send = Network::cancelpack('0903275310');
        print_r(Session::get('return_url'));
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
        User::where('email', $email)->update(array('email'=> ''));
        $user = User::where('_id', strval($uid))->first();
        $user->email = $email;
        $user->status = Constant::STATUS_ENABLE;
        $user->save();
//        User::where('_id', strval($uid))->update(array('status'=> Constant::STATUS_ENABLE));
        Auth::login($user);
        return Redirect::to('/thong-bao.html')->with('success','Xác thực email thành công. Mời bạn tiếp tục sử dụng dịch vụ.');
//        print_r($dataArr);die;
//        Session::set('reg_lession_popup', true);
//        if(Auth::user() && Auth::user()->_id==$uid){
//            return Redirect::to('/user/reg-lession');
//        }else{
//            Session::set('email_reg_lession',$email);
//            return Redirect::to('/');
//        }
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
            $user->save();

            Auth::login($user);
        }else{
            Auth::login($checkUser);
        }

        return Redirect::to(Session::get('return_url','/'));
    }
}