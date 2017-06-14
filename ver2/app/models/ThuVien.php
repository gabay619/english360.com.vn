<?php

use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/18/2015
 * Time: 5:17 PM
 */
class ThuVien extends Eloquent
{

    protected $collection = 'thuvien';

    const MAIN_CATE = '1427182938';

    public static function getCateUrl($cateid, $catename, $catetype){
        $slug = CommonHelpers::getCateSlugbyType($catetype);
        return '/'.$slug.'/chuyen-muc/'.CommonHelpers::utf8_to_url($catename).'-'.$cateid.'.html';
    }

    public function getArticleUrl($type){
        $cateSlug = CommonHelpers::getCateSlugbyType($type);
        $slug = CommonHelpers::utf8_to_url($this->name);
        return '/'.$cateSlug.'/'.$slug.'-'.$this->_id.'.html';
    }

    public function getDetailUrl($type){
        $cateSlug = CommonHelpers::getCateSlugbyType($type);
        $slug = CommonHelpers::utf8_to_url($this->name);
        return '/'.$cateSlug.'/'.$slug.'-'.$this->_id.'.html';
    }

    public static function getArticleUrlStatic($name, $id, $type){
        $cateSlug = CommonHelpers::getCateSlugbyType($type);
        $slug = CommonHelpers::utf8_to_url($name);
        return '/'.$cateSlug.'/'.$slug.'-'.$id.'.html';
    }

    public function categories(){
//        return $this->belongsToMany('Category', null, 'category', '_id');
        return Category::whereIn('_id', $this->category)->get();
    }

    public static function getIdFromSlug($slug){
        $tmpArr = explode('-', $slug);
        return array_pop($tmpArr);
    }

    public function getAllArticle(){

    }

    public static function getNewPost($cateId, $limit = 10, $free=false){
        $cateChild = Category::where('parentid', $cateId)->get();
        $arrCateId = array();
        foreach($cateChild as $aChild){
            $arrCateId[] = $aChild->_id;
        }
        $arrCateId[] = $cateId;
        $cond = array(
            'category' => array('$in' => $arrCateId),
            '$or' => array(
                array('calendar' => array('$exists'=>false)),
                array('calendar' => array('$lte'=> time()))
            )
        );
        if($free) $cond['free'] = '1';
        $allPost = ThuVien::where('status', Constant::STATUS_ENABLE)
                ->where($cond)
                ->limit($limit)
                ->orderBy('datecreate', 'desc')
                ->get();
//                ->toArray();
        return $allPost;
    }
}