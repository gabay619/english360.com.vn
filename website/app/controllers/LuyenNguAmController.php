<?php

class LuyenNguAmController extends \BaseController {

    public function __construct(){
        $this->beforeFilter('count_view', array('only'=> array(
                'getDetail'
        )));
    }

	//Danh sách bài học ngữ âm
	public function getIndex()
	{
        $lnaParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_LUYENNGUAM)->first();
        $allLnaCategories = Category::where('parentid', $lnaParent->_id)->get();
        //hightlight
        $hightlight = LuyenNguAm::getNewPost(6);
        $hightlightId= array();
        foreach($hightlight as $aHightlight){
            $hightlightId[] = $aHightlight['_id'];
        }
        $slide = array();
        $slide[] = isset($hightlight[0]) ? $hightlight[0] : null;
        $slide[] = isset($hightlight[1]) ? $hightlight[1] : null;
        $slide[] = isset($hightlight[2]) ? $hightlight[2] : null;
        unset($hightlight[0], $hightlight[1], $hightlight[2]);

        $list = LuyenNguAm::where('status', "1")
                ->whereNotIn('_id', $hightlightId)
                ->orderBy('datecreate', 'asc')
                ->paginate(10);
        return View::make('nguam.list', array(
                'list' => $list,
                'allLnaCategories' => $allLnaCategories,
                'slide'=>$slide,
                'hightlight' => $hightlight
        ));
	}

	//Danh sách bài học ngữ âm theo danh mục con
	public function getList($cateSlug)
	{
        $lnaParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_LUYENNGUAM)->first();
        $allLnaCategories = Category::where('parentid', $lnaParent->_id)->get();
        $cateid = CommonHelpers::getIdFromSlug($cateSlug);
        //hightlight
        $hightlight = LuyenNguAm::getNewPost(6);
        $hightlightId= array();
        foreach($hightlight as $aHightlight){
            $hightlightId[] = $aHightlight['_id'];
        }
        $slide = array();
        $slide[] = isset($hightlight[0]) ? $hightlight[0] : null;
        $slide[] = isset($hightlight[1]) ? $hightlight[1] : null;
        $slide[] = isset($hightlight[2]) ? $hightlight[2] : null;
        unset($hightlight[0], $hightlight[1], $hightlight[2]);

        $list = LuyenNguAm::where('status', "1")
                ->where('category', $cateid)
                ->whereNotIn('_id', $hightlightId)
                ->orderBy('datecreate', 'asc')
                ->paginate(10);
        return View::make('nguam.list', array(
                'list' => $list,
                'allLnaCategories' => $allLnaCategories,
                'slide' => $slide,
                'hightlight' => $hightlight
        ));
	}

    //Chi tiết bài học ngữ âm
    public function getDetail($slug){
        $id = CommonHelpers::getIdFromSlug($slug);
        $item = LuyenNguAm::where('status', '1')->where('_id', $id)->first();
        if(!$item){
            return 'Bài học không tồn tại.';
        }
    //Đếm số lượt xem
//        if(!Session::has('count_view_lna')){
//            Session::put('count_view_lna',0);
//        }
//        if(Session::get('count_view_lna') >= Constant::MAX_CONTENT_CATE_FREE  || !isset($item->free) || $item->free!='1') {
        if(!isset($item->free) || $item->free!='1') {
            Session::put('return_url', Request::url());
            Session::put('count_view', Session::get('count_view')-1);

            if (!Auth::user()) {
//				Session::put('popreg_require_login', 1);
                return Redirect::to('/user/register')->with('error', 'Hãy đăng ký để tiếp tục sử dụng dịch vụ.');
//                return Redirect::to('/user/quick-package?return_url='.Request::url())->with('error', 'Hãy đăng ký gói cước để tiếp tục sử dụng dịch vụ.');

            } else {
                if (!Auth::user()->registedPackage()) {
//					return Redirect::to('/user/package')->with('error', 'Bạn đã sử dụng hết 10 nội dung miễn phí.');
                    return Redirect::to('/user/package')->with('error', 'Hãy đăng ký gói cước để tiếp tục sử dụng dịch vụ.');
                }
//                else
//                    Session::remove('count_view_lna');
            }
        }
//        Session::put('count_view_lna', Session::get('count_view_lna')+1);

        //Log
        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_XEM_BAI_HOC_NGU_AM,
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

        return View::make('nguam.detail', array(
                'item' => $item
        ));
    }

    public function getExcercise(){
        $id = Input::get('id');
        $lna = LuyenNguAm::where('_id', $id)->first();

        $dienchu = LuyenNguAmBaiTap::where('lnaid', $id)->where('type', 'lna_dienchu')->first();
        $dientu = LuyenNguAmBaiTap::where('lnaid', $id)->where('type', 'lna_dientu')->first();
        $tracnghiem = LuyenNguAmBaiTap::where('lnaid', $id)->where('type', 'lna_tracnghiem')->orderBy('_id')->get();
        $xemtranh = LuyenNguAmBaiTap::where('lnaid', $id)->where('type', 'lna_xemtranh')->get();
        $phatam = LuyenNguAmBaiTap::where('lnaid', $id)->where('type', 'lna_phatam')->first();

        return View::make('nguam.excercise', array(
                'dienchu' => $dienchu,
                'tracnghiem' => $tracnghiem,
                'dientu' => $dientu,
                'xemtranh' => $xemtranh,
                'phatam' => $phatam,
                'post' => $lna
        ));
    }

}