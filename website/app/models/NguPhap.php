<?php
use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 09/12/2016
 * Time: 9:37 AM
 */
class NguPhap extends Eloquent
{
    protected $collection = 'nguphap';

    public function getDetailUrl(){
        $slug = empty($this->slug) ? CommonHelpers::utf8_to_url($this->name).'-'.$this->_id : $this->slug;
        return '/ngu-phap/'.$slug.'.html';
    }

    public static function getStaticDetailUrl($name, $id, $slug = ''){
        $slug = empty($slug) ? CommonHelpers::utf8_to_url($name).'-'.$id : $slug;
        return '/ngu-phap/'.$slug.'.html';
    }

    public static function getCateUrl(Category $cate){
        return '/ngu-phap/chuyen-muc/'.CommonHelpers::utf8_to_url($cate->name).'-'.$cate->_id.'.html';
    }

    public static function getNewPost($limit = 10, $free = false){
        $allPost = self::where('status', "1");
        if($free) $allPost->where('free','1');
        $allPost =	$allPost->limit($limit)
            ->orderBy('datecreate', 'asc')
            ->get();
//            ->toArray();
        return $allPost;
    }
}