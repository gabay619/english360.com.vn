<?php
use Jenssegers\Mongodb\Model as Eloquent;
class GamePoint extends Eloquent {
	public $collection = 'game_point';

	public function getPoint(){
		if(!isset($this->point)){
			$this->point = 0;
			$this->save();
		}
		return $this->point;
	}

	public function user(){
		return User::where('_id', $this->uid)->first();
	}
}