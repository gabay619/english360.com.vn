<?php

class PagesController extends \BaseController {

	public function getDetail($slug){
//		switch($slug){
//			case "gioi-thieu":
//				$type = Constant::TYPE_INFO;
//				break;
//			case "dieu-khoan":
//				$type = Constant::TYPE_TERM;
//				break;
//			default:
//				$type = Constant::TYPE_CONTACT;
//				break;
//		}

		$page = Page::where(array(
			'status' => Constant::STATUS_ENABLE,
			'slug' => $slug,
			'on' => Constant::ON_WEB
		))->first();
		return View::make('page.detail', array(
			'item' => $page
		));
	}
}