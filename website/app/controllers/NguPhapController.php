<?php

class NguPhapController extends \BaseController {

    public function __construct(){
        $this->beforeFilter('count_view', array('only'=> array(
            'getDetail'
        )));
    }

    //Danh sách bài học ngữ pháp
    public function getIndex()
    {
        $nguphapParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_NGUPHAP)->first();
        $allNpCategories = Category::where('parentid', $nguphapParent->_id)->get();
        //hightlight
        $hightlight = NguPhap::getNewPost(6);
        $hightlightId= array();
        foreach($hightlight as $aHightlight){
            $hightlightId[] = $aHightlight['_id'];
        }
        $slide = array();
        $slide[] = isset($hightlight[0]) ? $hightlight[0] : null;
        $slide[] = isset($hightlight[1]) ? $hightlight[1] : null;
        $slide[] = isset($hightlight[2]) ? $hightlight[2] : null;
        unset($hightlight[0], $hightlight[1], $hightlight[2]);

        $list = NguPhap::where('status', "1")
            ->whereNotIn('_id', $hightlightId)
            ->orderBy('datecreate', 'asc')
            ->paginate(10);
        return View::make('nguphap.list', array(
            'list' => $list,
            'allNpCategories' => $allNpCategories,
            'slide'=>$slide,
            'hightlight' => $hightlight
        ));
    }

    //Danh sách bài học ngữ âm theo danh mục con
    public function getList($cateSlug)
    {
        $nguphapParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_NGUPHAP)->first();
        $allNpCategories = Category::where('parentid', $nguphapParent->_id)->get();
        $cateid = CommonHelpers::getIdFromSlug($cateSlug);
        //hightlight
        $hightlight = NguPhap::getNewPost(6);
        $hightlightId= array();
        foreach($hightlight as $aHightlight){
            $hightlightId[] = $aHightlight['_id'];
        }
        $slide = array();
        $slide[] = isset($hightlight[0]) ? $hightlight[0] : null;
        $slide[] = isset($hightlight[1]) ? $hightlight[1] : null;
        $slide[] = isset($hightlight[2]) ? $hightlight[2] : null;
        unset($hightlight[0], $hightlight[1], $hightlight[2]);

        $list = NguPhap::where('status', "1")
            ->where('category', $cateid)
            ->whereNotIn('_id', $hightlightId)
            ->orderBy('datecreate', 'asc')
            ->paginate(10);
        return View::make('nguphap.list', array(
            'list' => $list,
            'allNpCategories' => $allNpCategories,
            'slide' => $slide,
            'hightlight' => $hightlight
        ));
    }

    //Chi tiết bài học ngữ pháp
    public function getDetail($slug){
        $id = CommonHelpers::getIdFromSlug($slug);
        $item = NguPhap::where('status', Constant::STATUS_ENABLE)->where('_id', $id)->first();
        if(!$item){
            return 'Bài học không tồn tại.';
        }
        //Đếm số lượt xem
        if(!isset($item->free) || $item->free!='1') {
            Session::put('return_url', Request::url());
            Session::put('count_view', Session::get('count_view')-1);

            if (!Auth::user()) {
                return Redirect::to('/user/register')->with('error', 'Hãy đăng ký để tiếp tục sử dụng dịch vụ.');

            } else {
                if (!Auth::user()->registedPackage()) {
                    return Redirect::to('/user/package')->with('error', 'Hãy đăng ký gói cước để tiếp tục sử dụng dịch vụ.');
                }
            }
        }

        //Log
        $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_XEM_BAI_HOC_NGU_PHAP,
            'chanel' => HistoryLog::CHANEL_WEB,
            'ip' => Network::ip(),
            'uid' => Auth::user() ? Auth::user()->_id : '',
            'url' => Request::url(),
            'status' => Constant::STATUS_ENABLE,
            'phone' => Auth::user() ? Auth::user()->phone : '',
            'price' => 0,
            'ref' => Input::get('ref','')
        );
        HisLog::insert($newHistoryLog);

        return View::make('nguphap.detail', array(
            'item' => $item
        ));
    }

    public function getExcercise(){
        $id = Input::get('id');
        $post = NguPhap::where('_id', $id)->first();

        $chontu = NguPhapBaiTap::where('npid', $id)->where('type', 'nguphap_chontu')->first();
        $dientu = NguPhapBaiTap::where('npid', $id)->where('type', 'nguphap_dientu')->first();
        $diennhieutu = NguPhapBaiTap::where('npid', $id)->where('type', 'nguphap_diennhieutu')->first();
        $diencumtu = NguPhapBaiTap::where('npid', $id)->where('type', 'nguphap_diencumtu')->first();
        $vietlaicau = NguPhapBaiTap::where('npid', $id)->where('type', 'nguphap_vietlaicau')->first();
        $dungsai = NguPhapBaiTap::where('npid', $id)->where('type', 'nguphap_dungsai')->first();
        $vietlaicautranh = NguPhapBaiTap::where('npid', $id)->where('type', 'nguphap_vietlaicautranh')->first();
        $tracnghiem = NguPhapBaiTap::where('npid', $id)->where('type', 'nguphap_tracnghiem')->first();
        $tracnghiemtranh = NguPhapBaiTap::where('npid', $id)->where('type', 'nguphap_tracnghiemtranh')->first();
        $dientutranh = NguPhapBaiTap::where('npid', $id)->where('type', 'nguphap_dientutranh')->first();
        $ghepcau = NguPhapBaiTap::where('npid', $id)->where('type', 'nguphap_ghepcau')->first();

        return View::make('nguphap.excercise', array(
            'tracnghiem' => $tracnghiem,
            'tracnghiemtranh' => $tracnghiemtranh,
            'chontu' => $chontu,
            'dientu' => $dientu,
            'diennhieutu' => $diennhieutu,
            'dientutranh' => $dientutranh,
            'diencumtu' => $diencumtu,
            'vietlaicau' => $vietlaicau,
            'dungsai' => $dungsai,
            'vietlaicautranh' => $vietlaicautranh,
            'ghepcau' => $ghepcau,
            'post' => $post
        ));
    }

}