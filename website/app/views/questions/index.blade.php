@extends('layouts.main')

@section('content')
    <div class="content">
        <div class="w1170">
            <div class="content_left pd_20">
                <div class="block">
                    <div class="block_answer block">
                        <div class="breadcrum">
                            <ul class="ul_breadcrum">
                                <li><a href="/">Trang chủ</a></li>
                                <li><a href="">Hỏi đáp</a></li>
                            </ul>
                        </div>
                        <div class="answer_ct block mgt10">
                            <div class="list_answer block">
                                @foreach($allQuestion as $aQuestion)
                                <?php
                                $user = $aQuestion->user();
                                ?>
                                @if($user)
                                <div class="item_answer liquid_block block mgb20" id="question_id_{{$aQuestion->_id}}">
                                    <div class="liquid_block_right">
                                        <div class="liquid_block_right_content">
                                            <div class="user_cmt block">
                                                <strong>{{$user ? $user->getDisplayName() : ''}}</strong>
                                                <label class="mini_time">{{date('d/m/Y H:i',$aQuestion->datecreate)}}</label>
                                            </div>
                                            <div class="text_cmt block">
                                                {{$aQuestion->content}}
                                            </div>
                                            <div class="control_cmt block">
                                                <a href="{{$aQuestion->getDetailUrl()}}"><span>Trả lời</span><label>({{count($aQuestion->getChilds())}})</label></a>
                                                @if(Auth::user() && $aQuestion->isLiked(Auth::user()->_id))
                                                <a href="javascript:void(0)" class="unlikeCommentBtn" data-id="{{$aQuestion->_id}}"><span>Bỏ thích</span><label>({{$aQuestion->getLikeNumber()}})</label></a>
                                                @else
                                                <a href="javascript:void(0)" class="likeCommentBtn" data-id="{{$aQuestion->_id}}"><span>Thích</span><label>({{$aQuestion->getLikeNumber()}})</label></a>
                                                @endif
                                                <a href="javascript:void(0)" class="reportCommentBtn" data-id="{{$aQuestion->_id}}"><span>Vi phạm</span><label></label></a>
                                            </div>
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
                            </div>
                        </div>
                        <div class="pages block">
                            {{$allQuestion->links()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="content_right">
                @hot_question()
                @hot_lessions()
                @right_ads()
            </div>
        </div>
    </div>

    <script>
        $(function(){
            $('.answer_ct').on('click', '.likeCommentBtn', function(){
                id = $(this).attr('data-id');
                like(id);
            });
            $('.answer_ct').on('click', '.unlikeCommentBtn', function(){
                id = $(this).attr('data-id');
                unlike(id);
            });
            $('.answer_ct').on('click', '.reportCommentBtn', function(){
                id = $(this).attr('data-id');
                showReportBox(id);
            });
        })
        function like(id){
            $.post('/question/like', {
                id: id
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
            $.post('/question/unlike', {
                id: id
            }, function(result){
                if(result.success){
                    $('.unlikeCommentBtn[data-id='+id+'] span').html('Thích');
                    $('.unlikeCommentBtn[data-id='+id+'] label').html('('+result.number+')');
                    $('.unlikeCommentBtn[data-id='+id+']').attr('class', 'likeCommentBtn');
                }else{
                    alert(result.message);
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
                id: id, type: '{{Constant::TYPE_HOIDAP}}', content: $('#txtReportContent').val()
            }, function(result){
                if(result.success){
                    showReportAlert(result.message)
                }else{
                    if(typeof result.package != 'undefined'){
                        window.location.href = '/user/package';
                    }else
                        showMss(result.message);
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
@endsection