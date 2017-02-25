<?php
use Jenssegers\Mongodb\Model as Eloquent;
class LogTxnBank extends Eloquent {
    protected $collection = 'log_txn_bank';

    public function user(){
        return User::where('_id', $this->uid)->first();
    }
}