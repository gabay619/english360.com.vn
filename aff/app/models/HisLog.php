<?php
use Jenssegers\Mongodb\Model as Eloquent;

class HisLog extends Eloquent {
	protected $collection = 'history_log';

	public function user(){
		return User::where('_id', $this->uid)->first();
	}
}