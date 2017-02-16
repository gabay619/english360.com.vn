<?php
use Jenssegers\Mongodb\Model as Eloquent;

class LuyenNguAm extends Eloquent {
	protected $collection = 'luyennguam';

	public function getDetailUrl(){
		$slug = CommonHelpers::utf8_to_url($this->name);
		return '/luyen-ngu-am/'.$slug.'-'.$this->_id.'.html';
	}

	public static function getStaticDetailUrl($name, $id){
		$slug = CommonHelpers::utf8_to_url($name);
		return '/luyen-ngu-am/'.$slug.'-'.$id.'.html';
	}

	public static function getCateUrl(Category $cate){
		return '/luyen-ngu-am/chuyen-muc/'.CommonHelpers::utf8_to_url($cate->name).'-'.$cate->_id.'.html';
	}

	public static function getNewPost($limit = 10, $free = false){
		$allPost = LuyenNguAm::where('status', "1");
		if($free) $allPost->where('free','1');
		$allPost =	$allPost->limit($limit)
			->orderBy('datecreate', 'asc')
			->get()
			->toArray();
		return $allPost;
	}
}