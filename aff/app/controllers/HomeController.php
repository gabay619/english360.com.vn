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
		return View::make('home.dashboard');
	}

	public function getIndex(){
		return View::make('home.index');
	}

    public function showMessage(){
        return View::make('home.message');
    }


}
