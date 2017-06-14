<?php

class TuDienController extends \BaseController {

	public function getIndex(){
		$allCate = Category::where('type', Constant::TYPE_TUDIEN)->get();
		$letter = Input::get('letter', '');
		$letter = strtoupper($letter);

		$searchWord = Input::get('searchWord', '');
		$cate = Input::get('cate', '');

//		var_dump($cate);die;

		$allTudien = Dictionary::where('_id', '!=', '');
		if(!empty($letter)){
			$allTudien->where('key', $letter);
		}
		if(!empty($searchWord)){
			$keywordRegex = new MongoRegex('/'.strtolower(Common::convert_vi_to_en($searchWord)).'/ui');

			$allTudien->where('value', $keywordRegex);
		}
		if(!empty($cate)){
			$cate = explode(',', $cate);
			$allTudien->where(array('catid'=> array('$in' => $cate)));
		}else
			$cate = array();

		$allTudien = $allTudien->orderBy('value')->paginate(20);
        //Log
        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_TU_DIEN,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => Auth::user() ? Auth::user()->_id : '',
                'url' => Request::url(),
                'status' => Constant::STATUS_ENABLE,
                'phone' => Auth::user() ? Auth::user()->phone : '',
                'price' => 0,
                'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""

        );
        HisLog::insert($newHistoryLog);

		return View::make('tudien.index', array(
			'allCate' => $allCate,
			'allTudien' => $allTudien,
			'letter' => $letter,
			'cate' => $cate
		));
	}
}