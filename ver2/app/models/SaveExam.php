<?php
use Jenssegers\Mongodb\Model as Eloquent;
class SaveExam extends Eloquent {

	public $collection = 'saveexam';

    public function getLession(){
        if(!isset($this->ex)){
            $this->ex = array();
            $this->time = array();
            $this->save();
        }
        return $this->ex;
    }

    public function getTime($key){
        $timeArr = array_reverse($this->time);
        return isset($timeArr[$key]) ? $timeArr[$key] : 0;
    }

    public function addLession(array $ex){
        $lession = isset($this->ex) ? $this->ex : array();
        $time = isset($this->time) ? $this->time : array();
        if(!in_array($ex, $lession)){
            array_push($lession, $ex);
            array_push($time, time());
        }
        $this->ex = $lession;
        $this->time = $time;
        return $this->save();
    }

    public function removeLession(array $ex){
        $lession = isset($this->ex) ? $this->ex : array();
        $time = isset($this->time) ? $this->time : array();
        if(($key = array_search($ex, $lession)) !== false) {
            unset($lession[$key]);
            unset($time[$key]);
        }

        $this->ex = array_values($lession);
        $this->time = array_values($time);
        return $this->save();
    }

    public function isSavedByUser(array $ex){
        $lession = isset($this->ex) ? $this->ex : array();
        if(($key = array_search($ex, $lession)) !== false) {
            return true;
        }

        return false;
    }
}