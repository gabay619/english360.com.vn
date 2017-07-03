<?php

class ThuvienController extends \BaseController {

    public function __construct(){
        $this->beforeFilter('count_view', array('only'=> array(
            'getDetail'
        )));
    }

	public function getIndex($cateSlug){
		$type = CommonHelpers::getTypebyCateSlug($cateSlug);
		$thuvienId = ThuVien::MAIN_CATE;

		$cate = Category::where('parentid', $thuvienId)->where('type', $type)->first();
        $cateChild = $cate->getChilds();
		$arrCateId = array();
        foreach($cateChild as $aChild){
            $arrCateId[] = $aChild->_id;
        }
		$arrCateId[] = $cate->_id;

		//hightlight
		$hightlight = ThuVien::getNewPost($cate->_id, 6);
		$hightlightId= array();
		foreach($hightlight as $aHightlight){
			$hightlightId[] = $aHightlight['_id'];
		}
		$slide = array();
		$slide[] = isset($hightlight[0]) ? $hightlight[0] : null;
		$slide[] = isset($hightlight[1]) ? $hightlight[1] : null;
		$slide[] = isset($hightlight[2]) ? $hightlight[2] : null;
		unset($hightlight[0], $hightlight[1], $hightlight[2]);

		$list = ThuVien::where('status', Constant::STATUS_ENABLE)
                ->where([
                        'category' => ['$in' => $arrCateId],
                        '$or' => array(
                                array('calendar' => array('$exists'=>false)),
                                array('calendar' => array('$lte'=> time()))
                        )
                ])
				->whereNotIn('_id', $hightlightId)
                ->orderBy('datecreate', 'desc')
                ->paginate(10);
		return View::make('thuvien.list', array(
			'list' => $list,
			'type' => $type,
            'cateChild' => $cateChild,
			'slide' => $slide,
			'hightlight' => $hightlight,
			'parentCate' => $cate
		));

	}

	public function getDetail($cateSlug,$slug){
        $thuvienId = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_THUVIEN)->first()->_id;
        $cond = array('slug' => $slug);
        if(Input::get('source','') != 'admin')
            $cond['status'] = Constant::STATUS_ENABLE;
        $item = ThuVien::where($cond)->first();
        if(!$item){
            unset($cond['slug']);
            $atId = CommonHelpers::getIdFromSlug($slug);
            $cond['_id'] = $atId;
            $item = ThuVien::where($cond)->first();
        }
//		if(Input::get('source','') == 'admin')
//			$item = ThuVien::where('_id', $atId)->first();
//		else
//			$item = ThuVien::where('status', Constant::STATUS_ENABLE)->where('_id', $atId)->first();

		if(!$item) return 'Bài học không tồn tại.';
        $type = CommonHelpers::getTypebyCateSlug($cateSlug);

		//Đếm số lượt xem

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

		$cate = Common::getcategorytype($type);
        $childCate = Category::whereIn('_id', $item->category)->where('parentid', '!=', $thuvienId)->first();

        //Log
        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => $type,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => Auth::user() ? Auth::user()->_id : '',
                'url' => Request::url(),
                'status' => Constant::STATUS_ENABLE,
                'email' => Auth::user() ? Auth::user()->email : '',
                'price' => 0,
				'ref' => Input::get('ref',''),
                'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""
        );
        HisLog::insert($newHistoryLog);
		return View::make('thuvien.detail', array(
			'item' => $item,
			'type' => $type,
			'cate' => $cate,
            'childCate' => $childCate
		));
	}

	public function getList($cateSlug, $cateChild)
	{
		$cateId = CommonHelpers::getIdFromSlug($cateChild);
		$cate = Category::where('status', "1")->where('_id', $cateId)->first();
		if(!$cate)
			return 'Danh mục không tồn tại.';
		$thuvienId = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_THUVIEN)->first()->_id;
		$cateParent = Category::where('parentid', $thuvienId)->where('type', $cate->type)->first();
		//hightlight
		$hightlight = ThuVien::getNewPost($cateParent->_id, 6);
		$hightlightId= array();
		foreach($hightlight as $aHightlight){
			$hightlightId[] = $aHightlight['_id'];
		}
		$slide = array();
		$slide[] = isset($hightlight[0]) ? $hightlight[0] : null;
		$slide[] = isset($hightlight[1]) ? $hightlight[1] : null;
		$slide[] = isset($hightlight[2]) ? $hightlight[2] : null;
		unset($hightlight[0], $hightlight[1], $hightlight[2]);

		$list = ThuVien::where('status', Constant::STATUS_ENABLE)
			->where(array(
                    'category'=> $cateId,
                    '$or' => array(
                            array('calendar' => array('$exists'=>false)),
                            array('calendar' => array('$lte'=> time()))
                    )
            ))
			->whereNotIn('_id', $hightlightId)
			->orderBy('datecreate', 'desc')
			->paginate(10);
		return View::make('thuvien.list', array(
			'list' => $list,
			'type' => $cate->type,
			'cateChild' => $cateParent->getChilds(),
			'parentCate' => $cateParent,
			'slide' => $slide,
			'hightlight' => $hightlight,
            'current' => $cate
		));
	}

	public function getListByCategory($catSlug){
		$catId = CommonHelpers::getIdFromSlug($catSlug);
		$list = Article::where('category', $catId)->get();

		$thuvienId = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_THUVIEN)->first()->_id;
		$cate = Category::where('parentid', $thuvienId)->where('type', $type)->first();
		$cateChild = $cate->getChilds();

		return View::make('articles.list', array(
			'list' => $list,
			'type' => $type,
			'cateChild' => $cateChild
		));
	}

    public function getTest(){
        echo 1;
    }

}