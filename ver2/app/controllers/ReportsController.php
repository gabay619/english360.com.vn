<?php

class ReportsController extends \BaseController {

    public function __construct(){
        $this->beforeFilter('auth');
    }

	public function postNew(){
		$id = Input::get('id');
		$type = Input::get('type');
		$content = Input::get('content');

		$newReport = new Report();
		$newReport->_id = strval(time());
		$newReport->content = $content;
		$newReport->uid = Auth::user()->_id;
		$newReport->itemid = $id;
		$newReport->type = $type;
		$newReport->datecreate = time();
		$newReport->save();

		return Response::json(array('success'=>true, 'message' => 'Cảm ơn bạn đã gửi báo cáo cho chúng tôi. Chúng tôi sẽ xem xét trong thời gian sớm nhất.'));
	}

}