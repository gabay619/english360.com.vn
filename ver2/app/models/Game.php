<?php
use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/20/2015
 * Time: 11:40 AM
 */
class Game extends Eloquent
{
    public $collection = 'hmcgame';

    public static function getCateHardUrl(Category $cate){
        return '/game/play-hard/'.CommonHelpers::utf8_to_url($cate->name).'-'.$cate->_id;
    }

    public static function getCateEasyUrl(Category $cate){
        return '/game/play-easy/'.CommonHelpers::utf8_to_url($cate->name).'-'.$cate->_id;
    }
}