<?php
use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/20/2015
 * Time: 11:41 AM
 */
class Notify extends Eloquent
{
    public $collection = 'notify';

    public function getDisplayAvatar(){
        $user = User::where('_id', $this->usercreate)->first();
        if($user){
            return $user->priavatar;
        }else
            return '/assets/web/images/avatar_user_comment_default.png';
    }

    public function getDetailUrl(){
        $type = isset($this->to['type']) ? $this->to['type'] : Constant::TYPE_THUVIEN;
        $url = '/';
        if($type == Constant::TYPE_HOIDAP){
            $url = '/hoi-dap/chi-tiet.html?id='.$this->to['id'];
        }elseif(isset($this->to)){
            $model = CommonHelpers::getModelFromType($type);
            $post = $model::where('_id', $this->to['id'])->first();
            $url = $post->getDetailUrl($type);
        }

        return $url;
    }
}