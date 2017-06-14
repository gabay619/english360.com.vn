@extends('layouts.private')

@section('content')
        <!--TAB CONTENT-->
<div class="content_tab_text">
    <div class="chcb block">
        @if(count($myNotify) >0)
            @foreach($myNotify as $aNotify)
                <div class="comment_item block">
                    <div class="liquid_block_right">
                        <button class="delete_btn" data-id="{{$aNotify->_id}}"><i class="fa fa-fw"></i>Xóa</button>
                        <div class="liquid_block_right_content">
                            <div class="user_cmt block">
                                <label class="mini_time">{{date('d/m/Y H:i', $aNotify->datecreate)}}</label>
                            </div>
                            <div class="text_cmt block">
                                <a href="{{$aNotify->getDetailUrl()}}#commentBox">{{$aNotify->mss}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="liquid_block_left">
                        <div class="avatar_user_comment">
                            <img src="{{$aNotify->getDisplayAvatar()}}">
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h3>Bạn chưa có thông báo nào.</h3>
        @endif
    </div>
</div>

<script>
    $(function () {
        $('.delete_btn').click(function(){
            if(!confirm('Bạn chắc chắn muốn xóa'))
                return false;
            id = $(this).attr('data-id');
            $parent = $(this).parent().parent();
            $.post('/user/delete-notify', {
                id:id
            }, function(result){
                if(result.success){
                    $parent.remove();
                }else{
                    alert(result.message);
                }
            }, 'json')
        })
    })
</script>
@endsection