<?php
use Jenssegers\Mongodb\Model as Eloquent;
class LogTxnCard extends Eloquent {
    protected $collection = 'log_txn_card';

    public function user(){
        return User::where('_id', $this->uid)->first();
    }
}