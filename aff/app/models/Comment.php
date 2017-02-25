<?php
use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/20/2015
 * Time: 11:38 AM
 */
class Comment extends Eloquent
{
    protected $collection = 'comment';

    public function user(){
        return User::where('_id', $this->uid)->first();
    }

    public function getChilds(){
        return self::whereIn('parentid', array((string)$this->_id, (int)$this->_id))
                ->where('status', Constant::STATUS_ENABLE)
                ->orderBy('datecreate', 'asc')
                ->get();
    }

    public function getLikeNumber(){
        return isset($this->like) ? count($this->like) : 0;
    }

    public function isLiked($userId){
        return isset($this->like) ? in_array($userId, $this->like) : false;
    }

    public function addLike($userId){
        $like = isset($this->like) ? $this->like : array();
        if(!in_array($userId, $like))
            array_push($like, $userId);

        $this->like = $like;
        return $this->save();
    }

    public function removeLike($userId){
        $like = isset($this->like) ? $this->like : array();
        if(($key = array_search($userId, $like)) !== false) {
            unset($like[$key]);
        }
        $this->like = $like;
        return $this->save();
    }
}