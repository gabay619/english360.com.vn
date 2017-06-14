<?php

/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 12/22/2015
 * Time: 4:36 PM
 */
class SongController extends BaseController
{
    public function __construct(){
        $this->beforeFilter('count_view', array('only'=> array(
                'getDetail'
        )));
    }

    public function getIndex(){
        $songParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_SONG)->first();
        $allSongCategories = Category::where('parentid', $songParent->_id)->get();
        //hightlight
        $hightlight = Song::getNewPost(6);
        $hightlightId= array();
        foreach($hightlight as $aHightlight){
            $hightlightId[] = $aHightlight['_id'];
        }
        $slide = array();
        $slide[] = isset($hightlight[0]) ? $hightlight[0] : null;
        $slide[] = isset($hightlight[1]) ? $hightlight[1] : null;
        $slide[] = isset($hightlight[2]) ? $hightlight[2] : null;
        unset($hightlight[0], $hightlight[1], $hightlight[2]);

        $list = Song::where(array(
                        'status' => Constant::STATUS_ENABLE,
                        '_id' => array('$nin'=>$hightlightId),
                        '$or' => array(
                                array('calendar' => array('$exists'=>false)),
                                array('calendar' => array('$lte'=> time()))
                        )
                ))
//            ->whereNotIn('_id', $hightlightId)
            ->orderBy('datecreate', 'desc')
            ->paginate(10);
        return View::make('song.list', array(
                'list' => $list,
                'allSongCategories' => $allSongCategories,
                'slide'=>$slide,
                'hightlight' => $hightlight,
        ));
    }

    public function getList($cateSlug){
        $songParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_SONG)->first();
        $allSongCategories = Category::where('parentid', $songParent->_id)->get();
        $cateid = CommonHelpers::getIdFromSlug($cateSlug);
        $current = Category::where('_id', $cateid)->first();
        //hightlight
        $hightlight = Song::getNewPost(6);
        $hightlightId= array();
        foreach($hightlight as $aHightlight){
            $hightlightId[] = $aHightlight['_id'];
        }
        $slide = array();
        $slide[] = isset($hightlight[0]) ? $hightlight[0] : null;
        $slide[] = isset($hightlight[1]) ? $hightlight[1] : null;
        $slide[] = isset($hightlight[2]) ? $hightlight[2] : null;
        unset($hightlight[0], $hightlight[1], $hightlight[2]);

        $list = Song::where(array(
                'status' => Constant::STATUS_ENABLE,
                '_id' => array('$nin'=>$hightlightId),
                'category' => $cateid,
                '$or' => array(
                        array('calendar' => array('$exists'=>false)),
                        array('calendar' => array('$lte'=> time()))
                )
        ))
//            ->where('category', $cateid)
//            ->whereNotIn('_id', $hightlightId)
            ->orderBy('datecreate', 'desc')
            ->paginate(10);
        return View::make('song.list', array(
                'list' => $list,
                'allSongCategories' => $allSongCategories,
                'slide' => $slide,
                'hightlight' => $hightlight,
                'current' => $current
        ));
    }

    public function getDetail($slug){
        $id = CommonHelpers::getIdFromSlug($slug);
        $item = Song::where('status', '1')->where('_id', $id)->first();
        if(!$item){
            return 'Bài học không tồn tại.';
        }
        if(!isset($item->free) || $item->free!='1') {
            Session::put('return_url', Request::url());
            Session::put('count_view', Session::get('count_view')-1);
            if (!Auth::user()) {
                return Redirect::to('/user/register')->with('error', 'Hãy đăng ký để tiếp tục sử dụng dịch vụ.');
            } else {
                if(Auth::user()->ssid != Session::getId()){
                    Auth::logout();
                    return Redirect::to('/user/login')->with('error', 'Tài khoản của bạn được đăng nhập từ nơi khác.');
                }
                if (!Auth::user()->registedPackage()) {
                    return Redirect::to('/user/package')->with('error', 'Hãy đăng ký gói cước để tiếp tục sử dụng dịch vụ.');
                }
            }
        }



        $childCate = Category::whereIn('_id', $item->category)->where('parentid', '!=', '0')->first();

        $allUpload = Upload::where('type', Constant::TYPE_SONG)
            ->where('itemid', $id)
            ->orderby('datecreate', 'desc')
            ->get();

        //Log
        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_XEM_BAI_HOC_BAI_HAT,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => Auth::user() ? Auth::user()->_id : '',
                'url' => Request::url(),
                'status' => Constant::STATUS_ENABLE,
                'email' => Auth::user() ? Auth::user()->email : '',
                'ref' => Input::get('ref',''),
                'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""

        );
        HisLog::insert($newHistoryLog);

        return View::make('song.detail', array(
            'item' => $item,
            'allUpload' => $allUpload,
            'childCate' => $childCate
        ));
    }

    public function getExcercise(){
        $id = Input::get('id', '');
        if(empty($id))
            return 'Bài học không tồn tại.';

        $item = Song::where('status', '1')->where('_id', $id)->first();
        return View::make('song.excercise', array(
            'item' => $item
        ));
    }

    public function getSearch(){
        $letter = Input::get('letter');
        if(!ctype_alpha($letter))
            $letter = '';
        $cond = array(
                'status' => Constant::STATUS_ENABLE,
                '$or' => array(
                        array('calendar' => array('$exists'=>false)),
                        array('calendar' => array('$lte'=> time()))
                )
        );
        if(!empty($letter)){
            $regex = new MongoRegex('/^'.$letter.'/ui');
            $cond['namenonutf'] = $regex;
//            $allSong = Song::where('namenonutf', $regex)->orderBy('namenonutf');
        }

        $allSong = Song::where($cond)->orderBy('namenonutf')->paginate(10);

        return View::make('song.search', array(
            'list' => $allSong,
            'letter' => $letter
        ));
    }
}