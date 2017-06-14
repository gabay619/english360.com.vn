<?php

class CommentsController extends \BaseController {

    public function __construct(){
        $this->beforeFilter('auth');
        $this->beforeFilter('package', array('only' => array(
            'postNew'
        )));

    }

    public function postNew(){
        $parent = Input::get('parent','0') != '' ? Input::get('parent','0') : '0';
        $content = strip_tags(Input::get('content'));
        $type = Input::get('type');
        $objid = Input::get('id');

        $comment = new Comment();
        $comment->_id = time();
        $comment->uid = Auth::user()->_id;
        $comment->type = $type;
        $comment->content = $content;
        $comment->objid = $objid;
        $comment->parentid = $parent;
        $comment->datecreate = time();
        $comment->status = Constant::STATUS_ENABLE;
        if($comment->save()){
            if($parent != '0'){
                $parentComment = Comment::whereIn('_id', array($parent, intval($parent)))->first();
                $parentUser = User::where('_id', $parentComment->uid)->first();
                if($parentComment && $parentComment->uid != Auth::user()->_id && $parentUser && $parentUser->receiveNotify()){
                    $notify = new Notify();
                    $notify->_id = strval(time());
                    $notify->uid = $parentComment->uid;
                    $notify->usercreate = Auth::user()->_id;
                    $notify->datecreate = time();
                    $notify->mss = Auth::user()->getDisplayName(). ' đã trả lời Bình luận của bạn';
                    $notify->status = Constant::STATUS_ENABLE;
                    $notify->type = Constant::TYPE_NOTIFY;
//                    $notify->url = Input::get('url', '/');
                    $notify->to = array(
                            'type' => $type,
                            'id' => $objid
                    );
                    $notify->save();
                }
            }
            return Response::json(array(
                    'success'=> true,
                    'message'=>'Comment thành công',
                    'id' => $comment->_id,
                    'content'=>$content,
                    'time' => date('d/m/Y H:i', $comment->datecreate)
            ));
        }
        else
            return Response::json(array('success'=>false, 'message' => 'Có lỗi xảy ra.'));
    }

    public function postLike(){
        $id = Input::get('id');
        $comment = Comment::whereIn('_id', array($id, intval($id)))->first();

        if(!$comment)
            return Response::json(array('success'=>false, 'message'=>'Comment đã bị xóa.'.$id));

        if($comment->addLike(Auth::user()->_id)){
            $commentUser = User::where('_id', $comment->uid)->first();
            if($comment->uid != Auth::user()->_id && $commentUser && $commentUser->receiveNotify()){
                $notify = new Notify();
                $notify->_id = strval(time());
                $notify->uid = $comment->uid;
                $notify->usercreate = Auth::user()->_id;
                $notify->datecreate = time();
                $notify->mss = Auth::user()->getDisplayName(). ' đã thích Bình luận của bạn';
                $notify->status = Constant::STATUS_ENABLE;
                $notify->type = Constant::TYPE_NOTIFY;
                $notify->to = array(
                        'type' => $comment->type,
                        'id' => $comment->objid
                );
//                $notify->url = Input::get('url', '/');
                $notify->save();
            }
            return Response::json(array('success'=>true, 'message'=>'Thành công.', 'number'=>$comment->getLikeNumber()));
        }else{
            return Response::json(array('success'=>false, 'message'=>'Có lỗi xảy ra, vui lòng thử lại sau.'));
        }
    }

    public function postUnlike(){
        $id = Input::get('id');
        $comment = Comment::whereIn('_id', array($id, intval($id)))->first();

        if(!$comment)
            return Response::json(array('success'=>false, 'message'=>'Comment đã bị xóa.'.$id));

        if($comment->removeLike(Auth::user()->_id)){
            return Response::json(array('success'=>true, 'message'=>'Thành công.', 'number'=>$comment->getLikeNumber()));
        }else{
            return Response::json(array('success'=>false, 'message'=>'Có lỗi xảy ra, vui lòng thử lại sau.'));
        }
    }
}