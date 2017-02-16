<?php

class GamesController extends \BaseController {

	public function __construct(){
		$this->beforeFilter('auth');
	}

	public function getIndex(){
		return View::make('games.index');
	}

	public function getRank(){
        $rank = GamePoint::orderBy('point', 'desc')->limit(10)->get();
        $myPoint = GamePoint::where('uid', Auth::user()->id)->first();
        if(!$myPoint){
            $myPoint = new GamePoint();
            $myPoint->uid = Auth::user()->_id;
            $myPoint->save();
        }
		return View::make('games.rank', array(
            'rank' => $rank,
            'myPoint' => $myPoint->getPoint()
        ));
	}

	public function getGuide(){
		return View::make('games.guide');
	}

	public function getStart(){
		$hmcParent = Category::whereIn('parentid', array('0',0))->where('type', Constant::TYPE_HOCMACHOI)->first();
		$allTopic = Category::where('parentid', $hmcParent->_id)->get();
		return View::make('games.start', array(
			'allTopic' => $allTopic
		));
	}

	public function getPlayEasy($slug){
		$id = CommonHelpers::getIdFromSlug($slug);
		$save = SaveGame::where(array(
				'uid' => Auth::user()->_id,
				'degree' => Constant::LEVEL_EASY,
				'category' => $id
			))->first();
		if(!$save){
			$save = new SaveGame();
			$save->uid = Auth::user()->_id;
			$save->degree = Constant::LEVEL_EASY;
			$save->category = $id;
			$save->level = 1;
			$save->save();
		}

        $level = $save->getLevel();
		$cate = Category::where('_id', $id)->first();
		$quiz = Game::where('category', $cate->_id)
			->where('degree', Constant::LEVEL_EASY)
            ->where('level', (string)$level)
			->first();
//        var_dump($quiz);die;

        //Log
        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_GAME,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => Auth::user()->_id,
                'url' => Request::url(),
                'status' => Constant::STATUS_ENABLE,
                'phone' => Auth::user()->phone,
                'price' => 0
        );
        HisLog::insert($newHistoryLog);
		return View::make('games.play_easy', array(
			'cate' => $cate,
			'quiz' => $quiz
		));
	}

	public function getPlayHard($slug){
		$id = CommonHelpers::getIdFromSlug($slug);
		$save = SaveGame::where(array(
				'uid' => Auth::user()->_id,
				'degree' => Constant::LEVEL_HARD,
				'category' => $id
			))->first();
		if(!$save){
			$save = new SaveGame();
			$save->uid = Auth::user()->_id;
			$save->degree = Constant::LEVEL_HARD;
			$save->category = $id;
			$save->level = 1;
			$save->save();
		}

		$level = $save->getLevel();
		$cate = Category::where('_id', $id)->first();
		$quiz = Game::where('category', $cate->_id)
			->where('degree', Constant::LEVEL_HARD)
			->where('level', (string)$level)
			->first();
//		var_dump($cate);die;
        $newHistoryLog = array(
                '_id' => strval(time().rand(10,99)),
                'datecreate' => time(),
                'action' => HistoryLog::LOG_GAME,
                'chanel' => HistoryLog::CHANEL_WEB,
                'ip' => Network::ip(),
                'uid' => Auth::user()->_id,
                'url' => Request::url(),
                'status' => Constant::STATUS_ENABLE,
                'phone' => Auth::user()->phone,
                'price' => 0
        );
        HisLog::insert($newHistoryLog);
		return View::make('games.play_hard', array(
			'cate' => $cate,
			'quiz' => $quiz
		));
	}

    public function getResult($id){
        $quiz = Game::where('_id', $id)->first();
        $cateId = Input::get('category');
        $cate = Category::where('_id', $cateId)->first();
        if($quiz->degree == Constant::LEVEL_HARD)
            return Redirect::to(Game::getCateHardUrl($cate));
        else
            return Redirect::to(Game::getCateEasyUrl($cate));
    }

    public function postResult($id){
		$quiz = Game::where('_id', $id)->first();
		$cateId = Input::get('category');
		$category = Category::where('_id', $cateId)->first();
		$select = Input::get('select');
//		var_dump($select);die;

		$saveGame = SaveGame::where(array(
				'uid' => Auth::user()->_id,
				'degree' => $quiz->degree,
				'category' => $cateId
			))->first();
		$saveGame->level = $saveGame->getLevel()+1;
		$saveGame->save();

        $gamePoint = GamePoint::where('uid', Auth::user()->_id)->first();
        if(!$gamePoint){
            $gamePoint = new GamePoint();
            $gamePoint->uid = Auth::user()->_id;
            $gamePoint->save();
        }

        $point = $gamePoint->getPoint();
        $trueCount = 0;
        foreach($quiz->question as $key=>$aQuestion){
            if(CommonHelpers::checkAnswerQuiz($aQuestion['aw'], $select[$key])){
                $point++;
                $trueCount++;
            }
        }

        $gamePoint->point = $point;
        $gamePoint->save();


		return View::make('games.result', array(
			'quiz' => $quiz,
			'select' => $select,
			'category' => $category,
            'trueCount' => $trueCount
		));
    }
}