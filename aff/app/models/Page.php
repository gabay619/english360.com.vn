<?php
use Jenssegers\Mongodb\Model as Eloquent;
class Page extends Eloquent {
	public $collection = 'page';

	public static function getNameByType($type){
		$typeArr = array(
			Constant::TYPE_INFO => 'Giới thiệu',
			Constant::TYPE_TERM => 'Điều khoản',
			Constant::TYPE_CONTACT => 'Liên hệ'
		);

		return $typeArr[$type];
	}

	public function getName(){
		$typeArr = array(
			Constant::TYPE_INFO => 'Giới thiệu',
			Constant::TYPE_TERM => 'Điều khoản',
			Constant::TYPE_CONTACT => 'Liên hệ'
		);

		return $typeArr[$this->type];
	}
}