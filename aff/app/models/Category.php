<?php
use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/19/2015
 * Time: 10:43 AM
 */
class Category extends Eloquent
{
    protected $collection = 'category';

    public function isParent(){
        return !isset($this->parentid) || empty($this->parentid) || $this->parent_id==0;
    }

    public function getChilds($limit=''){
        if($limit)
            return self::where('parentid', $this->_id)->orderBy('sort','asc')->limit($limit)->get();
        else
            return self::where('parentid', $this->_id)->orderBy('sort','asc')->get();
    }

    public function getUrl(){
        $slug = CommonHelpers::utf8_to_url($this->name);
        return '/danh-muc/'.$slug.'-'.$this->_id.'.html';
    }

    public function getArrChildsId(){
        $arr = [];
        foreach($this->getChilds() as $aChild){
            $arr[] = $aChild->_id;
        }
        return $arr;
    }

}