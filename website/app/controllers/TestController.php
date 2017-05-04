<?php

class TestController extends \BaseController {

    public function __construct(){
        $this->beforeFilter('auth', array('except'=> array(
            'getSound'
        )));
    }

	public function getIndex(){
        return View::make('test.index');
    }

    public function getRun(){
        $testUser = TestUser::where(array('uid'=>Auth::user()->_id))->first();
        if(!$testUser){
            $testUser = new TestUser();
            $testUser->uid = Auth::user()->_id;
            $testUser->save();
        }
        $firstTest = $testUser->getNewQuestion(1,'test_nguphap');
        if(!$firstTest)
            return Redirect::to('/thong-bao.html')->with('error', 'Bạn đã trả lời hết câu hỏi trong kho dữ liệu, vui lòng trở lại sau.');
        return View::make('test.run', array(
            'firstTest' => $firstTest
        ));
    }

    public function getView(){
        $id = Input::get('id');
        $question = Test::where('_id',$id)->first();
        return View::make('test.view', array(
           'firstTest' => $question
        ));
    }

    public function postQuestion(){
        $number = intval(Input::get('number'));
        $level = intval(Input::get('level'));
        $id = Input::get('id');
        if($number>=1 && $number <=6) $type = 'test_nguphap';
        elseif($number<=12) $type = 'test_tuvung';
        elseif($number == 13) $type = 'test_doc';
        elseif($number == 14) $type = 'test_nghe';
        else
            return Response::json(array('success'=>false,'message' => 'Bạn đã hoàn thành bài kiểm tra.'));
//        switch ($number){
//            case 7:
//                $type = 'test_tuvung';
//                break;
//            case 8:
//                $type = 'test_nghe';
//                break;
//            case 9:
//                $type = 'test_doc';
//                break;
//            default:
//                $type = 'test_nguphap';
//                break;
//        }

        $testUser = TestUser::where(array('uid'=>Auth::user()->_id))->first();
        if(!$testUser){
            $testUser = new TestUser();
            $testUser->uid = Auth::user()->_id;
            $testUser->save();
        }
        $testUser->addQuestion($id);
        $newQuestion = $testUser->getNewQuestion($level, $type);
        if($newQuestion){
            return Response::json(array('success'=>true,'content' => urldecode($newQuestion->content),'title' => $newQuestion->name,'id'=>$newQuestion->_id));
        }else{
            return Response::json(array('success'=>false,'message' => 'Bạn đã trả lời hết câu hỏi trong kho dữ liệu, vui lòng trở lại sau'));
        }
    }

    public function postResult(){
        $testResult = new TestResult();
        $testResult->_id = strval(time());
        $testResult->uid = Auth::user()->_id;
        $testResult->datecreate = time();
        $testResult->point = intval(Input::get('point'));
        $testResult->num = intval(Input::get('num'));
        $testResult->save();
        return Response::json(array('success'=>true,'url'=>'/test/result?id='.$testResult->_id));
    }

    public function getResult(){
        $id = Input::get('id','');
        if(empty($id)){
            $testResult = TestResult::where(array('uid'=>Auth::user()->_id))->orderBy('datecreate','desc')->first();
        }else{
            $testResult = TestResult::where(array('uid'=>Auth::user()->_id,'_id'=>$id))->first();
        }
        if(!$testResult){
            return Redirect::to('/thong-bao.html')->with('error','Bạn chưa có kết quả kiểm tra trình độ.');
        }
        
        $testLevel = TestLevel::where(array(
            'start' => array('$lte'=> $testResult->point),
            'end' => array('$gte' => $testResult->point)
        ))->first();
        $allLevel = TestLevel::orderby('start','asc')->get();

        return View::make('test.result',array(
            'testResult' => $testResult,
            'testLevel' => $testLevel,
            'allLevel' => $allLevel
        ));
    }

    public function getReset(){
        $rs = TestUser::where(array('uid'=>Auth::user()->_id))->first();
        if($rs) $rs->delete();
        echo 'ok';
    }

    public function getSound(){
        return View::make('test.sound');
    }
}