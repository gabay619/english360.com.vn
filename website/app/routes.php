<?php

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
Route::get('/search', 'HomeController@getSearch');
Route::get('/disable-email.html', 'UsersController@disableEmail');
Route::get('/fb-callback.html', 'UsersController@facebookCallback');
Route::get('/verify-email.html', 'UsersController@verifyEmail');
Route::get('/thong-bao.html', 'HomeController@showMessage');
Route::get('/bai-hoc-free.html', 'FreeLessionController@index');

Route::controller('user', 'UsersController');
Route::controller('job', 'JobsController');
Route::controller('test', 'TestController');
Route::controller('comment', 'CommentsController');
Route::controller('game', 'GamesController');
Route::controller('question', 'QuestionsController');
Route::controller('upload', 'UploadsController');
Route::controller('report', 'ReportsController');
Route::controller('ajax', 'AjaxController');
Route::controller('txn', 'TxnsController');
Route::get('/trang/{slug}.html', 'PagesController@getDetail');
Route::get('/hoi-dap.html', 'QuestionsController@getIndex');
Route::get('/hoi-dap/chi-tiet.html', 'QuestionsController@getDetail');

Route::get('/tu-dien.html', 'TuDienController@getIndex');

Route::get('/giao-tiep-co-ban.html', 'GiaoTiepCoBanController@getIndex');
Route::get('/giao-tiep-co-ban/bai-tap.html', 'GiaoTiepCoBanController@getExcercise');
Route::get('/giao-tiep-co-ban/chuyen-muc/{catSlug}.html', 'GiaoTiepCoBanController@getList');
Route::get('/giao-tiep-co-ban/{slug}.html', 'GiaoTiepCoBanController@getDetail');

Route::get('/bai-hat.html', 'SongController@getIndex');
Route::get('/bai-hat/bai-tap.html', 'SongController@getExcercise');
Route::get('/bai-hat/tim-kiem.html', 'SongController@getSearch');
Route::get('/bai-hat/chuyen-muc/{cateSlug}.html', 'SongController@getList');
Route::get('/bai-hat/{slug}.html', 'SongController@getDetail');

Route::get('/luyen-ngu-am.html', 'LuyenNguAmController@getIndex');
Route::get('/luyen-ngu-am/bai-tap.html', 'LuyenNguAmController@getExcercise');
Route::get('/luyen-ngu-am/chuyen-muc/{cateSlug}.html', 'LuyenNguAmController@getList');
Route::get('/luyen-ngu-am/{slug}.html', 'LuyenNguAmController@getDetail');

Route::get('/ngu-phap.html', 'NguPhapController@getIndex');
Route::get('/ngu-phap/bai-tap.html', 'NguPhapController@getExcercise');
Route::get('/ngu-phap/chuyen-muc/{cateSlug}.html', 'NguPhapController@getList');
Route::get('/ngu-phap/{slug}.html', 'NguPhapController@getDetail');

Route::get('/{cateSlug}.html', 'ThuvienController@getIndex');
Route::get('/{cateSlug}/chuyen-muc/{cateChild}.html', 'ThuvienController@getList');
Route::get('/{cateSlug}/{slug}.html', 'ThuvienController@getDetail');



