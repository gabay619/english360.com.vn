<?php
use Jenssegers\Mongodb\Model as Eloquent;
class TxnSms extends Eloquent {
    protected $collection = 'txn_sms';

    public function user(){
        return User::where('_id', $this->uid)->first();
    }
}