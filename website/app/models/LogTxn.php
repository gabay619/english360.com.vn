<?php
use Jenssegers\Mongodb\Model as Eloquent;
class LogTxn extends Eloquent {
    protected $collection = 'log_txn';

    public function user(){
        return User::where('_id', $this->uid)->first();
    }
}