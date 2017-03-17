<?php
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/19/2015
 * Time: 11:27 AM
 */
Widget::register('datepicker', function ($start, $end, $url=''){
    if(empty($url)) $url = Request::url();
    return View::make('widgets.datepicker', array(
        'start' => $start,
        'end' => $end,
        'url' => $url
    ));
});

use Gregwar\Captcha\CaptchaBuilder;
Widget::register('captcha',function(){
    $builder = new CaptchaBuilder;
    $builder->build();
    $captcha = $builder->inline();
    Session::put('captchaPhrase', $builder->getPhrase());
    return View::make('widgets.captcha',array(
        'captcha' => $captcha
    ));
});

Widget::register('pagination', function($stpage,$rowcount,$limit,$maxshowpage=3){
    if($rowcount <= $limit) return;
    $totalpage = ceil($rowcount/$limit);
    return View::make('widgets.pagination',array(
        'stpage' => $stpage,
        'totalpage' => $totalpage,
        'maxshowpage' => $maxshowpage
    ));
});

Widget::register('chatbox', function(){
    return View::make('widgets.chat');
});

Widget::register('aside', function (){
   $allPages = Page::where(array(
       'status' => Constant::STATUS_ENABLE,
       'on' => Constant::ON_AFF
   ))->get();
    return View::make('widgets.aside', array(
        'allPages' => $allPages
    ));
});

Widget::register('outsidemenu', function (){
    $allPages = Page::where(array(
        'status' => Constant::STATUS_ENABLE,
        'on' => Constant::ON_AFF
    ))->get();
    return View::make('widgets.outsidemenu', array(
        'allPages' => $allPages
    ));
});