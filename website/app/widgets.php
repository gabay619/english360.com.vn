<?php
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/19/2015
 * Time: 11:27 AM
 */
Widget::register('slider', function(){
    $item = Show::where('type', 'slideshow')->first();
    $list = $item->lession;
    $listLession = array();
    foreach($list as $aLession) {
        $model = CommonHelpers::getModelFromType($aLession['type']);
        $lession = $model::where('_id', $aLession['id'])->first();
        if($lession){
            $cate = Common::getcategorytype($aLession['type']);
            $listLession[] = array(
                    'name' => $lession->name,
                    'url' => $lession->getDetailUrl($aLession['type']),
                    'avatar' => $lession->avatar,
                    'cate' => $cate['name']
            );
        }
    }
    $slideList = array();
    $slideList[] = isset($listLession[0]) ? $listLession[0] : null;
    $slideList[] = isset($listLession[1]) ? $listLession[1] : null;
    $slideList[] = isset($listLession[2]) ? $listLession[2] : null;
    unset($listLession[0], $listLession[1], $listLession[2]);

        return View::make('widgets.slider', array(
            'slideList' => $slideList,
            'listLession' => $listLession
        ));
});

Widget::register('header_nav', function(){
    $thuvienId = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_THUVIEN)->first()->_id;
    //Người nổi tiếng
    $famousParent = Category::where('parentid', $thuvienId)->where('type', Constant::TYPE_FAMOUS)->first();
    //video
    $videoParent = Category::where('parentid', $thuvienId)->where('type', Constant::TYPE_VIDEO)->first();
    //radio
    $radioParent = Category::where('parentid', $thuvienId)->where('type', Constant::TYPE_RADIO)->first();
    //Phim
    $filmParent = Category::where('parentid', $thuvienId)->where('type', Constant::TYPE_FILM)->first();
    //Kinh nghiệm
    $expParent = Category::where('parentid', $thuvienId)->where('type', Constant::TYPE_EXP)->first();
    //tiếng Anh hàng ngày
    $dailyParent = Category::where('parentid', $thuvienId)->where('type', Constant::TYPE_DAILY)->first();
    //Thành ngữ
    $idiomParent = Category::where('parentid', $thuvienId)->where('type', Constant::TYPE_IDIOM)->first();

    //Giao tiếp cơ bản
    $gtcbParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_GTCB)->first();
//    $allGtcbCategories = Category::where('parentid', $gtcbParent->_id)->orderBy('_id', 'desc')->get();
    //Bài hát tiếng Anh
    $songParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_SONG)->first();
    $allSongCategories = Category::where('parentid', $songParent->_id)->orderBy('_id', 'desc')->get();
    //Luyện ngữ âm
    $lnaParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_LUYENNGUAM)->first();
//    $allLnaCategories = Category::where('parentid', $lnaParent->_id)->orderBy('_id', 'desc')->get();

//        echo 1;die;
    return View::make('widgets.header_nav', array(
//            'allGtcbCategories' => $allGtcbCategories,
            'allSongCategories' => $allSongCategories,
//            '$allLnaCategories' => $allLnaCategories,
            'videoParent' => $videoParent,
            'radioParent' => $radioParent,
            'filmParent' => $filmParent,
            'famousParent' => $famousParent,
            'expParent' => $expParent,
            'dailyParent' => $dailyParent,
            'idiomParent' => $idiomParent
    ));
});

Widget::register('hot_lessions', function(){
    $item = Show::where('type', 'hot_lession')->first();
    $list = $item->lession;
    $listLession = array();
    foreach($list as $aLession){
        $model = CommonHelpers::getModelFromType($aLession['type']);
        $lession = $model::where('_id', $aLession['id'])->first();
        if($lession){
            $cate = Common::getcategorytype($aLession['type']);
            $listLession[] = array(
                    'name' => $lession->name,
                    'url' => $lession->getDetailUrl($aLession['type']),
                    'avatar' => $lession->avatar,
                    'cate' => $cate['name']
            );
        }
    }

    $firstLession = isset($listLession[0]) ? $listLession[0] : null;
    unset($listLession[0]);

    return View::make('widgets.hot_lessions', array(
        'firstLession' => $firstLession,
        'listLession' => $listLession
    ));
});

Widget::register('relatedposts', function($type, $post){
    $model = CommonHelpers::getModelFromType($type);
    $tagArr =explode(',', $post->keyword);
    $cond = array(
        '_id' => array('$ne' => $post->_id),
        'status' => Constant::STATUS_ENABLE,
        'category'=> $post->category,
//        'calendar' => array('$lte'=> time()),
        '$or' => array()
    );
    if($type != Constant::TYPE_GTCB && $type != Constant::TYPE_LUYENNGUAM && $type != Constant::TYPE_NGUPHAP){
        $cond['calendar'] = array('$lte'=> time());
    }
    foreach ($tagArr as $tag){
        $cond['$or'][] = array('keyword' => new MongoRegex("/$tag/ui"));
    }
//    print_r($cond);
    $allRelated = $model::where($cond);




    $allRelated= $allRelated->orderBy('datecreate', 'desc')
            ->limit(10)->get();
    if(count($allRelated) < 4){
        unset($cond['$or']);
        $category = Category::whereIn('_id', $post->category)->get();
        if(count($category) > 0){
            $lastChildCate = $category[0];
            foreach($category as $aCate){
                if($aCate->parentid == $lastChildCate->_id)
                    $lastChildCate = $aCate;
            }
            $cond['category'] = $lastChildCate->_id;
            $allRelated = $model::where($cond)->orderBy('datecreate', 'desc')
                ->limit(10)->get();
        }
    }

    return View::make('widgets.related_posts', array(
        'allRelated' => $allRelated,
        'model' => $model,
        'type' => $type
    ));
});

Widget::register('commentbox', function($type, $id){
//    $model = CommonHelpers::getModelFromType($type);
    $allComments = Comment::where('type', $type)
            ->where('objid', $id)
            ->where('parentid', '0')
            ->where('status', Constant::STATUS_ENABLE)
            ->orderBy('datecreate', 'desc')
            ->get();
    return View::make('widgets.comment_box', array(
        'allComments'=>$allComments,
        'type' => $type,
        'id' => $id
    ));
});

Widget::register('othertopicgame', function($id=''){
    $hmcParent = Category::whereIn('parentid', array('0',0))
            ->where('_id', '!=', $id)
            ->where('type', Constant::TYPE_HOCMACHOI)
            ->first();
    $allTopic = Category::where('parentid', $hmcParent->_id)->get();
   return View::make('widgets.other_topic_game', array(
       'allTopic' => $allTopic
   ));
});

Widget::register('hot_question', function(){
    $list = DB::collection('faq')->raw()->aggregate([
        ['$match' => array('parentid'=>'0', 'like'=> array('$exists' => true)) ],
        ['$project' => [
            'likes' => array('$size' => array('$like')),
            '_id' => '$_id',
            'content' => '$content',
            'usercreate' => '$usercreate',
            'datecreate' => '$datecreate'
        ]
        ],
        ['$sort' => array('likes' => -1)],
        ['$limit' => 5]
    ]);

//    print_r($list['result'][0]['usercreate']);exit;
   return View::make('widgets.hot_question', array(
       'list' => $list['result']
   ));
});

Widget::register('right_ads', function(){
    return View::make('widgets.right_ads');
});

Widget::register('private_tab', function(){
    $checkPackage = Common::isRegPackage(Auth::user()->_id);
   return View::make('widgets.private_tab', array(
       'checkPackage' => $checkPackage
   ));
});

Widget::register('right_tool', function(){
    return View::make('widgets.right_tool');
});

Widget::register('chatbox', function(){
//    $allChat = Chat::where('ssid', Session::getId())->first();
//    return View::make('widgets.chatbox', array(
//        'allChat' => $allChat,
//        'sessionId' => Session::getId()
//    ));
//    if(!Network::is3g())
    return View::make('widgets.chat');
});

Widget::register('popup', function(){
    $url = Request::url();
    if(Auth::user())
        $login = '1';
    else
        $login = '2';

    $popup = Popup::where(array(
            'status' => Constant::STATUS_ENABLE,
            'start' => array('$lte'=>time()),
            'end' => array('$gte'=>time()),
            '$or' => array(
                array('url' => ''),
                array('url' => $url)
            ),
            'login' => array('$in' => array($login, '3')),
            'ver' => array('$in' => array('web', 'ww'))
    ))->first();
    if($popup)
        return View::make('widgets.popup', array(
                'popup' => $popup
        ));
});

Widget::register('event_welcome', function(){
    return;
    $user = Auth::user();
    if(!$user)
        return;

    $show = false;
    $checkFreeUser = FreeUser::where('phone', $user->phone)->first();
    if(!$checkFreeUser) return;

    if($checkFreeUser->show == 0){
        $show = 'welcome';
        $checkFreeUser->show = 1;
        $checkFreeUser->save();
    }

    $dateDiff = (time() - $checkFreeUser->_id)/86400;
    if($dateDiff > 15){
        $show = 'expired';
        $checkFreeUser->delete();
    }
    if($show)
        return View::make('widgets.event_welcome', array('show'=>$show));
});

Widget::register('event', function (){
    return;
    if (isset($_SESSION['event_id'])){
        $event = EventModel::where('_id',$_SESSION['event_id'])->first();
//        print_r($event);
        if($event){
            return View::make('widgets.event', array(
               'event' => $event
            ));
        }
    }
    if(Auth::user()){
        $checkEventUser = EventUser::where('uid',Auth::user()->_id)->first();
        if($checkEventUser){
            $event = EventModel::where('_id',$checkEventUser->eid)->first();
            if($event){
                if((time() - $checkEventUser->datecreate)/86400 > $event->free_day){
                    $checkEventUser->delete();
                    return View::make('widgets.expired-event');
                }
            }
        }
    }
});

Widget::register('review', function($id,$type){
    if(!Auth::user()) return;
    $allType = Common::getAllLessionType();
    $checked = isset(Auth::user()->reg_lession) ? Auth::user()->reg_lession : array();
    return View::make('widgets.review', array(
        'allType'=>$allType,
        'checked'=>$checked,
        'id'=>$id,
        'type'=>$type
    ));
});

Widget::register('regpopup', function(){
    return;
    if(Auth::user()) return;
    if(Session::has('popreg_require_login'))
        return View::make('widgets.regpopup');
    $config = ConfigCl::where(array('name'=>Constant::CONFIG_POPUP_REG))->first();
    if(!$config) return;
    $timeout = isset($config->value['timeout']) ? $config->value['timeout'] : 0;
    $number = Session::get('number_popreg',0);
    if($number >= $config->value['number']) return;
//    Session::put('number_popreg', $number+1);
    return View::make('widgets.regpopup',array(
       'timeout' => $timeout*1000
    ));
});

Widget::register('banner', function ($type=Constant::BANNER_WEB_FOOTER){
    $banner = Banner::where(array('status'=>Constant::STATUS_ENABLE, 'type'=>$type))->first();
    if($banner)
        return View::make('widgets.banner',array(
            'banner'=>$banner
        ));
});

Widget::register('emailbox', function($type=''){
    return;
    $email = '';
    if(Auth::user()){
        $checked = isset(Auth::user()->reg_lession) ? Auth::user()->reg_lession : array();
        if(is_array($checked) && count($checked)>0 )
            return;
        else
            $email = Auth::user()->email;
    }elseif (Session::has('email_reg_lession')){
        $email = Session::get('email_reg_lession');
    }

    $allType = Common::getAllLessionType();
    $checked = isset(Auth::user()->reg_lession) ? Auth::user()->reg_lession : array(Constant::TYPE_FAMOUS);

    return View::make('widgets.emailbox', array(
        'email'=>$email,
        'allType' => $allType,
        'checked' => $checked
    ));
});

Widget::register('reglession', function (){
    return;
    if(Session::has('reg_lession_popup') && Session::has('email_reg_lession')){
        $allType = Common::getAllLessionType();
        $checked = array(Constant::TYPE_FAMOUS);
//        $email = Session::has('email_get_lession');
        return View::make('widgets.reglession', array(
            'allType' => $allType,
            'checked' => $checked
        ));
    }
});