<?php

class AjaxController extends \BaseController {

    public function __construct(){
        $this->beforeFilter('auth', array('only'=>array(
            'postReview',
            'postDelUpload',
            'postUpdateEmail',
//            'postRegLession',
        )));
    }

	public function postLoadReview(){
		$id = Input::get('id');
		$type = Input::get('type');
		$model = CommonHelpers::getModelFromType($type);
		$item = $model::where('_id', $id)->first();
		$re = array(
			'yes' => isset($item->review['yes']) ? count($item->review['yes']) : 0,
			'no' => isset($item->review['no']) ? count($item->review['no']) : 0,
		);
		return Response::json($re);
	}

	public function postReview(){
		$id = Input::get('id');
		$type = Input::get('type');
		$ok = Input::get('ok') == 1;
		$model = CommonHelpers::getModelFromType($type);
		$item = $model::where('_id', $id)->first();
		if(!$item)
			return Response::json(array('success'=>false , 'message' => 'Bài học không tồn tại.'));
		$uid = Auth::user()->_id;
		if(!isset($item->review))
			$item->review = array(
				'yes' => array(),
				'no' => array()
			);

		if(isset($item->review['yes']) && is_array($item->review['yes']))
			$yes = $item->review['yes'];
		else
			$yes = array();
		if(isset($item->review['no']) && is_array($item->review['no']))
			$no = $item->review['no'];
		else
			$no = array();
		if(in_array($uid, $yes) || in_array($uid, $no)){
			return Response::json(array('success'=>false , 'message' => 'Bạn đã đánh giá bài học này rồi.'));
		}

		if($ok){
			array_push($yes, $uid);
//			$item->review = array(
//			'yes' => $item->review['yes'] + 1,
//			'no' => $item->review['no']
//		);
		}else{
			array_push($no, $uid);
//			$item->review = array(
//				'yes' => $item->review['yes'],
//				'no' => $item->review['no'] + 1
//			);
		}
		$item->review = array(
			'yes' => $yes,
			'no' => $no
		);
		$item->save();
		return Response::json(array('success' => true, 'message' => 'Đánh giá thành công.'));
	}

	public function postDelUpload(){
		$id = Input::get('id');
		$item = Upload::where('_id', $id)->where('type', Constant::TYPE_SONG)->first();
		if(!$item)
			return Response::json(array('success'=>false, 'message'=>'Bản thu này không tồn tại.'));

		if(!Auth::user() || Auth::user()->_id != $item->uid)
			return Response::json(array('success'=>false, 'message' => 'Bạn không được quyền xóa bản thu này.'));

		$item->delete();
		return Response::json(array('success'=>true, 'message'=>'Xóa bản thu thành công!'));
	}

    public function postUpdateEmail(){
        $input['email'] = Input::get('email');
		$rules = array(
			'email'=>'required|email'
		);
		$validator = Validator::make($input, $rules);
		if($validator->fails()){
			return Response::json(array('success'=>false, 'message'=>$validator->errors()->first()));
		}
		$userId = strval(Auth::user()->_id);
//		print_r($userId);die;
		if($input['email'] != Auth::user()->email){
			$checkUser = User::where(array(
					'email'=>$input['email'],
					'_id'=>array('$ne'=>$userId))
			)->first();
			if($checkUser)
				return Response::json(array('success'=>false,'message'=>'Email này đã được sử dụng.'));
		}

		User::where('_id',$userId)->update(array('email'=>$input['email']));

        return Response::json(array('success'=>true));
    }

	public function postRegEmailLession(){
		$email = Input::get('email');
		$rules1 = array(
			'email'=>'email|required',
		);
		$validator = Validator::make(array('email'=>$email), $rules1);
		if($validator->fails()){
			return Response::json(array('success'=>false, 'mss'=>$validator->errors()->first()));
		}
		if(Auth::user()){
			$checkUser = User::where(array('email' => $email, '_id'=>array('$ne'=>Auth::user()->_id)))->first();
			if($checkUser){
				//Gửi email yêu cầu xác nhận
				$bodyEmail = '<p>Xin chào,</p>'.
				'<p>Để xác thực email cho tài khoản English360, bạn vui lòng click vào đường link bên dưới:</p>'.
				'<p><a href="'.Common::getVerifyEmailUrl(Auth::user()->_id,$email).'">'.Common::getVerifyEmailUrl(Auth::user()->_id,$email).'</a></p>'.
				'<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>';
				$mail = new \helpers\Mail($email, 'Xác thực email English360.vn', $bodyEmail);
				$mail->send();
				return Response::json(array('success'=>false, 'mss'=>'Chúng tôi đã gửi 1 email xác nhận về địa chỉ '.$email.', vui lòng xác nhận địa chỉ email này là của bạn.', 'verify'=>true));
			}else{
				//Update email
				User::where('_id', Auth::user()->_id)->update(array('email'=>$email));
				return Response::json(array('success'=>true));
			}
		}else{
			$checkUser = User::where('email', $email)->first();
			if($checkUser){
				// Nếu không phải chính user vừa tạo thì yêu cầu xác thực
				if($email != Session::get('email_reg_lession','')){
					Session::set('required_verify_email', $email);
					return Response::json(array('success'=>false, 'mss'=>'Email đã được sử dụng, vui lòng xác thực', 'login'=>true));
				}
				return Response::json(array('success'=>true));
			}else{
				//Check nếu là user vừa tạo thì update email
				if(Session::has('email_reg_lession')){
					if(Session::get('email_reg_lession') != $email){
						User::where(array(
							'email'=> Session::get('email_reg_lession'),
							'phone' => array('$exists' => false)
						))->update(array('email'=>$email));
						Session::set('email_reg_lession', $email);
					}
					return Response::json(array('success'=>true));
				}
				//Email mới thì tạo TK mới
				$unpassword = Common::generateRandomPassword();
				$password = Common::encryptpassword($unpassword);
				User::insert(array(
					'_id' => strval(time()),
					'email' => $email,
					'username' => 'user'.time(),
					'un_password'=>$unpassword,
					'password' => $password,
					'datecreate' => $now,
					'status'=>Constant::STATUS_ENABLE,
					'thong_bao' => array(
						'noti' => "1",
						'email' => "1",
					)
				));
				Session::set('email_reg_lession', $email);
				return Response::json(array('success'=>true));
			}
		}
	}

    public function postRegLession(){
        $select = Input::get('select');
		$email = Input::get('email', Session::get('email_reg_lession',''));
		if(empty($email) && !Auth::user()){
			return Response::json(array('success'=>false,'message'=>'Có lỗi xảy ra, vui lòng thử lại sau.'));
		}
		$user = Auth::user() ? Auth::user() : User::where('email',$email)->first();
		$user->reg_lession = $select;
		$user->save();
		Session::remove('reg_lession_popup');
		return Response::json(array('success'=>true,'message'=>'Lưu thay đổi thành công.'));
    }

	public function postAddLession(){
//		$email = Input::get('email');
		$type = Input::get('type');
		if(!Auth::user()){
			$email = Session::get('email_reg_lession');
			//Nếu đã tồn tại user có email này
			$checkUser = User::where('email', $email)->first();
			if($checkUser){
				$reg_lession = isset($checkUser->reg_lession) ? $checkUser->reg_lession : array();
				if(!in_array($type, $reg_lession))
					array_push($reg_lession, $type);

				$checkUser->reg_lession = $reg_lession;
				$checkUser->save();
				return Response::json(array('success'=>true));
			}
			$user = new User();
			$user->_id = strval(time());
			$user->email = $email;
			$user->reg_lession = array($type);
			$user->save();
			return Response::json(array('success'=>true));
		}
		$checkUser = User::where(array(
			'email' => $email,
			'_id' => array('$ne'=>Auth::user()->_id)
		))->first();
		if($checkUser){
			return Response::json(array('success'=>false, 'mss'=>'Email này đã có người sử dụng.'));
		}
		$reg_lession = isset(Auth::user()->reg_lession) ? Auth::user()->reg_lession : array();
		if(!in_array($type, $reg_lession))
			array_push($reg_lession, $type);

		User::where('_id',Auth::user()->_id)->update(array('reg_lession'=>$reg_lession,'email'=>$email));
		return Response::json(array('success'=>true));
	}

    public function postAlertChat(){
        if(!Session::has('chat_alert') || (time()- Session::get('chat_alert') > 5*60)){
            $phoneArr = ['0936026186'];
            $mss = '(English360.vn) Thông báo: Có nội dung chat mới chưa được trả lời.';
            foreach($phoneArr as $aPhone){
                Network::sentMT($aPhone, 'PUSH', $mss);
            }
            Session::put('chat_alert',time());
        }
    }

	public function postAddPopupNumber(){
		Session::put('number_popreg', Session::get('number_popreg',0)+1);
		return Response::json(array('success'=>true));
	}

	public function postRemoveEvent(){
		unset($_SESSION['event_id']);
		return Response::json(array('success'=>true));
	}

	public function postRegEvent(){
		$email = Input::get('email','');
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return Response::json(array('success'=>false, 'message'=>'Địa chỉ email không hợp lệ.'));
		}
		$event_id = Input::get('event_id');
		$event = EventModel::where('_id', $event_id)->first();
		if(!$event){
			return Response::json(array('success'=>false, 'message'=>'Sự kiện này đã hết hạn.'));
		}
		$user = User::where('email',$email)->first();
		if(!$user){
			$unpassword = Common::generateRandomPassword();
			$password = Common::encryptpassword($unpassword);
			$user = new User();
			$user->_id = strval(time());
			$user->username = 'user'.time();
			$user->un_password = $unpassword;
			$user->password = $password;
			$user->datecreate = time();
			$user->status = Constant::STATUS_ENABLE;
			$user->email = $email;
			$user->save();
		}
		$eventUser = EventUser::where(array('uid'=>$user->_id, 'eid' => $event_id))->first();
		if(!$eventUser){
			$eventUser = new EventUser();
			$eventUser->_id = strval(time());
			$eventUser->uid = strval($user->_id);
			$eventUser->eid = strval($event_id);
			$eventUser->datecreate = time();
			$eventUser->save();
		}

		$start = $eventUser['datecreate'];
		$end = $start + $event->free_day*24*60*60;
		$body = str_replace(array('{username}','{pass}','{start}','{end}'), array($user->username, $user->un_password,date('d/m/Y',$start), date('d/m/Y',$end)), $event->contentEmail);
		$subject = $event->name;
		$mail = new \helpers\Mail($email,$subject,$body);
		if(!$mail->send()){
			return Response::json(array('success'=>false, 'message'=>'Không thể gửi email cho bạn. Vui lòng thử lại sau.'));
		}
		return Response::json(array(
			'success' => true,
			'message' => '<p>Cảm ơn bạn đã tham gia Chương trình Khuyến mại của English360.</p>
        <p>Tài khoản miễn phí đã được gửi về địa chỉ Email của bạn. Vui lòng kiểm tra email và làm theo hướng dẫn.</p>'
		));
	}
}