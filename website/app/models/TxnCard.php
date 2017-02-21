<?php
use Jenssegers\Mongodb\Model as Eloquent;
class TxnCard extends Eloquent {
    protected $collection = 'txn_card';

    public function user(){
        return User::where('_id', $this->uid)->first();
    }
}