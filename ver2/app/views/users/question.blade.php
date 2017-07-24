@extends('layouts.private')

@section('content')
        <!--TAB CONTENT-->
<div class="content_tab_text">
    <div class="chcb block">
        @if(count($myQuestion) >0)
        @foreach($myQuestion as $aQuestion)
        <div class="comment_item block">
            <div class="liquid_block_right">
                <button class="delete_btn" data-id="{{$aQuestion->_id}}"><i class="fa fa-fw"></i>Xóa</button>
                <div class="liquid_block_right_content">
                    <div class="user_cmt block">
                        <strong>{{Auth::user()->getDisplayName()}}</strong>
                        <label class="mini_time">{{date('d/m/Y H:i', $aQuestion->datecreate)}}</label>
                    </div>
                    <div class="text_cmt block">
                        {{$aQuestion->content}}
                    </div>
                    <div class="control_cmt block">
                        <a href="{{$aQuestion->getDetailUrl()}}"><span>Xem chi tiết</span></a>
                    </div>
                </div>
            </div>
            <div class="liquid_block_left">
                <div class="avatar_user_comment">
                    <img src="{{Auth::user()->getDisplayAvatar()}}">
                </div>
            </div>
        </div>
        @endforeach
        @else
        <h3>Bạn chưa có câu hỏi nào.</h3>
        @endif
    </div>
</div>
<script>
    $(function(){
        $('.delete_btn').click(function(){
            if(!confirm('Bạn chắc chắn muốn xóa câu hỏi này?'))
                return false;

            id = $(this).attr('data-id');

            $parent = $(this).parent().parent();
            $.post('/question/delete', {
                id: id
            }, function(result){
                if(result.success){
                    $parent.remove();
                }else{
                    alert(result.message);
                }
            }, 'json');
        });

    });
</script>
@endsection