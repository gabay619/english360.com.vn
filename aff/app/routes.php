<?php
use Gregwar\Captcha\CaptchaBuilder;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@getIndex');
Route::get('/dashboard', 'HomeController@getDashboard');
Route::get('/fb-callback.html', 'UsersController@facebookCallback');
Route::get('/gg-callback.html', 'UsersController@googleCallback');
Route::get('/thong-bao.html', 'HomeController@showMessage');
Route::get('/verify-email.html', 'UsersController@verifyEmail');

Route::get('/captcha', function(){
    $builder = new CaptchaBuilder;
    $builder->build();
    $captcha = $builder->inline();
    Session::put('captchaPhrase', $builder->getPhrase());
    return $captcha;
});

Route::controller('user', 'UsersController');
Route::controller('test', 'TestController');
Route::controller('upload', 'UploadsController');
Route::controller('ajax', 'AjaxController');
Route::controller('txn', 'TxnsController');
Route::controller('link', 'LinksController');
Route::controller('payment', 'PaymentsController');
Route::controller('report', 'ReportsController');
Route::get('/trang/{slug}.html', 'PagesController@getDetail');





