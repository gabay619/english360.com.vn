<?php

class GiaoTiepCoBanController extends \BaseController {

    public function __construct(){
        $this->beforeFilter('count_view', array('only'=> array(
                'getDetail'
        )));
    }

    public function getIndex(){
        $gtcbParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_GTCB)->first();
        $allGtcbCategories = Category::where('parentid', $gtcbParent->_id)->get();
        //hightlight
        $hightlight = GiaoTiepCoBan::getNewPost(6);
        $hightlightId= array();
        foreach($hightlight as $aHightlight){
            $hightlightId[] = $aHightlight['_id'];
        }
        $slide = array();
        $slide[] = isset($hightlight[0]) ? $hightlight[0] : null;
        $slide[] = isset($hightlight[1]) ? $hightlight[1] : null;
        $slide[] = isset($hightlight[2]) ? $hightlight[2] : null;
        unset($hightlight[0], $hightlight[1], $hightlight[2]);

        $list = GiaoTiepCoBan::where('status', "1")
            ->whereNotIn('_id', $hightlightId)
            ->orderBy('datecreate', 'asc')->paginate(10);

        return View::make('gtcb.list', array(
                'list' => $list,
                'allGtcbCategories' => $allGtcbCategories,
                'slide' => $slide,
                'hightlight' => $hightlight
        ));
    }

	public function getList($cateSlug){
        $gtcbParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_GTCB)->first();
        $allGtcbCategories = Category::where('parentid', $gtcbParent->_id)->get();
        $cateid = CommonHelpers::getIdFromSlug($cateSlug);
        //hightlight
        $hightlight = GiaoTiepCoBan::getNewPost(6);
        $hightlightId= array();
        foreach($hightlight as $aHightlight){
            $hightlightId[] = $aHightlight['_id'];
        }
        $slide = array();
        $slide[] = isset($hightlight[0]) ? $hightlight[0] : null;
        $slide[] = isset($hightlight[1]) ? $hightlight[1] : null;
        $slide[] = isset($hightlight[2]) ? $hightlight[2] : null;
        unset($hightlight[0], $hightlight[1], $hightlight[2]);

        $list = GiaoTiepCoBan::where('status', "1")
            ->where('category', $cateid)
            ->whereNotIn('_id', $hightlightId)
            ->orderBy('datecreate', 'asc')
            ->paginate();
        return View::make('gtcb.list', array(
                'list' => $list,
                'allGtcbCategories' => $allGtcbCategories,
                'slide' => $slide,
                'hightlight' => $hightlight
        ));
	}

	public function getDetail($slug){
        $atId = CommonHelpers::getIdFromSlug($slug);
        $item = GiaoTiepCoBan::where('_id', $atId)->first();
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

        //Log
        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_XEM_BAI_HOC_GTCB,
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
		return View::make('gtcb.detail', array(
			'item' => $item
		));
	}

    public function getExcercise(){
        $id = Input::get('id');
        $gtcb = GiaoTiepCoBan::where('_id', $id)->first();

        $tracnghiem = GiaoTiepCoBanBaiTap::where('gtcbid', $id)->where('type', 'gtcb_tracnghiem')->get();
        $dientu = GiaoTiepCoBanBaiTap::where('gtcbid', $id)->where('type', 'gtcb_dientu')->first();
        $sapxep = GiaoTiepCoBanBaiTap::where('gtcbid', $id)->where('type', 'gtcb_sapxep')->first();
        $ghepcau = GiaoTiepCoBanBaiTap::where('gtcbid', $id)->where('type', 'gtcb_ghepcau')->first();
        $luyennghe = GiaoTiepCoBanLuyenNghe::where('gtcbid', $id)->first();

        return View::make('gtcb.excercise', array(
            'tracnghiem' => $tracnghiem,
            'dientu' => $dientu,
            'sapxep' => $sapxep,
            'luyennghe' => $luyennghe,
            'ghepcau' => $ghepcau,
            'post' => $gtcb
        ));

    }

}