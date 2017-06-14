<?php

class QuestionsController extends \BaseController {

    public function __construct(){
        $this->beforeFilter('auth', array('only'=>array(
            'postLike',
            'postUnlike',
            'postNew'
        )));
    }

	public function getIndex(){
		$allQuestion = Question::where('status', Constant::STATUS_ENABLE)
			->where('parentid', '0')
			->orderBy('datecreate', 'desc')
			->paginate(20);
		return View::make('questions.index', array(
			'allQuestion' => $allQuestion
		));
	}

	public function getDetail(){
		$id = Input::get('id','');
		$item = Question::where('status', '1')
                ->where('_id', $id)
                ->first();
		if(!$item){
			return 'Câu hỏi không tồn tại.';
		}
		return View::make('questions.detail', array(
			'item' => $item
		));
	}

	public function postLike(){
		$id = Input::get('id');
		$question = Question::whereIn('_id', array($id, intval($id)))->first();

		if(!$question)
			return Response::json(array('success'=>false, 'message'=>'Comment đã bị xóa.'.$id));

		if($question->addLike(Auth::user()->_id)){
            $questionUser = User::where('_id', $question->usercreate)->first();
            if($question->usercreate != Auth::user()->_id && $questionUser && $questionUser->receiveNotify()){
                $notify = new Notify();
                $notify->_id = strval(time());
                $notify->uid = $question->usercreate;
                $notify->usercreate = Auth::user()->_id;
                $notify->datecreate = time();
                $notify->mss = Auth::user()->getDisplayName(). ' đã thích Bình luận của bạn';
                $notify->status = Constant::STATUS_ENABLE;
                $notify->type = Constant::TYPE_NOTIFY;
                $notify->to = array(
                    'type' => Constant::TYPE_HOIDAP,
                    'id' => $id
                );
//                $notify->url = Input::get('url', '/');
                $notify->save();
            }
			return Response::json(array('success'=>true, 'message'=>'Thành công.', 'number'=>$question->getLikeNumber()));
		}else{
			return Response::json(array('success'=>false, 'message'=>'Có lỗi xảy ra, vui lòng thử lại sau.'));
		}
	}

	public function postUnlike(){
		$id = Input::get('id');
		$question = Question::whereIn('_id', array($id, intval($id)))->first();

		if(!$question)
			return Response::json(array('success'=>false, 'message'=>'Comment đã bị xóa.'.$id));

		if($question->removeLike(Auth::user()->_id)){
			return Response::json(array('success'=>true, 'message'=>'Thành công.', 'number'=>$question->getLikeNumber()));
		}else{
			return Response::json(array('success'=>false, 'message'=>'Có lỗi xảy ra, vui lòng thử lại sau.'));
		}
	}

	public function postNew(){
		$content = strip_tags(Input::get('content'));
        $parentid = Input::get('parent','');
		if(empty($content))
			return Response::json(array('success'=>false, 'message'=>'Bạn chưa nhập nội dung câu hỏi.'));

		$question = new Question();
		$question->_id = strval(time());
        if(empty($parentid)){
            //Gửi câu hỏi mới cần đăng ký gói cước
            if(!Auth::user()->registedPackage()){
                Session::put('return_url', Input::get('return_url', '/'));
                return Response::json(array('success'=>false, 'message'=>'Bạn cần đăng ký gói cước.', 'package'=>1));
            }
            $question->parentid = '0';
        }else{
            $question->parentid = $parentid;
        }
        $question->content = $content;
        $question->parentid = empty($parentid) ? '0' : $parentid;
		$question->status = Constant::STATUS_ENABLE;
		$question->usercreate = Auth::user()->_id;
		$question->datecreate = time();
		if($question->save()){
            if(!empty($parentid)){
                //Thông báo
                $parent = Question::whereIn('_id', array($parentid, intval($parentid)))->first();
                $parentUser = User::where('_id', $parent->usercreate)->first();
                if($parent->usercreate != Auth::user()->_id && $parentUser && $parentUser->receiveNotify()){
                    $notify = new Notify();
                    $notify->_id = strval(time());
                    $notify->uid = $parent->usercreate;
                    $notify->usercreate = Auth::user()->_id;
                    $notify->datecreate = time();
                    $notify->mss = Auth::user()->getDisplayName(). ' đã trả lời Câu hỏi của bạn';
                    $notify->status = Constant::STATUS_ENABLE;
                    $notify->type = Constant::TYPE_NOTIFY;
//                    $notify->url = Input::get('url', '/');
                    $notify->to = array(
                        'type' => Constant::TYPE_HOIDAP,
                        'id' => $parentid
                    );
                    $notify->save();

                    //Gửi email
                    if($parentUser->isAllowEmail()){
                        $to = $parentUser->email;
                        $user = Auth::user()->getDisplayName();
                        $time = date('H:i d/m/Y');
                        $url = Constant::BASE_URL.'/hoi-dap/chi-tiet.html?id='.$parentid;
                        $disable_url = Common::makeLinkDisableEmailNotify($parentUser->phone, $parentUser->password);
                        include $_SERVER['DOCUMENT_ROOT'].'/mail/newAns.php';
                        $subject = 'English360.vn: '.Auth::user()->getDisplayName(). ' đã trả lời Câu hỏi của bạn';
                        $mail = new \helpers\Mail($to,$subject,$body);
                        @$mail->send();
                    }
                }
            }

            //Log
            $newHistoryLog = array(
                    '_id' => strval(time().rand(10,99)),
                    'datecreate' => time(),
                    'action' => HistoryLog::LOG_HOI_DAP,
                    'chanel' => HistoryLog::CHANEL_WEB,
                    'ip' => Network::ip(),
                    'uid' => Auth::user()->_id,
                    'url' => empty($parentid) ? Constant::BASE_URL.'/hoi-dap.html' : Constant::BASE_URL.'/hoi-dap/chi-tiet.html?id='.$parent,
                    'status' => Constant::STATUS_ENABLE,
                    'phone' => Auth::user()->phone,
                    'price' => 0
            );
            HisLog::insert($newHistoryLog);

            return Response::json(array(
                    'success'=>true,
                    'message'=>'Bạn đã đặt câu hỏi thành công.',
                    'id'=>$question->_id,
                    'content'=>$content,
                    'time' => date('d/m/Y H:i', $question->datecreate)
            ));
        }
		else
			return Response::json(array('success'=>false, 'message'=>'Có lỗi xảy ra, vui lòng thử lại sau.'));
	}

    public function postDelete(){
        $id = Input::get('id');

        if(empty($id)){
            return Response::json(array('success'=>false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'));
        }

        $question = Question::where('_id', $id)->where('usercreate', Auth::user()->_id)->first();
        if(!$question)
            return Response::json(array('success'=>false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'));

        if($question->delete())
            return Response::json(array('success'=>true, 'message' => 'Xóa thành công.'));

        return Response::json(array('success'=>false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'));
    }
}