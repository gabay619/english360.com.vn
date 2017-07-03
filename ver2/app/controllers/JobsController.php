<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15/08/2016
 * Time: 10:58 AM
 */
class JobsController extends \BaseController
{
    public function getSendLession(){
//        echo 'Bat dau gui mail ('.date('d/m/Y H:i').') : '.PHP_EOL;
//        $data = array();
//        $data[] = array(
//            'to' => 'congchinh.619@gmail.com',
//            'subject' => 'tieu de test '.date('d/m/Y H:i:s'),
//            'body' => '<b>noi dung test '.time().'<br>'
//        );
//        $data[] = array(
//            'to' => 'chinhnc@viq.vn',
//            'subject' => 'tieu de test '.date('d/m/Y H:i:s'),
//            'body' => 'noi dung test '.time()
//        );
//        return Response::json($data);
        $diffTime = 659; //10min
        $currentTime = time();
//        $currentTime = strtotime('2016-10-17 14:49:00');
        $tenMinBefore = $currentTime - $diffTime;

        $allType = Common::getAllLessionType();
        $cateArr = array(
            Constant::TYPE_FILM => '1450861603',
            Constant::TYPE_FAMOUS => '1450844989',
            Constant::TYPE_DAILY => '1428995217',
            Constant::TYPE_EXP => '1427344743',
            Constant::TYPE_RADIO => '1427344702',
            Constant::TYPE_VIDEO => '1427183162',
            Constant::TYPE_IDIOM => '1427183137',
            Constant::TYPE_SONG => '1450854263'
        );

        $data = array();
        foreach($allType as $key=>$val){
            $model = CommonHelpers::getModelFromType($key);
            $newLession = $model::where(array(
                'calendar' => array('$gte'=>$tenMinBefore, '$lte' => $currentTime),
                'category' => $cateArr[$key]
            ))->get();

            $allUser = User::where(array(
                'reg_lession' => $key,
                'email' => array('$ne'=>''),
                'thong_bao.email' => '1'
            ))->get();
            foreach($newLession as $aLession){
                $detailUrl = Constant::BASE_URL;
                $detailUrl .= $key != Constant::TYPE_SONG ? ThuVien::getArticleUrlStatic($aLession->name, $aLession->_id, $key, $aLession->slug) : Song::getStaticDetailUrl($aLession->name, $aLession->_id);
                $detailUrl .= '?ref=email';

                $related = $model::where(array(
                    '_id'=>array('$ne'=>$aLession->_id),
                    'category' => $cateArr[$key],
                    '$or' => array(
                        array('calendar' => array('$exists'=>false)),
                        array('calendar' => array('$lte'=> time()))
                    )
                ))->orderBy('datecreate', 'desc')
                    ->limit(4)->get()->toArray();
                foreach ($related as $k=>$v){
                    $url = Constant::BASE_URL;
                    $url .= $key!= Constant::TYPE_SONG ? ThuVien::getArticleUrlStatic($v['name'], $v['_id'], $key) : Song::getStaticDetailUrl($v['name'], $v['_id']);
                    $related[$k]['url'] = $url.'?ref=email';
                    $related[$k]['avatar'] = Common::getWebImageLink($v['avatar']);
                }
                foreach($allUser as $aUser){
                    $data[] = $this->_sendMail($aLession->name, Common::getWebImageLink($aLession->avatar), $aLession->captions, $detailUrl, date('H:i d/m/Y', $aLession->datecreate), $val, $related, $aUser);
                    $emailLog = new EmailLog();
                    $emailLog->to = $aUser->email;
                    $emailLog->userid = $aUser->_id;
                    $emailLog->action = $key;
                    $emailLog->itemid = $aLession->_id;
                    $emailLog->datecreate = time();
                    $emailLog->save();
                }
            }
//            echo '<hr>';
        }
        $checkQueue = EmailQueue::all();
        foreach ($checkQueue as $aQueue){
            $data[] = array(
                'to' => $aQueue->to,
                'subject' => $aQueue->subject,
                'body' => $aQueue->content
            );
            $aQueue->delete();
            $emailLog = new EmailLog();
            $emailLog->to = $aQueue->to;
            $emailLog->userid = '';
            $emailLog->action = '';
            $emailLog->itemid = '';
            $emailLog->datecreate = time();
            $emailLog->save();
        }
        return Response::json($data);
    }

    public function getTestMail(){
        $checkQueue = EmailQueue::all();
        foreach ($checkQueue as $aQueue){
            print_r($aQueue);
            $aQueue->delete();
        }
    }

    private function _sendMail($title, $avatar, $description, $detailUrl, $time, $cate_name, $related, $user){
        $to = $user->email;
        $disable_url = Common::makeLinkDisableEmailNotify($user->phone, $user->password);
        include $_SERVER['DOCUMENT_ROOT'].'/mail/newLession.php';
        $subject = 'Thông báo bài học mới English360';
        return array(
            'to' => $user->email,
            'subject' => $subject,
            'body' => $body
        );
        $mail = new \helpers\Mail($user->email,$subject,$body);
        echo $mail->send() ? date('H:i:s d/m/Y', time()).': Thanh cong|'.$cate_name.'|'.$title.'|'.$to : date('H:i:s d/m/Y', time()).': That bai|'.$cate_name.'|'.$to;

        echo PHP_EOL;
    }

    public function getAdsDemo(){
        $ads = AdsLog::where('phone',Input::get('phone'))->first();
        if(!$ads){
            $ads = new AdsLog();
            $ads->_id = strval(time());
            $ads->phone = Input::get('phone');
        }
        $ads->time = time();
        var_dump($ads->save());
    }

    public function getScanAds(){
        $tenBefore = time() - 10*60;
        $fiveBefore = time() - 5*60;
//        $fiveBefore = time();
        $allAds = AdsLog::where(array(
            'time' => array('$gte'=>$tenBefore, '$lte'=>$fiveBefore)
        ))->get();
        foreach($allAds as $ad){
            $this->_generateFake($ad->phone);
        }
    }

    private function _generateFake($phone){
        $user = User::where('phone',$phone)->first();
        ##random IP
        $randomIp = Common::getRandomIp();
        ##Log dang nhap
        $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_DANG_NHAP,
            'chanel' => HistoryLog::CHANEL_WEB,
            'ip' => $randomIp,
            'uid' => $user->_id,
            'url' => Constant::BASE_URL.'/user/login',
            'status' => Constant::STATUS_ENABLE,
            'phone' => $phone,
            'price' => 0
        );
        HisLog::insert($newHistoryLog);
        ##get authkey
        $auth = AuthKey::where('phone', $phone)->first();
        if(!$auth || empty($auth->key)){
            $authKey = Common::generateRandomPassword();
        }else $authKey = $auth->key;
        $info = 'Mã xác thực dịch vụ English360 của bạn là: '.$authKey;
        Network::sentMT($phone, 'OTP', $info);
        ##tạo 10 log
        $this->_createLogBefore($randomIp);
        sleep(rand(7,10));
        $this->_createLogAfter($randomIp, $user->_id, $phone);
        ##Dang ky goi cuoc
        $smsRegister = Network::registedpack($phone);
        HisLog::insert(array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
            'chanel' => HistoryLog::CHANEL_WEB,
            'ip' => $randomIp,
            'uid' => $user->_id,
            'url' => Constant::BASE_URL.'/user/package',
            'status' => $smsRegister==0 ? Constant::STATUS_ENABLE : Constant::STATUS_DISABLE,
            'phone' => $phone,
            'price'=> $smsRegister==0  ? Network::getPackageItem()['E']['price'] : 0
        ));
        echo 'Dang ky thanh cong ('.date('d/m/Y H:i').'):'.$phone.PHP_EOL;
//		$_SESSION['notsave_log'] = 1;
//		header("Location: ".$linkRedirect);exit;
    }

    private function _createLogBefore($randomIp){
        $time = time();
        $cateArr = array(
            '1450861603' => Constant::TYPE_FILM,
            '1450844989' => Constant::TYPE_FAMOUS,
            '1428995217' => Constant::TYPE_DAILY,
            '1427344743' => Constant::TYPE_EXP,
            '1427344702' => Constant::TYPE_RADIO,
            '1427183162' => Constant::TYPE_VIDEO,
            '1427183137' => Constant::TYPE_IDIOM,
        );
        $catidArr = array(
            '1427344743',
            '1427183137',
            '1427183162',
            '1427344702',
            '1428995217',
            '1450844989',
            '1450844989'
        );
        $catid = '1427344743';
        for($i=0; $i<10; $i++){
            $time = $time - rand(3,10);
            if($i==0 || rand(0,10) <= 3){
                $catid = $catidArr[rand(0, count($catidArr)-1)];
                $post = $this->_getRandomPost('', $catid);
            }else{
                $post =$this->_getRandomPost($post->_id, $catid);
            }
            $type = $cateArr[$catid];
            HisLog::insert(array(
                '_id' => strval($time.rand(10,99)),
                'datecreate' => $time,
                'action' => HistoryLog::LOG_XEM_BAI_HOC,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => $randomIp,
                'uid' => '',
                'url' => ThuVien::getArticleUrlStatic($post->name,$post->_id,$type),
                'status' => Constant::STATUS_ENABLE,
                'phone' => '',
                'price'=> 0
            ));
        }
    }

    private function _createLogAfter($randomIp, $uid, $phone){
        $time = time();
        $catidArr = array('1427344743', '1427183137', '1427183162', '1427344702', '1428995217', '1450844989', '1450844989');
        $catid = '1427344743';
        for($i=0; $i<10; $i++){
            $time = $time + rand(3,10);
            if($i==0 || rand(0,10) <= 3){
                $catid = $catidArr[rand(0, count($catidArr)-1)];
                $post = $this->_getRandomPost('', $catid);
            }else{
                $post =$this->_getRandomPost($post->_id, $catid);
            }
            $type = Category::where(array('_id'=>array('$in'=>$post->category)))->first()->type;
            HisLog::insert(array(
                '_id' => strval($time.rand(10,99)),
                'datecreate' => $time,
                'action' => HistoryLog::LOG_XEM_BAI_HOC,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => $randomIp,
                'uid' => $uid,
                'url' => ThuVien::getArticleUrlStatic($post->name,$post->_id,$type),
                'status' => Constant::STATUS_ENABLE,
                'phone' => $phone,
                'price'=> 0
            ));
        }
    }

    private function _getRandomPost($id, $catid){
        if(empty($id)){
            $count = ThuVien::count();
            $rand = rand(0, $count-1);
            $item = ThuVien::offset($rand)->first();
        }else{
            $cond = array('category'=>$catid, '_id'=>array('$ne'=>$id));
            $count = ThuVien::where($cond)->count();
            $rand = rand(0, $count-2);
            $item = ThuVien::where($cond)->offset($rand)->first();
//            ->first();

//            $currentPost = ThuVien::where('_id',$id)->first();
//            $cond = array('category'=>$catid, '_id'=>array('$ne'=>$id));
//            $count = ThuVien::where($cond)->count();
//            if($count > 0){
//                $rand = rand(0, $cond-1);
//                $item = ThuVien::where($cond)->inRandomOrder()->first();
//            }else{
//                $item = ThuVien::where(array('_id'=>array('$ne'=>$id)))->orderBy('datecreate', 'desc')->first();
//            }
        }

//        echo $item->name.'<br>';
        return $item;
    }

    public function getSendEvent(){
        $data = array();
        $allEvent = EventModel::where('status',Constant::STATUS_ENABLE)->get();
//        $today = date_create();
        foreach ($allEvent as $aEvent){
            //Not today
            $allEventUser = EventUser::where(array('eid'=>$aEvent->_id,'datecreate'=>array('$gte'=> time()-($aEvent->free_day+1)*86400)))->get();
            foreach ($allEventUser as $aEventUser){
                $user = User::where('_id', $aEventUser->uid)->first();
                $endOfEvent = $aEventUser->datecreate + ($aEvent->free_day+1)*86400;
                $beginOfDay = strtotime("midnight", $endOfEvent);
                $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
                //Nếu vừa hết khuyến mãi
                if(time() > $beginOfDay && time() < $endOfDay && Network::getUserInfo($user->phone)!=1){
                    if(isset($user->phone) && !empty($user->phone) && Network::mobifoneNumber($user->phone)){
                        //sent MT
                        if(Network::checkTCSMS($user->phone) != 1){
                            $content = 'Chương trình "'.$aEvent->name.'" đã kết thúc. Để tiếp tục sử dụng dịch vụ, vui lòng soạn DK E gửi 9317. Miễn phí ngày đầu sử dụng (Giá sau KM: 2.000đ/ngày). Dịch vụ gia hạn hàng ngày. Chi tiết liên hệ 0432474175.';
                            $rs = Network::sentMT($user->phone, 'PUSH', $content);
                            $data[] = array(
                                'type' => 'sms',
                                'eid' => $aEvent->_id,
                                'phone' => $user->phone,
                                'content' => 'Chương trình "'.$aEvent->name.'" đã kết thúc.',
                                'rs' => $rs
                            );
                        }
                    }else if(isset($user->email) && !empty($user->email)){
                        $body = '<p>Chương trình "'.$aEvent->name.'" đã kết thúc.</p>
                        <p>Để tiếp tục sử dụng dịch vụ, vui lòng soạn DK E gửi 9317 (Chỉ áp dụng cho thuê bao MobiFone). Cước phí: 2.000đ/ngày. </p>
                        <p>Dịch vụ gia hạn hàng ngày. Chi tiết liên hệ 0432474175.</p>';
                        $data[] = array(
                            'type' => 'email',
                            'eid' => $aEvent->_id,
                            'to' => $user->email,
                            'subject' => 'Chương trình "'.$aEvent->name.'" đã kết thúc.',
                            'body' => $body
                        );
                    }
                }else if(time() <= $beginOfDay){
                    $start = $aEventUser->datecreate;
                    $end = $start + $aEvent->free_day*86400;
                    $user = User::where('_id', $aEventUser->uid)->first();
                    if(isset($user->phone) && !empty($user->phone) && Network::mobifoneNumber($user->phone)){
                        //sent MT
                        if(Network::checkTCSMS($user->phone) != 1){
                            $content = str_replace(array('{phone}','{pass}','{start}','{end}'), array($user->phone, $user->un_password,date('d/m/Y',$start), date('d/m/Y',$end)), $aEvent->dailyMT);
                            $rs = Network::sentMT($user->phone, 'PUSH', $content);
                            $data[] = array(
                                'type' => 'sms',
                                'eid' => $aEvent->_id,
                                'phone' => $user->phone,
                                'content' => $aEvent->name,
                                'rs' => $rs
                            );
                        }
                    }else if(isset($user->email) && !empty($user->email)){
                        $body = str_replace(array('{username}','{pass}','{start}','{end}'), array($user->username, $user->un_password,date('d/m/Y',$start), date('d/m/Y',$end)), $aEvent->dailyEmail);
                        $data[] = array(
                            'type' => 'email',
                            'eid' => $aEvent->_id,
                            'to' => $user->email,
                            'subject' => $aEvent->name,
                            'body' => $body
                        );
                    }
                }
            }
        }
        return Response::json($data);
    }
}