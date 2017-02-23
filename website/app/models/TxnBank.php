<?php
use Jenssegers\Mongodb\Model as Eloquent;
class TxnBank extends Eloquent {
    protected $collection = 'txn_bank';

    public function user(){
        return User::where('_id', $this->uid)->first();
    }
}