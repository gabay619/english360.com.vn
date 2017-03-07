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