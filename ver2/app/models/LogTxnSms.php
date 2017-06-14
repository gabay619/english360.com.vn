<?php
use Jenssegers\Mongodb\Model as Eloquent;
class LogTxnSms extends Eloquent {
    protected $collection = 'log_txn_sms';

    public function user(){
        return User::where('_id', $this->uid)->first();
    }
}