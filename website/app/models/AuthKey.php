<?php
use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 12/18/2015
 * Time: 2:31 PM
 */
class AuthKey extends Eloquent
{
    public $collection = 'auth_key';

    public function generateAuthKey(){
        $authKey = rand(100000, 999999);
        $this->key = $authKey;
        $this->time = time();
        $this->save();
    }

    public function getAuthKey()
    {
        if ($this->checkAuthKeyExpired()) {
            $this->generateAuthKey();
        }
        return $this->key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->key == $authKey;
    }

    public function checkAuthKeyExpired(){
        $expired = 2*60;
        return !isset($this->key) || ((time() - $this->time) > $expired);
    }

    public function removeAuthKey(){
        $this->key = null;
        $this->count = 0;
        $this->save();
    }

    public static function findOrCreateNew($phone){
        $record = self::where('phone',$phone)->first();
        if(!$record){
            $record = new AuthKey();
            $record->phone = $phone;
            $record->save();
        }else{
            if(time() - $record->time >= 60*60)
                $record->removeAuthKey();
        }
        return $record;
    }
}