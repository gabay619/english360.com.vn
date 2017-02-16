<h4 class="title_1">
    Bình luận
</h4>
<div class="comment_box row" id="commentBox">
    <div class="commment_box_type_area row">
        <div class="liquid_block_right">
            <div class="liquid_block_right_content">
                <div class="comment_type_here">
                    <textarea placeholder="Bạn đang nghĩ gì" @if(Auth::guest()) disabled @endif data-parent=""></textarea>
                </div>
                <div class="btn_am">
                    <div class="left">
                        <a href="javascript:void(0)" class="btn_x btn_red btn_sendcomment">Gửi bình luận</a>
                    </div>
                    <div class="right">
                        @if(Auth::guest())
                        <i class="text_style_1">Bạn phải đăng nhập để bình luận !</i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="liquid_block_left">
            <div class="avatar_user_comment">
                <img src="{{Auth::user() ? Auth::user()->getDisplayAvatar() : '/assets/web/images/avatar_user_comment_default.png'}}" />
            </div>
        </div>
    </div>
    <div class="comment_list row">

        {{--<strong class="notice_1 notice_comment"><span>Hiển thị 10/100 bình luận</span></strong>--}}
        @foreach($allComments as $aComment)
            <?php
            $user = $aComment->user();
            $childs = $aComment->getChilds();
            ?>
        @if($user)
        <div class="comment_item block" id="comment_id_{{$aComment->_id}}">
            <div class="liquid_block_right">
                <div class="liquid_block_right_content">
                    <div class="user_cmt block">
                        <strong>{{$user->getDisplayName()}}</strong>
                        <label class="mini_time">{{date('d/m/Y H:i',$aComment->datecreate)}}</label>
                    </div>
                    <div class="text_cmt block">
                        {{$aComment->content}}
                    </div>
                    <div class="control_cmt block">
                        @if(Auth::user())
                        <a href="javascript:void(0)" class="addCommentBtn" data-id="{{$aComment->_id}}"><span>Trả lời</span><label>({{count($childs)}})</label></a>
                        @endif
                        @if(Auth::user() && $aComment->isLiked(Auth::user()->_id))
                        <a href="javascript:void(0)" class="unlikeCommentBtn" data-id="{{$aComment->_id}}"><span>Bỏ thích</span><label>({{$aComment->getLikeNumber()}})</label></a>
                        @else
                        <a href="javascript:void(0)" class="likeCommentBtn" data-id="{{$aComment->_id}}"><span>Thích</span><label>({{$aComment->getLikeNumber()}})</label></a>
                        @endif
                        <a href="javascript:void(0)" class="reportCommentBtn" data-id="{{$aComment->_id}}"><span>Vi phạm</span><label></label></a>
                    </div>

                    @foreach($childs as $aChild)
                        <?php $userChild = $aChild->user() ?>
                    @if($userChild)
                    <div class="comment_item comment_item_sub block">
                        <div class="liquid_block_right">
                            <div class="liquid_block_right_content">
                                <div class="user_cmt block">
                                    <strong>{{$userChild->getDisplayName()}}</strong>
                                    <label class="mini_time">{{date('d/m/Y H:i',$aChild->datecreate)}}</label>
                                </div>
                                <div class="text_cmt block">
                                    {{$aChild->content}}
                                </div>
                                <div class="control_cmt block">
                                    @if(Auth::user() && $aChild->isLiked(Auth::user()->_id))
                                    <a href="javascript:void(0)" class="unlikeCommentBtn" data-id="{{$aChild->_id}}"><span>Bỏ thích</span><label>({{$aChild->getLikeNumber()}})</label></a>
                                    @else
                                    <a href="javascript:void(0)" class="likeCommentBtn" data-id="{{$aChild->_id}}"><span>Thích</span><label>({{$aChild->getLikeNumber()}})</label></a>
                                    @endif
                                    <a href="javascript:void(0)" class="reportCommentBtn" data-id="{{$aChild->_id}}"><span>Vi phạm</span><label></label></a>
                                </div>
                            </div>
                        </div>
                        <div class="liquid_block_left">
                            <div class="avatar_user_comment">
                                <img src="{{$userChild->getDisplayAvatar()}}">
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="liquid_block_left">
                <div class="avatar_user_comment">
                    <img src="{{$user->getDisplayAvatar()}}">
                </div>
            </div>
        </div>
            @endif
        @endforeach
        {{--<div class="btn_more_comment block center">--}}
            {{--<a href="">Xem thêm bình luận</a>--}}
        {{--</div>--}}
    </div>
</div>
<script>
    $(function(){
       $('.comment_box').on('click', '.addCommentBtn', function(){
           $('.comment_list textarea').remove();
           id = $(this).attr('data-id');
            html = '<div class="control_cmt block comment_type_here">'+
                   '<textarea placeholder="Nhập bình luận và nhấn Enter" style="height: 60px" class="comment-area" data-parent="'+id+'"></textarea>'+
                   '</div>';

           $parent = $(this).parent().parent();
           $parent.append(html);
           $parent.find('textarea').focus();
       });
        $('.comment_box').on('click', '.likeCommentBtn', function(){
            id = $(this).attr('data-id');
            like(id);
        });
        $('.comment_box').on('click', '.unlikeCommentBtn', function(){
            id = $(this).attr('data-id');
            unlike(id);
        });
        $('.comment_box').on('click', '.reportCommentBtn', function(){
            id = $(this).attr('data-id');
            showReportBox(id);
        });
        $('.comment_list').on('keyup','textarea',function(e){
            if(e.which==13 && $(this).val() != ''){
                comment($(this).attr('data-parent'), $(this).val());
                $(this).remove();
            }
        });
        $('.btn_sendcomment').click(function(){
            $parent = $(this).parent().parent().parent();
            content = $parent.find('textarea').val();
            if(content != ''){
                comment('', content);
                $parent.find('textarea').val('');
            }
        });
    });

    function comment(parent, content){
        $.post('/comment/new', {
            parent: parent, content: content, type: '{{$type}}', id: '{{$id}}', return_url: window.location.href
        }, function(result){
            if(result.success){
                if(parent == ''){
                    htmlx = '<div class="comment_item block" id="comment_id_'+result.id+'">'+
                                '<div class="liquid_block_right">'+
                                    '<div class="liquid_block_right_content">'+
                                        '<div class="user_cmt block">'+
                                            '<strong>{{Auth::user() ? Auth::user()->getDisplayName() : ''}}</strong>'+
                                            '<label class="mini_time"> '+result.time+'</label>'+
                                        '</div>'+
                                        '<div class="text_cmt block">'+ result.content+'</div>'+
                                        '<div class="control_cmt block">'+
                                            '<a href="javascript:void(0)" class="addCommentBtn" data-id="'+result.id+'"><span>Trả lời</span><label>(0)</label></a>'+
                                            '<a href="javascript:void(0)" class="likeCommentBtn" data-id="'+result.id+'"><span>Thích</span><label>(0)</label></a>'+
                                            '<a href="javascript:void(0)" class="reportCommentBtn" data-id="'+result.id+'"><span>Vi phạm</span><label></label></a>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="liquid_block_left">'+
                                    '<div class="avatar_user_comment">'+
                                        '<img src="{{Auth::user() ? Auth::user()->getDisplayAvatar() : ''}}">'+
                                    '</div>'+
                                '</div>'+
                            '</div>';

                    $('.comment_list').prepend(htmlx);
                }else{
                    htmlx = '<div class="comment_item comment_item_sub block">'+
                                '<div class="liquid_block_right">'+
                                    '<div class="liquid_block_right_content">'+
                                        '<div class="user_cmt block">'+
                                            '<strong>{{Auth::user() ? Auth::user()->getDisplayName() : ''}}</strong>'+
                                            '<label class="mini_time"> '+result.time+'</label>'+
                                        '</div>'+
                                        '<div class="text_cmt block">'+result.content+'</div>'+
                                        '<div class="control_cmt block">'+
                                            '<a href="javascript:void(0)" class="likeCommentBtn" data-id="'+result.id+'"><span>Thích</span><label>(0)</label></a>'+
                                            '<a href=""><span>Vi phạm</span><label></label></a>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="liquid_block_left">'+
                                    '<div class="avatar_user_comment">'+
                                    '<img src="{{Auth::user() ? Auth::user()->getDisplayAvatar() : ''}}">'+
                                    '</div>'+
                                '</div>'+
                            '</div>';

                    $('#comment_id_'+parent+' >.liquid_block_right>.liquid_block_right_content').append(htmlx);
                }
            }else{
                if(typeof result.package != 'undefined'){
                    window.location.href = '/user/package';
                }else
                    showMss(result.message);
            }
        }, 'json')
    }

    function like(id){
        $.post('/comment/like', {
            id: id, url: window.location.href
        }, function(result){
            if(result.success){
                $('.likeCommentBtn[data-id='+id+'] span').html('Bỏ thích');
                $('.likeCommentBtn[data-id='+id+'] label').html('('+result.number+')');
                $('.likeCommentBtn[data-id='+id+']').attr('class', 'unlikeCommentBtn');
            }else{
                if(typeof result.package != 'undefined'){
                    window.location.href = '/user/package';
                }else
                    showMss(result.message);
            }
        }, 'json')
    }

    function unlike(id){
        $.post('/comment/unlike', {
            id: id
        }, function(result){
            if(result.success){
                $('.unlikeCommentBtn[data-id='+id+'] span').html('Thích');
                $('.unlikeCommentBtn[data-id='+id+'] label').html('('+result.number+')');
                $('.unlikeCommentBtn[data-id='+id+']').attr('class', 'likeCommentBtn');
            }else{
                showMss(result.message);
            }
        }, 'json')
    }

    function showReportBox(id){
        bootbox.dialog({
            message: '<p style="font-size: 14px;">Cho chúng tôi biết lý do?</p>'+
                        '<textarea class="form-control" rows="5" id="txtReportContent"></textarea>',
            title: 'Báo cáo Vi phạm',
            buttons: {
                success: {
                    label: 'Gửi báo cáo',
                    className: 'btn-success',
                    callback: function() {
                        report(id);
                    }
                },
                danger: {
                    label: "Hủy",
                    className: "btn-danger",
                    callback: function() {
                        $('.modal').modal('hide');
                    }
                },
            }
        });
    }

    function report(id){
        $.post('/report/new', {
            id: id, type: '{{Constant::TYPE_COMMENT}}', content: $('#txtReportContent').val()
        }, function(result){
            if(result.success){
                showReportAlert(result.message)
            }
        }, 'json')
    }

    function showReportAlert(mss){
        bootbox.alert(
            '<div style="font-size: 14px; text-align: center"><p>'+mss+'</p></div>'
            , function(){
                $('.modal').modal('hide');
            });
    }
</script>