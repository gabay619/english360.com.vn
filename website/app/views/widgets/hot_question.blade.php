<div class="block">
    <div class="creat_answer block">
        <div class="heading2">
            <div class="title_heading2">
                <h2><a title="" href="">Đặt câu hỏi</a></h2>
            </div>
        </div>
        <div class="block creat_answer_ct">
            @if(Auth::user())
            <textarea class="textarea_1" placeholder="Bạn đang thắc mắc điều gì ?" id="txtQuestion"></textarea>
            <span class="btn_sendanswer_area block">
                <a class="btn_sendanswer" href="javascript:sendNewQuestion();">Gửi</a>
            </span>
                @else
            <p>Bạn cần <a href="/user/login">đăng nhập</a> để đặt câu hỏi.</p>
            @endif
        </div>
    </div>
</div>
<div class="block">
    <div class="creat_answer block">
        <div class="heading2">
            <div class="title_heading2">
                <h2><a title="" href="">Câu hỏi được quan tâm nhiều nhất</a></h2>
            </div>
        </div>
        <div class="answer_ct answer_ct_right block">
            <div class="list_answer block">
                @foreach($list as $item)
                    <?php
                    $user = User::where('_id', $item['usercreate'])->first();
                    $replyCount = Question::whereIn('parentid', array(strval($item['_id']), intval($item['_id'])))
                            ->where('status', Constant::STATUS_ENABLE)
                            ->count();
                    $question = Question::where('_id', $item['_id'])->first();
                    ?>
                <div class="item_answer liquid_block block">
                    <div class="liquid_block_right">
                        <div class="liquid_block_right_content">
                            <div class="user_cmt block">
                                <strong>{{$user->getDisplayName()}}</strong>
                                <label class="mini_time">{{date('d/m/Y H:i', $item['datecreate'])}}</label>
                            </div>
                            <div class="text_cmt block">
                                <p>{{$item['content']}}</p>
                            </div>
                            <div class="control_cmt block">
                                <a href="{{Question::getStaticDetailUrl($item['_id'])}}"><span>Trả lời</span><label>({{$replyCount}})</label></a>
                                @if(Auth::user() && $question->isLiked(Auth::user()->_id))
                                <a href="javascript:void(0)" class="unlikeCommentBtn" data-id="{{$item['_id']}}"><span>Bỏ thích</span><label>({{$item['likes']}})</label></a>
                                @else
                                <a href="javascript:void(0)" class="likeCommentBtn" data-id="{{$item['_id']}}"><span>Thích</span><label>({{$item['likes']}})</label></a>
                                @endif
                                <a href="javascript:void(0)" class="reportCommentBtn" data-id="{{$item['_id']}}"><span>Vi phạm</span><label></label></a>
                            </div>
                        </div>
                    </div>
                    <div class="liquid_block_left">
                        <div class="avatar_user_comment">
                            <img src="{{$user->getDisplayAvatar()}}">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function sendNewQuestion(){
        content = $('#txtQuestion').val();
        if(content == ''){
            showMss('Bạn chưa nhập nội dung câu hỏi'); return false;
        }
        $.post('/question/new', {
            content: content, return_url: window.location.href
        }, function(result){
            if(result.success){
                showMss(result.message);
                window.location.href = '/hoi-dap/chi-tiet.html?id='+result.id;
            }else{
                if(typeof result.package != 'undefined'){
                    window.location.href = '/user/package';
                }else
                    showMss(result.message);
            }
        }, 'json')
    }
</script>