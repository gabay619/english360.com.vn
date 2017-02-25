<?php
use Jenssegers\Mongodb\Model as Eloquent;
class Upload extends Eloquent {
	protected $collection = 'upload';

	public function user(){
		return User::where('_id', $this->uid)->first();
	}
}