@extends('layouts.main')

@section('content')
    <div class="content">
        <div class="w1170">
            <div class="content_left pd_20">
                <div class="block">
                    <div class="block_answer_detail block">
                        <div class="breadcrum">
                            <ul class="ul_breadcrum">
                                <li><a href="/">Trang chủ</a></li>
                                <li><a href="/hoi-dap.html">Hỏi đáp</a></li>
                            </ul>
                        </div>
                        <div class="answer_one_item block">
                            <h2 class="te_ch heading4 block">{{$item->content}}</h2>
                            <div class="des_te_ch block">
                                <span class="ng_dang">Đăng bởi <strong>{{$item->user()->getDisplayName()}}</strong></span>
                                <span><label class="mini_time"><i class="fa fa-fw"></i>{{date('d/m/Y H:i', $item->datecreate)}}</label></span>
                            </div>
                            <div class="control_cmt block">
                                @if(Auth::user() && $item->isLiked(Auth::user()->_id))
                                    <a href="javascript:void(0)" class="unlikeCommentBtn" data-id="{{$item->_id}}"><span>Bỏ thích</span><label>({{$item->getLikeNumber()}})</label></a>
                                @else
                                    <a href="javascript:void(0)" class="likeCommentBtn" data-id="{{$item->_id}}"><span>Thích</span><label>({{$item->getLikeNumber()}})</label></a>
                                @endif
                                <a href="javascript:void(0)" class="reportCommentBtn" data-id="{{$item->_id}}"><span>Vi phạm</span><label></label></a>
                            </div>
                            <div class="block input_traloi">
                                @if(Auth::user())
                                <textarea class="box_input_tl" placeholder="Câu trả lời của bạn" id="txtComment"></textarea>
                                <a href="javascript:sendComment()" class="btn_x btn_blue btn_gctl btn_padding_16">Gửi câu trả lời</a>
                                @else
                                <div style="border: 1px solid #ccc; padding: 20px">Bạn cần <a href="/user/login">đăng nhập</a> để trả lời câu hỏi này.</div>
                                @endif
                            </div>
                            {{--<div class="nav_des_te block">--}}
                                {{--<span class="dem_ctl block_x"><i class="fa fa-fw"></i> Hiển thị 15/30 câu trả lời</span>--}}
                            {{--</div>--}}
                        </div>
                        <div class="answer_ct block mgt10">
                            <div class="list_answer block" id="listAnswer">
                                @foreach($item->getChilds() as $aChild)
                                    <?php
                                    $user = $aChild->user();

                                    ?>
                                @if($user)
                                <div class="item_answer liquid_block block mgb20">
                                    <div class="liquid_block_right">
                                        <div class="liquid_block_right_content">
                                            <div class="user_cmt block">
                                                <strong>{{$user->getDisplayName()}}</strong>
                                                <label class="mini_time">{{date('d/m/Y H:i', $aChild->datecreate)}}</label>
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
                                            <img src="{{$user->getDisplayAvatar()}}">
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div> <!--Block Categories Right / Câu hỏi được quan tâm nhiều nhất-->
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
            $('.content').on('click', '.likeCommentBtn', function(){
                id = $(this).attr('data-id');
                like(id);
            });
            $('.content').on('click', '.unlikeCommentBtn', function(){
                id = $(this).attr('data-id');
                unlike(id);
            });
            $('.content').on('click', '.reportCommentBtn', function(){
                id = $(this).attr('data-id');
                showReportBox(id);
            });
        });
        @if(Auth::user())
        function sendComment(){
            content = $('#txtComment').val();
            if(content == ''){
                alert('Bạn chưa nhập nội dung câu hỏi'); return false;
            }
            $.post('/question/new', {
                content: content, parent: '{{$item->_id}}', return_url: window.location.href
            }, function(result){
                if(result.success){
//                    alert(result.message);
                    htmlx = '<div class="item_answer liquid_block block mgb20">'+
                            '<div class="liquid_block_right">'+
                            '<div class="liquid_block_right_content">'+
                            '<div class="user_cmt block">'+
                            '<strong>{{Auth::user()->getDisplayName()}}</strong>'+
                            '<label class="mini_time">'+result.time+'</label>'+
                            '</div>'+
                            '<div class="text_cmt block">'+result.content+'</div>'+
                            '<div class="control_cmt block">'+
                            '<a href="javascript:void(0)" class="likeCommentBtn" data-id="'+result.id+'"><span>Thích</span><label>(0)</label></a>'+
                            '<a href="javascript:void(0)" class="reportCommentBtn" data-id="'+result.id+'"><span>Vi phạm</span><label></label></a>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<div class="liquid_block_left">'+
                            '<div class="avatar_user_comment">'+
                            '<img src="{{Auth::user()->getDisplayAvatar()}}">'+
                            '</div>'+
                            '</div>'+
                            '</div>';
                    $('#listAnswer').prepend(htmlx);
                    $('#txtComment').val('');
//                    window.location.href = '/hoi-dap/chi-tiet.html?id='+result.id;
                }else{
                    if(typeof result.package != 'undefined'){
                        window.location.href = '/user/package';
                    }else
                        showMss(result.message);
                }
            }, 'json')
        }

        @endif

        function like(id){
            $.post('/question/like', {
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
            $.post('/question/unlike', {
                id: id
            }, function(result){
                if(result.success){
                    $('.unlikeCommentBtn[data-id='+id+'] span').html('Thích');
                    $('.unlikeCommentBtn[data-id='+id+'] label').html('('+result.number+')');
                    $('.unlikeCommentBtn[data-id='+id+']').attr('class', 'likeCommentBtn');
                }else{
                    if(typeof result.package != 'undefined'){
                        window.location.href = '/user/package';
                    }else
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