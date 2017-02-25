<?php
use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/19/2015
 * Time: 9:41 AM
 */
class GiaoTiepCoBan extends Eloquent
{
    protected $collection = 'gtcb';

    public function getDetailUrl(){
        $slug = CommonHelpers::utf8_to_url($this->name);
        return '/giao-tiep-co-ban/'.$slug.'-'.$this->_id.'.html';
    }

    public static function getStaticDetailUrl($name, $id){
        $slug = CommonHelpers::utf8_to_url($name);
        return '/giao-tiep-co-ban/'.$slug.'-'.$id.'.html';
    }

    public static function getCateUrl(Category $cate){
        return '/giao-tiep-co-ban/chuyen-muc/'.CommonHelpers::utf8_to_url($cate->name).'-'.$cate->_id.'.html';
    }

    public static function getNewPost($limit = 10, $free=false){
        $allPost = GiaoTiepCoBan::where('status', "1");
        if($free) $allPost->where('free','1');
        $allPost = $allPost->limit($limit)
                ->orderBy('datecreate', 'asc')
                ->get()
                ->toArray();
        return $allPost;
    }
}