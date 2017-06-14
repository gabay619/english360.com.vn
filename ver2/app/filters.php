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
//    Input::merge(Common::array_strip_tags(Input::all()));
    if(Auth::user()){
        if(Auth::user()->ssid != Session::getId()){
            Auth::logout();
        }
    }
});


App::after(function($request, $response)
{

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
    if(Auth::user()->ssid != Session::getId()){
        Auth::logout();
        return Redirect::to('/user/login')->with('error', 'Tài khoản của bạn được đăng nhập từ nơi khác.');
    }
});

Route::filter('package', function(){
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
    }elseif(!Auth::user()->registedPackage()){
        if (Request::ajax())
        {
            Session::put('return_url', Input::get('return_url', '/'));
            return Response::json(array('success'=>false, 'message'=> 'Bạn cần đăng ký gói cước.', 'package'=>1));
        }
        else
        {
            Session::put('return_url', Request::url());
            return Redirect::guest('/user/package');
        }
    }
});

Route::filter('count_view', function(){
//    if(!Session::has('count_view')){
//        Session::put('count_view',1);
//    }else{
//        Session::put('count_view', Session::get('count_view')+1);
//    }
//    if(Session::get('count_view') > Constant::MAX_CONTENT_FREE){
//        Session::put('return_url', Request::url());
//        if(!Auth::user()){
//            return Redirect::to('/user/login')->with('error', 'Bạn đã sử dụng hết 10 nội dung miễn phí. Hãy đăng nhập để tiếp tục sử dụng dịch vụ.');
//        }else{
//            if(Auth::user()->ssid != Session::getId()){
//                Auth::logout();
//                return Redirect::to('/user/login')->with('error', 'Tài khoản của bạn được đăng nhập từ nơi khác.');
//            }
//            if(!Auth::user()->registedPackage()){
//                return Redirect::to('/user/package')->with('error', 'Bạn đã sử dụng hết 10 nội dung miễn phí.');
//            }
//            else
//                Session::remove('count_view');
//        }
//    }
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
	if (Auth::check()) return Redirect::to('/');
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
