<?php
use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/19/2015
 * Time: 9:44 AM
 */
class Song extends Eloquent
{
    protected $collection = 'hmcaudio';

    public static function getCateUrl(Category $cate){
        return '/bai-hat/chuyen-muc/'.CommonHelpers::utf8_to_url($cate->name).'-'.$cate->_id.'.html';
    }

    public function getDetailUrl(){
        return '/bai-hat/'.CommonHelpers::utf8_to_url($this->name).'-'.$this->_id.'.html';
    }

    public static function getStaticDetailUrl($name, $id){
        return '/bai-hat/'.CommonHelpers::utf8_to_url($name).'-'.$id.'.html';
    }

    public static function getNewPost($limit = 10, $free=false){
        $cond = array(
            '$or' => array(
                array('calendar' => array('$exists'=>false)),
                array('calendar' => array('$lte'=> time()))
            )
        );
        if($free) $cond['free'] = '1';
        $allPost = Song::where('status', Constant::STATUS_ENABLE)
                ->where($cond)
                ->limit($limit)
                ->orderBy('datecreate', 'desc')
                ->get()
                ->toArray();
        return $allPost;
    }
}