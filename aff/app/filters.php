<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
//    Input::merge(CommonHelpers::array_strip_tags(Input::all()));
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/
Route::filter('payment', function (){
	if(!isset(Auth::user()->bank['id']))
		return Redirect::to('/payment/setting')->with('error','Bạn cần cập nhật thông tin thanh toán');
});

Route::filter('approve', function (){
	if(Auth::user()->aff_status != Constant::STATUS_ENABLE){
		if (Request::ajax()){
			return Response::json(array('success'=>false, 'message'=>'Tài khoản của bạn chưa được duyệt, vui lòng liên hệ bộ phận CSKH'));
		}else
			return Redirect::to('/thong-bao.html')->with('error', 'Tài khoản của bạn chưa được duyệt, vui lòng liên hệ bộ phận CSKH');
	}
});

Route::filter('auth', function()
{
	if (Auth::guest())
	{
        if (Request::ajax())
		{
            Session::put('return_url', Input::get('return_url', '/'));
            return Response::json(array('success'=>false, 'message'=> 'Bạn cần đăng nhập để thực hiện chức năng này'));
		}
		else
		{
            Session::put('return_url', Request::url());
            return Redirect::guest('/user/login');
		}
	}
	if(Auth::user()->aff_status == Constant::STATUS_DISABLE){
		Auth::logout();
		if (Request::ajax())
		{
			return Response::json(array('success'=>false, 'message'=> 'Tài khoản của bạn bị khóa, vui lòng liên hệ bộ phận CSKH'));
		}
		else
		{

			return Redirect::to('/thong-bao.html')->with('error','Tài khoản của bạn bị khóa, vui lòng liên hệ bộ phận CSKH');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/dashboard');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
        if (Request::ajax())
            return Response::json(array('success'=>false, 'message'=> 'Bad Request'));
        else
            throw new Illuminate\Session\TokenMismatchException;
	}
});
