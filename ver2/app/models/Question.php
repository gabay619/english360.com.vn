<?php
use Jenssegers\Mongodb\Model as Eloquent;

class Question extends Eloquent {
	protected $collection = 'faq';

	public function user(){
		return User::where('_id', $this->usercreate)->first();
	}

	public function getChilds(){
		return self::whereIn('parentid', array((string)$this->_id, $this->_id))
                ->where('status', Constant::STATUS_ENABLE)
                ->orderBy('datecreate', 'desc')
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

    public function getDetailUrl(){
        return '/hoi-dap/chi-tiet.html?id='.$this->_id;
    }

    public static function getStaticDetailUrl($id){
        return '/hoi-dap/chi-tiet.html?id='.$id;
    }
}