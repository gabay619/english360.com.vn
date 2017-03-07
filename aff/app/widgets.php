<?php
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/19/2015
 * Time: 11:27 AM
 */
Widget::register('datepicker', function ($start, $end, $url=''){
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