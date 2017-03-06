<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function getIndex(){
        $thuvienId = ThuVien::MAIN_CATE;
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
        $allGtcbCategories = Category::where('parentid', $gtcbParent->_id)->get();
        //Bài hát tiếng Anh
        $songParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_SONG)->first();
        $allSongCategories = Category::where('parentid', $songParent->_id)->get();
        //Luyện ngữ âm
//        $lnaParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_LUYENNGUAM)->first();
//        $allLnaCategories = Category::where('parentid', $lnaParent->_id)->get();

//        echo 1;die;
		return View::make('home.index', array(
                'allGtcbCategories' => $allGtcbCategories,
                'allSongCategories' => $allSongCategories,
//                'allLnaCategories' => $allLnaCategories,
                'videoParent' => $videoParent,
                'radioParent' => $radioParent,
                'filmParent' => $filmParent,
                'famousParent' => $famousParent,
                'expParent' => $expParent,
                'dailyParent' => $dailyParent,
                'idiomParent' => $idiomParent
		));
	}

    public function getSearch(){
        $keyword = html_entity_decode(Input::get('keyword'));
        $keywordRegex = new MongoRegex('/'.Common::vietnameseToEnglish($keyword).'/ui');

        $list = array();
        $cond = array(
            'namenonutf' => $keywordRegex,
            '$or' => array(
                array('calendar' => array('$exists'=>false)),
                array('calendar' => array('$lte'=> time()))
            ),
            'status' => Constant::STATUS_ENABLE
        );
//        print_r(Common::vietnameseToEnglish($cond));die;
//        print_r(Common::vietnameseToEnglish($keyword));die;
        $allGtcb = GiaoTiepCoBan::where($cond)->orderBy('datecreate','desc')->limit(5)->get();
        foreach($allGtcb as $aGtcb){
            $list[] = array(
                '_id' => $aGtcb->_id,
                'name' => $aGtcb->name,
                'avatar' => $aGtcb->avatar,
                'captions' => $aGtcb->captions,
                'url' => $aGtcb->getDetailUrl(),
                'date' => date('d/m/Y', $aGtcb->datecreate),
                'cate' => 'Giao tiếp cơ bản'
            );
        }

        $allSong = Song::where($cond)->orderBy('datecreate','desc')->limit(5)->get();
        foreach($allSong as $aSong){
            $list[] = array(
                    '_id' => $aSong->_id,
                    'name' => $aSong->name,
                    'avatar' => $aSong->avatar,
                    'captions' => $aSong->captions,
                    'url' => $aSong->getDetailUrl(),
                    'date' => date('d/m/Y', $aSong->datecreate),
                    'cate' => 'Bài hát tiếng Anh'
            );
        }

        $allLna = LuyenNguAm::where($cond)->orderBy('datecreate','desc')->limit(5)->get();
        foreach($allLna as $aLna){
            $list[] = array(
                    '_id' => $aLna->_id,
                    'name' => $aLna->name,
                    'avatar' => $aLna->avatar,
                    'captions' => $aLna->captions,
                    'url' => $aLna->getDetailUrl(),
                    'date' => date('d/m/Y', $aLna->datecreate),
                    'cate' => 'Luyện ngữ âm'
            );
        }

        $allThuvien = ThuVien::where($cond)->orderBy('datecreate','desc')->limit(20)->get();
        foreach($allThuvien as $aThuvien){
            $cate = Category::where(array('_id'=>array('$in'=>$aThuvien->category)))->first();
            if($cate && !empty($cate->type)){
//            var_dump($cate);die;
                $list[] = array(
                        '_id' => $aThuvien->_id,
                        'name' => $aThuvien->name,
                        'avatar' => $aThuvien->avatar,
                        'captions' => $aThuvien->captions,
                        'url' => $aThuvien->getDetailUrl($cate->type),
                        'date' => date('d/m/Y', $aThuvien->datecreate),
                        'cate' => $cate->name
                );
            }

        }
//        $list = ThuVien::where('status', '1')->get();
        $page = Input::get('page', 1);
        $limit = 10;
        $totalPage = ceil(count($list) / $limit);
        if($page > $totalPage) $page = $totalPage;
        $start = ($page - 1)*$limit;

        $listLession = array();
        if(count($list) > 0){
            for($i=$start; $i< $start+ $limit; $i++){
                if(isset($list[$i])) {
                    $listLession[] = $list[$i];
                }
            }
        }
        return View::make('home.search', array(
            'keyword' => $keyword,
            'listLession' => $listLession,
            'page' => $page,
            'totalPage' => $totalPage,
            'limit' => $limit
        ));
    }

    public function showMessage(){
        return View::make('home.message');
    }

    public function aff($uid){
//        echo $uid;exit;
        $redirect = Input::get('redirect','/');
        $affClick = new AffClick();
        $affClick->_id = strval(time());
        $affClick->datecreate = time();
        $affClick->uid = $uid;
        $affClick->redirect = $redirect;
        $affClick->ip = Request::ip();
        $affClick->save();

        Session::put('aff_uid', $uid);
        return Redirect::to($redirect);
    }
}
