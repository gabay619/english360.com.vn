<?php
require app_path('../../sdk/Facebook/autoload.php');
class UsersController extends \BaseController {

	public function __construct(){
        $this->beforeFilter('csrf', array('on' => 'post', 'except'=>array(
//            'postUploadAvatar',
        )));
        $this->beforeFilter('auth', array('except' => array(
			'getLogin',
			'postLogin',
            'getRegister',
            'postRegister',
		)));

		$this->beforeFilter('guest', array('only' => array(
			'getLogin',
			'postLogin',
            'getRegister',
            'postRegister',
		)));
	}

    public function getRegister(){
        return View::make('users.register');
    }

    public function postRegister(){
        $rules = User::$rules;
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){
            return Redirect::back()->with('error', $validator->errors()->first())->withInput();
        }
        if(!Common::isPhoneNumber(Input::get('phone'))){
            return Redirect::back()->with('error', 'Số điện thoại không hợp lệ.')->withInput();
        }

        $checkEmail = User::where('email',Input::get('email'))->first();
        if($checkEmail){
            if($checkEmail->status == Constant::STATUS_ENABLE){
                return Redirect::back()->with('error', 'Địa chỉ Email đã được sử dụng.')->withInput();
            }
            $user = $checkEmail;
            $user->un_password = Input::get('password');
            $user->password = Common::encryptpassword($user->un_password);
            $user->save();
        }else{
            $user = new User();
            $user->_id = strval(time());
            $user->datecreate = time();
            $user->status = Constant::STATUS_DISABLE;
            $user->phone = Input::get('phone');
            $user->email = Input::get('email');
            $user->un_password = Input::get('password');
            $user->fullname = Input::get('fullname');
            $user->password = Common::encryptpassword($user->un_password);
            $user->account_balance = 0;
            $user->cmnd = '';
            $user->cmnd_ngaycap = '';
            $user->cmnd_noicap = '';
            $user->priavatar = '';
            $user->thong_bao = array(
                'noti' => '1',
                'email' => '1',
            );
            $user->save();
        }

        $verifyUrl = Common::getVerifyEmailUrl($user->_id,$user->email,'http://aff.english360.com.vn');
        //Gửi email xác nhận
        $content = '<p>Xin chào '.$user->fullname.'</p>'.
            '<p>Cảm ơn bạn đã đăng ký tài khoản tại http://aff.english360.com.vn. Để hoàn thành việc kích hoạt tài khoản, bạn vui lòng click vào đường dẫn dưới đây:</p>'.
            '<p><a href="'.$verifyUrl.'">'.$verifyUrl.'</a></p>'.
            '<p>Tài khoản của bạn có thể sử dụng tất cả các dịch vụ của English360.</p>'.
            '<p>Cảm ơn bạn đã đồng hành cùng chúng tôi.</p>'.
            '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>'.
            '<p>Ban quản trị English360</p>'.
            '<p>Hotline: '.Constant::SUPPORT_PHONE.'; Email: cskh@english360.com.vn</p>'
        ;
        $mail = new \helpers\Mail($user->email,'Xác nhận tài khoản English360.com.vn',$content);
        try{
            if(!$mail->send()){
                throw new Exception('MAIL ERROR!');
            }
        }catch (Exception $e){
            return Redirect::back()->with('error', 'Không thể gửi thư xác nhận đến địa chỉ email của bạn, vui lòng thử lại sau.')->withInput();
        }

        return Redirect::back()->with('true', 'Vui lòng kiểm tra email để xác thực tài khoản của bạn.');
    }
    
    public function getVerifyEmail(){
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
    }

	public function getLogin()
	{
        session_start();
        $fb = new Facebook\Facebook([
            'app_id' => Constant::FACEBOOK_APP_ID, // Replace {app-id} with your app id
            'app_secret' => Constant::FACEBOOK_APP_KEY,
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        $fb_login = $helper->getLoginUrl('http://aff.english360.com.vn/fb-callback.html', $permissions);
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
            return Redirect::back()->with('error', 'Vui lòng nhập đầy đủ Email và Mật khẩu.')->withInput();
        }
		$user = User::where(array('email'=> $email))->first();
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
                return Redirect::to('/dashboard');
			}else{
                return Redirect::back()->with('error', 'Mật khẩu không đúng.')->withInput();
			}
		}else{
            return Redirect::back()->with('error', 'Email này chưa được đăng ký tài khoản.')->withInput();
        }
	}

	public function getLogout(){
        //Log
		Auth::logout();
		return Redirect::back();
	}

	public function getProfile(){
		return View::make('users.profile');
	}

    public function getSetting(){
        echo Auth::user()->aff()->_id;exit;
        return View::make('users.setting');
    }

	public function postSetting(){
        $fullname = Input::get('fullname', '');
        $birthday = Input::get('birthday', '');
        $cmnd = Input::get('cmnd','');
        $cmnd_ngaycap = Input::get('cmnd_ngaycap', '');
        $cmnd_noicap = Input::get('cmnd_noicap', '');
        $user = Auth::user();

        if(!empty($birthday) && DateTime::createFromFormat('d/m/Y', $birthday)->getTimestamp() > time()){
            return Redirect::back()->with('error', 'Ngày sinh không được lớn hơn ngày hiện tại.')->withInput();
        }

        if(!empty($birthday) && !empty($cmnd_ngaycap) && DateTime::createFromFormat('d/m/Y', $birthday)->getTimestamp() > DateTime::createFromFormat('d/m/Y', $cmnd_ngaycap)->getTimestamp()){
            return Redirect::back()->with('error', 'Ngày cấp CMND không được nhỏ hơn ngày sinh.')->withInput();
        }

        $rules = array(
            'fullname' => 'min:2',
            'cmnd' => 'numeric|min:8',
            'phone' => 'between:9,13|unique:user',
        );
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){
            return Redirect::back()->with('error', $validator->errors()->first())->withInput();
        }
        $user->fullname = $fullname;
        $user->birthday = $birthday;
        $user->cmnd = $cmnd;
        $user->cmnd_ngaycap = $cmnd_ngaycap;
        $user->cmnd_noicap = $cmnd_noicap;
        $user->save();
        return Redirect::back()->with('success', 'Thay đổi thông tin thành công.');
    }

    public function getChangePassword(){
        return View::make('users.change_pass');
    }

    public function postChangePassword(){
        $old_password = Input::get('old_password');
        if(Auth::user()->password != Common::encryptpassword($old_password)){
            return Redirect::back()->with('error', 'Mật khẩu cũ không đúng');
        }

        $rules = array(
            'old_pass'=>'required|alpha_num',
            'password'=>'required|alpha_num|between:6,12|confirmed',
            'password_confirmation'=>'required|alpha_num|between:6,12',
        );
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){
            return Redirect::back()->withInput()->with('error', $validator->errors()->first());
        }
        $user = Auth::user();
        $user->un_password = Input::get('password');
        $user->password = Common::encryptpassword($user->un_password);
        $user->save();
        return Redirect::back()->with('success', 'Đổi mật khẩu thành công.');
    }

	public function getTest(){
//		$send = Network::cancelpack('0903275310');
        print_r(Session::get('return_url'));
	}

    public function facebookCallback(){
        session_start();
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

        return Redirect::to('/dashboard');
    }
}