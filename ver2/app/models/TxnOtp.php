<?php
use Jenssegers\Mongodb\Model as Eloquent;
class TxnOtp extends Eloquent {
    protected $collection = 'txn_otp';

    public function user(){
        return User::where('_id', $this->uid)->first();
    }
}