<?php
use Jenssegers\Mongodb\Model as Eloquent;

class SaveGame extends Eloquent {
	public $collection = 'savegame';

	public function getLevel(){
		if(!isset($this->level)){
			$this->level = 1;
			$this->save();
		}
		return $this->level;
	}
}