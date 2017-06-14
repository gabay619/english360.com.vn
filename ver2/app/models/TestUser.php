<?php
use Jenssegers\Mongodb\Model as Eloquent;

class TestUser extends Eloquent {
    public $collection = 'test_user';

    public function getQuestion(){
        return isset($this->question) ? $this->question : array();
    }

    public function addQuestion($qId){
        $question = self::getQuestion();
        if(!in_array($qId, $question))
            array_push($question, $qId);

        $this->question = $question;
        return $this->save();
    }

    public function getNewQuestion($level, $type){
        $newQuestion = Test::where(array(
            'level' => $level,
            'type' => $type,
            '_id' => array('$nin'=>self::getQuestion())
        ))->first();
//        if($newQuestion){
//            self::addQuestion($newQuestion->_id);
//        }
        return $newQuestion;
    }
}