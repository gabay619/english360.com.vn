<?php
use Jenssegers\Mongodb\Model as Eloquent;
class Txn extends Eloquent {
    protected $collection = 'txn';

    public function user(){
        return User::where('_id', $this->uid)->first();
    }
}