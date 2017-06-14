<?php

use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/18/2015
 * Time: 5:17 PM
 */
class Article extends Eloquent
{

    protected $collection = 'thuvien';


    public function getArticleUrl(){
        $slug = CommonHelpers::utf8_to_url($this->name);
        return '/thu-vien/'.$slug.'-'.$this->_id.'.html';
    }

    public function categories(){
//        return $this->belongsToMany('Category', null, 'category', '_id');
        return Category::whereIn('_id', $this->category)->get();
    }

    public static function getIdFromSlug($slug){
        $tmpArr = explode('-', $slug);
        return array_pop($tmpArr);
    }
}