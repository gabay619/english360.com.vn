<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Jenssegers\Mongodb\Model as Eloquent;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $collection = 'user';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static 	$rules = array(
        'full_name'=>'min:2',
        'email'=>'required|email',
//        'username'=>'required|alpha_num|unique:user',
        'phone'=>'between:9,13|unique:user',
        'password'=>'required|alpha_num|between:6,12|confirmed',
        'password_confirmation'=>'required|alpha_num|between:6,12',
	);

    public function getDisplayName(){
        if(isset($this->displayname) && !empty($this->displayname) && $this->displayname!=$this->email) return $this->displayname;
        if(!empty($this->email)) return $this->email;
        if(isset($this->username) && !empty($this->username)) return $this->username;
        return '';
    }

    public function getFullDisplayName(){
        if(isset($this->displayname) && !empty($this->displayname)) return $this->displayname;
        if(!empty($this->email)) return $this->email;
        if(isset($this->username) && !empty($this->username)) return $this->username;
        return '';
    }

    public function getDisplayAvatar(){
        return isset($this->priavatar) && !empty($this->priavatar) ? $this->priavatar : '/assets/web/images/avatar_user_comment_default.png';
    }

    public function getBalance(){
        return isset($this->balance) && !empty($this->balance) ? $this->balance : 0;
    }

    public function getPackageTime(){
        return isset($this->pkg_expired) && $this->pkg_expired > time() ? $this->pkg_expired : false;
    }

    public function getSavedExam(){
        $save = SaveExam::where(array('uid' => $this->_id))->first();
        if(!$save){
            $save = new SaveExam();
            $save->uid = $this->_id;
            $save->save();
        }

        return $save;
    }

    public function getCountNotify(){
        return Notify::where('uid', $this->_id)
                ->where('status', Constant::STATUS_ENABLE)
                ->where('type', Constant::TYPE_NOTIFY)
                ->count();
    }

    public function readAllNotify(){
        Notify::where('uid', $this->_id)->update(array('status' => Constant::STATUS_DISABLE));
    }

    public function receiveNotify(){
        $result = false;
        if(isset($this->thong_bao['noti']) && $this->thong_bao['noti'] == 1)
            $result = true;
        return $result;
    }

    public function registedPackage(){
        return isset($this->pkg_expired) && $this->pkg_expired > time();
    }

    public function isAllowEmail(){
        return isset($this->email) && isset($this->thong_bao['email']) && !empty($this->email) && $this->thong_bao['email'] == Constant::STATUS_ENABLE;
    }

    public function aff(){
        if(isset($this->aff['uid'])){
            return static::find($this->aff['uid']);
        }
        return false;
    }

    public function account(){
        $acc = Account::where('uid',$this->_id)->first();
        if(!$acc){
            $acc = new Account();
            $acc->_id = strval(time());
            $acc->uid = $this->_id;
            $acc->balance = 0;
            $acc->save();
        }
        return $acc;
    }
}
