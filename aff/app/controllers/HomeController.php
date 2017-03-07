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
	public function __construct()
	{
		$this->beforeFilter('auth', array('only' => array(
			'getDashboard',
		)));
		$this->beforeFilter('guest', array('only' => array(
			'getIndex',
		)));
	}

	public function getDashboard(){
		$cond = array(
			'uid' => Auth::user()->_id
		);
		$start = date('01/m/Y');
		$end = date('d/m/Y');
		if(!empty(Input::get('start'))){
			$start = Input::get('start');
		}
		if(!empty(Input::get('end'))){
			$end = Input::get('end');
		}
		$convertStartdate = DateTime::createFromFormat('d/m/Y', $start)->format('Y-m-d');
		$convertEnddate = DateTime::createFromFormat('d/m/Y', $end)->format('Y-m-d');
		$cond['datecreate'] = array(
			'$gte' => (int)strtotime($convertStartdate. ' 00:00:00'),
			'$lte' => (int)strtotime($convertEnddate. ' 23:59:59')
		);
		$countClick = AffClick::where($cond)->count();

		$countUser = User::where(array(
			'aff.uid' => Auth::user()->_id,
			'aff.datecreate' => array(
				'$gte' => (int)strtotime($convertStartdate. ' 00:00:00'),
				'$lte' => (int)strtotime($convertEnddate. ' 23:59:59')
			),
			'status' => Constant::STATUS_ENABLE
		))->count();

		return View::make('home.dashboard',array(
			'click' => $countClick,
			'user' => $countUser,
			'start' => $start,
			'end' => $end
		));
	}

	public function getIndex(){
		return View::make('home.index');
	}

    public function showMessage(){
        return View::make('home.message');
    }


}
